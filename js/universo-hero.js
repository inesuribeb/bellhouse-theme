document.addEventListener('DOMContentLoaded', function() {
    const heroImg = document.getElementById('heroImgGrande');
    
    if (!heroImg) return;
    
    // Zoom out al cargar
    setTimeout(() => {
        heroImg.classList.add('loaded');
    }, 100);
});