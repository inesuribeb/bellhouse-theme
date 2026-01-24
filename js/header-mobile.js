document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('mobileMenuToggle');
    const menuOverlay = document.getElementById('mobileMenuOverlay');
    const tiendaToggle = document.querySelector('.mobile-nav-toggle');
    const tiendaSubmenu = document.querySelector('.mobile-submenu');
    const mobileHeaderWrapper = document.querySelector('.mobile-header-wrapper');
    const mobileSearchBtn = document.getElementById('mobileSearchBtn'); // ⭐ NUEVO
    const searchModal = document.getElementById('searchModal'); // ⭐ NUEVO
    const searchModalInput = document.getElementById('searchModalInput'); // ⭐ NUEVO
    
    if (!menuToggle || !menuOverlay) {
        console.log('Header mobile: elementos no encontrados');
        return;
    }
    
    // Toggle menú principal
    menuToggle.addEventListener('click', function() {
        menuOverlay.classList.toggle('active');
        document.body.classList.toggle('menu-open');
        if (mobileHeaderWrapper) {
            mobileHeaderWrapper.classList.toggle('menu-open');
        }
    });
    
    // ⭐ NUEVA FUNCIONALIDAD: Búsqueda desde móvil
    if (mobileSearchBtn && searchModal && searchModalInput) {
        mobileSearchBtn.addEventListener('click', function() {
            // Cerrar menú overlay
            menuOverlay.classList.remove('active');
            document.body.classList.remove('menu-open');
            if (mobileHeaderWrapper) {
                mobileHeaderWrapper.classList.remove('menu-open');
            }
            
            // Abrir modal de búsqueda (mismo que desktop)
            searchModal.classList.add('active');
            document.body.style.overflow = 'hidden';
            
            // Focus en el input después de un pequeño delay
            setTimeout(() => {
                searchModalInput.focus();
            }, 100);
        });
    }
    
    // Accordion de Tienda
    if (tiendaToggle && tiendaSubmenu) {
        tiendaToggle.addEventListener('click', function() {
            tiendaSubmenu.classList.toggle('open');
            this.classList.toggle('open');
        });
    }
    
    // Cerrar menú al hacer click fuera
    menuOverlay.addEventListener('click', function(e) {
        if (e.target === menuOverlay) {
            menuOverlay.classList.remove('active');
            document.body.classList.remove('menu-open');
            if (mobileHeaderWrapper) {
                mobileHeaderWrapper.classList.remove('menu-open');
            }
        }
    });
    
    // Aplicar clases del header desktop al mobile
    const desktopHeader = document.querySelector('.fixed-header');
    
    if (mobileHeaderWrapper && desktopHeader) {
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === 'class') {
                    const classList = desktopHeader.classList;
                    
                    // Header transparente
                    if (classList.contains('header-transparent')) {
                        mobileHeaderWrapper.classList.add('header-transparent');
                    } else {
                        mobileHeaderWrapper.classList.remove('header-transparent');
                    }
                    
                    // Header sobre universo
                    if (classList.contains('header-over-universo')) {
                        mobileHeaderWrapper.classList.add('header-over-universo');
                    } else {
                        mobileHeaderWrapper.classList.remove('header-over-universo');
                    }
                    
                    // Header sobre video
                    if (classList.contains('header-over-video')) {
                        mobileHeaderWrapper.classList.add('header-over-video');
                    } else {
                        mobileHeaderWrapper.classList.remove('header-over-video');
                    }
                    
                    // Header oculto
                    if (classList.contains('header-hidden')) {
                        mobileHeaderWrapper.classList.add('header-hidden');
                    } else {
                        mobileHeaderWrapper.classList.remove('header-hidden');
                    }
                }
            });
        });
        
        observer.observe(desktopHeader, { attributes: true });
        
        // Aplicar clases iniciales
        if (desktopHeader.classList.contains('header-transparent')) {
            mobileHeaderWrapper.classList.add('header-transparent');
        }
        if (desktopHeader.classList.contains('header-over-universo')) {
            mobileHeaderWrapper.classList.add('header-over-universo');
        }
        if (desktopHeader.classList.contains('header-over-video')) {
            mobileHeaderWrapper.classList.add('header-over-video');
        }
        if (desktopHeader.classList.contains('header-hidden')) {
            mobileHeaderWrapper.classList.add('header-hidden');
        }
    }
});