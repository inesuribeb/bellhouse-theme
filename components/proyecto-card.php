<?php
$card_index = get_query_var('card_index', 1);
$is_vertical = ($card_index % 2 != 0); 

// Obtener campos ACF
$image_card = get_field('image_card');
$type = get_field('type');
$descripcion_corta = get_field('descripcion_corta');
$permalink = get_permalink();
?>

<a href="<?php echo esc_url($permalink); ?>" class="proyecto-card <?php echo $is_vertical ? 'vertical' : 'horizontal'; ?>">
    
    <!-- Imagen -->
    <div class="proyecto-card__image">
        <?php if ($image_card) : ?>
            <img src="<?php echo esc_url($image_card['url']); ?>" 
                 alt="<?php echo esc_attr($image_card['alt']); ?>">
        <?php else : ?>
            <!-- Placeholder si no hay imagen -->
            <div class="placeholder-image"></div>
        <?php endif; ?>
    </div>
    
    <!-- Info -->
    <div class="proyecto-card__info">
        <?php if ($type) : ?>
            <span class="proyecto-card__type"><?php echo esc_html($type); ?></span>
        <?php endif; ?>
        
        <h3 class="proyecto-card__title"><?php the_title(); ?></h3>
        
        <?php if ($descripcion_corta) : ?>
            <p class="proyecto-card__description"><?php echo esc_html($descripcion_corta); ?></p>
        <?php endif; ?>
    </div>
    
</a>