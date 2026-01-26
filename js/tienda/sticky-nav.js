document.addEventListener('DOMContentLoaded', function() {
    console.log('🔧 Sticky nav script cargado');
    
    // Esperar un momento para asegurar que el header esté renderizado
    setTimeout(function() {
        const stickyNav = document.querySelector('.tienda-nav-sticky');
        
        console.log('📍 Sticky nav encontrado:', stickyNav);
        
        if (!stickyNav) {
            console.log('❌ Sticky nav NO encontrado');
            return;
        }
        
        function actualizarStickyTop() {
            // ⭐ Detectar si estamos en móvil o desktop
            const isMobile = window.innerWidth <= 768;
            
            console.log('📱 ¿Es móvil?', isMobile, '| Ancho:', window.innerWidth + 'px');
            
            // ⭐ Seleccionar el header correcto según el dispositivo
            let header;
            if (isMobile) {
                // ⭐ CORRECCIÓN: Usar .mobile-header-wrapper
                header = document.querySelector('.mobile-header-wrapper');
                console.log('🔍 Buscando .mobile-header-wrapper:', header);
            } else {
                header = document.querySelector('.header-desktop .fixed-header');
                console.log('🔍 Buscando .header-desktop .fixed-header:', header);
            }
            
            if (!header) {
                console.log('❌ Header NO encontrado');
                // Listar todos los headers disponibles
                console.log('📋 Headers disponibles:', document.querySelectorAll('header, [class*="header"]'));
                return;
            }
            
            const headerHeight = header.offsetHeight;
            console.log(`✅ Altura del header (${isMobile ? 'móvil' : 'desktop'}):`, headerHeight + 'px');
            
            // ⭐ El sticky se pega justo debajo del header
            stickyNav.style.top = `${headerHeight}px`;
            console.log('✅ Sticky top aplicado:', stickyNav.style.top);
        }
        
        // Calcular al cargar
        actualizarStickyTop();
        
        // Recalcular si cambia el tamaño de la ventana
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(actualizarStickyTop, 100);
        });
        
        // Recalcular después de cargar imágenes
        window.addEventListener('load', actualizarStickyTop);
        
        // ⭐ Recalcular durante el scroll
        let scrollTimeout;
        window.addEventListener('scroll', function() {
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(actualizarStickyTop, 50);
        }, { passive: true });
        
    }, 100);
});