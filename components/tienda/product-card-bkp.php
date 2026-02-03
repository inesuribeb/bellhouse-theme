<?php
/**
 * Product Card
 */

global $product;

// Leer desde query_var
$card_is_horizontal = get_query_var('card_is_horizontal', false);

// Obtener datos del producto
$product_id = get_the_ID();
$product_title = get_the_title();
$product_link = get_permalink();
$product_price = $product->get_price_html();

// Imagen principal
$image_id = $product->get_image_id();
$image_url = wp_get_attachment_image_url($image_id, 'full');

// Imagen hover (ACF)
$imagen_hover = get_field('imagen_hover', $product_id);
$hover_url = $imagen_hover ? $imagen_hover['url'] : null;

// Determinar clase vertical/horizontal
$orientation_class = $card_is_horizontal ? 'horizontal' : 'vertical';

// ⭐ NUEVO: Verificar si es novedad o está rebajado
$es_novedad = get_field('novedad', $product_id);
$es_rebajado = $product->is_on_sale();
?>
<article class="product-card <?php echo $orientation_class; ?>">
    <a href="<?php echo esc_url($product_link); ?>" class="product-card__link">

        <!-- Imagen -->
        <div class="product-card__image">
            
            <!-- ⭐ NUEVO: Etiquetas -->
            <?php if ($es_novedad || $es_rebajado): ?>
                <div class="product-card__badges">
                    <?php if ($es_novedad): ?>
                        <span class="product-card__badge product-card__badge--novedad">NOVEDAD</span>
                    <?php endif; ?>
                    
                    <?php if ($es_rebajado): ?>
                        <span class="product-card__badge product-card__badge--oferta">OFERTA</span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <?php if ($image_url): ?>
                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($product_title); ?>"
                    class="product-card__img-main">
            <?php endif; ?>

            <?php if ($hover_url): ?>
                <img src="<?php echo esc_url($hover_url); ?>" alt="<?php echo esc_attr($product_title); ?>"
                    class="product-card__img-hover">
            <?php endif; ?>
        </div>

        <!-- Info -->
        <div class="product-card__info">
            <div class="product-card__main-info">
                <h3 class="product-card__title"><?php echo esc_html($product_title); ?></h3>
                <div class="product-card__price"><?php echo $product_price; ?></div>
            </div>
            <button class="product-card__cta">COMPRAR</button>
        </div>

    </a>
</article>