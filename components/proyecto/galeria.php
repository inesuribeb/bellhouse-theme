<?php
// Obtener imágenes del carousel (1-8)
$carousel_images = array();
for ($i = 1; $i <= 8; $i++) {
    $img = get_field('carousel_imagen_' . $i);
    if ($img) {
        $carousel_images[] = $img;
    }
}
?>

<?php if (!empty($carousel_images)): ?>
<section class="project-galeria">
    
    <h2 class="galeria-titulo">Galería</h2>
    
    <div class="galeria-carousel-wrapper">
        <div class="galeria-carousel" id="galeriaCarousel">
            <?php foreach ($carousel_images as $index => $img): ?>
                <?php 
                // Determinar orientación por aspect ratio
                $width = $img['width'];
                $height = $img['height'];
                $ratio = $width / $height;
                $is_horizontal = $ratio > 1;
                ?>
                <div class="galeria-slide <?php echo $is_horizontal ? 'horizontal' : 'vertical'; ?>">
                    <img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>">
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Flechas de navegación -->
        <button class="galeria-arrow galeria-arrow-left" id="galeriaArrowLeft">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
        </button>
        <button class="galeria-arrow galeria-arrow-right" id="galeriaArrowRight">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
        </button>
    </div>
    
</section>
<?php endif; ?>