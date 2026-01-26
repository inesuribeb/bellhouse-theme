// jQuery(document).ready(function($) {
//     $('.acordeon-header').on('click', function() {
//         const $item = $(this).closest('.acordeon-item');
//         $item.toggleClass('active');
//         $('.acordeon-item').not($item).removeClass('active');
//     });
// });

jQuery(document).ready(function($) {
    $('.acordeon-header').on('click', function() {
        const $item = $(this).closest('.acordeon-item');
        const wasActive = $item.hasClass('active');
        
        $item.toggleClass('active');
        $('.acordeon-item').not($item).removeClass('active');
        
        // ⭐ Si se está ABRIENDO
        if (!wasActive) {
            // Guardar scroll actual
            const currentScroll = window.pageYOffset;
            
            setTimeout(function() {
                // Forzar re-cálculo del sticky haciendo scroll
                window.scrollTo(0, currentScroll - 50);
                
                // Volver a la posición después de un frame
                setTimeout(function() {
                    window.scrollTo(0, currentScroll);
                }, 10);
            }, 100);
        }
    });
});