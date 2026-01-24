document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const menuOverlay = document.querySelector('.menu-overlay');
    const fixedHeader = document.querySelector('.fixed-header');
    
    if (!menuToggle || !menuOverlay) return;
    
    let isMenuOpen = false;
    
    // Abrir menú al hacer hover en el botón MENÚ
    menuToggle.addEventListener('mouseenter', function() {
        menuOverlay.classList.add('active');
        isMenuOpen = true;
    });
    
    // Cerrar menú al salir del overlay
    menuOverlay.addEventListener('mouseleave', function() {
        menuOverlay.classList.remove('active');
        isMenuOpen = false;
    });
    
    // También cerrar si sales del header hacia arriba
    fixedHeader.addEventListener('mouseleave', function(e) {
        // Solo cerrar si el mouse sale hacia arriba (no hacia el overlay)
        if (e.clientY < fixedHeader.getBoundingClientRect().bottom && isMenuOpen) {
            menuOverlay.classList.remove('active');
            isMenuOpen = false;
        }
    });
});