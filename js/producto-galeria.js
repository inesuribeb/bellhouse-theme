document.addEventListener('DOMContentLoaded', function() {
    const mainImage = document.getElementById('main-image');
    const thumbs = document.querySelectorAll('.thumb');
    
    if (!mainImage || thumbs.length === 0) return;
    
    thumbs.forEach(thumb => {
        thumb.addEventListener('click', function() {
            // Cambiar imagen principal
            const newImageUrl = this.dataset.image;
            mainImage.src = newImageUrl;
            
            // Actualizar clase active
            thumbs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
        });
    });
});


// Acordeones
const acordeonHeaders = document.querySelectorAll('.acordeon-header');

acordeonHeaders.forEach(header => {
    header.addEventListener('click', function() {
        const item = this.closest('.acordeon-item');
        const isActive = item.classList.contains('active');
        
        // Cerrar todos los acordeones
        document.querySelectorAll('.acordeon-item').forEach(i => i.classList.remove('active'));
        
        // Abrir el clickeado si no estaba activo
        if (!isActive) {
            item.classList.add('active');
        }
    });
});


document.addEventListener('DOMContentLoaded', function() {
    const galeriaMain = document.querySelector('.galeria-main');
    const modal = document.getElementById('gallery-modal');
    const modalClose = document.querySelector('.modal-close');
    const modalImage = document.getElementById('modal-image');
    const modalMainImage = document.querySelector('.modal-main-image');
    const currentImageSpan = document.getElementById('current-image');
    const modalThumbs = document.querySelectorAll('.modal-thumb');
    const arrowLeft = document.querySelector('.modal-arrow-left');
    const arrowRight = document.querySelector('.modal-arrow-right');
    
    let currentIndex = 0;
    const totalImages = modalThumbs.length;
    let isZoomed = false;
    
    // Crear cursor para modal
    const modalCursor = document.createElement('div');
    modalCursor.className = 'modal-cursor';
    modalCursor.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
    `;
    document.body.appendChild(modalCursor);
    
    if (galeriaMain) {
        // Crear el cursor personalizado para galeria-main
        const customCursor = document.createElement('div');
        customCursor.className = 'custom-cursor';
        customCursor.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
        `;
        document.body.appendChild(customCursor);
        
        // Mostrar cursor cuando el mouse entra en galeria-main
        galeriaMain.addEventListener('mouseenter', function() {
            customCursor.classList.add('visible');
        });
        
        // Ocultar cursor cuando el mouse sale de galeria-main
        galeriaMain.addEventListener('mouseleave', function() {
            customCursor.classList.remove('visible');
        });
        
        // Mover el cursor siguiendo el mouse
        galeriaMain.addEventListener('mousemove', function(e) {
            customCursor.style.left = e.clientX + 'px';
            customCursor.style.top = e.clientY + 'px';
        });
        
        // Abrir modal al hacer clic en galeria-main
        galeriaMain.addEventListener('click', function() {
            const mainImage = document.getElementById('main-image');
            const currentImageSrc = mainImage.src;
            
            // Encontrar el índice de la imagen actual
            let foundIndex = 0;
            modalThumbs.forEach((thumb, index) => {
                if (thumb.dataset.image === currentImageSrc) {
                    foundIndex = index;
                }
            });
            
            openModal(currentImageSrc, foundIndex);
        });
    }
    
    // Función para actualizar el icono del cursor del modal
    function updateModalCursorIcon() {
        const icon = isZoomed ? 
            '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" /></svg>' :
            '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>';
        modalCursor.innerHTML = icon;
    }
    
    // Eventos del cursor en la imagen del modal
    modalMainImage.addEventListener('mouseenter', function() {
        modalCursor.classList.add('visible');
    });
    
    modalMainImage.addEventListener('mouseleave', function() {
        modalCursor.classList.remove('visible');
    });
    
    modalMainImage.addEventListener('mousemove', function(e) {
        modalCursor.style.left = e.clientX + 'px';
        modalCursor.style.top = e.clientY + 'px';
    });
    
    // Toggle zoom al hacer clic en la imagen
    modalMainImage.addEventListener('click', function(e) {
        // Evitar que se active si se hace clic en las flechas
        if (e.target.closest('.modal-arrow')) return;
        
        isZoomed = !isZoomed;
        modalMainImage.classList.toggle('zoomed', isZoomed);
        modal.classList.toggle('modal-zoomed', isZoomed);
        updateModalCursorIcon();
    });
    
    // Función para abrir el modal
    function openModal(imageSrc, index) {
        currentIndex = index;
        isZoomed = false;
        modalMainImage.classList.remove('zoomed');
        modal.classList.remove('modal-zoomed');
        updateModalCursorIcon();
        updateModalImage();
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    
    // Función para actualizar la imagen del modal
    function updateModalImage() {
        const activeThumb = modalThumbs[currentIndex];
        modalImage.src = activeThumb.dataset.image;
        currentImageSpan.textContent = currentIndex + 1;
        
        // Actualizar miniaturas activas
        modalThumbs.forEach((thumb, i) => {
            thumb.classList.toggle('active', i === currentIndex);
        });
        
        // Actualizar estado de las flechas
        arrowLeft.disabled = currentIndex === 0;
        arrowRight.disabled = currentIndex === totalImages - 1;
        
        // Hacer scroll a la miniatura activa
        activeThumb.scrollIntoView({
            behavior: 'smooth',
            block: 'nearest',
            inline: 'center'
        });
    }
    
    // Navegar a la imagen anterior
    function prevImage() {
        if (currentIndex > 0) {
            currentIndex--;
            isZoomed = false;
            modalMainImage.classList.remove('zoomed');
            modal.classList.remove('modal-zoomed');
            updateModalCursorIcon();
            updateModalImage();
        }
    }
    
    // Navegar a la imagen siguiente
    function nextImage() {
        if (currentIndex < totalImages - 1) {
            currentIndex++;
            isZoomed = false;
            modalMainImage.classList.remove('zoomed');
            modal.classList.remove('modal-zoomed');
            updateModalCursorIcon();
            updateModalImage();
        }
    }
    
    // Event listeners para las flechas
    arrowLeft.addEventListener('click', prevImage);
    arrowRight.addEventListener('click', nextImage);
    
    // Cerrar modal
    function closeModal() {
        modal.classList.remove('active');
        modalMainImage.classList.remove('zoomed');
        modal.classList.remove('modal-zoomed');
        isZoomed = false;
        document.body.style.overflow = '';
    }
    
    modalClose.addEventListener('click', closeModal);
    
    // Cerrar modal con tecla ESC y navegar con flechas del teclado
    document.addEventListener('keydown', function(e) {
        if (!modal.classList.contains('active')) return;
        
        if (e.key === 'Escape') {
            if (isZoomed) {
                // Si está en zoom, primero quitar el zoom
                isZoomed = false;
                modalMainImage.classList.remove('zoomed');
                modal.classList.remove('modal-zoomed');
                updateModalCursorIcon();
            } else {
                // Si no está en zoom, cerrar el modal
                closeModal();
            }
        } else if (e.key === 'ArrowLeft') {
            prevImage();
        } else if (e.key === 'ArrowRight') {
            nextImage();
        }
    });
    
    // Cambiar imagen al hacer clic en miniatura
    modalThumbs.forEach((thumb, index) => {
        thumb.addEventListener('click', function() {
            currentIndex = index;
            isZoomed = false;
            modalMainImage.classList.remove('zoomed');
            modal.classList.remove('modal-zoomed');
            updateModalCursorIcon();
            updateModalImage();
        });
    });
});


// ========================================
// CAROUSEL THUMBS (nuevo)
// ========================================
document.addEventListener('DOMContentLoaded', function() {
    const thumbsContainer = document.querySelector('.galeria-thumbs');
    const arrowLeft = document.getElementById('thumbsArrowLeft');
    const arrowRight = document.getElementById('thumbsArrowRight');

    if (thumbsContainer && arrowLeft && arrowRight) {
        const scrollAmount = 300;

        function updateArrows() {
            const scrollLeft = thumbsContainer.scrollLeft;
            const maxScroll = thumbsContainer.scrollWidth - thumbsContainer.clientWidth;

            if (scrollLeft <= 0) {
                arrowLeft.classList.add('hidden');
            } else {
                arrowLeft.classList.remove('hidden');
            }

            if (scrollLeft >= maxScroll - 1) {
                arrowRight.classList.add('hidden');
            } else {
                arrowRight.classList.remove('hidden');
            }

            if (maxScroll <= 0) {
                arrowLeft.classList.add('hidden');
                arrowRight.classList.add('hidden');
            }
        }

        setTimeout(updateArrows, 100);
        thumbsContainer.addEventListener('scroll', updateArrows);
        window.addEventListener('resize', updateArrows);

        arrowLeft.addEventListener('click', function(e) {
            e.stopPropagation();
            thumbsContainer.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        });

        arrowRight.addEventListener('click', function(e) {
            e.stopPropagation();
            thumbsContainer.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        });
    }
});