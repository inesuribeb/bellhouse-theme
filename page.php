<?php
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

    <main class="page-proyectos">

        <section class="proyectos-intro">
            <div class="container">
                <h1><?php the_title(); ?></h1>
                <?php the_content(); ?>
            </div>
        </section>

        <?php if (is_page('nuestros-proyectos')): ?>
            <section class="proyectos-grid-section">
                <div class="container">
                    <?php include(get_stylesheet_directory() . '/components/grid-proyectos.php'); ?>
                    <!-- CTA Form Card -->
                    <?php include(get_stylesheet_directory() . '/components/proyecto-cta-form.php'); ?>
                </div>
            </section>

            <!-- ⭐ FAQ Section -->
            <?php include(get_stylesheet_directory() . '/components/faq-proyectos.php'); ?>
        <?php endif; ?>

    </main>

    <?php
    get_footer();