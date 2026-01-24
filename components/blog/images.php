<?php
$img_vertical = get_field('blog_img_vertical');
$img_horizontal = get_field('blog_img_horizontal');
?>

<?php if ($img_vertical || $img_horizontal): ?>
<section class="blog-images">
    
    <?php if ($img_vertical): ?>
        <div class="images-vertical">
            <img src="<?php echo esc_url($img_vertical['url']); ?>" alt="<?php echo esc_attr($img_vertical['alt']); ?>">
        </div>
    <?php endif; ?>
    
    <?php if ($img_horizontal): ?>
        <div class="images-horizontal">
            <img src="<?php echo esc_url($img_horizontal['url']); ?>" alt="<?php echo esc_attr($img_horizontal['alt']); ?>">
        </div>
    <?php endif; ?>
    
</section>
<?php endif; ?>