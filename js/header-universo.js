document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('.fixed-header');
    const universoSection = document.querySelector('.home-universo');
    const videoSection = document.querySelector('.home-video');
    
    if (!header) return;
    
    // Observer para Universo Bell House
    if (universoSection) {
        const universoObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    header.classList.add('header-over-universo');
                } else {
                    header.classList.remove('header-over-universo');
                }
            });
        }, {
            threshold: 0.01,
            rootMargin: '0px 0px -90% 0px'
        });
        
        universoObserver.observe(universoSection);
    }
    
    // Observer para Video
    if (videoSection) {
        const videoObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    header.classList.add('header-over-video');
                } else {
                    header.classList.remove('header-over-video');
                }
            });
        }, {
            threshold: 0.01,
            rootMargin: '0px 0px -90% 0px'
        });
        
        videoObserver.observe(videoSection);
    }
});