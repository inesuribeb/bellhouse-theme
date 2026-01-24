document.addEventListener('DOMContentLoaded', function() {
    const blogHeroImg = document.getElementById('blogHeroImg');
    
    if (!blogHeroImg) return;
    
    // Zoom out al cargar
    setTimeout(() => {
        blogHeroImg.classList.add('loaded');
    }, 100);
});