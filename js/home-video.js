document.addEventListener('DOMContentLoaded', function() {
    const videoElement = document.querySelector('.home-video video[data-autoplay]');
    
    if (!videoElement) return;
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Reproducir cuando 50% es visible
                videoElement.play().catch(err => {
                    console.log('No se pudo reproducir el video:', err);
                });
            } else {
                // Pausar cuando sale del viewport
                videoElement.pause();
            }
        });
    }, {
        threshold: 0.5 // 50% visible
    });
    
    observer.observe(videoElement.closest('.home-video'));
});