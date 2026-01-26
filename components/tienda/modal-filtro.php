<?php
/**
 * Subcategorías + Botón Filtrar
 */

// ========================================
// DETECTAR CONTEXTO ACTUAL
// ========================================

$es_novedades = is_page('novedades');
$es_ofertas = is_page('ofertas');

// Solo mostrar si estamos en tienda, categoría, novedades u ofertas
if (!is_shop() && !is_product_category() && !$es_novedades && !$es_ofertas) {
    return;
}
?>

<div class="subcategorias-filtrar-container">
    
    <?php
    // Incluir subcategorías (se mostrarán solo si existen)
    include(get_stylesheet_directory() . '/components/tienda/subcategorias.php');
    ?>
    
    <!-- Botón FILTRAR (siempre visible) -->
    <div class="filtrar-ordenar-wrapper">
        <button class="filtrar-btn" id="filtrarBtn">
            <span>FILTRAR</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
            </svg>
        </button>
    </div>

</div>