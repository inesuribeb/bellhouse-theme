<?php
// Obtener campos ACF
$label = get_field('universo_label');
$titulo = get_field('universo_titulo');
$imagen = get_field('universo_imagen');
$link = get_field('universo_link');
?>

<section class="home-universo">
    <a href="<?php echo esc_url($link); ?>" class="universo-link">
        <div class="universo-content">
            <?php if ($label): ?>
                <span class="universo-label"><?php echo esc_html($label); ?></span>
            <?php endif; ?>
            
            <?php if ($titulo): ?>
                <h2 class="universo-titulo"><?php echo wp_kses_post($titulo); ?></h2>
            <?php endif; ?>
            
            <?php if ($imagen): ?>
                <div class="universo-imagen">
                    <img src="<?php echo esc_url($imagen['url']); ?>" 
                         alt="<?php echo esc_attr($imagen['alt']); ?>">
                </div>
            <?php endif; ?>
        </div>
    </a>
</section>