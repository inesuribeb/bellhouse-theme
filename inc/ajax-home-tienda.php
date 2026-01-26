<?php
// ========================================
// AJAX: Obtener productos para Home Tienda
// ========================================

add_action('wp_ajax_get_home_tienda_productos', 'bellhouse_get_home_tienda_productos');
add_action('wp_ajax_nopriv_get_home_tienda_productos', 'bellhouse_get_home_tienda_productos');

function bellhouse_get_home_tienda_productos() {
    $categoria = isset($_POST['categoria']) ? sanitize_text_field($_POST['categoria']) : 'todos';
    
    error_log('🚀 Petición AJAX recibida para categoría: ' . $categoria);
    
    // Mapeo de categorías a posiciones y cantidad
    $configuracion = array(
        'todos' => array('posiciones' => array(1,2,3,4,5,6), 'cantidad' => 6),
        'asientos' => array('posiciones' => array(1,3,4), 'cantidad' => 3),
        'objetos' => array('posiciones' => array(1,2,3,6), 'cantidad' => 4),
        'muebles' => array('posiciones' => array(2,3,5), 'cantidad' => 3),
        'iluminacion' => array('posiciones' => array(3,4,6), 'cantidad' => 3),
        'textiles' => array('posiciones' => array(2,3,6), 'cantidad' => 3),
    );
    
    $config = isset($configuracion[$categoria]) ? $configuracion[$categoria] : $configuracion['todos'];
    $productos = array();
    
    if ($categoria === 'todos') {
        // Para TODOS: 1 producto aleatorio de cada categoría principal
        $categorias_principales = get_terms(array(
            'taxonomy' => 'product_cat',
            'hide_empty' => true,
            'parent' => 0,
            'exclude' => array(get_option('default_product_cat')),
        ));
        
        error_log('🔍 Total categorías encontradas: ' . count($categorias_principales));
        
        foreach ($categorias_principales as $cat) {
            if ($cat->slug === 'uncategorized') continue;
            
            error_log('🔍 Buscando producto en categoría: ' . $cat->name . ' (slug: ' . $cat->slug . ')');
            
            $producto = get_posts(array(
                'post_type' => 'product',
                'posts_per_page' => 1,
                'orderby' => 'rand',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'term_id',
                        'terms' => $cat->term_id,
                    ),
                ),
            ));
            
            if (!empty($producto)) {
                $productos[] = $producto[0];
                error_log('✅ Producto encontrado: ' . $producto[0]->post_title);
            } else {
                error_log('❌ No hay productos en esta categoría');
            }
        }
        
        error_log('🔍 Total productos después del loop: ' . count($productos));
        
        // ⭐ Añadir 1 producto extra de OBJETOS
        $objetos_term = get_term_by('slug', 'objetos', 'product_cat');
        error_log('🔍 Buscando término objetos: ' . ($objetos_term ? $objetos_term->name : 'NO ENCONTRADO'));
        
        if ($objetos_term) {
            error_log('🔍 ID de objetos: ' . $objetos_term->term_id);
            
            $producto_extra = get_posts(array(
                'post_type' => 'product',
                'posts_per_page' => 1,
                'orderby' => 'rand',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'term_id',
                        'terms' => $objetos_term->term_id,
                    ),
                ),
            ));
            
            error_log('🔍 Productos extra encontrados: ' . count($producto_extra));
            
            if (!empty($producto_extra)) {
                $productos[] = $producto_extra[0];
                error_log('✅ Producto extra de objetos añadido: ' . $producto_extra[0]->post_title);
            } else {
                error_log('❌ No se encontró producto extra de objetos');
            }
        } else {
            error_log('❌ Término "objetos" no existe. Listando todas las categorías:');
            $todas = get_terms(array('taxonomy' => 'product_cat', 'hide_empty' => false));
            foreach ($todas as $t) {
                error_log('   - ' . $t->name . ' (slug: ' . $t->slug . ')');
            }
        }
        
        error_log('🔍 Total productos final: ' . count($productos));
        
        // Limitar a 6
        $productos = array_slice($productos, 0, 6);
        
    } else {
        // Para categoría específica: productos aleatorios
        $term = get_term_by('slug', $categoria, 'product_cat');
        
        if ($term) {
            $productos = get_posts(array(
                'post_type' => 'product',
                'posts_per_page' => $config['cantidad'],
                'orderby' => 'rand',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'term_id',
                        'terms' => $term->term_id,
                    ),
                ),
            ));
        }
    }
    
    // Formatear productos para JSON
    $resultado = array();
    foreach ($productos as $index => $producto) {
        $product = wc_get_product($producto->ID);
        $image_id = $product->get_image_id();
        $image_url = wp_get_attachment_image_url($image_id, 'large');
        
        $resultado[] = array(
            'id' => $producto->ID,
            'titulo' => $producto->post_title,
            'precio' => $product->get_price_html(),
            'imagen' => $image_url,
            'link' => get_permalink($producto->ID),
            'posicion' => $config['posiciones'][$index] ?? ($index + 1),
        );
    }
    
    error_log('📤 Enviando ' . count($resultado) . ' productos al frontend');
    
    wp_send_json_success($resultado);
}