<?php
// Obtener campos ACF
$titulo = get_field('universo_hero_titulo');
$img_pequena = get_field('universo_hero_img_pequena');
$img_grande = get_field('universo_hero_img_grande');
?>

<section class="universo-hero">
    <div class="universo-hero-container">
        
        <!-- Columna izquierda: Título e imagen pequeña -->
        <div class="hero-left">
            <?php if ($titulo): ?>
                <h1 class="hero-titulo"><?php echo esc_html($titulo); ?></h1>
            <?php endif; ?>
            
            <?php if ($img_pequena): ?>
                <div class="hero-img-pequena">
                    <img src="<?php echo esc_url($img_pequena['url']); ?>" alt="<?php echo esc_attr($img_pequena['alt']); ?>">
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Columna derecha: Imagen grande -->
        <?php if ($img_grande): ?>
            <div class="hero-right">
                <img 
                    src="<?php echo esc_url($img_grande['url']); ?>" 
                    alt="<?php echo esc_attr($img_grande['alt']); ?>"
                    class="hero-img-grande" 
                    id="heroImgGrande"
                >
            </div>
        <?php endif; ?>
        
    </div>
</section>