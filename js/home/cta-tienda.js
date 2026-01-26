document.addEventListener('DOMContentLoaded', function () {
    const categorias = document.querySelectorAll('#homeTiendaCategorias .categoria-item');
    const underline = document.querySelector('.home-tienda-categorias .categoria-underline');
    const grid = document.getElementById('homeTiendaGrid');

    if (!categorias.length || !grid) return;

    // ========================================
    // SUBRAYADO ANIMADO (solo desktop)
    // ========================================

    function actualizarSubrayado(categoria) {
        if (!underline) return;
        
        const rect = categoria.getBoundingClientRect();
        const parentRect = categoria.parentElement.getBoundingClientRect();
        const left = rect.left - parentRect.left;
        const width = rect.width;

        underline.style.width = `${width}px`;
        underline.style.left = `${left}px`;
    }

    // Posicionar subrayado en la categoría activa al cargar
    const categoriaActiva = document.querySelector('#homeTiendaCategorias .categoria-item.active');
    if (categoriaActiva && underline) {
        actualizarSubrayado(categoriaActiva);
    }

    // Mover subrayado al hacer hover (solo desktop)
    categorias.forEach(categoria => {
        categoria.addEventListener('mouseenter', function () {
            if (window.innerWidth > 768) {
                actualizarSubrayado(this);
            }
        });

        categoria.addEventListener('mouseleave', function () {
            if (window.innerWidth > 768) {
                const activa = document.querySelector('#homeTiendaCategorias .categoria-item.active');
                if (activa) {
                    actualizarSubrayado(activa);
                }
            }
        });
    });

    // Actualizar subrayado al cambiar de categoría
    categorias.forEach(categoria => {
        categoria.addEventListener('click', function () {
            // Quitar active de todas
            categorias.forEach(c => c.classList.remove('active'));
            // Añadir active a la clickeada
            this.classList.add('active');
            
            // Actualizar subrayado (solo desktop)
            if (window.innerWidth > 768) {
                actualizarSubrayado(this);
            }

            // Cargar productos de esta categoría
            const categoriaSlug = this.getAttribute('data-categoria');
            cargarProductos(categoriaSlug);
        });
    });

    // Recalcular subrayado al hacer resize (solo desktop)
    window.addEventListener('resize', function () {
        if (window.innerWidth > 768) {
            const activa = document.querySelector('#homeTiendaCategorias .categoria-item.active');
            if (activa && underline) {
                actualizarSubrayado(activa);
            }
        }
    });

    // ========================================
    // CARGAR PRODUCTOS VIA AJAX
    // ========================================

    function cargarProductos(categoria) {
        console.log('Cargando productos de:', categoria);

        // Mostrar loading
        grid.classList.add('loading');
        grid.innerHTML = '<p style="grid-column: 1/-1; text-align: center; padding: 40px;">Cargando productos...</p>';

        // Hacer petición AJAX
        fetch(ajaxurl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                action: 'get_home_tienda_productos',
                categoria: categoria,
            })
        })
            .then(response => response.json())
            .then(data => {
                console.log('Productos recibidos:', data);

                if (data.success && data.data.length > 0) {
                    renderizarProductos(data.data, categoria);
                } else {
                    grid.innerHTML = '<p style="grid-column: 1/-1; text-align: center; padding: 40px;">No hay productos disponibles</p>';
                }

                grid.classList.remove('loading');
            })
            .catch(error => {
                console.error('Error cargando productos:', error);
                grid.innerHTML = '<p style="grid-column: 1/-1; text-align: center; padding: 40px;">Error al cargar productos</p>';
                grid.classList.remove('loading');
            });
    }

    // ========================================
    // RENDERIZAR PRODUCTOS EN GRID
    // ========================================

    function renderizarProductos(productos, categoria) {
        const isMobile = window.innerWidth <= 768;
        const maxProductos = isMobile ? 2 : 6; // ⭐ 2 en móvil, 6 en desktop
        
        // Limpiar grid
        grid.innerHTML = '';
        
        // Crear array de posiciones vacías
        const posiciones = Array(maxProductos).fill(null);
        
        // Colocar productos en sus posiciones (limitado a maxProductos)
        productos.slice(0, maxProductos).forEach((producto, index) => {
            const pos = isMobile ? index : (producto.posicion - 1); // En móvil: orden secuencial
            if (pos >= 0 && pos < maxProductos) {
                posiciones[pos] = producto;
            }
        });
        
        // Renderizar todas las posiciones
        posiciones.forEach((producto, index) => {
            if (producto) {
                // Crear card de producto
                const card = document.createElement('div');
                card.className = 'home-tienda-product';
                card.style.gridColumn = `${index + 1}`;
                card.setAttribute('data-categoria', categoria);
                
                // Solo imagen, sin info
                card.innerHTML = `
                    <img src="${producto.imagen}" alt="${producto.titulo}">
                `;
                
                // Click lleva a la tienda con filtro de categoría
                card.addEventListener('click', function() {
                    const cat = this.getAttribute('data-categoria');
                    if (cat === 'todos') {
                        window.location.href = '/tienda/';
                    } else {
                        window.location.href = `/tienda/categoria/${cat}/`;
                    }
                });
                
                grid.appendChild(card);
            } else {
                // Posición vacía (solo en desktop)
                if (!isMobile) {
                    const empty = document.createElement('div');
                    empty.className = 'home-tienda-product-empty';
                    empty.style.gridColumn = `${index + 1}`;
                    grid.appendChild(empty);
                }
            }
        });
    }

    // ========================================
    // INICIALIZAR: Desktop vs Móvil
    // ========================================

    function inicializar() {
        const isMobile = window.innerWidth <= 768;

        if (isMobile) {
            // ⭐ MÓVIL: Activar primera categoría (no TODOS)
            const primeraCategoria = document.querySelector('#homeTiendaCategorias .categoria-item:not([data-categoria="todos"])');

            if (primeraCategoria) {
                // Quitar active de TODOS
                const todosBtn = document.querySelector('#homeTiendaCategorias .categoria-item[data-categoria="todos"]');
                if (todosBtn) todosBtn.classList.remove('active');

                // Activar primera categoría
                primeraCategoria.classList.add('active');

                // Cargar productos de esa categoría
                const categoriaSlug = primeraCategoria.getAttribute('data-categoria');
                cargarProductos(categoriaSlug);
            }
        } else {
            // ⭐ DESKTOP: Cargar TODOS
            cargarProductos('todos');
        }
    }

    // Ejecutar al cargar
    inicializar();

    // NO recargamos al hacer resize, solo ajustamos subrayado si estamos en desktop
});