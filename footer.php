<?php
/**
 * Footer template
 */

// Obtener el ID de la página Footer Settings
$footer_page = get_page_by_path('footer-settings');
$footer_id = $footer_page ? $footer_page->ID : null;

// Obtener campos ACF
$direccion = get_field('footer_direccion', $footer_id);
$telefono = get_field('footer_telefono', $footer_id);
$email = get_field('footer_email', $footer_id);
$newsletter_texto = get_field('footer_newsletter_texto', $footer_id);
$instagram = get_field('footer_instagram', $footer_id);
$linkedin = get_field('footer_linkedin', $footer_id);
$whatsapp = get_field('footer_whatsapp', $footer_id);
$email_network = get_field('footer_email_network', $footer_id);
?>

<footer class="site-footer">
    <div class="footer-content">

        <!-- Bloque izquierdo (50%) -->
        <div class="footer-left">

            <!-- Ven a vernos (40%) -->
            <div class="footer-column footer-address">
                <h3 class="footer-title">Ven a vernos</h3>
                <p class="footer-text">
                    <?php echo nl2br(esc_html($direccion)); ?><br>
                    <?php echo esc_html($telefono); ?><br>
                    <?php echo esc_html($email); ?>
                </p>
            </div>

            <!-- Newsletter (50%) - Solo si tienda activa -->
            <?php
            $tienda_visible = get_theme_mod('tienda_visible', false);
            if ($tienda_visible && class_exists('WooCommerce')):
                ?>
                <div class="footer-column footer-newsletter">
                    <h3 class="footer-title"><?php echo nl2br(esc_html($newsletter_texto)); ?></h3>
                    <form class="newsletter-form" action="#" method="post">
                        <input type="email" name="email" placeholder="Email" required>
                        <button type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="newsletter-icon">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </button>
                    </form>
                </div>
            <?php endif; ?>

        </div>

        <!-- Bloque derecho (50%) -->
        <div class="footer-right">

            <!-- Menú (33.33%) -->
            <div class="footer-column footer-menu">
                <h3 class="footer-title">Menú</h3>
                <nav class="footer-nav">
                    <a href="/universo-bell-house">Universo Bell House</a>

                    <?php
                    // ⭐ Mostrar Novedades y Tienda solo si está activa
                    $tienda_visible = get_theme_mod('tienda_visible', false);
                    if ($tienda_visible && class_exists('WooCommerce')):
                        ?>
                        <a href="/novedades">Novedades</a>
                    <?php endif; ?>

                    <a href="/nuestros-proyectos">Proyectos</a>

                    <?php if ($tienda_visible && class_exists('WooCommerce')): ?>
                        <a href="/tienda">Tienda</a>
                    <?php endif; ?>

                    <a href="/blog">Blog</a>
                    <a href="/contacto">Contacto</a>
                </nav>
            </div>

            <!-- Networks (33.33%) -->
            <div class="footer-column footer-networks">
                <h3 class="footer-title">Networks</h3>
                <nav class="footer-social">
                    <a href="<?php echo esc_url($instagram); ?>" target="_blank">
                        Instagram
                        <svg class="footer-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 960 560">
                            <path
                                d="M642.81,163.71,261.55,536l-48.3-48.67L587.18,107.17c-6.3-.5-10.87-1.23-15.44-1.18-91.46.81-182.94,1.46-274.4,2.83-15,.22-20.61-4.67-19.41-19.68,1.51-18.84-5.48-44.31,4.28-54.82,9.22-9.91,35.4-5.06,54.12-5.1,120.71-.3,241.43.17,362.15-.51,17-.1,21.55,5.19,21.48,21.64q-.8,199.64,0,399.27c.06,15.43-4.4,20.9-20.44,21-58.93.25-59.34.77-58.83-58.31.7-81.08,2.12-162.16,3.17-243.23C643.92,167.3,643.21,165.55,642.81,163.71Z" />
                        </svg>
                    </a>
                    <a href="<?php echo esc_url($linkedin); ?>" target="_blank">
                        LinkedIn
                        <svg class="footer-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 960 560">
                            <path
                                d="M642.81,163.71,261.55,536l-48.3-48.67L587.18,107.17c-6.3-.5-10.87-1.23-15.44-1.18-91.46.81-182.94,1.46-274.4,2.83-15,.22-20.61-4.67-19.41-19.68,1.51-18.84-5.48-44.31,4.28-54.82,9.22-9.91,35.4-5.06,54.12-5.10,120.71-.3,241.43.17,362.15-.51,17-.1,21.55,5.19,21.48,21.64q-.8,199.64,0,399.27c.06,15.43-4.4,20.9-20.44,21-58.93.25-59.34.77-58.83-58.31.7-81.08,2.12-162.16,3.17-243.23C643.92,167.3,643.21,165.55,642.81,163.71Z" />
                        </svg>
                    </a>
                    <a href="<?php echo esc_url($whatsapp); ?>" target="_blank">
                        Whatsapp
                        <svg class="footer-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 960 560">
                            <path
                                d="M642.81,163.71,261.55,536l-48.3-48.67L587.18,107.17c-6.3-.5-10.87-1.23-15.44-1.18-91.46.81-182.94,1.46-274.4,2.83-15,.22-20.61-4.67-19.41-19.68,1.51-18.84-5.48-44.31,4.28-54.82,9.22-9.91,35.4-5.06,54.12-5.10,120.71-.3,241.43.17,362.15-.51,17-.1,21.55,5.19,21.48,21.64q-.8,199.64,0,399.27c.06,15.43-4.4,20.9-20.44,21-58.93.25-59.34.77-58.83-58.31.7-81.08,2.12-162.16,3.17-243.23C643.92,167.3,643.21,165.55,642.81,163.71Z" />
                        </svg>
                    </a>
                    <a href="mailto:<?php echo esc_attr($email_network); ?>">
                        Email
                        <svg class="footer-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 960 560">
                            <path
                                d="M642.81,163.71,261.55,536l-48.3-48.67L587.18,107.17c-6.3-.5-10.87-1.23-15.44-1.18-91.46.81-182.94,1.46-274.4,2.83-15,.22-20.61-4.67-19.41-19.68,1.51-18.84-5.48-44.31,4.28-54.82,9.22-9.91,35.4-5.06,54.12-5.10,120.71-.3,241.43.17,362.15-.51,17-.1,21.55,5.19,21.48,21.64q-.8,199.64,0,399.27c.06,15.43-4.4,20.9-20.44,21-58.93.25-59.34.77-58.83-58.31.7-81.08,2.12-162.16,3.17-243.23C643.92,167.3,643.21,165.55,642.81,163.71Z" />
                        </svg>
                    </a>
                </nav>
            </div>

            <!-- Diseño y desarrollo (33.33%) -->
            <div class="footer-column footer-credits">
                <h3 class="footer-title">Diseño y desarrollo</h3>
                <nav class="footer-credits-links">
                    <a href="https://estudio.inesuribe.es/" target="_blank">Estudio Ines Uribe</a>
                    <a href="https://virgulillaestudio.com/" target="_blank">Virgulilla Estudio</a>
                </nav>
                <h3 class="footer-title footer-title-links">Links</h3>
                <nav class="footer-legal">
                    <a href="/aviso-legal">Aviso legal</a>
                    <a href="/privacidad">Privacidad</a>
                    <a href="/cookies">Cookies</a>
                    <?php
                    // ⭐ Mostrar Compras y Devoluciones solo si tienda activa
                    $tienda_visible = get_theme_mod('tienda_visible', false);
                    if ($tienda_visible && class_exists('WooCommerce')):
                        ?>
                        <a href="/compras">Compras</a>
                        <a href="/devoluciones">Devoluciones</a>
                    <?php endif; ?>
                </nav>
            </div>

        </div>

    </div>

    <!-- Logo grande -->
    <div class="footer-logo">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo_BH.svg" alt="Bell House"
            class="footer-logo-img">
    </div>
</footer>

<a href="https://wa.me/34608226771" 
   class="whatsapp-float" 
   target="_blank" 
   rel="noopener noreferrer"
   aria-label="Contactar por WhatsApp">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
    </svg>
</a>

<!-- Modal Carrito (disponible en todas las páginas) -->
<?php include(get_stylesheet_directory() . '/components/producto/modal-carrito.php'); ?>

<?php wp_footer(); ?>
</body>

</html>