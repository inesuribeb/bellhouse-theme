<?php
/**
 * HTML del Modal de Filtros
 * Este archivo se incluye al final del body
 */

// ⭐ Solo cargar en páginas de tienda, categorías, novedades y ofertas
if (!is_shop() && !is_product_category() && !is_product_tag() && !is_page('novedades') && !is_page('ofertas')) {
    return;
}

// ========================================
// OBTENER CATEGORÍA ACTUAL
// ========================================

$current_category_id = null;

if (is_product_category()) {
    $current_category = get_queried_object();
    $current_category_id = $current_category->term_id;
    
} elseif ((is_page('novedades') || is_page('ofertas')) && isset($_GET['categoria'])) {
    // ⭐ Detectar categoría en Novedades/Ofertas desde parámetro URL
    $categoria_slug = sanitize_text_field($_GET['categoria']);
    $current_category = get_term_by('slug', $categoria_slug, 'product_cat');
    if ($current_category) {
        $current_category_id = $current_category->term_id;
    }
}

// ========================================
// OBTENER COLORES (filtrados por categoría)
// ========================================

$color_args = array(
    'taxonomy' => 'pa_color',
    'hide_empty' => true,
);

// Si estamos en una categoría, solo mostrar colores de productos en esa categoría
if ($current_category_id) {
    // Obtener productos de la categoría
    $products_in_cat = get_posts(array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'fields' => 'ids',
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $current_category_id,
            ),
        ),
    ));
    
    $color_args['object_ids'] = $products_in_cat;
}

$colores = get_terms($color_args);

// ========================================
// OBTENER MATERIALES (filtrados por categoría)
// ========================================

$material_args = array(
    'taxonomy' => 'pa_materiales',
    'hide_empty' => true,
);

// Si estamos en una categoría, solo mostrar materiales de productos en esa categoría
if ($current_category_id) {
    $material_args['object_ids'] = $products_in_cat;
}

$materiales = get_terms($material_args);

// ========================================
// DETECTAR SI OCULTAR TAB ORDENAR
// ========================================

$ocultar_ordenar = is_page('novedades') || is_page('ofertas');
?>

<!-- Modal lateral derecho -->
<div class="filtrar-modal" id="filtrarModal">
    <!-- Overlay oscuro -->
    <div class="filtrar-modal-overlay" id="filtrarModalOverlay"></div>

    <!-- Panel lateral -->
    <div class="filtrar-modal-panel">

        <!-- Header con tabs y close -->
        <div class="filtrar-modal-header">
            <div class="filtrar-modal-tabs <?php echo $ocultar_ordenar ? 'solo-filtrar' : ''; ?>">
                <button class="filtrar-modal-tab active" data-tab="filtrar">FILTRAR</button>
                <?php if (!$ocultar_ordenar): ?>
                    <span class="filtrar-modal-separator">|</span>
                    <button class="filtrar-modal-tab" data-tab="ordenar">ORDENAR</button>
                <?php endif; ?>
            </div>
            <button class="filtrar-modal-close" id="filtrarModalClose">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Contenido FILTRAR -->
        <div class="filtrar-modal-content" id="filtrarContent">

            <!-- ========== COLOR ========== -->
            <div class="filtro-seccion">
                <button class="filtro-toggle" data-target="filtroColores">
                    <h3 class="filtro-titulo">COLOR</h3>
                    <svg class="filtro-icon filtro-icon-plus" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <svg class="filtro-icon filtro-icon-minus" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                    </svg>
                </button>
                <div class="filtro-content" id="filtroColores">
                    <?php if (!empty($colores) && !is_wp_error($colores)): ?>
                        <div class="filtro-colores">
                        <?php
                        foreach ($colores as $color):
                            $color_slug = $color->slug;
                            ?>
                            <button class="color-swatch" data-color="<?php echo esc_attr($color_slug); ?>" data-value="<?php echo esc_attr($color->term_id); ?>">
                                <span class="color-swatch-inner"></span>
                            </button>
                        <?php endforeach;
                        ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- ========== MATERIAL ========== -->
            <div class="filtro-seccion">
                <button class="filtro-toggle" data-target="filtroMateriales">
                    <h3 class="filtro-titulo">MATERIAL</h3>
                    <svg class="filtro-icon filtro-icon-plus" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <svg class="filtro-icon filtro-icon-minus" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                    </svg>
                </button>
                <div class="filtro-content" id="filtroMateriales">
                    <?php if (!empty($materiales) && !is_wp_error($materiales)): ?>
                        <div class="filtro-materiales">
                        <?php
                        foreach ($materiales as $material):
                            ?>
                            <button class="material-box" data-value="<?php echo esc_attr($material->term_id); ?>">
                                <?php echo esc_html($material->name); ?>
                            </button>
                        <?php endforeach;
                        ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- ========== RANGO DE PRECIO ========== -->
            <div class="filtro-seccion">
                <button class="filtro-toggle" data-target="filtroPrecio">
                    <h3 class="filtro-titulo">RANGO DE PRECIO</h3>
                    <svg class="filtro-icon filtro-icon-plus" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <svg class="filtro-icon filtro-icon-minus" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                    </svg>
                </button>
                <div class="filtro-content" id="filtroPrecio">
                    <div class="filtro-precio">
                        <div class="precio-inputs">
                            <input type="number" id="precioMin" placeholder="0" min="0" max="5000" value="0">
                            <span>—</span>
                            <input type="number" id="precioMax" placeholder="5000" min="0" max="5000" value="5000">
                        </div>
                        <div class="precio-slider">
                            <input type="range" id="sliderMin" min="0" max="5000" step="50" value="0">
                            <input type="range" id="sliderMax" min="0" max="5000" step="50" value="5000">
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Contenido ORDENAR (solo si NO es Novedades/Ofertas) -->
        <?php if (!$ocultar_ordenar): ?>
        <div class="filtrar-modal-content" id="ordenarContent" style="display: none;">
            
            <div class="ordenar-opciones">
                
                <!-- TODO (por defecto) -->
                <label class="ordenar-opcion">
                    <input type="radio" name="ordenar" value="todo" class="ordenar-radio" checked>
                    <span class="ordenar-label">TODO</span>
                </label>
                
                <!-- Novedad -->
                <label class="ordenar-opcion">
                    <input type="radio" name="ordenar" value="novedad" class="ordenar-radio">
                    <span class="ordenar-label">NOVEDAD</span>
                </label>
                
                <!-- Rebajado -->
                <label class="ordenar-opcion">
                    <input type="radio" name="ordenar" value="rebajado" class="ordenar-radio">
                    <span class="ordenar-label">REBAJADO</span>
                </label>
                
            </div>
            
        </div>
        <?php endif; ?>

        <!-- Footer con botones BORRAR y APLICAR -->
        <div class="filtrar-modal-footer">
            <button class="filtrar-modal-borrar" id="filtrarBorrarBtn">BORRAR</button>
            <button class="filtrar-modal-aplicar" id="filtrarAplicarBtn">APLICAR</button>
        </div>

    </div>
</div>