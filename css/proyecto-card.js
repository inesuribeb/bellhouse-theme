document.addEventListener('DOMContentLoaded', function() {
    function ajustarAlturaCards() {
        const cards = document.querySelectorAll('.proyecto-card');
        
        // Resetear altura para recalcular
        cards.forEach(card => {
            card.style.height = 'auto';
        });
        
        let maxHeight = 0;
        
        // Calcular la altura máxima basada en las imágenes horizontales
        cards.forEach(card => {
            if (card.classList.contains('horizontal')) {
                const imageContainer = card.querySelector('.proyecto-card__image');
                const containerWidth = imageContainer.offsetWidth;
                
                // Calcular altura para aspect ratio 4:3
                const calculatedHeight = (containerWidth * 3) / 4;
                
                if (calculatedHeight > maxHeight) {
                    maxHeight = calculatedHeight;
                }
            }
        });
        
        // Aplicar la altura a todas las cards
        if (maxHeight > 0) {
            cards.forEach(card => {
                card.style.height = maxHeight + 'px';
            });
        }
    }
    
    // Ajustar al cargar
    ajustarAlturaCards();
    
    // Ajustar al cambiar tamaño de ventana
    window.addEventListener('resize', ajustarAlturaCards);
});