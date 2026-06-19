# Web WordPress para Fundas.sr

Este paquete deja lista la base para entregar una web de venta/catalogo de accesorios de celular en WordPress para `Fundas.sr`.

## Que incluye

- Tema hijo `movilshop-child` para un diseno publico moderno.
- Plugin `movilshop-tools` para:
  - boton de WhatsApp en productos,
  - modo catalogo opcional,
  - productos destacados en la portada,
  - shortcode para categorias principales.
- Guia de instalacion para WordPress y WooCommerce.
- Lista de paginas, categorias y productos de ejemplo.
- Fotos reales para AirPods Pro, cargadores, cables y fundas.
- CSV de productos demo para WooCommerce.

## Recomendacion de uso

Para este cliente conviene empezar como catalogo con WhatsApp:

- El publico ve productos, precios, fotos y ofertas.
- Cada producto tiene boton de consulta por WhatsApp.
- El cliente cambia precios, stock, fotos y nombres desde Productos en WordPress.
- Mas adelante se puede activar carrito y pagos con WooCommerce.

## Estructura

```text
wordpress-accesorios-celular/
  wp-content/
    plugins/
      movilshop-tools/
    themes/
      movilshop-child/
  docs/
    instalacion.md
    contenido-inicial.md
    productos-demo.csv
  assets/
    catalogo/
```

## Instalacion rapida

1. Instalar WordPress en el hosting.
2. Instalar el tema gratuito Storefront.
3. Copiar `movilshop-child` en `wp-content/themes/`.
4. Copiar `movilshop-tools` en `wp-content/plugins/`.
5. Activar WooCommerce, Storefront Child y MovilShop Tools.
6. Configurar el numero de WhatsApp en Ajustes > MovilShop.
7. Crear productos y categorias segun `docs/contenido-inicial.md`.
