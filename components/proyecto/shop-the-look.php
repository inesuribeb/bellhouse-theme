<?php
/**
 * Componente: Shop the Look
 * Muestra productos relacionados con el proyecto
 */

// Obtener los productos seleccionados
$productos = get_field('shop_the_look_productos');

// Solo mostrar si hay productos seleccionados
if ($productos && count($productos) > 0) :
?>

<section class="shop-the-look">
    <div class="shop-container">
        <h2 class="shop-title">Shop the look</h2>
        
        <div class="shop-grid">
            <?php foreach ($productos as $producto) : 
                // Obtener datos del producto WooCommerce
                $product = wc_get_product($producto->ID);
                if (!$product) continue;
                
                $imagen = get_the_post_thumbnail_url($producto->ID, 'large');
                $titulo = get_the_title($producto->ID);
                $precio = $product->get_price_html();
                $link = get_permalink($producto->ID);
            ?>
            
            <div class="shop-card">
                <a href="<?php echo esc_url($link); ?>" class="shop-card-link">
                    <?php if ($imagen) : ?>
                        <div class="shop-card-image">
                            <img src="<?php echo esc_url($imagen); ?>" alt="<?php echo esc_attr($titulo); ?>">
                        </div>
                    <?php endif; ?>
                    
                    <div class="shop-card-content">
                        <h3 class="shop-card-title"><?php echo esc_html($titulo); ?></h3>
                        <div class="shop-card-price"><?php echo $precio; ?></div>
                        <span class="shop-card-button">COMPRAR</span>
                    </div>
                </a>
            </div>
            
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php endif; ?>