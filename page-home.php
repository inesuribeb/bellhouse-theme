<?php
/**
 * Template Name: Home
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <!-- Header personalizado -->
    <?php
    ob_start();
    include(get_stylesheet_directory() . '/parts/header.html');
    $header_content = ob_get_clean();
    echo do_shortcode($header_content);
    ?>

    <main class="page-home">
        
        <!-- Portada -->
        <?php
        $tienda_visible = get_theme_mod('tienda_visible', false);
        include(get_stylesheet_directory() . '/components/home/portada.php');
        ?>

        <!-- Intro -->
        <?php include(get_stylesheet_directory() . '/components/home/intro.php'); ?>

        <div class="espacio-vacio-menor"></div>

        <!-- CTA Proyectos -->
        <?php include(get_stylesheet_directory() . '/components/home/cta-proyectos.php'); ?>

        <!-- CTA Novedades -->
        <?php include(get_stylesheet_directory() . '/components/home/cta-novedades.php'); ?>

        <!-- CTA Tienda (solo si tienda visible) -->
        <?php if ($tienda_visible): ?>
            <?php include(get_stylesheet_directory() . '/components/home/cta-tienda.php'); ?>
        <?php endif; ?>

        <!-- CTA Universo Bell House -->
        <?php include(get_stylesheet_directory() . '/components/home/cta-universo.php'); ?>

        <!-- CTA Video -->
        <?php include(get_stylesheet_directory() . '/components/home/cta-video.php'); ?>

        <!-- CTA Contacto -->
        <?php include(get_stylesheet_directory() . '/components/home/cta-contacto.php'); ?>

    </main>

    <?php get_footer(); ?>
</body>
</html>