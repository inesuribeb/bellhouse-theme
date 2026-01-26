<?php
/**
 * Intro de la tienda
 * Detecta si estamos en: Tienda general, Categoría, Novedades u Ofertas
 */

// Inicializar variables
$titulo = '';
$texto = '';

// ========================================
// DETECTAR PÁGINA ACTUAL
// ========================================

if (is_page('novedades')) {
    // ⭐ NOVEDADES
    $titulo = get_field('novedades_titulo') ?: 'Novedades';
    $texto = get_field('novedades_texto') ?: 'Descubre las últimas incorporaciones a nuestro catálogo.';
    
} elseif (is_page('ofertas')) {
    // ⭐ OFERTAS
    $titulo = get_field('ofertas_titulo') ?: 'Ofertas';
    $texto = get_field('ofertas_texto') ?: 'Productos seleccionados con descuentos exclusivos.';
    
} elseif (is_product_category()) {
    // ⭐ CATEGORÍA ESPECÍFICA
    $current_category = get_queried_object();
    $titulo = $current_category->name;
    $texto = $current_category->description ?: 'Explora nuestra selección de ' . strtolower($current_category->name) . '.';
    
} else {
    // ⭐ TIENDA GENERAL
    $shop_page_id = wc_get_page_id('shop');
    $titulo = get_field('tienda_titulo', $shop_page_id) ?: 'Nuestra selección';
    $texto = get_field('tienda_texto', $shop_page_id) ?: 'Esta no es una tienda más...';
}
?>

<section class="tienda-intro">
    <div class="tienda-intro-content">
        <h1 class="tienda-titulo"><?php echo esc_html($titulo); ?></h1>
        <p class="tienda-texto"><?php echo esc_html($texto); ?></p>
    </div>
</section>