<?php
$subtitulo = get_field('blog_subtitulo');
$texto = get_field('blog_texto');
?>

<?php if ($subtitulo || $texto): ?>
<section class="blog-text1">
    
    <div class="text1-left">
        <?php if ($subtitulo): ?>
            <h2 class="text1-subtitulo"><?php echo esc_html($subtitulo); ?></h2>
        <?php endif; ?>
    </div>
    
    <div class="text1-right">
        <?php if ($texto): ?>
            <div class="text1-contenido">
                <?php echo wp_kses_post($texto); ?>
            </div>
        <?php endif; ?>
    </div>
    
</section>
<?php endif; ?>