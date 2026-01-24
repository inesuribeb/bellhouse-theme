document.addEventListener('DOMContentLoaded', function() {
    const projectCards = document.querySelectorAll('.proyecto-card');
    
    if (!projectCards.length) return;
    
    // Intersection Observer para detectar cuando entran en pantalla
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                // Opcional: dejar de observar después de animar
                // observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1, // Se activa cuando el 10% es visible
        rootMargin: '0px 0px -50px 0px' // Se activa 50px antes de que entre
    });
    
    // Observar todas las tarjetas
    projectCards.forEach(card => {
        observer.observe(card);
    });
});