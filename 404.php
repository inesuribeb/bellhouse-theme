<?php
/**
 * Template for 404 - Página no encontrada
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

<main class="page-404">
    <div class="error-404-container">
        <div class="error-404-content">
            <span class="error-404-code">404</span>
            <h1 class="error-404-title">Página no encontrada</h1>
            <p class="error-404-text">
                Lo sentimos, la página que buscas no existe o ha sido movida.
            </p>
            <div class="error-404-buttons">
                <a href="<?php echo home_url(); ?>" class="error-404-button">
                    Volver al inicio
                    <svg class="boton-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 960 560">
                        <path d="M642.81,163.71,261.55,536l-48.3-48.67L587.18,107.17c-6.3-.5-10.87-1.23-15.44-1.18-91.46.81-182.94,1.46-274.4,2.83-15,.22-20.61-4.67-19.41-19.68,1.51-18.84-5.48-44.31,4.28-54.82,9.22-9.91,35.4-5.06,54.12-5.1,120.71-.3,241.43.17,362.15-.51,17-.1,21.55,5.19,21.48,21.64q-.8,199.64,0,399.27c.06,15.43-4.4,20.9-20.44,21-58.93.25-59.34.77-58.83-58.31.7-81.08,2.12-162.16,3.17-243.23C643.92,167.3,643.21,165.55,642.81,163.71Z" />
                    </svg>
                </a>
                <a href="/nuestros-proyectos" class="error-404-button error-404-button--secondary">
                    Ver proyectos
                </a>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>
</body>
</html>