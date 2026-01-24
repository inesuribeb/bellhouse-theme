document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('imageCompare');
    const beforeWrapper = document.getElementById('beforeWrapper');
    const beforeImg = document.querySelector('.image-before');
    const slider = document.getElementById('imageSlider');
    
    if (!container || !beforeWrapper || !slider || !beforeImg) return;
    
    // Ajustar ancho de la imagen "antes" al tamaño del contenedor
    function setBeforeImageWidth() {
        const containerWidth = container.offsetWidth;
        beforeImg.style.width = containerWidth + 'px';
    }
    
    setBeforeImageWidth();
    window.addEventListener('resize', setBeforeImageWidth);
    
    let isActive = false;
    
    function updateSlider(clientX) {
        const containerRect = container.getBoundingClientRect();
        let position = ((clientX - containerRect.left) / containerRect.width) * 100;
        
        position = Math.max(0, Math.min(100, position));
        
        beforeWrapper.style.width = position + '%';
        slider.style.left = position + '%';
    }
    
    slider.addEventListener('mousedown', function() {
        isActive = true;
    });
    
    document.addEventListener('mouseup', function() {
        isActive = false;
    });
    
    document.addEventListener('mousemove', function(e) {
        if (!isActive) return;
        updateSlider(e.clientX);
    });
    
    slider.addEventListener('touchstart', function() {
        isActive = true;
    });
    
    document.addEventListener('touchend', function() {
        isActive = false;
    });
    
    document.addEventListener('touchmove', function(e) {
        if (!isActive) return;
        updateSlider(e.touches[0].clientX);
    });
});





// Galería Carousel
const galeriaCarousel = document.getElementById('galeriaCarousel');
const arrowLeft = document.getElementById('galeriaArrowLeft');
const arrowRight = document.getElementById('galeriaArrowRight');

if (galeriaCarousel && arrowLeft && arrowRight) {
    const scrollAmount = 400;
    
    // Función para actualizar visibilidad de flechas
    function updateArrows() {
        const scrollLeft = galeriaCarousel.scrollLeft;
        const maxScroll = galeriaCarousel.scrollWidth - galeriaCarousel.clientWidth;
        
        // Ocultar flecha izquierda si está al principio
        if (scrollLeft <= 0) {
            arrowLeft.style.display = 'none';
        } else {
            arrowLeft.style.display = 'flex';
        }
        
        // Ocultar flecha derecha si está al final
        if (scrollLeft >= maxScroll - 1) {
            arrowRight.style.display = 'none';
        } else {
            arrowRight.style.display = 'flex';
        }
    }
    
    // Actualizar al cargar
    updateArrows();
    
    // Actualizar al hacer scroll
    galeriaCarousel.addEventListener('scroll', updateArrows);
    
    // Actualizar al redimensionar ventana
    window.addEventListener('resize', updateArrows);
    
    // Click en flechas
    arrowLeft.addEventListener('click', function() {
        galeriaCarousel.scrollBy({
            left: -scrollAmount,
            behavior: 'smooth'
        });
    });
    
    arrowRight.addEventListener('click', function() {
        galeriaCarousel.scrollBy({
            left: scrollAmount,
            behavior: 'smooth'
        });
    });
}