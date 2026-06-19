<?php
/**
 * Plugin Name: MovilShop Tools
 * Description: Herramientas para catalogo de accesorios de celular con WooCommerce y WhatsApp.
 * Version: 1.0.0
 * Author: Codex
 * Text Domain: movilshop-tools
 */

if (!defined('ABSPATH')) {
    exit;
}

final class MovilShop_Tools
{
    private const OPTION_GROUP = 'movilshop_options';
    private const OPTION_PHONE = 'movilshop_whatsapp_phone';
    private const OPTION_MESSAGE = 'movilshop_whatsapp_message';
    private const OPTION_CATALOG = 'movilshop_catalog_mode';

    public function __construct()
    {
        add_action('admin_menu', [$this, 'add_settings_page']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action('woocommerce_single_product_summary', [$this, 'render_whatsapp_button'], 35);
        add_filter('woocommerce_loop_add_to_cart_link', [$this, 'replace_loop_button'], 10, 2);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
        add_shortcode('movilshop_featured', [$this, 'featured_shortcode']);
        add_shortcode('movilshop_categories', [$this, 'categories_shortcode']);

        if ($this->is_catalog_mode()) {
            add_filter('woocommerce_is_purchasable', '__return_false');
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
        }
    }

    public function add_settings_page(): void
    {
        add_options_page(
            'MovilShop',
            'MovilShop',
            'manage_options',
            'movilshop',
            [$this, 'render_settings_page']
        );
    }

    public function register_settings(): void
    {
        register_setting(self::OPTION_GROUP, self::OPTION_PHONE, ['sanitize_callback' => 'sanitize_text_field']);
        register_setting(self::OPTION_GROUP, self::OPTION_MESSAGE, ['sanitize_callback' => 'sanitize_text_field']);
        register_setting(self::OPTION_GROUP, self::OPTION_CATALOG, ['sanitize_callback' => 'absint']);
    }

    public function render_settings_page(): void
    {
        ?>
        <div class="wrap">
            <h1>MovilShop</h1>
            <form method="post" action="options.php">
                <?php settings_fields(self::OPTION_GROUP); ?>
                <table class="form-table" role="presentation">
                    <tr>
                        <th scope="row"><label for="<?php echo esc_attr(self::OPTION_PHONE); ?>">Numero de WhatsApp</label></th>
                        <td>
                            <input class="regular-text" id="<?php echo esc_attr(self::OPTION_PHONE); ?>" name="<?php echo esc_attr(self::OPTION_PHONE); ?>" value="<?php echo esc_attr(get_option(self::OPTION_PHONE, '')); ?>" placeholder="5491123456789">
                            <p class="description">Usa formato internacional sin signos ni espacios.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="<?php echo esc_attr(self::OPTION_MESSAGE); ?>">Mensaje inicial</label></th>
                        <td>
                            <input class="regular-text" id="<?php echo esc_attr(self::OPTION_MESSAGE); ?>" name="<?php echo esc_attr(self::OPTION_MESSAGE); ?>" value="<?php echo esc_attr(get_option(self::OPTION_MESSAGE, 'Hola, quiero consultar por este producto:')); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Modo catalogo</th>
                        <td>
                            <label>
                                <input type="checkbox" name="<?php echo esc_attr(self::OPTION_CATALOG); ?>" value="1" <?php checked($this->is_catalog_mode()); ?>>
                                Ocultar compra directa y usar consultas por WhatsApp
                            </label>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }

    public function enqueue_assets(): void
    {
        wp_enqueue_style(
            'movilshop-tools',
            plugin_dir_url(__FILE__) . 'assets/movilshop-tools.css',
            [],
            '1.0.0'
        );
    }

    public function render_whatsapp_button(): void
    {
        global $product;

        if (!$product instanceof WC_Product) {
            return;
        }

        echo wp_kses_post($this->whatsapp_button_html($product, 'movilshop-whatsapp-button'));
    }

    public function replace_loop_button(string $html, WC_Product $product): string
    {
        if (!$this->is_catalog_mode()) {
            return $html;
        }

        return $this->whatsapp_button_html($product, 'button movilshop-loop-button');
    }

    public function featured_shortcode(array $atts): string
    {
        if (!class_exists('WooCommerce')) {
            return '';
        }

        $atts = shortcode_atts(['limit' => 8], $atts, 'movilshop_featured');

        return do_shortcode(sprintf(
            '[products limit="%d" columns="4" visibility="featured"]',
            absint($atts['limit'])
        ));
    }

    public function categories_shortcode(): string
    {
        if (!class_exists('WooCommerce')) {
            return '';
        }

        return '<div class="movilshop-category-strip">' . do_shortcode('[product_categories number="8" columns="4" parent="0"]') . '</div>';
    }

    private function whatsapp_button_html(WC_Product $product, string $class): string
    {
        $phone = preg_replace('/\D+/', '', (string) get_option(self::OPTION_PHONE, ''));

        if ($phone === '') {
            return '';
        }

        $message = get_option(self::OPTION_MESSAGE, 'Hola, quiero consultar por este producto:');
        $text = trim($message . ' ' . $product->get_name() . ' - ' . get_permalink($product->get_id()));
        $url = 'https://wa.me/' . $phone . '?text=' . rawurlencode($text);

        return sprintf(
            '<a class="%s" href="%s" target="_blank" rel="noopener">Consultar por WhatsApp</a>',
            esc_attr($class),
            esc_url($url)
        );
    }

    private function is_catalog_mode(): bool
    {
        return (bool) get_option(self::OPTION_CATALOG, true);
    }
}

add_action('plugins_loaded', static function (): void {
    if (class_exists('WooCommerce')) {
        new MovilShop_Tools();
    }
});

