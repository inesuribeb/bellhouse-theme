<?php
// Obtener campos
$titulo = get_the_title();
$main_image = get_field('blog_main_image');
?>

<section class="blog-hero">
    
    <!-- Título centrado -->
    <div class="hero-titulo-wrapper">
        <h1 class="hero-titulo"><?php echo esc_html($titulo); ?></h1>
    </div>
    
    <!-- Imagen a sangre -->
    <?php if ($main_image): ?>
        <div class="hero-imagen">
            <img 
                src="<?php echo esc_url($main_image['url']); ?>" 
                alt="<?php echo esc_attr($main_image['alt']); ?>"
                id="blogHeroImg"
            >
        </div>
    <?php endif; ?>
    
</section>