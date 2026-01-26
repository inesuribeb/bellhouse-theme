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
                <div class="modal-thumb <?php echo $index === 0 ? 'active' : ''; ?>" 
                     data-index="<?php echo $index; ?>" 
                     data-image="<?php echo esc_url($img['url']); ?>"
                     data-type="<?php echo esc_attr($img['type']); ?>"
                     data-variation-id="<?php echo esc_attr($img['variation_id'] ?? ''); ?>"
                     <?php 
                     // Añadir atributos de variación
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
        </div>
    </div>
</div>