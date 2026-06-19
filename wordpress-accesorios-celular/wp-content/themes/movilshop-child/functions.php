<?php
/**
 * MovilShop Child theme functions.
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('wp_enqueue_scripts', static function (): void {
    wp_enqueue_style(
        'storefront-style',
        get_template_directory_uri() . '/style.css',
        [],
        wp_get_theme('storefront')->get('Version')
    );

    wp_enqueue_style(
        'movilshop-child-style',
        get_stylesheet_uri(),
        ['storefront-style'],
        wp_get_theme()->get('Version')
    );
});

add_action('after_setup_theme', static function (): void {
    add_theme_support('woocommerce');
});

add_action('storefront_before_header', static function (): void {
    $shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/tienda/');
    ?>
    <div class="movilshop-topbar">
        <details class="movilshop-menu-panel">
            <summary aria-label="Abrir categorias">
                <span></span>
                <span></span>
                <span></span>
            </summary>
            <nav aria-label="Categorias">
                <a href="<?php echo esc_url(home_url('/product-category/fundas/')); ?>">Fundas</a>
                <a href="<?php echo esc_url(home_url('/product-category/cargadores/')); ?>">Cargadores</a>
                <a href="<?php echo esc_url(home_url('/product-category/cables/')); ?>">Cables</a>
                <a href="<?php echo esc_url(home_url('/product-category/airpods-pro/')); ?>">AirPods Pro</a>
            </nav>
        </details>
        <a class="movilshop-topbar-brand" href="<?php echo esc_url(home_url('/')); ?>">Fundas.sr</a>
        <a class="movilshop-topbar-action" href="<?php echo esc_url($shop_url); ?>">Catalogo</a>
    </div>
    <?php
});

add_shortcode('movilshop_hero', static function (): string {
    $shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/tienda/');
    $asset_url = get_stylesheet_directory_uri() . '/assets/catalogo/';

    ob_start();
    ?>
    <section class="movilshop-hero">
        <div>
            <p class="movilshop-brand-title">Fundas.sr</p>
            <h1>Tu pagina principal para fundas y accesorios.</h1>
            <p>AirPods Pro, cargadores, cables y fundas con precios actualizados y consulta directa por WhatsApp.</p>
            <div class="movilshop-hero-actions">
                <a class="button" href="<?php echo esc_url($shop_url); ?>">Ver catalogo</a>
                <a class="button alt" href="<?php echo esc_url(home_url('/contacto/')); ?>">Consultar</a>
            </div>
        </div>
        <div class="movilshop-hero-gallery" aria-hidden="true">
            <img src="<?php echo esc_url($asset_url . 'fundas-iphone.jpg'); ?>" alt="">
            <img src="<?php echo esc_url($asset_url . 'airpods-pro.jpg'); ?>" alt="">
            <img src="<?php echo esc_url($asset_url . 'cargador-usb-c-20w.jpg'); ?>" alt="">
            <img src="<?php echo esc_url($asset_url . 'cables-iphone.jpg'); ?>" alt="">
        </div>
    </section>
    <?php
    return ob_get_clean();
});
