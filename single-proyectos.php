<?php
/**
 * Template para proyecto individual
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

<main class="proyecto-single">
    
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        
        <!-- Hero -->
        <?php include(get_stylesheet_directory() . '/components/proyecto/hero.php'); ?>
        
        <!-- Intro -->
        <?php include(get_stylesheet_directory() . '/components/proyecto/intro.php'); ?>
        
        <!-- Antes y Después -->
        <?php include(get_stylesheet_directory() . '/components/proyecto/antes-despues.php'); ?>
        
        <!-- Galería -->
        <?php include(get_stylesheet_directory() . '/components/proyecto/galeria.php'); ?>
        
        <!-- Shop the Look -->
        <?php include(get_stylesheet_directory() . '/components/proyecto/shop-the-look.php'); ?>
        
    <?php endwhile; endif; ?>

</main>

<?php
get_footer();