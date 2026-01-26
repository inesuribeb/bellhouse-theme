<?php
/**
 * Galería de imágenes del producto (con imágenes de variaciones)
 */

global $product;

echo '</div>';

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
        'type' => 'principal',
        'variation_id' => null,
        'attributes' => array()
    );
    $image_ids_added[] = $image_id;
}

// Añadir imagen hover
if ($imagen_hover && isset($imagen_hover['id']) && !in_array($imagen_hover['id'], $image_ids_added)) {
    $all_images[] = array(
        'id' => $imagen_hover['id'],
        'url' => $imagen_hover['url'],
        'type' => 'hover',
        'variation_id' => null,
        'attributes' => array()
    );
    $image_ids_added[] = $imagen_hover['id'];
}

// Añadir galería del producto padre
foreach ($gallery_ids as $gallery_id) {
    if (!in_array($gallery_id, $image_ids_added)) {
        $all_images[] = array(
            'id' => $gallery_id,
            'url' => wp_get_attachment_image_url($gallery_id, 'full'),
            'type' => 'gallery',
            'variation_id' => null,
            'attributes' => array()
        );
        $image_ids_added[] = $gallery_id;
    }
}

// ⭐ Añadir imágenes de variaciones (TODAS, con o sin precio)
if ($product->is_type('variable')) {
    $variation_ids = $product->get_children();
    
    foreach ($variation_ids as $variation_id) {
        $variation_obj = wc_get_product($variation_id);
        
        if (!$variation_obj) continue;
        
        $variation_image_id = $variation_obj->get_image_id();
        
        if ($variation_image_id) {
            // Obtener atributos de la variación
            $variation_attributes = array();
            foreach ($variation_obj->get_variation_attributes() as $attr_key => $attr_value) {
                $variation_attributes['attribute_' . $attr_key] = $attr_value;
            }
            
            // Añadir siempre (aunque esté duplicada)
            $all_images[] = array(
                'id' => $variation_image_id,
                'url' => wp_get_attachment_image_url($variation_image_id, 'full'),
                'type' => 'variation',
                'variation_id' => $variation_id,
                'attributes' => $variation_attributes
            );
        }
    }
}
?>

<div class="product-galeria" data-product-id="<?php echo $product->get_id(); ?>">
    
    <!-- Contenedor principal con imagen y miniaturas superpuestas -->
    <div class="galeria-main-wrapper">
        
        <!-- Imagen principal grande -->
        <div class="galeria-main">
            <img id="main-image" 
                 src="<?php echo esc_url($image_url); ?>" 
                 alt="<?php echo esc_attr($product->get_name()); ?>" 
                 data-default-image="<?php echo esc_url($image_url); ?>">
        </div>
        
        <!-- Miniaturas superpuestas en la parte inferior -->
        <?php if (count($all_images) > 1): ?>
            <div class="galeria-thumbs">
                <?php foreach ($all_images as $index => $img): ?>
                    <div class="thumb <?php echo $index === 0 ? 'active' : ''; ?>" 
                         data-image="<?php echo esc_url($img['url']); ?>"
                         data-image-id="<?php echo esc_attr($img['id']); ?>"
                         data-type="<?php echo esc_attr($img['type']); ?>"
                         data-variation-id="<?php echo esc_attr($img['variation_id'] ?? ''); ?>"
                         <?php 
                         // ⭐ Añadir atributos de variación como data-attributes
                         if (!empty($img['attributes'])): 
                             foreach ($img['attributes'] as $attr_key => $attr_value): 
                                 $clean_key = str_replace('attribute_', '', $attr_key);
                                 ?>
                                 data-<?php echo esc_attr($clean_key); ?>="<?php echo esc_attr($attr_value); ?>"
                                 <?php 
                             endforeach;
                         endif;
                         ?>>
                        <img src="<?php echo esc_url($img['url']); ?>" 
                             alt="Miniatura <?php echo $index + 1; ?>">
                    </div>
                <?php endforeach; ?>
                
                <!-- Flechas de navegación -->
                <button class="galeria-thumbs-arrow galeria-thumbs-arrow-left" id="thumbsArrowLeft">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                </button>
                <button class="galeria-thumbs-arrow galeria-thumbs-arrow-right" id="thumbsArrowRight">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </button>
            </div>
        <?php endif; ?>
        
    </div>
    
</div>

