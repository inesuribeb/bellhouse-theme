document.addEventListener('DOMContentLoaded', function() {
    const filtrarBtn = document.getElementById('filtrarBtn');
    const filtrarModal = document.getElementById('filtrarModal');
    const filtrarModalOverlay = document.getElementById('filtrarModalOverlay');
    const filtrarModalClose = document.getElementById('filtrarModalClose');
    
    // Tabs
    const tabs = document.querySelectorAll('.filtrar-modal-tab');
    const filtrarContent = document.getElementById('filtrarContent');
    const ordenarContent = document.getElementById('ordenarContent');
    
    if (!filtrarBtn || !filtrarModal) return;
    
    // Abrir modal
    filtrarBtn.addEventListener('click', function() {
        filtrarModal.classList.add('active');
        filtrarBtn.classList.add('active');
        document.body.style.overflow = 'hidden';
        
        // ⭐ Pre-cargar filtros de la URL cuando se abre el modal
        precargarFiltrosDesdeURL();
    });
    
    // Cerrar modal con X
    filtrarModalClose.addEventListener('click', closeModal);
    
    // Cerrar modal con overlay
    filtrarModalOverlay.addEventListener('click', closeModal);
    
    // Función cerrar modal
    function closeModal() {
        filtrarModal.classList.remove('active');
        filtrarBtn.classList.remove('active');
        document.body.style.overflow = '';
    }
    
    // Cambiar entre tabs
    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            
            // Cambiar tabs activos
            tabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            // Cambiar contenido
            if (targetTab === 'filtrar') {
                filtrarContent.style.display = 'block';
                ordenarContent.style.display = 'none';
            } else {
                filtrarContent.style.display = 'none';
                ordenarContent.style.display = 'block';
            }
        });
    });
    
    // Cerrar con ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && filtrarModal.classList.contains('active')) {
            closeModal();
        }
    });

    // ========================================
    // ACORDEONES DE FILTROS
    // ========================================

    const filtroToggles = document.querySelectorAll('.filtro-toggle');

    filtroToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const content = document.getElementById(targetId);
            const iconPlus = this.querySelector('.filtro-icon-plus');
            const iconMinus = this.querySelector('.filtro-icon-minus');
            
            // Toggle activo
            content.classList.toggle('active');
            
            // Cambiar iconos
            if (content.classList.contains('active')) {
                iconPlus.style.display = 'none';
                iconMinus.style.display = 'block';
            } else {
                iconPlus.style.display = 'block';
                iconMinus.style.display = 'none';
            }
        });
    });

    // ========================================
    // SELECCIÓN DE COLORES
    // ========================================

    const colorSwatches = document.querySelectorAll('.color-swatch');
    const selectedColors = new Set();

    colorSwatches.forEach(swatch => {
        swatch.addEventListener('click', function() {
            const colorValue = this.getAttribute('data-value');
            
            // Toggle selección
            if (this.classList.contains('selected')) {
                this.classList.remove('selected');
                selectedColors.delete(colorValue);
            } else {
                this.classList.add('selected');
                selectedColors.add(colorValue);
            }
            
            console.log('Colores seleccionados:', Array.from(selectedColors));
            actualizarBotones();
        });
    });

    // ========================================
    // SELECCIÓN DE MATERIALES
    // ========================================

    const materialBoxes = document.querySelectorAll('.material-box');
    const selectedMaterials = new Set();

    materialBoxes.forEach(box => {
        box.addEventListener('click', function() {
            const materialValue = this.getAttribute('data-value');
            
            // Toggle selección
            if (this.classList.contains('selected')) {
                this.classList.remove('selected');
                selectedMaterials.delete(materialValue);
            } else {
                this.classList.add('selected');
                selectedMaterials.add(materialValue);
            }
            
            console.log('Materiales seleccionados:', Array.from(selectedMaterials));
            actualizarBotones();
        });
    });

    // ========================================
    // SLIDER DE PRECIO
    // ========================================

    const sliderMin = document.getElementById('sliderMin');
    const sliderMax = document.getElementById('sliderMax');
    const precioMinInput = document.getElementById('precioMin');
    const precioMaxInput = document.getElementById('precioMax');

    if (sliderMin && sliderMax) {
        // Actualizar inputs cuando se mueve el slider
        sliderMin.addEventListener('input', function() {
            let minVal = parseInt(this.value);
            let maxVal = parseInt(sliderMax.value);
            
            if (minVal >= maxVal) {
                this.value = maxVal - 50;
                minVal = maxVal - 50;
            }
            
            precioMinInput.value = minVal;
            actualizarBotones();
        });
        
        sliderMax.addEventListener('input', function() {
            let minVal = parseInt(sliderMin.value);
            let maxVal = parseInt(this.value);
            
            if (maxVal <= minVal) {
                this.value = minVal + 50;
                maxVal = minVal + 50;
            }
            
            precioMaxInput.value = maxVal;
            actualizarBotones();
        });
        
        // Actualizar sliders cuando se escriben los inputs
        precioMinInput.addEventListener('input', function() {
            sliderMin.value = this.value;
            actualizarBotones();
        });
        
        precioMaxInput.addEventListener('input', function() {
            sliderMax.value = this.value;
            actualizarBotones();
        });
    }

    // ========================================
    // PRE-CARGAR FILTROS DESDE URL
    // ========================================
    
    function precargarFiltrosDesdeURL() {
        const urlParams = new URLSearchParams(window.location.search);
        
        // Limpiar selecciones previas
        selectedColors.clear();
        selectedMaterials.clear();
        
        colorSwatches.forEach(swatch => swatch.classList.remove('selected'));
        materialBoxes.forEach(box => box.classList.remove('selected'));
        
        // Pre-seleccionar colores
        if (urlParams.has('filter_color')) {
            const colorIds = urlParams.get('filter_color').split(',');
            colorIds.forEach(colorId => {
                const swatch = document.querySelector(`.color-swatch[data-value="${colorId}"]`);
                if (swatch) {
                    swatch.classList.add('selected');
                    selectedColors.add(colorId);
                }
            });
        }
        
        // Pre-seleccionar materiales
        if (urlParams.has('filter_material')) {
            const materialIds = urlParams.get('filter_material').split(',');
            materialIds.forEach(materialId => {
                const box = document.querySelector(`.material-box[data-value="${materialId}"]`);
                if (box) {
                    box.classList.add('selected');
                    selectedMaterials.add(materialId);
                }
            });
        }
        
        // Pre-rellenar rango de precio
        if (urlParams.has('min_price')) {
            const minPrice = parseInt(urlParams.get('min_price'));
            precioMinInput.value = minPrice;
            sliderMin.value = minPrice;
        } else {
            precioMinInput.value = 0;
            sliderMin.value = 0;
        }
        
        if (urlParams.has('max_price')) {
            const maxPrice = parseInt(urlParams.get('max_price'));
            precioMaxInput.value = maxPrice;
            sliderMax.value = maxPrice;
        } else {
            precioMaxInput.value = 5000;
            sliderMax.value = 5000;
        }
        
        // Pre-seleccionar orden
        if (urlParams.has('orderby')) {
            const orderby = urlParams.get('orderby');
            const radioBtn = document.querySelector(`input[name="ordenar"][value="${orderby}"]`);
            if (radioBtn) {
                radioBtn.checked = true;
            }
        } else {
            // Si no hay orderby en URL, seleccionar "todo"
            const radioTodo = document.querySelector('input[name="ordenar"][value="todo"]');
            if (radioTodo) {
                radioTodo.checked = true;
            }
        }
        
        // Actualizar estado de botones
        actualizarBotones();
    }

    // ========================================
    // BOTONES APLICAR Y BORRAR
    // ========================================

    const aplicarBtn = document.getElementById('filtrarAplicarBtn');
    const borrarBtn = document.getElementById('filtrarBorrarBtn');
    let hayFiltrosActivos = false;

    function actualizarBotones() {
        // Verificar si hay filtros activos en el modal
        const hayColores = selectedColors.size > 0;
        const hayMateriales = selectedMaterials.size > 0;
        const precioMinVal = parseInt(precioMinInput.value) || 0;
        const precioMaxVal = parseInt(precioMaxInput.value) || 5000;
        const hayPrecio = precioMinVal > 0 || precioMaxVal < 5000;
        
        // Verificar si hay orden seleccionado (diferente a "todo")
        const ordenSeleccionado = document.querySelector('input[name="ordenar"]:checked');
        const hayOrden = ordenSeleccionado && ordenSeleccionado.value !== 'todo';
        
        // Hay filtros activos si hay alguno seleccionado
        hayFiltrosActivos = hayColores || hayMateriales || hayPrecio || hayOrden;
        
        // ⭐ También considerar filtros en URL
        const urlParams = new URLSearchParams(window.location.search);
        const hayFiltrosEnURL = urlParams.has('filter_color') || 
                                urlParams.has('filter_material') || 
                                urlParams.has('min_price') || 
                                urlParams.has('max_price') || 
                                (urlParams.has('orderby') && urlParams.get('orderby') !== 'todo');
        
        // Habilitar/deshabilitar botón APLICAR
        if (hayFiltrosActivos) {
            aplicarBtn.disabled = false;
            aplicarBtn.style.opacity = '1';
            aplicarBtn.style.cursor = 'pointer';
        } else {
            aplicarBtn.disabled = true;
            aplicarBtn.style.opacity = '0.5';
            aplicarBtn.style.cursor = 'not-allowed';
        }
        
        // Habilitar/deshabilitar botón BORRAR (considera URL también)
        if (hayFiltrosActivos || hayFiltrosEnURL) {
            borrarBtn.classList.add('active');
        } else {
            borrarBtn.classList.remove('active');
        }
    }

    // Actualizar cuando cambia el orden
    const ordenRadios = document.querySelectorAll('input[name="ordenar"]');
    ordenRadios.forEach(radio => {
        radio.addEventListener('change', actualizarBotones);
    });

    // Estado inicial
    actualizarBotones();

    // ========================================
    // APLICAR FILTROS
    // ========================================

    aplicarBtn.addEventListener('click', function() {
        if (!hayFiltrosActivos) return;
        
        // Construir URL con parámetros
        const url = new URL(window.location.href);
        const params = new URLSearchParams();
        
        // Añadir colores
        if (selectedColors.size > 0) {
            params.append('filter_color', Array.from(selectedColors).join(','));
        }
        
        // Añadir materiales
        if (selectedMaterials.size > 0) {
            params.append('filter_material', Array.from(selectedMaterials).join(','));
        }
        
        // Añadir precio
        const precioMinVal = parseInt(precioMinInput.value) || 0;
        const precioMaxVal = parseInt(precioMaxInput.value) || 5000;
        if (precioMinVal > 0 || precioMaxVal < 5000) {
            params.append('min_price', precioMinVal);
            params.append('max_price', precioMaxVal);
        }
        
        // Añadir orden (solo si no es "todo")
        const ordenSeleccionado = document.querySelector('input[name="ordenar"]:checked');
        if (ordenSeleccionado && ordenSeleccionado.value !== 'todo') {
            params.append('orderby', ordenSeleccionado.value);
        }
        
        // Redirigir con parámetros
        window.location.href = url.pathname + '?' + params.toString();
    });

    // ========================================
    // BORRAR FILTROS
    // ========================================

    borrarBtn.addEventListener('click', function() {
        if (!borrarBtn.classList.contains('active')) return;
        
        // Limpiar filtros
        selectedColors.clear();
        selectedMaterials.clear();
        
        // Deseleccionar colores
        colorSwatches.forEach(swatch => {
            swatch.classList.remove('selected');
        });
        
        // Deseleccionar materiales
        materialBoxes.forEach(box => {
            box.classList.remove('selected');
        });
        
        // Reset precio
        precioMinInput.value = 0;
        precioMaxInput.value = 5000;
        sliderMin.value = 0;
        sliderMax.value = 5000;
        
        // Reset orden a "TODO"
        const ordenTodo = document.querySelector('input[name="ordenar"][value="todo"]');
        if (ordenTodo) {
            ordenTodo.checked = true;
        }
        
        // Actualizar botones
        actualizarBotones();
        
        // Redirigir a URL limpia
        window.location.href = window.location.pathname;
    });
});