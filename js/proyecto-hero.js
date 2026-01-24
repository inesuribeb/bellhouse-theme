document.addEventListener('DOMContentLoaded', function() {
    const projectHeroImg = document.getElementById('projectHeroImg');
    
    if (!projectHeroImg) return;
    
    // Zoom out al cargar
    setTimeout(() => {
        projectHeroImg.classList.add('loaded');
    }, 100);
});