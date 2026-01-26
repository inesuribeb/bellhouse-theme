<?php
/**
 * Subcategorías de tienda
 * Se muestran cuando estás en una categoría que tiene subcategorías
 */

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

// Variables para detectar categoría/subcategoría
$current_category = null;
$category_to_show = null;

// ========================================
// DETECTAR CATEGORÍA ACTUAL
// ========================================

if (is_product_category()) {
    // Estamos en una categoría estándar
    $current_category = get_queried_object();
    
    $parent_id = $current_category->parent;
    if ($parent_id != 0) {
        $category_to_show = $parent_id;
    } else {
        $category_to_show = $current_category->term_id;
    }
    
} elseif (($es_novedades || $es_ofertas) && isset($_GET['categoria'])) {
    // Estamos en Novedades/Ofertas con filtro de categoría
    $categoria_slug = sanitize_text_field($_GET['categoria']);
    $current_category = get_term_by('slug', $categoria_slug, 'product_cat');
    
    if ($current_category) {
        $parent_id = $current_category->parent;
        if ($parent_id != 0) {
            $category_to_show = $parent_id;
        } else {
            $category_to_show = $current_category->term_id;
        }
    }
}

// Si no hay categoría detectada, no mostrar subcategorías
if (!$category_to_show) {
    return;
}

// Obtener subcategorías
$subcategories = get_terms(array(
    'taxonomy' => 'product_cat',
    'hide_empty' => false,
    'parent' => $category_to_show,
));

// Si no hay subcategorías, no mostrar nada
if (empty($subcategories) || is_wp_error($subcategories)) {
    return;
}
?>

<section class="tienda-subcategorias">
    <!-- Flechas indicadoras -->
    <div class="subcategoria-arrow subcategoria-arrow-left" id="subcategoriaArrowLeft">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
        </svg>
    </div>

    <div class="subcategoria-arrow subcategoria-arrow-right" id="subcategoriaArrowRight">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
    </div>

    <div class="subcategorias-list" id="subcategoriasList">
        <!-- Botón "TODO" que lleva a la categoría padre -->
        <?php
        $parent_category = get_term($category_to_show, 'product_cat');
        
        // ⭐ Construir URL según contexto
        if ($es_novedades || $es_ofertas) {
            $todo_url = add_query_arg('categoria', $parent_category->slug, $current_page_url);
            $todo_active = (isset($_GET['categoria']) && $_GET['categoria'] === $parent_category->slug);
        } else {
            $todo_url = get_term_link($parent_category);
            $todo_active = ($current_category->term_id == $category_to_show);
        }
        ?>
        <a href="<?php echo esc_url($todo_url); ?>" class="subcategoria-item <?php echo $todo_active ? 'active' : ''; ?>">
            TODO
        </a>

        <?php foreach ($subcategories as $subcategory): 
            // ⭐ Construir URL según contexto
            if ($es_novedades || $es_ofertas) {
                $subcategory_url = add_query_arg('categoria', $subcategory->slug, $current_page_url);
                $subcategory_active = (isset($_GET['categoria']) && $_GET['categoria'] === $subcategory->slug);
            } else {
                $subcategory_url = get_term_link($subcategory);
                $subcategory_active = is_product_category($subcategory->slug);
            }
        ?>
            <a href="<?php echo esc_url($subcategory_url); ?>" class="subcategoria-item <?php echo $subcategory_active ? 'active' : ''; ?>">
                <?php echo strtoupper($subcategory->name); ?>
            </a>
        <?php endforeach; ?>
    </div>
</section>