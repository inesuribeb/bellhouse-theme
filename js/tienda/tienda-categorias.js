document.addEventListener('DOMContentLoaded', function() {
    const categoriasContainer = document.querySelector('.tienda-categorias');
    const categorias = document.querySelectorAll('.categoria-item');
    
    if (!categoriasContainer || categorias.length === 0) return;
    
    // Crear el subrayado animado
    const underline = document.createElement('div');
    underline.className = 'categoria-underline';
    categoriasContainer.appendChild(underline);
    
    // Función para mover el subrayado
    function moveUnderline(item) {
        const itemRect = item.getBoundingClientRect();
        const containerRect = categoriasContainer.getBoundingClientRect();
        const left = itemRect.left - containerRect.left;
        const width = itemRect.width;
        
        underline.style.left = left + 'px';
        underline.style.width = width + 'px';
    }
    
    // Inicializar en el item activo
    const activeItem = document.querySelector('.categoria-item.active');
    if (activeItem) {
        moveUnderline(activeItem);
    }
    
    // Hover en cada categoría
    categorias.forEach(item => {
        item.addEventListener('mouseenter', function() {
            moveUnderline(this);
        });
    });
    
    // Volver al activo cuando sale el mouse
    categoriasContainer.addEventListener('mouseleave', function() {
        if (activeItem) {
            moveUnderline(activeItem);
        }
    });
});