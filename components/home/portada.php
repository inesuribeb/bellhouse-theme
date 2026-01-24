<?php
$tienda_visible = get_theme_mod('tienda_visible', false);

if ($tienda_visible) {
    // ========================================
    // PORTADA CON TIENDA (versión actual)
    // ========================================
    $titulo = get_field('portada_titulo');
    $card1_imagen = get_field('portada_card1_imagen');
    $card1_texto = get_field('portada_card1_texto');
    $card1_link = get_field('portada_card1_link');
    $card2_imagen = get_field('portada_card2_imagen');
    $card2_texto = get_field('portada_card2_texto');
    $card2_link = get_field('portada_card2_link');
    ?>

    <section class="home-portada">
        <!-- Título centrado -->
        <?php if ($titulo): ?>
            <div class="portada-titulo">
                <h1><?php echo wp_kses_post($titulo); ?></h1>
            </div>
        <?php endif; ?>

        <!-- Cards -->
        <div class="portada-cards">
            <!-- Card 1 -->
            <a href="<?php echo esc_url($card1_link); ?>" class="portada-card portada-card--left">
                <?php if ($card1_imagen): ?>
                    <div class="portada-card__image">
                        <img src="<?php echo esc_url($card1_imagen['url']); ?>"
                            alt="<?php echo esc_attr($card1_imagen['alt']); ?>">
                    </div>
                <?php endif; ?>
                <span class="portada-card__text"><?php echo esc_html($card1_texto); ?></span>
            </a>

            <!-- Card 2 -->
            <a href="<?php echo esc_url($card2_link); ?>" class="portada-card portada-card--right">
                <?php if ($card2_imagen): ?>
                    <div class="portada-card__image">
                        <img src="<?php echo esc_url($card2_imagen['url']); ?>"
                            alt="<?php echo esc_attr($card2_imagen['alt']); ?>">
                    </div>
                <?php endif; ?>
                <span class="portada-card__text"><?php echo esc_html($card2_texto); ?></span>
            </a>
        </div>
    </section>

    <?php
} else {
    // ========================================
    // PORTADA SIN TIENDA (versión fullscreen)
    // ========================================
    $titulo_sin_tienda = get_field('portada_sin_tienda_titulo');
    $tipo_fondo = get_field('portada_sin_tienda_tipo');
    $imagen_fondo = get_field('portada_sin_tienda_imagen');
    $video_fondo = get_field('portada_sin_tienda_video');
    
    // Preparar estilo inline si es imagen
    $style_bg = '';
    if ($tipo_fondo === 'imagen' && $imagen_fondo) {
        $style_bg = 'style="background-image: url(' . esc_url($imagen_fondo['url']) . ');"';
    }
    ?>

    <section class="home-portada home-portada--fullscreen" <?php echo $style_bg; ?>>
        
        <!-- Video (solo si es video) -->
        <?php if ($tipo_fondo === 'video' && $video_fondo): ?>
            <div class="portada-fondo-video">
                <video autoplay muted loop playsinline>
                    <source src="<?php echo esc_url($video_fondo['url']); ?>" type="video/mp4">
                </video>
            </div>
        <?php endif; ?>

        <!-- Título centrado -->
        <?php if ($titulo_sin_tienda): ?>
            <div class="portada-titulo">
                <h1><?php echo wp_kses_post($titulo_sin_tienda); ?></h1>
            </div>
        <?php endif; ?>
    </section>

<?php
}
?>