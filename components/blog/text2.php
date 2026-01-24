<?php
$subtitulo_2 = get_field('blog_subtitulo_2');
$texto_2 = get_field('blog_texto_2');
?>

<?php if ($subtitulo_2 || $texto_2): ?>
<section class="blog-text2">
    
    <?php if ($subtitulo_2): ?>
        <h2 class="text2-subtitulo"><?php echo esc_html($subtitulo_2); ?></h2>
    <?php endif; ?>
    
    <?php if ($texto_2): ?>
        <div class="text2-contenido">
            <?php echo wp_kses_post($texto_2); ?>
        </div>
    <?php endif; ?>
    
</section>
<?php endif; ?>