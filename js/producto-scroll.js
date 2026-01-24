document.addEventListener('DOMContentLoaded', function() {
    const galeriaThumbs = document.querySelector('.galeria-thumbs');
    
    
    if (!galeriaThumbs) {
        console.error('NO SE ENCONTRÓ .galeria-thumbs');
        return;
    }
    
    function handleScroll() {
        // Leer el scroll del body en lugar de window
        const scrollY = document.body.scrollTop || document.documentElement.scrollTop;
        
        
        if (scrollY > 50) {
            galeriaThumbs.classList.add('visible');
        } else {
            galeriaThumbs.classList.remove('visible');
        }
    }
    
    // Escuchar en body que es donde está el scroll
    document.body.addEventListener('scroll', handleScroll);
    
    // Ejecutar al cargar
    handleScroll();
});