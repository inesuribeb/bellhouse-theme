<?php
/**
 * Modal de carrito - estructura principal
 */
?>

<div class="modal-carrito" id="modalCarrito">
    <div class="modal-carrito-overlay" id="modalCarritoOverlay"></div>
    
    <div class="modal-carrito-panel">
        
        <!-- Header: TU CESTA (N) -->
        <?php include(get_stylesheet_directory() . '/components/producto/modal-carrito-header.php'); ?>
        
        <!-- Lista de productos (scroll interno) -->
        <?php include(get_stylesheet_directory() . '/components/producto/modal-carrito-productos.php'); ?>
        
        <!-- Subtotal + Botón finalizar -->
        <?php include(get_stylesheet_directory() . '/components/producto/modal-carrito-footer.php'); ?>
        
    </div>
</div>