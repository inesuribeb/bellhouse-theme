document.addEventListener('DOMContentLoaded', function () {
    const cartBadge = document.getElementById('cartBadge');
    const mobileCartBadge = document.getElementById('mobileCartBadge');
    const cartIcon = document.getElementById('headerCartIcon');
    const mobileCartIcon = document.getElementById('mobileCartIcon');
    const modal = document.getElementById('modalCarrito');

    // ─── Actualizar badge ───────────────────────

    function updateBadge() {
        const saved = sessionStorage.getItem('bellhouse_carrito');
        const carrito = saved ? JSON.parse(saved) : [];
        const total = carrito.reduce((sum, item) => sum + item.quantity, 0);

        // Desktop
        if (cartBadge) {
            if (total > 0) {
                cartBadge.textContent = total;
                cartBadge.classList.remove('hidden');
            } else {
                cartBadge.classList.add('hidden');
            }
        }

        // Mobile
        if (mobileCartBadge) {
            if (total > 0) {
                mobileCartBadge.textContent = total;
                mobileCartBadge.classList.remove('hidden');
            } else {
                mobileCartBadge.classList.add('hidden');
            }
        }
    }

    // ─── Abrir modal carrito ────────────────────

    function openCarrito() {
        if (window.bellhouseCarrito) {
            window.bellhouseCarrito.open();
        } else if (modal) {
            modal.classList.add('active');
        }
    }

    if (cartIcon) {
        cartIcon.addEventListener('click', openCarrito);
    }

    if (mobileCartIcon) {
        mobileCartIcon.addEventListener('click', openCarrito);
    }

    // ─── Escuchar cambios en el carrito ─────────

    window.addEventListener('bellhouse_carrito_updated', function () {
        updateBadge();
    });

    // Inicializar badge al cargar
    updateBadge();
});