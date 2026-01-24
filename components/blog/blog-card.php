<?php
$is_vertical = get_query_var('card_is_vertical', true);
$featured_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
$date = get_the_date('d.m.Y');
$title = get_the_title();
$permalink = get_permalink();
?>

<a href="<?php echo esc_url($permalink); ?>" 
   class="blog-card <?php echo $is_vertical ? 'vertical' : 'horizontal'; ?>">
    
    <!-- Imagen destacada -->
    <div class="blog-card__image">
        <?php if ($featured_image) : ?>
            <img src="<?php echo esc_url($featured_image); ?>" alt="<?php echo esc_attr($title); ?>">
        <?php else : ?>
            <div class="placeholder-image"></div>
        <?php endif; ?>
    </div>
    
    <!-- Info -->
    <div class="blog-card__info">
        <time class="blog-card__date"><?php echo $date; ?></time>
        <h3 class="blog-card__title"><?php echo esc_html($title); ?></h3>
    </div>
    
</a>