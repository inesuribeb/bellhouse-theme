<?php
/**
 * Template Name: Universo Bell House
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

<main class="page-universo">
    
    <!-- Hero -->
    <?php include(get_stylesheet_directory() . '/components/universo/hero.php'); ?>
    
    <!-- Historia -->
    <?php include(get_stylesheet_directory() . '/components/universo/historia.php'); ?>
    
    <!-- Equipo -->
    <?php include(get_stylesheet_directory() . '/components/universo/equipo.php'); ?>
    
    <!-- Publicaciones -->
    <?php include(get_stylesheet_directory() . '/components/universo/publicaciones.php'); ?>
    
    <!-- Contacto -->
    <?php include(get_stylesheet_directory() . '/components/universo/contacto.php'); ?>

</main>

<?php
get_footer();