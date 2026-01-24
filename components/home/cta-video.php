<?php
// Obtener campos ACF
$tipo = get_field('video_tipo');
$video = get_field('video_archivo');
$imagen = get_field('video_imagen');
?>

<section class="home-video">
    <?php if ($tipo === 'video' && $video): ?>
        <video class="video-background" muted loop playsinline data-autoplay>
            <source src="<?php echo esc_url($video['url']); ?>" type="<?php echo esc_attr($video['mime_type']); ?>">
            Tu navegador no soporta el elemento de video.
        </video>
    <?php elseif ($tipo === 'imagen' && $imagen): ?>
        <img src="<?php echo esc_url($imagen['url']); ?>" 
             alt="<?php echo esc_attr($imagen['alt']); ?>"
             class="video-background">
    <?php endif; ?>
</section>