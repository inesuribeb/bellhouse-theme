document.addEventListener('DOMContentLoaded', function() {
    const grid = document.querySelector('.tienda-grid');
    if (!grid) return;
    
    function updateBorders() {
        const cards = Array.from(grid.querySelectorAll('.product-card'));
        const gridRect = grid.getBoundingClientRect();
        
        // Obtener la posición Y de la primera fila
        let firstRowTop = null;
        
        cards.forEach(card => {
            const cardTop = card.offsetTop;
            
            // Detectar primera fila
            if (firstRowTop === null) {
                firstRowTop = cardTop;
            }
        });
        
        cards.forEach(card => {
            const rect = card.getBoundingClientRect();
            const cardTop = card.offsetTop;
            
            // Border derecho: si está en el borde derecho del grid
            const isAtRightEdge = Math.abs((rect.right - gridRect.right)) < 5;
            
            // Border top: si está en la primera fila
            const isAtTop = Math.abs(cardTop - firstRowTop) < 5;
            
            // Aplicar clases
            if (isAtRightEdge) {
                card.classList.remove('border-right');
            } else {
                card.classList.add('border-right');
            }
            
            if (isAtTop) {
                card.classList.add('border-top');
            } else {
                card.classList.remove('border-top');
            }
        });
    }
    
    // Ejecutar al cargar y al cambiar tamaño
    updateBorders();
    window.addEventListener('resize', updateBorders);
});