document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('.fixed-header');
    const footer = document.querySelector('.site-footer');
    
    if (!header || !footer) return;
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Header está sobre footer → ocultar
                header.classList.add('header-hidden');
            } else {
                // Header salió del footer → mostrar
                header.classList.remove('header-hidden');
            }
        });
    }, {
        threshold: 0,
        rootMargin: '0px 0px -95% 0px' // Solo cuando el TOP del footer está visible
    });
    
    observer.observe(footer);
});