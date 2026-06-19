# Guia de instalacion

## 1. WordPress

Instala WordPress en el hosting del cliente. Si todavia no tiene hosting, usa uno con PHP 8.1 o superior, MySQL/MariaDB, certificado SSL y backups.

## 2. Plugins necesarios

Instala desde el panel de WordPress:

- WooCommerce
- Elementor, opcional si quieres editar secciones visualmente
- WP Mail SMTP
- UpdraftPlus o el sistema de backups del hosting
- Wordfence Security o Solid Security

Luego sube y activa el plugin incluido:

- `movilshop-tools`

## 3. Tema

Instala el tema gratuito `Storefront` desde Apariencia > Temas.

Luego sube la carpeta:

```text
wp-content/themes/movilshop-child
```

Activa `MovilShop Child`.

## 4. Configuracion de WooCommerce

En WooCommerce > Ajustes:

- Moneda: la moneda local del cliente.
- Productos: activar gestion de inventario si maneja stock.
- Pagos: desactivar pagos si sera solo catalogo por WhatsApp.
- Envio: configurar zonas solo si vendera con carrito.

## 5. Configuracion de WhatsApp

Ve a Ajustes > MovilShop:

- Numero de WhatsApp: usa formato internacional sin signos. Ejemplo: `5491123456789`.
- Mensaje: texto inicial de consulta.
- Modo catalogo: activado si no quieres carrito.

## 6. Paginas recomendadas

Crea estas paginas:

- Inicio
- Tienda
- Contacto
- Sobre nosotros

En Ajustes > Lectura, define `Inicio` como pagina principal.

En Ajustes > Generales, pon el titulo del sitio como:

```text
Fundas.sr
```

En la pagina Inicio puedes usar estos shortcodes:

```text
[movilshop_hero]
[movilshop_featured limit="8"]
```

Las categorias principales ya aparecen en el menu de tres lineas de la esquina superior izquierda.

## 8. Importar productos de ejemplo

Inclui un CSV en:

```text
docs/productos-demo.csv
```

Los precios estan en `0` para que el cliente los cargue. Antes de importar, sube las imagenes principales de `assets/catalogo/` a Medios en WordPress. Luego ve a Productos > Importar y usa el CSV como base.

Las fotos extra de fundas estan en `assets/catalogo/originales/` por si quieres crear mas productos o galerias.

## 7. Entrega al cliente

Crea un usuario para el cliente con rol `Gestor de tienda`.

Ensena este flujo:

1. Entrar al panel.
2. Ir a Productos.
3. Editar nombre, precio, oferta, stock, foto y categoria.
4. Guardar cambios.
