<?php
// Obtener campos ACF
$titulo = get_field('contacto_titulo');
$link = get_field('contacto_link');
?>

<section class="home-contacto">
    <a href="<?php echo esc_url($link); ?>" class="contacto-link">
        <?php if ($titulo): ?>
            <h2 class="contacto-titulo"><?php echo esc_html($titulo); ?></h2>
        <?php endif; ?>
    </a>
</section>