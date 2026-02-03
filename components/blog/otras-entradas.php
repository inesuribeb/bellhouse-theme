<?php
/**
 * Otras entradas - 3 posts aleatorios excluyendo el actual
 */

$current_post_id = get_the_ID();

$args = array(
    'post_type' => 'post',
    'posts_per_page' => 3,
    'orderby' => 'rand',
    'exclude' => array($current_post_id),
    'post_status' => 'publish',
);

$otras_entradas = new WP_Query($args);
?>

<?php if ($otras_entradas->have_posts()) : ?>

<section class="otras-entradas">
    
    <!-- Título -->
    <div class="otras-entradas__titulo-wrapper">
        <h2 class="otras-entradas__titulo">Otras entradas</h2>
    </div>
    
    <!-- Cards -->
    <div class="otras-entradas__grid">
        <?php while ($otras_entradas->have_posts()) : $otras_entradas->the_post(); ?>
            
            <a href="<?php echo esc_url(get_permalink()); ?>" class="otras-entradas__card">
                
                <!-- Imagen -->
                <div class="otras-entradas__image">
                    <?php $img = get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>
                    <?php if ($img) : ?>
                        <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                    <?php else : ?>
                        <div class="placeholder-image"></div>
                    <?php endif; ?>
                </div>
                
                <!-- Overlay con fecha y título -->
                <div class="otras-entradas__overlay">
                    <time class="otras-entradas__date"><?php echo get_the_date('d.m.Y'); ?></time>
                    <h3 class="otras-entradas__title"><?php echo esc_html(get_the_title()); ?></h3>
                </div>
                
            </a>
            
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
    </div>
    
</section>

<?php endif; ?>