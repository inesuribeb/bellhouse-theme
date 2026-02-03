document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('modalCarrito');
    const overlay = document.getElementById('modalCarritoOverlay');
    const close = document.getElementById('modalCarritoClose');
    const lista = document.getElementById('modalCarritoLista');
    const vacia = document.getElementById('modalCarritoVacia');
    const subtotalEl = document.getElementById('modalCarritoSubtotal');
    const countEl = document.querySelector('.modal-carrito-count');
    const addToCartButtons = document.querySelectorAll('.custom-add-to-cart-button, .add-to-cart-button');

    // ─── Añadir desde cards de tienda (antes del return) ───

    document.querySelectorAll('.product-card__cta').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            const productId = this.dataset.productId;
            const productName = this.dataset.productName;
            const productImage = this.dataset.productImage;
            const productUrl = this.dataset.productUrl;
            const price = parseFloat(this.dataset.productPrice);

            if (!productId) return;

            const saved = sessionStorage.getItem('bellhouse_carrito');
            let carrito = saved ? JSON.parse(saved) : [];

            const existingIndex = carrito.findIndex(item => item.id === productId);

            if (existingIndex > -1) {
                carrito[existingIndex].quantity += 1;
            } else {
                carrito.push({
                    id: productId,
                    name: productName,
                    image: productImage,
                    price: price,
                    quantity: 1,
                    url: productUrl
                });
            }

            sessionStorage.setItem('bellhouse_carrito', JSON.stringify(carrito));
            window.dispatchEvent(new Event('bellhouse_carrito_updated'));

            if (window.bellhouseCarrito) {
                window.bellhouseCarrito.open();
            }
        });
    });

    // ─── A partir de aquí necesita el modal ─────

    if (!modal) return;

    // ─── Carrito persistente con sessionStorage ────

    function getCarrito() {
        const saved = sessionStorage.getItem('bellhouse_carrito');
        return saved ? JSON.parse(saved) : [];
    }

    function saveCarrito(carrito) {
        sessionStorage.setItem('bellhouse_carrito', JSON.stringify(carrito));
        window.dispatchEvent(new Event('bellhouse_carrito_updated'));
    }

    let carrito = getCarrito();

    // ─── Obtener max cantidad según stock ───────

    function getMaxQuantity(productId) {
        if (typeof modalCarritoData === 'undefined' || !modalCarritoData.stockData) return 10;
        const stockInfo = modalCarritoData.stockData[productId];
        if (stockInfo && stockInfo.manage_stock) {
            return Math.max(1, parseInt(stockInfo.stock));
        }
        return 10;
    }

    // ─── Funciones principales ─────────────────

    function openModal() {
        carrito = getCarrito();
        renderCarrito();
        modal.classList.add('active');
    }

    function closeModal() {
        modal.classList.remove('active');
    }

    // ─── Añadir producto (desde página de producto) ────

    function addToCart() {
        const productId = document.querySelector('input[name="product_id"]')?.value
            || document.querySelector('.custom-variations-form')?.dataset.product_id
            || document.querySelector('button[name="add-to-cart"]')?.value;

        const productName = document.querySelector('.product-name')?.textContent?.trim();
        const productImage = document.querySelector('.galeria-main img')?.src;
        const productUrl = document.querySelector('input[name="product_url"]')?.value
            || window.location.href;
        const quantityInput = document.querySelector('input[name="quantity"]');
        const quantity = quantityInput ? parseInt(quantityInput.value) : 1;

        const priceEl = document.querySelector('.product-price ins .amount')
            || document.querySelector('.product-price .amount');
        const priceText = priceEl ? priceEl.textContent.replace(/[€\s.]/g, '').replace(',', '.') : '0';
        const price = parseFloat(priceText);

        if (!productId) return;

        const maxQuantity = getMaxQuantity(productId);
        const existingIndex = carrito.findIndex(item => item.id === productId);

        if (existingIndex > -1) {
            carrito[existingIndex].quantity = Math.min(carrito[existingIndex].quantity + quantity, maxQuantity);
        } else {
            carrito.push({
                id: productId,
                name: productName,
                image: productImage,
                price: price,
                quantity: Math.min(quantity, maxQuantity),
                url: productUrl
            });
        }

        saveCarrito(carrito);
        openModal();
    }

    // ─── Borrar producto ────────────────────────

    function removeFromCart(productId) {
        carrito = carrito.filter(item => item.id !== productId);
        saveCarrito(carrito);
        renderCarrito();
    }

    // ─── Cambiar cantidad ───────────────────────

    function updateQuantity(productId, newQuantity) {
        const item = carrito.find(item => item.id === productId);
        if (item) {
            item.quantity = parseInt(newQuantity);
            if (item.quantity <= 0) {
                removeFromCart(productId);
                return;
            }
        }
        saveCarrito(carrito);
        renderCarrito();
    }

    // ─── Render ─────────────────────────────────

    function renderCarrito() {
        lista.innerHTML = '';

        if (carrito.length === 0) {
            vacia.classList.remove('hidden');
            lista.classList.add('hidden');
            subtotalEl.textContent = '€0.00';
            if (countEl) countEl.textContent = '(0)';
            return;
        }

        vacia.classList.add('hidden');
        lista.classList.remove('hidden');

        let subtotal = 0;
        let totalItems = 0;

        carrito.forEach(function (item) {
            const maxQuantity = getMaxQuantity(item.id);
            if (item.quantity > maxQuantity) {
                item.quantity = maxQuantity;
                saveCarrito(carrito);
            }

            const itemTotal = item.price * item.quantity;
            subtotal += itemTotal;
            totalItems += item.quantity;

            const card = document.createElement('div');
            card.className = 'modal-carrito-card';
            card.innerHTML = `
                <div class="modal-carrito-card-imagen">
                    <a href="${item.url}" class="modal-carrito-card-imagen-link">
                        <img src="${item.image}" alt="${item.name}">
                    </a>
                </div>
                <div class="modal-carrito-card-info">
                    <div class="modal-carrito-card-top">
                        <h3 class="modal-carrito-card-nombre">${item.name}</h3>
                        <button class="modal-carrito-card-borrar" data-id="${item.id}">Borrar</button>
                    </div>
                    <div class="modal-carrito-card-bottom">
                        <div class="modal-carrito-card-cantidad">
                            <select data-id="${item.id}">
                                ${Array.from({ length: maxQuantity }, (_, i) => `<option value="${i + 1}" ${item.quantity === i + 1 ? 'selected' : ''}>${i + 1}</option>`).join('')}
                            </select>
                        </div>
                        <span class="modal-carrito-card-precio">€${itemTotal.toFixed(2)}</span>
                    </div>
                </div>
            `;

            lista.appendChild(card);
        });

        subtotalEl.textContent = '€' + subtotal.toFixed(2);
        if (countEl) countEl.textContent = '(' + totalItems + ')';

        lista.querySelectorAll('.modal-carrito-card-borrar').forEach(btn => {
            btn.addEventListener('click', function () {
                removeFromCart(this.dataset.id);
            });
        });

        lista.querySelectorAll('.modal-carrito-card-cantidad select').forEach(sel => {
            sel.addEventListener('change', function () {
                updateQuantity(this.dataset.id, this.value);
            });
        });
    }

    // ─── Eventos ────────────────────────────────

    addToCartButtons.forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            addToCart();
        });
    });

    overlay.addEventListener('click', closeModal);
    close.addEventListener('click', closeModal);

    const finalizerBtn = document.getElementById('modalCarritoFinalizar');
    if (finalizerBtn) {
        finalizerBtn.addEventListener('click', function () {
            if (typeof modalCarritoData !== 'undefined') {
                window.location.href = modalCarritoData.checkoutUrl;
            }
        });
    }

    // ─── Exponer funciones al exterior ──────────

    window.bellhouseCarrito = {
        render: renderCarrito,
        open: openModal
    };
});