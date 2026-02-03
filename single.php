<?php
/**
 * Template para post individual (blog)
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

<main class="blog-single">
    
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        
        <!-- Hero -->
        <?php include(get_stylesheet_directory() . '/components/blog/hero.php'); ?>
        
        <!-- Text 1 -->
        <?php include(get_stylesheet_directory() . '/components/blog/text1.php'); ?>
        
        <!-- Images -->
        <?php include(get_stylesheet_directory() . '/components/blog/images.php'); ?>
        
        <!-- Text 2 -->
        <?php include(get_stylesheet_directory() . '/components/blog/text2.php'); ?>
        
        <!-- Imagen Final -->
        <?php include(get_stylesheet_directory() . '/components/blog/imagen-final.php'); ?>
        
        <!-- Otras entradas (lo haremos después) -->
        <?php include(get_stylesheet_directory() . '/components/blog/otras-entradas.php'); ?>

    <?php endwhile; endif; ?>

</main>

<?php
get_footer();