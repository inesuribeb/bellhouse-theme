document.addEventListener('DOMContentLoaded', function() {
    // Solo en home
    if (!document.body.classList.contains('home')) return;
    
    const header = document.querySelector('.fixed-header');
    const portadaSection = document.querySelector('.home-portada');
    
    if (!header || !portadaSection) return;
    
    // Observar cuando el header sale de la sección portada
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Estamos en portada → header transparente
                header.classList.add('header-transparent');
            } else {
                // Salimos de portada → header normal
                header.classList.remove('header-transparent');
            }
        });
    }, {
        threshold: 0.1, // Se activa cuando 10% de portada es visible
        rootMargin: '-70px 0px 0px 0px' // Offset para que cambie justo cuando pase el header
    });
    
    observer.observe(portadaSection);
});