<?php
/**
 * Categorías principales
 */

// Obtener categorías principales (sin padre)
$main_categories = get_terms(array(
    'taxonomy' => 'product_cat',
    'hide_empty' => false,
    'parent' => 0,
    'exclude' => array(get_option('default_product_cat')), // Excluir "Uncategorized"
));

// ========================================
// DETECTAR CONTEXTO ACTUAL
// ========================================

$es_novedades = is_page('novedades');
$es_ofertas = is_page('ofertas');
$current_page_url = '';

// Si estamos en Novedades u Ofertas, guardar la URL base
if ($es_novedades) {
    $current_page_url = get_permalink(get_page_by_path('novedades'));
} elseif ($es_ofertas) {
    $current_page_url = get_permalink(get_page_by_path('ofertas'));
}

// Detectar la categoría actual
$current_category_id = null;
$parent_category_id = null;
$is_shop_page = is_shop() && !$es_novedades && !$es_ofertas;

// Si estamos en categoría específica
if (is_product_category()) {
    $current_category = get_queried_object();
    $current_category_id = $current_category->term_id;
    
    if ($current_category->parent != 0) {
        $parent_category_id = $current_category->parent;
    } else {
        $parent_category_id = $current_category_id;
    }
}

// Si estamos en Novedades/Ofertas con parámetro de categoría
if (($es_novedades || $es_ofertas) && isset($_GET['categoria'])) {
    $categoria_slug = sanitize_text_field($_GET['categoria']);
    $categoria = get_term_by('slug', $categoria_slug, 'product_cat');
    
    if ($categoria) {
        if ($categoria->parent != 0) {
            $parent_category_id = $categoria->parent;
        } else {
            $parent_category_id = $categoria->term_id;
        }
    }
}

if (!empty($main_categories) && !is_wp_error($main_categories)):
?>

<section class="tienda-categorias">
    
    <div class="categoria-underline"></div>
    
    <nav class="categorias-grid" id="categoriasGrid">
        
        <!-- ⭐ BOTÓN "TODOS" -->
        <?php
        if ($es_novedades || $es_ofertas) {
            // En Novedades/Ofertas: TODOS lleva a la página sin filtro de categoría
            $todos_url = $current_page_url;
            $todos_active = !isset($_GET['categoria']);
        } else {
            // En tienda normal: TODOS lleva a /tienda/
            $todos_url = get_permalink(wc_get_page_id('shop'));
            $todos_active = $is_shop_page;
        }
        ?>
        <a href="<?php echo esc_url($todos_url); ?>" 
           class="categoria-item <?php echo $todos_active ? 'active' : ''; ?>" 
           data-category-id="todos">
            <span class="categoria-nombre">TODOS</span>
        </a>
        
        <?php foreach ($main_categories as $category): 
            // Saltar "Uncategorized"
            if ($category->slug === 'uncategorized') continue;
            
            // ⭐ Construir URL según el contexto
            if ($es_novedades || $es_ofertas) {
                // En Novedades/Ofertas: añadir parámetro ?categoria=slug
                $category_url = add_query_arg('categoria', $category->slug, $current_page_url);
            } else {
                // En tienda normal: URL de categoría estándar
                $category_url = get_term_link($category);
            }
            
            // Marcar como activa
            $is_active = ($category->term_id == $parent_category_id);
            $active_class = $is_active ? 'active' : '';
        ?>
            <a href="<?php echo esc_url($category_url); ?>" 
               class="categoria-item <?php echo $active_class; ?>" 
               data-category-id="<?php echo $category->term_id; ?>">
                <span class="categoria-nombre"><?php echo strtoupper($category->name); ?></span>
            </a>
        <?php endforeach; ?>
        
    </nav>
    
</section>

<?php endif; ?>