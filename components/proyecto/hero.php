<?php
// Obtener imagen hero
$img_hero = get_field('img_hero');
$titulo = get_the_title();
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
        <!-- Overlay -->
        <div class="project-hero-overlay"></div>
        
        <!-- Título -->
        <?php if ($titulo): ?>
            <h1 class="project-hero-titulo"><?php echo esc_html($titulo); ?></h1>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>