<?php
// Obtener el ID de la página Home
$home_id = get_page_by_path('home')->ID;

// Obtener campos ACF de Home
$titulo = get_field('contacto_titulo', $home_id);
$link = get_field('contacto_link', $home_id);
?>

<section class="home-contacto">
    <a href="<?php echo esc_url($link); ?>" class="contacto-link">
        <?php if ($titulo): ?>
            <h2 class="contacto-titulo"><?php echo esc_html($titulo); ?></h2>
        <?php endif; ?>
    </a>
</section>