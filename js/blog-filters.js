document.addEventListener('DOMContentLoaded', function() {
    // Solo ejecutar en móvil
    if (window.innerWidth > 768) return;
    
    const filterList = document.getElementById('filterList');
    const arrowLeft = document.getElementById('filterArrowLeft');
    const arrowRight = document.getElementById('filterArrowRight');
    
    if (!filterList || !arrowLeft || !arrowRight) return;
    
    // Función para actualizar visibilidad de flechas
    function updateArrows() {
        const scrollLeft = filterList.scrollLeft;
        const maxScroll = filterList.scrollWidth - filterList.clientWidth;
        
        // Ocultar flecha izquierda si está al inicio
        if (scrollLeft <= 5) {
            arrowLeft.style.opacity = '0';
        } else {
            arrowLeft.style.opacity = '0.6';
        }
        
        // Ocultar flecha derecha si está al final
        if (scrollLeft >= maxScroll - 5) {
            arrowRight.style.opacity = '0';
        } else {
            arrowRight.style.opacity = '0.6';
        }
    }
    
    // Actualizar al cargar
    updateArrows();
    
    // Actualizar al hacer scroll
    filterList.addEventListener('scroll', updateArrows);
    
    // Actualizar al redimensionar
    window.addEventListener('resize', updateArrows);
});