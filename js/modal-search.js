document.addEventListener('DOMContentLoaded', function() {
    const searchModal = document.getElementById('searchModal');
    const searchModalOverlay = document.getElementById('searchModalOverlay');
    const searchModalInput = document.getElementById('searchModalInput');
    const searchModalResults = document.getElementById('searchModalResults');
    
    // Iconos de búsqueda (desktop y mobile)
    const searchIcons = document.querySelectorAll('.search-icon');
    
    // Abrir modal al hacer click en cualquier icono de búsqueda
    searchIcons.forEach(icon => {
        icon.addEventListener('click', function() {
            searchModal.classList.add('active');
            document.body.style.overflow = 'hidden'; // Bloquear scroll
            searchModalInput.focus(); // Focus automático
        });
    });
    
    // Cerrar modal
    function closeModal() {
        searchModal.classList.remove('active');
        document.body.style.overflow = ''; // Restaurar scroll
        searchModalInput.value = ''; // Limpiar input
        searchModalResults.innerHTML = ''; // Limpiar resultados
    }
    
    // Cerrar al hacer click en overlay
    searchModalOverlay.addEventListener('click', closeModal);
    
    // Cerrar con tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && searchModal.classList.contains('active')) {
            closeModal();
        }
    });
    
    // Live search (búsqueda en tiempo real)
    let searchTimeout;
    searchModalInput.addEventListener('input', function() {
        const query = this.value.trim();
        
        // Limpiar timeout anterior
        clearTimeout(searchTimeout);
        
        // Si el input está vacío, limpiar resultados
        if (query.length === 0) {
            searchModalResults.innerHTML = '';
            return;
        }
        
        // Si el query es muy corto, no buscar aún
        if (query.length < 2) {
            return;
        }
        
        // Mostrar loading
        searchModalResults.innerHTML = '<div class="search-loading">Buscando...</div>';
        
        // Esperar 300ms antes de buscar (debounce)
        searchTimeout = setTimeout(function() {
            performSearch(query);
        }, 300);
    });
    
    // Función para realizar la búsqueda
    function performSearch(query) {
        // Llamada Ajax a WordPress
        fetch(`${window.location.origin}/wp-admin/admin-ajax.php?action=bellhouse_search&q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                displayResults(data);
            })
            .catch(error => {
                console.error('Error en búsqueda:', error);
                searchModalResults.innerHTML = '<div class="search-empty">Error al buscar. Inténtalo de nuevo.</div>';
            });
    }
    
    // Función para mostrar resultados
    function displayResults(data) {
        // Si no hay resultados
        if (!data.proyectos.length && !data.posts.length && !data.productos.length) {
            searchModalResults.innerHTML = '<div class="search-empty">No se encontraron resultados</div>';
            return;
        }
        
        let html = '';
        
        // Proyectos
        if (data.proyectos.length > 0) {
            html += '<div class="search-results-group">';
            html += '<h3 class="search-results-title">Proyectos (' + data.proyectos.length + ')</h3>';
            data.proyectos.forEach(item => {
                html += `
                    <a href="${item.link}" class="search-result-item">
                        <div class="search-result-image">
                            <img src="${item.image}" alt="${item.title}">
                        </div>
                        <div class="search-result-info">
                            <h4 class="search-result-title">${item.title}</h4>
                            <p class="search-result-meta">${item.type || 'Proyecto'}</p>
                        </div>
                    </a>
                `;
            });
            html += '</div>';
        }
        
        // Blog
        if (data.posts.length > 0) {
            html += '<div class="search-results-group">';
            html += '<h3 class="search-results-title">Blog (' + data.posts.length + ')</h3>';
            data.posts.forEach(item => {
                html += `
                    <a href="${item.link}" class="search-result-item">
                        <div class="search-result-image">
                            <img src="${item.image}" alt="${item.title}">
                        </div>
                        <div class="search-result-info">
                            <h4 class="search-result-title">${item.title}</h4>
                            <p class="search-result-meta">${item.date}</p>
                        </div>
                    </a>
                `;
            });
            html += '</div>';
        }
        
        // Productos
        if (data.productos.length > 0) {
            html += '<div class="search-results-group">';
            html += '<h3 class="search-results-title">Productos (' + data.productos.length + ')</h3>';
            data.productos.forEach(item => {
                html += `
                    <a href="${item.link}" class="search-result-item">
                        <div class="search-result-image">
                            <img src="${item.image}" alt="${item.title}">
                        </div>
                        <div class="search-result-info">
                            <h4 class="search-result-title">${item.title}</h4>
                            <p class="search-result-meta">${item.price || 'Producto'}</p>
                        </div>
                    </a>
                `;
            });
            html += '</div>';
        }
        
        searchModalResults.innerHTML = html;
    }
});