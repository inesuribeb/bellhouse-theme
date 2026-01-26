<?php
/**
 * Botón Filtrar/Ordenar + Modal
 */
?>

<!-- Botón FILTRAR -->
<div class="filtrar-ordenar-wrapper">
    <button class="filtrar-btn" id="filtrarBtn">
        <span>FILTRAR</span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
        </svg>
    </button>
</div>

<!-- Modal lateral derecho -->
<div class="filtrar-modal" id="filtrarModal">
    <!-- Overlay oscuro -->
    <div class="filtrar-modal-overlay" id="filtrarModalOverlay"></div>
    
    <!-- Panel lateral -->
    <div class="filtrar-modal-panel">
        
        <!-- Header con tabs y close -->
        <div class="filtrar-modal-header">
            <div class="filtrar-modal-tabs">
                <button class="filtrar-modal-tab active" data-tab="filtrar">FILTRAR</button>
                <span class="filtrar-modal-separator">|</span>
                <button class="filtrar-modal-tab" data-tab="ordenar">ORDENAR</button>
            </div>
            <button class="filtrar-modal-close" id="filtrarModalClose">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <!-- Contenido FILTRAR -->
        <div class="filtrar-modal-content" id="filtrarContent">
            <p>Contenido de filtros aquí...</p>
        </div>
        
        <!-- Contenido ORDENAR -->
        <div class="filtrar-modal-content" id="ordenarContent" style="display: none;">
            <p>Contenido de ordenar aquí...</p>
        </div>
        
        <!-- Footer con botón BORRAR -->
        <div class="filtrar-modal-footer">
            <button class="filtrar-modal-borrar" id="filtrarBorrar">BORRAR</button>
        </div>
        
    </div>
</div>