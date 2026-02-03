document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('.fixed-header');
    const hero = document.querySelector('.project-hero');
    if (!header || !hero) return;

    function checkScroll() {
        const heroBottom = hero.getBoundingClientRect().bottom;
        if (heroBottom > 0) {
            header.classList.add('en-hero');
        } else {
            header.classList.remove('en-hero');
        }
    }

    // Ejecutar al cargar
    checkScroll();

    document.addEventListener('scroll', checkScroll, true);
});