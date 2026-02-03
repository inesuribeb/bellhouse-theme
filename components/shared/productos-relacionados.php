<?php
/**
 * Componente reutilizable: Productos Relacionados
 * Uso: proyectos (Shop the look) y productos (Combínalo con)
 * 
 * Variables requeridas:
 * - $productos: array de posts de productos
 * - $titulo: string del título de la sección
 */

// Solo mostrar si hay productos seleccionados
if ($productos && count($productos) > 0) :
?>

<section class="shop-the-look">
    <div class="shop-container">
        <h2 class="shop-title"><?php echo esc_html($titulo); ?></h2>
        
        <div class="shop-grid">
            <?php foreach ($productos as $producto) : 
                // Obtener datos del producto WooCommerce
                $product = wc_get_product($producto->ID);
                if (!$product) continue;
                
                // Imagen principal
                $imagen = get_the_post_thumbnail_url($producto->ID, 'large');
                
                // Imagen PNG silueteada (ACF)
                $imagen_png = get_field('imagen_png', $producto->ID);
                $imagen_hover_url = $imagen_png ? $imagen_png['url'] : $imagen;
                
                // Datos del producto
                $titulo_producto = get_the_title($producto->ID);
                $link = get_permalink($producto->ID);
                
                // Categoría principal
                $categorias = get_the_terms($producto->ID, 'product_cat');
                $categoria_nombre = '';
                if ($categorias && !is_wp_error($categorias)) {
                    $categoria_nombre = $categorias[0]->name;
                }
                
                // Subcategoría (si tiene más de una categoría)
                $subcategoria_nombre = '';
                if ($categorias && count($categorias) > 1) {
                    $subcategoria_nombre = $categorias[1]->name;
                }
            ?>
            
            <div class="shop-card">
                <a href="<?php echo esc_url($link); ?>" class="shop-card-link">
                    
                    <!-- Imagen de fondo -->
                    <div class="shop-card-image">
                        <img src="<?php echo esc_url($imagen); ?>" alt="<?php echo esc_attr($titulo_producto); ?>">
                    </div>
                    
                    <!-- Cuadro expandible -->
                    <div class="shop-card-box">
                        
                        <!-- Label (visible sin hover) -->
                        <div class="shop-card-label">
                            <!-- Grupo izquierdo -->
                            <div class="shop-card-label-left">
                                <span class="shop-card-dot">•</span>
                                <span class="shop-card-label-text">COMPRAR</span>
                            </div>
                            
                            <!-- Grupo derecho -->
                            <div class="shop-card-label-right">
                                <span class="shop-card-category"><?php echo strtoupper($categoria_nombre); ?></span>
                                <svg class="shop-card-arrow" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Contenido hover (visible con hover) -->
                        <div class="shop-card-hover-content">
                            <h3 class="shop-card-hover-title"><?php echo esc_html($titulo_producto); ?></h3>
                            
                            <?php if ($subcategoria_nombre) : ?>
                                <p class="shop-card-hover-subtitle"><?php echo esc_html($subcategoria_nombre); ?></p>
                            <?php endif; ?>
                            
                            <div class="shop-card-hover-image">
                                <img src="<?php echo esc_url($imagen_hover_url); ?>" alt="<?php echo esc_attr($titulo_producto); ?>">
                            </div>
                            
                            <span class="shop-card-hover-button">COMPRAR</span>
                        </div>
                        
                    </div>
                    
                </a>
            </div>
            
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php endif; ?>