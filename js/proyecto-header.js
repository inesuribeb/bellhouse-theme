document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('.fixed-header');
    const mobileHeader = document.querySelector('.mobile-header-wrapper');
    const hero = document.querySelector('.project-hero');
    if (!hero) return;

    function checkScroll() {
        const heroBottom = hero.getBoundingClientRect().bottom;

        if (header) {
            if (heroBottom > 0) {
                header.classList.add('en-hero');
            } else {
                header.classList.remove('en-hero');
            }
        }

        if (mobileHeader) {
            if (heroBottom > 0) {
                mobileHeader.classList.add('en-hero');
            } else {
                mobileHeader.classList.remove('en-hero');
            }
        }
    }

    checkScroll();

    document.addEventListener('scroll', checkScroll, true);
});