<?php
/**
 * Template for Política de Cookies
 * WordPress automáticamente usa este template para la página con slug "cookies"
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

<!-- Header -->
<?php 
ob_start();
include(get_stylesheet_directory() . '/parts/header.html');
$header_content = ob_get_clean();
echo do_shortcode($header_content);
?>

<main class="page-cookies">
    <div class="cookies-container">
        <h1><?php the_title(); ?></h1>
        
        <div class="cookies-content">
            <?php
            if (have_posts()) :
                while (have_posts()) : the_post();
                    the_content();
                endwhile;
            endif;
            ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
</body>
</html>