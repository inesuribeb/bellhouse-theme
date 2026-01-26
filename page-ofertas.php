<?php
/**
 * Template Name: Ofertas
 * Template para mostrar productos rebajados
 */

defined('ABSPATH') || exit;

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class('page-ofertas'); ?>>
    <?php wp_body_open(); ?>

    <!-- Header personalizado -->
    <?php
    ob_start();
    include(get_stylesheet_directory() . '/parts/header.html');
    $header_content = ob_get_clean();
    echo do_shortcode($header_content);
    ?>

    <main class="tienda-archive">

        <!-- 1. Intro (Título + Texto ACF de la página Ofertas) -->
        <?php include(get_stylesheet_directory() . '/components/tienda/intro.php'); ?>

        <!-- ⭐ Contenedor sticky para categorías + subcategorías -->
        <div class="tienda-nav-sticky">
            <!-- 2. Categorías -->
            <?php include(get_stylesheet_directory() . '/components/tienda/categorias.php'); ?>

            <!-- 3. Subcategorías + Botón Filtrar -->
            <?php include(get_stylesheet_directory() . '/components/tienda/modal-filtro.php'); ?>
        </div>

        <!-- 4. Grid de productos (con filtro de rebajados) -->
        <?php include(get_stylesheet_directory() . '/components/tienda/grid-productos.php'); ?>

    </main>

    <?php
    // Modal de filtros (fuera del main, al final del body)
    include(get_stylesheet_directory() . '/components/tienda/modal-filtros-html.php');
    ?>

    <?php get_footer(); ?>
</body>

</html>