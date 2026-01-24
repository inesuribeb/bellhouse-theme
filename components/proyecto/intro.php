<?php
// Obtener campos ACF
$titulo = get_the_title();
$intro = get_field('intro');
$quote = get_field('quote');
$img_vertical = get_field('img_vertical');
$img_horizontal = get_field('img_horizontal');
?>

<section class="project-intro">
    <div class="intro-container">
        
        <!-- Columna izquierda: Título e intro -->
        <div class="intro-left">
            <?php if ($titulo): ?>
                <h1 class="intro-titulo"><?php echo esc_html($titulo); ?></h1>
            <?php endif; ?>
            
        </div>
        
        <!-- Columna derecha: Vacía (solo para layout) -->
        <div class="intro-right">
        <?php if ($intro): ?>
                <div class="intro-texto">
                    <?php echo wp_kses_post($intro); ?>
                </div>
            <?php endif; ?>
        </div>
        
    </div>
    
    <!-- Quote en toda la anchura -->
    <?php if ($quote): ?>
        <div class="intro-quote-container">
            <blockquote class="intro-quote">
                <?php echo esc_html($quote); ?>
            </blockquote>
        </div>
    <?php endif; ?>
    
    <!-- Imágenes: Vertical (izq) + Horizontal (der) -->
    <div class="intro-images">
        <?php if ($img_vertical): ?>
            <div class="intro-image-vertical">
                <img src="<?php echo esc_url($img_vertical['url']); ?>" alt="<?php echo esc_attr($img_vertical['alt']); ?>">
            </div>
        <?php endif; ?>
        
        <?php if ($img_horizontal): ?>
            <div class="intro-image-horizontal">
                <img src="<?php echo esc_url($img_horizontal['url']); ?>" alt="<?php echo esc_attr($img_horizontal['alt']); ?>">
            </div>
        <?php endif; ?>
    </div>
</section>