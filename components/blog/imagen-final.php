<?php
$img_final = get_field('blog_img_final');
?>

<?php if ($img_final): ?>
<section class="blog-imagen-final">
    <div class="imagen-final-wrapper">
        <img src="<?php echo esc_url($img_final['url']); ?>" alt="<?php echo esc_attr($img_final['alt']); ?>">
    </div>
</section>
<?php endif; ?>