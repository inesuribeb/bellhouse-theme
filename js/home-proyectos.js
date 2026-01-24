document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.querySelector('.proyectos-carousel');
    const wrapper = document.querySelector('.proyectos-carousel-wrapper');
    
    if (!carousel || !wrapper) return;
    
    let scrollPosition = 0;
    let isAnimating = false;
    let isDragging = false;
    let startPos = 0;
    let currentTranslate = 0;
    let prevTranslate = 0;
    let animationID;
    
    // Duplicar contenido para bucle infinito
    const cards = carousel.innerHTML;
    carousel.innerHTML = carousel.innerHTML + carousel.innerHTML;
    
    // Contar cards
    const cardsCount = document.querySelectorAll('.proyecto-carousel-card').length / 2;
    
    // ========================================
    // ANIMACIÓN AUTOMÁTICA (Desktop)
    // ========================================
    function animate() {
        if (!isAnimating || isDragging) return;
        
        scrollPosition -= 0.6;
        
        const cardWidth = document.querySelector('.proyecto-carousel-card').offsetWidth + 15;
        const totalWidth = cardsCount * cardWidth;
        
        if (Math.abs(scrollPosition) >= totalWidth) {
            scrollPosition = 0;
        }
        
        carousel.style.transform = `translateX(${scrollPosition}px)`;
        animationID = requestAnimationFrame(animate);
    }
    
    // ========================================
    // TOUCH EVENTS (Móvil)
    // ========================================
    function touchStart(index) {
        return function(event) {
            isDragging = true;
            startPos = getPositionX(event);
            prevTranslate = scrollPosition;
            carousel.style.cursor = 'grabbing';
            
            // Pausar animación automática
            isAnimating = false;
            cancelAnimationFrame(animationID);
        }
    }
    
    function touchMove(event) {
        if (!isDragging) return;
        
        const currentPosition = getPositionX(event);
        const movedBy = currentPosition - startPos;
        currentTranslate = prevTranslate + movedBy;
        
        carousel.style.transform = `translateX(${currentTranslate}px)`;
    }
    
    function touchEnd() {
        isDragging = false;
        carousel.style.cursor = 'grab';
        
        scrollPosition = currentTranslate;
        
        // Verificar bucle infinito
        const cardWidth = document.querySelector('.proyecto-carousel-card').offsetWidth + 15;
        const totalWidth = cardsCount * cardWidth;
        
        if (Math.abs(scrollPosition) >= totalWidth) {
            scrollPosition = 0;
            carousel.style.transform = `translateX(0px)`;
        } else if (scrollPosition > 0) {
            scrollPosition = -totalWidth + scrollPosition;
            carousel.style.transform = `translateX(${scrollPosition}px)`;
        }
        
        // Reanudar animación automática solo en desktop
        if (window.innerWidth > 768) {
            setTimeout(() => {
                isAnimating = true;
                animate();
            }, 500);
        }
    }
    
    function getPositionX(event) {
        return event.type.includes('mouse') ? event.pageX : event.touches[0].clientX;
    }
    
    // ========================================
    // EVENT LISTENERS
    // ========================================
    
    // Touch events (móvil)
    carousel.addEventListener('touchstart', touchStart(0));
    carousel.addEventListener('touchmove', touchMove);
    carousel.addEventListener('touchend', touchEnd);
    
    // Mouse events (desktop drag opcional)
    carousel.addEventListener('mousedown', touchStart(0));
    carousel.addEventListener('mousemove', touchMove);
    carousel.addEventListener('mouseup', touchEnd);
    carousel.addEventListener('mouseleave', () => {
        if (isDragging) touchEnd();
    });
    
    // Hover pause (solo desktop)
    carousel.addEventListener('mouseenter', () => {
        if (window.innerWidth > 768) {
            isAnimating = false;
            cancelAnimationFrame(animationID);
        }
    });
    
    carousel.addEventListener('mouseleave', () => {
        if (window.innerWidth > 768 && !isDragging) {
            isAnimating = true;
            animate();
        }
    });
    
    // ========================================
    // INTERSECTION OBSERVER (iniciar animación)
    // ========================================
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !isAnimating && window.innerWidth > 768) {
                isAnimating = true;
                animate();
            }
        });
    }, {
        threshold: 0.7
    });
    
    observer.observe(wrapper);
    
    // Cursor grab visual
    carousel.style.cursor = 'grab';
});