// document.addEventListener('DOMContentLoaded', function() {
//     const carousel = document.querySelector('.proyectos-carousel');
//     const wrapper = document.querySelector('.proyectos-carousel-wrapper');
    
//     if (!carousel || !wrapper) return;
    
//     let scrollPosition = 0;
//     let isAnimating = false;
//     let isDragging = false;
//     let startPos = 0;
//     let currentTranslate = 0;
//     let prevTranslate = 0;
//     let animationID;
    
//     const cards = carousel.innerHTML;
//     carousel.innerHTML = carousel.innerHTML + carousel.innerHTML;
    
//     const cardsCount = document.querySelectorAll('.proyecto-carousel-card').length / 2;
    

//     function animate() {
//         if (!isAnimating || isDragging) return;
        
//         scrollPosition -= 0.6;
        
//         const cardWidth = document.querySelector('.proyecto-carousel-card').offsetWidth + 15;
//         const totalWidth = cardsCount * cardWidth;
        
//         if (Math.abs(scrollPosition) >= totalWidth) {
//             scrollPosition = 0;
//         }
        
//         carousel.style.transform = `translateX(${scrollPosition}px)`;
//         animationID = requestAnimationFrame(animate);
//     }
    
//     function touchStart(index) {
//         return function(event) {
//             isDragging = true;
//             startPos = getPositionX(event);
//             prevTranslate = scrollPosition;
//             carousel.style.cursor = 'grabbing';
            
//             isAnimating = false;
//             cancelAnimationFrame(animationID);
//         }
//     }
    
//     function touchMove(event) {
//         if (!isDragging) return;
        
//         const currentPosition = getPositionX(event);
//         const movedBy = currentPosition - startPos;
//         currentTranslate = prevTranslate + movedBy;
        
//         carousel.style.transform = `translateX(${currentTranslate}px)`;
//     }
    
//     function touchEnd() {
//         isDragging = false;
//         carousel.style.cursor = 'grab';
        
//         scrollPosition = currentTranslate;
        
//         const cardWidth = document.querySelector('.proyecto-carousel-card').offsetWidth + 15;
//         const totalWidth = cardsCount * cardWidth;
        
//         if (Math.abs(scrollPosition) >= totalWidth) {
//             scrollPosition = 0;
//             carousel.style.transform = `translateX(0px)`;
//         } else if (scrollPosition > 0) {
//             scrollPosition = -totalWidth + scrollPosition;
//             carousel.style.transform = `translateX(${scrollPosition}px)`;
//         }
        
//         if (window.innerWidth > 768) {
//             setTimeout(() => {
//                 isAnimating = true;
//                 animate();
//             }, 500);
//         }
//     }
    
//     function getPositionX(event) {
//         return event.type.includes('mouse') ? event.pageX : event.touches[0].clientX;
//     }
    

//     carousel.addEventListener('touchstart', touchStart(0));
//     carousel.addEventListener('touchmove', touchMove);
//     carousel.addEventListener('touchend', touchEnd);
    
//     carousel.addEventListener('mousedown', touchStart(0));
//     carousel.addEventListener('mousemove', touchMove);
//     carousel.addEventListener('mouseup', touchEnd);
//     carousel.addEventListener('mouseleave', () => {
//         if (isDragging) touchEnd();
//     });
    
//     carousel.addEventListener('mouseenter', () => {
//         if (window.innerWidth > 768) {
//             isAnimating = false;
//             cancelAnimationFrame(animationID);
//         }
//     });
    
//     carousel.addEventListener('mouseleave', () => {
//         if (window.innerWidth > 768 && !isDragging) {
//             isAnimating = true;
//             animate();
//         }
//     });
    

//     const observer = new IntersectionObserver((entries) => {
//         entries.forEach(entry => {
//             if (entry.isIntersecting && !isAnimating && window.innerWidth > 768) {
//                 isAnimating = true;
//                 animate();
//             }
//         });
//     }, {
//         threshold: 0.7
//     });
    
//     observer.observe(wrapper);
    
//     carousel.style.cursor = 'grab';
// });


document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.querySelector('.proyectos-carousel');
    const wrapper = document.querySelector('.proyectos-carousel-wrapper');
    
    if (!carousel || !wrapper) return;
    
    let scrollPosition = 0;
    let isAnimating = false;
    let animationID;
    
    // Duplicar contenido para bucle infinito
    const cards = carousel.innerHTML;
    carousel.innerHTML = carousel.innerHTML + carousel.innerHTML;
    
    // Contar cards
    const cardsCount = document.querySelectorAll('.proyecto-carousel-card').length / 2;
    
    // ========================================
    // SOLO DESKTOP: Animación automática
    // ========================================
    function animate() {
        if (!isAnimating) return;
        
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
    // DETECCIÓN DE DESKTOP vs MÓVIL
    // ========================================
    function isDesktop() {
        return window.innerWidth > 768;
    }
    
    // ========================================
    // CONFIGURAR COMPORTAMIENTO SEGÚN DISPOSITIVO
    // ========================================
    function setupCarousel() {
        if (isDesktop()) {
            // DESKTOP: Animación automática con transform
            carousel.style.cursor = 'grab';
            wrapper.style.overflowX = 'hidden';
            
            // Hover pause
            carousel.addEventListener('mouseenter', pauseAnimation);
            carousel.addEventListener('mouseleave', resumeAnimation);
            
        } else {
            // MÓVIL: Scroll nativo fluido
            carousel.style.cursor = 'default';
            carousel.style.transform = 'none';
            wrapper.style.overflowX = 'auto';
            wrapper.style.scrollBehavior = 'smooth';
            wrapper.style.webkitOverflowScrolling = 'touch'; // iOS smooth scroll
            
            // Ocultar scrollbar en móvil
            wrapper.style.scrollbarWidth = 'none';
            wrapper.style.msOverflowStyle = 'none';
            
            // Detener cualquier animación
            isAnimating = false;
            cancelAnimationFrame(animationID);
        }
    }
    
    function pauseAnimation() {
        if (!isDesktop()) return;
        isAnimating = false;
        cancelAnimationFrame(animationID);
    }
    
    function resumeAnimation() {
        if (!isDesktop()) return;
        isAnimating = true;
        animate();
    }
    
    // ========================================
    // INTERSECTION OBSERVER (iniciar en desktop)
    // ========================================
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !isAnimating && isDesktop()) {
                isAnimating = true;
                animate();
            }
        });
    }, {
        threshold: 0.7
    });
    
    observer.observe(wrapper);
    
    // ========================================
    // INICIALIZAR Y RESIZE
    // ========================================
    setupCarousel();
    
    window.addEventListener('resize', () => {
        setupCarousel();
    });
});