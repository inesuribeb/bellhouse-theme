<?php
/**
 * Template para producto individual (WooCommerce)
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
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Header personalizado -->
<?php 
ob_start();
include(get_stylesheet_directory() . '/parts/header.html');
$header_content = ob_get_clean();
echo do_shortcode($header_content);
?>

<main class="product-single">
    
    <?php while (have_posts()) : the_post(); ?>
        
        <!-- Info del producto -->
        <section class="product-info">
            
            <!-- Galería de imágenes -->
            <?php include(get_stylesheet_directory() . '/components/producto/galeria.php'); ?>
            
            <!-- Detalles del producto -->
            <?php include(get_stylesheet_directory() . '/components/producto/detalles.php'); ?>
            
        </section>
        
        <!-- Productos relacionados (Combínalo con) -->
        <section class="product-relacionados">
            <h2>Combínalo con</h2>
            <!-- Lo dejamos para después -->
        </section>
        
    <?php endwhile; ?>

</main>

<?php
get_footer();
?>
</body>
</html>