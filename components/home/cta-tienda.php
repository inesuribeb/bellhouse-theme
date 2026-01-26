<?php
/**
 * CTA Tienda - Grid de productos con categorías
 */

// Obtener campos ACF
$label = get_field('home_tienda_label') ?: '/tienda';
$titulo = get_field('home_tienda_titulo') ?: 'Selección Bell House';
$texto = get_field('home_tienda_texto') ?: 'Nuestros favoritos. Ahora online.';

// Obtener categorías principales
$categorias = get_terms(array(
    'taxonomy' => 'product_cat',
    'hide_empty' => false,
    'parent' => 0,
    'exclude' => array(get_option('default_product_cat')),
));
?>

<section class="home-tienda">
    <div class="home-tienda-container">
        
        <!-- Header -->
        <div class="home-tienda-header">
            <span class="home-tienda-label"><?php echo esc_html($label); ?></span>
            <h2 class="home-tienda-titulo"><?php echo esc_html($titulo); ?></h2>
            <p class="home-tienda-texto"><?php echo esc_html($texto); ?></p>
        </div>
        
        <!-- Categorías (igual que en tienda) -->
        <div class="home-tienda-categorias">
            <div class="categoria-underline"></div>
            <nav class="categorias-grid" id="homeTiendaCategorias">
                
                <!-- TODOS (activo por defecto) -->
                <button class="categoria-item active" data-categoria="todos" data-slug="">
                    <span class="categoria-nombre">TODOS</span>
                </button>
                
                <?php if (!empty($categorias) && !is_wp_error($categorias)): ?>
                    <?php foreach ($categorias as $categoria): ?>
                        <?php if ($categoria->slug === 'uncategorized') continue; ?>
                        <button class="categoria-item" 
                                data-categoria="<?php echo esc_attr($categoria->slug); ?>"
                                data-slug="<?php echo esc_attr($categoria->slug); ?>">
                            <span class="categoria-nombre"><?php echo strtoupper($categoria->name); ?></span>
                        </button>
                    <?php endforeach; ?>
                <?php endif; ?>
                
            </nav>
        </div>
        
        <!-- Grid de productos (6 columnas) -->
        <div class="home-tienda-grid" id="homeTiendaGrid">
            <!-- Los productos se cargarán aquí con JavaScript -->
        </div>
        
    </div>
</section>