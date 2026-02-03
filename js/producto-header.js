document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('.fixed-header');
    if (!header) return;

    document.addEventListener('scroll', function() {
        if ((document.documentElement.scrollTop || document.body.scrollTop) > 10) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    }, true);
});