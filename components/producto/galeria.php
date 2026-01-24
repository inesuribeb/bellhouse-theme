<?php
/**
 * Galería de imágenes del producto (con imágenes de variaciones)
 */

global $product;

// Imagen principal
$image_id = $product->get_image_id();
$image_url = wp_get_attachment_image_url($image_id, 'full');

// Imagen hover (ACF)
$imagen_hover = get_field('imagen_hover');

// Galería de imágenes
$gallery_ids = $product->get_gallery_image_ids();

// Todas las imágenes juntas (para las miniaturas)
$all_images = array();
$image_ids_added = array(); // Para evitar duplicados

// Añadir imagen principal
if ($image_id) {
    $all_images[] = array(
        'id' => $image_id,
        'url' => $image_url,
    );
    $image_ids_added[] = $image_id;
}

// Añadir imagen hover
if ($imagen_hover && isset($imagen_hover['id']) && !in_array($imagen_hover['id'], $image_ids_added)) {
    $all_images[] = array(
        'id' => $imagen_hover['id'],
        'url' => $imagen_hover['url'],
    );
    $image_ids_added[] = $imagen_hover['id'];
}

// Añadir galería
foreach ($gallery_ids as $gallery_id) {
    if (!in_array($gallery_id, $image_ids_added)) {
        $all_images[] = array(
            'id' => $gallery_id,
            'url' => wp_get_attachment_image_url($gallery_id, 'full'),
        );
        $image_ids_added[] = $gallery_id;
    }
}

// ⭐ NUEVO: Añadir imágenes de variaciones (si es producto variable)
// ⭐ NUEVO: Añadir imágenes de variaciones (si es producto variable)
if ($product->is_type('variable')) {
    $variations = $product->get_available_variations();
    
    echo '<!-- DEBUG: Total variaciones: ' . count($variations) . ' -->';
    
    foreach ($variations as $variation) {
        $variation_id = $variation['variation_id'];
        
        // Obtener la imagen directamente del post thumbnail de la variación
        $variation_image_id = get_post_thumbnail_id($variation_id);
        
        echo '<!-- DEBUG: Variación ID: ' . $variation_id . ' | Image ID desde post: ' . $variation_image_id . ' -->';
        
        // Solo añadir si es una imagen única (no duplicada)
        if ($variation_image_id && !in_array($variation_image_id, $image_ids_added)) {
            $all_images[] = array(
                'id' => $variation_image_id,
                'url' => wp_get_attachment_image_url($variation_image_id, 'full'),
            );
            $image_ids_added[] = $variation_image_id;
            echo '<!-- DEBUG: Imagen añadida! -->';
        }
    }
}
?>

<div class="product-galeria" data-product-id="<?php echo $product->get_id(); ?>">
    
    <!-- Contenedor principal con imagen y miniaturas superpuestas -->
    <div class="galeria-main-wrapper">
        
        <!-- Imagen principal grande -->
        <div class="galeria-main">
            <img id="main-image" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($product->get_name()); ?>" data-default-image="<?php echo esc_url($image_url); ?>">
        </div>
        
        <!-- Miniaturas superpuestas en la parte inferior -->
        <?php if (count($all_images) > 1): ?>
            <div class="galeria-thumbs">
                <?php foreach ($all_images as $index => $img): ?>
                    <div class="thumb <?php echo $index === 0 ? 'active' : ''; ?>" data-image="<?php echo esc_url($img['url']); ?>">
                        <img src="<?php echo esc_url($img['url']); ?>" alt="Miniatura <?php echo $index + 1; ?>">
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
    </div>
    
</div>

<!-- Modal de galería -->
<div id="gallery-modal" class="gallery-modal">
    <div class="modal-header">
        <button class="modal-close">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
        <h2 class="modal-product-name"><?php echo esc_html($product->get_name()); ?></h2>
    </div>
    
    <div class="modal-content">
        <button class="modal-arrow modal-arrow-left">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
            </svg>
        </button>
        
        <div class="modal-main-image">
            <img id="modal-image" src="" alt="">
        </div>
        
        <button class="modal-arrow modal-arrow-right">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3" />
            </svg>
        </button>
    </div>
    
    <div class="modal-footer">
        <div class="modal-counter">
            <span id="current-image">1</span>/<span id="total-images"><?php echo count($all_images); ?></span> imágenes
        </div>
        
        <div class="modal-thumbs">
            <?php foreach ($all_images as $index => $img): ?>
                <div class="modal-thumb <?php echo $index === 0 ? 'active' : ''; ?>" data-index="<?php echo $index; ?>" data-image="<?php echo esc_url($img['url']); ?>">
                    <img src="<?php echo esc_url($img['url']); ?>" alt="Miniatura <?php echo $index + 1; ?>">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>