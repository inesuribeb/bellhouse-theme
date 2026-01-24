<?php
// Obtener imagen hero
$img_hero = get_field('img_hero');
?>

<?php if ($img_hero): ?>
<section class="project-hero">
    <div class="project-hero-image">
        <img 
            src="<?php echo esc_url($img_hero['url']); ?>" 
            alt="<?php echo esc_attr($img_hero['alt']); ?>"
            class="project-hero-img"
            id="projectHeroImg"
        >
    </div>
</section>
<?php endif; ?>