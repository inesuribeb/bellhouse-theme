document.addEventListener('DOMContentLoaded', function() {
    const subcategoriasList = document.getElementById('subcategoriasList');
    const arrowLeft = document.getElementById('subcategoriaArrowLeft');
    const arrowRight = document.getElementById('subcategoriaArrowRight');
    
    if (!subcategoriasList || !arrowLeft || !arrowRight) return;
    
    // Función para actualizar visibilidad de flechas
    function updateArrows() {
        const scrollLeft = subcategoriasList.scrollLeft;
        const maxScroll = subcategoriasList.scrollWidth - subcategoriasList.clientWidth;
        
        // Si no hay scroll (todo cabe), ocultar flechas
        if (maxScroll <= 0) {
            arrowLeft.style.display = 'none';
            arrowRight.style.display = 'none';
            return;
        }
        
        // Mostrar/ocultar según posición
        if (scrollLeft <= 0) {
            arrowLeft.style.display = 'none';
        } else {
            arrowLeft.style.display = 'flex';
        }
        
        if (scrollLeft >= maxScroll - 1) {
            arrowRight.style.display = 'none';
        } else {
            arrowRight.style.display = 'flex';
        }
    }
    
    // Ejecutar al cargar y al hacer scroll
    updateArrows();
    subcategoriasList.addEventListener('scroll', updateArrows);
    window.addEventListener('resize', updateArrows);
    
    // ⭐ NUEVO: Click en flechas para hacer scroll
    const scrollAmount = 200; // Píxeles a desplazar
    
    arrowLeft.addEventListener('click', function() {
        subcategoriasList.scrollBy({
            left: -scrollAmount,
            behavior: 'smooth'
        });
    });
    
    arrowRight.addEventListener('click', function() {
        subcategoriasList.scrollBy({
            left: scrollAmount,
            behavior: 'smooth'
        });
    });
    
    // Hacer scroll automático al item activo al cargar
    setTimeout(function() {
        const activeItem = subcategoriasList.querySelector('.subcategoria-item.active');
        if (activeItem) {
            activeItem.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest',
                inline: 'center'
            });
        }
    }, 100);
});