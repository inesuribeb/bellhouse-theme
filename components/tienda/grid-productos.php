<?php
/**
 * Grid de productos con filtros
 */

// Obtener productos de WooCommerce
$args = array(
    'post_type' => 'product',
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'DESC',
);

// ========================================
// DETECTAR SI ESTAMOS EN NOVEDADES U OFERTAS
// ========================================

$es_novedades = is_page('novedades');
$es_ofertas = is_page('ofertas');

// Si estamos en una categoría, filtrar por ella
if (is_product_category()) {
    $current_category = get_queried_object();
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'product_cat',
            'field' => 'term_id',
            'terms' => $current_category->term_id,
        ),
    );
}

// ⭐ NUEVO: Si hay parámetro de categoría en URL (desde páginas Novedades/Ofertas)
if (isset($_GET['categoria']) && !empty($_GET['categoria'])) {
    $categoria_slug = sanitize_text_field($_GET['categoria']);
    $categoria = get_term_by('slug', $categoria_slug, 'product_cat');
    
    if ($categoria) {
        if (!isset($args['tax_query'])) {
            $args['tax_query'] = array();
        }
        $args['tax_query']['relation'] = 'AND';
        $args['tax_query'][] = array(
            'taxonomy' => 'product_cat',
            'field' => 'term_id',
            'terms' => $categoria->term_id,
        );
    }
}

// ========================================
// FILTROS DE COLOR Y MATERIAL
// ========================================

if (!isset($args['tax_query'])) {
    $args['tax_query'] = array();
}
$args['tax_query']['relation'] = 'AND';

// Filtro de Color
if (isset($_GET['filter_color']) && !empty($_GET['filter_color'])) {
    $color_ids = array_map('intval', explode(',', sanitize_text_field($_GET['filter_color'])));
    $args['tax_query'][] = array(
        'taxonomy' => 'pa_color',
        'field' => 'term_id',
        'terms' => $color_ids,
        'operator' => 'IN',
    );
}

// Filtro de Material
if (isset($_GET['filter_material']) && !empty($_GET['filter_material'])) {
    $material_ids = array_map('intval', explode(',', sanitize_text_field($_GET['filter_material'])));
    $args['tax_query'][] = array(
        'taxonomy' => 'pa_materiales',
        'field' => 'term_id',
        'terms' => $material_ids,
        'operator' => 'IN',
    );
}

// ========================================
// FILTRO DE PRECIO
// ========================================

if (isset($_GET['min_price']) || isset($_GET['max_price'])) {
    $min_price = isset($_GET['min_price']) ? floatval($_GET['min_price']) : 0;
    $max_price = isset($_GET['max_price']) ? floatval($_GET['max_price']) : 999999;
    
    if (!isset($args['meta_query'])) {
        $args['meta_query'] = array();
    }
    
    $args['meta_query']['relation'] = 'AND';
    $args['meta_query'][] = array(
        'key' => '_price',
        'value' => array($min_price, $max_price),
        'type' => 'NUMERIC',
        'compare' => 'BETWEEN',
    );
}

// ========================================
// ORDENAR / FILTRAR POR NOVEDADES U OFERTAS
// ========================================

// ⭐ Si estamos en la página de Novedades, forzar filtro de novedad
if ($es_novedades) {
    if (!isset($args['meta_query'])) {
        $args['meta_query'] = array();
    }
    $args['meta_query']['relation'] = 'AND';
    $args['meta_query'][] = array(
        'key' => 'novedad',
        'value' => '1',
        'compare' => '=',
    );
    $args['orderby'] = 'date';
    $args['order'] = 'DESC';
    
} elseif ($es_ofertas) {
    // ⭐ Si estamos en la página de Ofertas, forzar filtro de rebajados
    $args['post__in'] = array_merge(
        array(0),
        wc_get_product_ids_on_sale()
    );
    $args['orderby'] = 'date';
    $args['order'] = 'DESC';
    
} else {
    // ⭐ Solo aplicar orderby si NO estamos en Novedades/Ofertas
    $orderby = isset($_GET['orderby']) ? sanitize_text_field($_GET['orderby']) : '';

    if ($orderby === 'novedad') {
        if (!isset($args['meta_query'])) {
            $args['meta_query'] = array();
        }
        $args['meta_query']['relation'] = 'AND';
        $args['meta_query'][] = array(
            'key' => 'novedad',
            'value' => '1',
            'compare' => '=',
        );
        $args['orderby'] = 'date';
        $args['order'] = 'DESC';
        
    } elseif ($orderby === 'rebajado') {
        $args['post__in'] = array_merge(
            array(0),
            wc_get_product_ids_on_sale()
        );
        $args['orderby'] = 'date';
        $args['order'] = 'DESC';
    }
}

$productos = new WP_Query($args);

if ($productos->have_posts()):
?>

<section class="tienda-grid">
    <?php 
    while ($productos->have_posts()): 
        $productos->the_post();
        
        // Leer orientación desde ACF
        $orientacion = get_field('orientacion_card', get_the_ID());
        $is_horizontal = ($orientacion === 'horizontal');
        
        // Pasar variable al componente
        set_query_var('card_is_horizontal', $is_horizontal);
        include(get_stylesheet_directory() . '/components/tienda/product-card.php');
        
    endwhile;
    wp_reset_postdata();
    ?>
</section>

<?php else: ?>
    <p class="no-products"><?php echo get_field('tienda_sin_productos', wc_get_page_id('shop')) ?: 'Aún no hay productos en esta categoría'; ?></p>
<?php endif; ?>