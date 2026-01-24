jQuery(document).ready(function($) {
    $('.acordeon-header').on('click', function() {
        const $item = $(this).closest('.acordeon-item');
        $item.toggleClass('active');
        $('.acordeon-item').not($item).removeClass('active');
    });
});