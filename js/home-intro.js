document.addEventListener('DOMContentLoaded', function() {
    const servicioItems = document.querySelectorAll('.servicio-item');
    const imagenes = document.querySelectorAll('.intro-imagen');
    let currentIndex = 0;
    let autoRotateInterval;
    let isHovering = false;

    // Función para cambiar servicio activo
    function cambiarServicio(index) {
        // Remover active de todos
        servicioItems.forEach(item => item.classList.remove('active'));
        imagenes.forEach(img => img.classList.remove('active'));
        
        // Añadir active al seleccionado
        servicioItems[index].classList.add('active');
        imagenes[index].classList.add('active');
        
        currentIndex = index;
    }

    // Auto-rotate cada 2 segundos
    function iniciarAutoRotate() {
        autoRotateInterval = setInterval(() => {
            if (!isHovering) {
                const nextIndex = (currentIndex + 1) % servicioItems.length;
                cambiarServicio(nextIndex);
            }
        }, 3000);
    }

    // Hover en servicios
    servicioItems.forEach((item, index) => {
        item.addEventListener('mouseenter', () => {
            isHovering = true;
            cambiarServicio(index);
        });
        
        item.addEventListener('mouseleave', () => {
            isHovering = false;
        });
    });

    // Iniciar auto-rotate
    iniciarAutoRotate();
});