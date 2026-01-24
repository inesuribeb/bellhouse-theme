<?php
// Verificar si la sección está activada
if (!get_field('novedades_activar')) {
    return; // No mostrar nada si está desactivada
}

// Obtener campos ACF
$label = get_field('novedades_label');
$titulo = get_field('novedades_titulo');
$imagen = get_field('novedades_imagen');
$tiene_enlace = get_field('novedades_tiene_enlace');
$link = get_field('novedades_link');
?>

<section class="home-novedades-wrapper">
    <div class="espacio-vacio"></div>
    <div class="home-novedades">

    <?php if ($tiene_enlace && $link): ?>
        <!-- Versión CON enlace -->
        <a href="<?php echo esc_url($link); ?>" class="novedades-link">
            <?php if ($imagen): ?>
                <div class="novedades-background" style="background-image: url('<?php echo esc_url($imagen['url']); ?>');">
                </div>
            <?php endif; ?>

            <div class="novedades-content">
                <?php if ($label): ?>
                    <span class="novedades-label"><?php echo esc_html($label); ?></span>
                <?php endif; ?>

                <?php if ($titulo): ?>
                    <h2 class="novedades-titulo"><?php echo wp_kses_post($titulo); ?></h2>
                <?php endif; ?>
            </div>
        </a>

    <?php else: ?>
        <!-- Versión SIN enlace (solo decorativa) -->
        <div class="novedades-link novedades-link--no-link">
            <?php if ($imagen): ?>
                <div class="novedades-background" style="background-image: url('<?php echo esc_url($imagen['url']); ?>');">
                </div>
            <?php endif; ?>

            <div class="novedades-content">
                <?php if ($label): ?>
                    <span class="novedades-label"><?php echo esc_html($label); ?></span>
                <?php endif; ?>

                <?php if ($titulo): ?>
                    <h2 class="novedades-titulo"><?php echo wp_kses_post($titulo); ?></h2>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
    </div>
    <div class="espacio-vacio"></div>
</section>