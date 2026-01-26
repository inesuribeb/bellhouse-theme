jQuery(document).ready(function ($) {
    console.log('Script cargado correctamente');
    console.log('Acordeones encontrados:', $('.acordeon-header').length);
    
    // ======================================
    // CÓDIGO ORIGINAL PARA WOOCOMMERCE NATIVO
    // ======================================
    $('form.variations_form').each(function () {

        $(this).on('found_variation', function (event, variation) {
            console.log('Variación encontrada:', variation);

            // Actualizar el precio
            if (variation.price_html) {
                $('.product-price').html(variation.price_html);
                console.log('Precio actualizado');
            }
        });

        $(this).on('reset_data', function () {

            // Restaurar precio original
            const originalPrice = $(this).data('original-price');
            if (originalPrice) {
                $('.product-price').html(originalPrice);
            }
        });

        // Guardar el precio original
        $(this).data('original-price', $('.product-price').html());
    });

    // ======================================
    // CÓDIGO PERSONALIZADO PARA CUSTOM VARIATIONS
    // ======================================
    const $form = $('.custom-variations-form');
    if ($form.length) {

        const variations = $form.data('product_variations');
        const $variationId = $form.find('.variation_id');
        const $addToCartBtn = $form.find('.custom-add-to-cart-button');
        const $priceContainer = $('.product-price');
        const originalPrice = $priceContainer.html();
        const originalButtonText = $addToCartBtn.text();

        // Función para encontrar variación coincidente
        function findMatchingVariation() {
            const selected = {};
            let allSelected = true;

            // Obtener valores de selects y inputs hidden
            $form.find('select, input[data-attribute_name]').each(function () {
                const attrName = $(this).data('attribute_name');
                const value = $(this).val();
                
                if (value) {
                    selected[attrName] = value;
                } else {
                    allSelected = false;
                }
            });

            // Si no están todos seleccionados, no buscar variación
            if (!allSelected) {
                return null;
            }

            // Buscar variación que coincida
            for (let i = 0; i < variations.length; i++) {
                const variation = variations[i];
                let match = true;

                for (let attr in selected) {
                    // Normalizar espacios para comparación
                    const selectedValue = selected[attr].trim();
                    const variationValue = (variation.attributes[attr] || '').trim();
                    
                    if (variationValue !== selectedValue) {
                        match = false;
                        break;
                    }
                }

                if (match) {
                    console.log('✅ Matching variation found:', variation);
                    return variation;
                }
            }

            return null;
        }

        // Si solo hay inputs hidden (una sola opción), habilitar botón automáticamente
        const hasOnlyHiddenInputs = $form.find('select').length === 0 && $form.find('.color-swatches').length === 0;
        if (hasOnlyHiddenInputs) {
            console.log('Only one option available, auto-selecting');
            const matchedVariation = findMatchingVariation();
            if (matchedVariation) {
                $variationId.val(matchedVariation.variation_id);
                $addToCartBtn.prop('disabled', false);

                if (matchedVariation.price_html) {
                    $priceContainer.html(matchedVariation.price_html);
                }
            }
        }

        // Al cambiar cualquier select o input hidden
        $form.on('change', 'select, input[type="hidden"][data-attribute_name]', function () {
            const matchedVariation = findMatchingVariation();

            if (matchedVariation) {
                // Variación encontrada
                $variationId.val(matchedVariation.variation_id);
                
                // Actualizar precio
                if (matchedVariation.price_html) {
                    $priceContainer.html(matchedVariation.price_html);
                }
                
                // ⭐ Gestión de stock
                const $quantityInput = $form.find('input[name="quantity"]');
                
                if (matchedVariation.is_in_stock) {
                    $addToCartBtn.prop('disabled', false);
                    $addToCartBtn.text(originalButtonText);
                    
                    if (matchedVariation.max_qty) {
                        // Tiene stock limitado
                        $quantityInput.attr('max', matchedVariation.max_qty);
                        
                        // Si la cantidad actual es mayor que el stock, ajustar
                        if (parseInt($quantityInput.val()) > matchedVariation.max_qty) {
                            $quantityInput.val(matchedVariation.max_qty);
                        }
                        
                        console.log('Stock disponible:', matchedVariation.max_qty);
                    } else {
                        // Stock ilimitado o no gestionado
                        $quantityInput.attr('max', 9999);
                        console.log('Stock: Ilimitado');
                    }
                } else {
                    // Sin stock
                    $addToCartBtn.prop('disabled', true);
                    $addToCartBtn.text('Agotado');
                    $quantityInput.attr('max', 0);
                    $quantityInput.val(0);
                    console.log('⚠️ Sin stock');
                }

                console.log('Variation selected:', matchedVariation.variation_id);
            } else {
                // No hay coincidencia → Restaurar precio original (rango)
                $variationId.val(0);
                $addToCartBtn.prop('disabled', true);
                $addToCartBtn.text(originalButtonText);
                $priceContainer.html(originalPrice);
                
                // ⭐ Resetear cantidad
                const $quantityInput = $form.find('input[name="quantity"]');
                $quantityInput.attr('max', 9999);
                $quantityInput.val(1);

                console.log('No matching variation - price reset to range');
            }
        });
    }

    // ======================================
    // ACORDEONES
    // ======================================
    $('.acordeon-header').on('click', function () {
        const $item = $(this).closest('.acordeon-item');

        $item.toggleClass('active');

        $('.acordeon-item').not($item).removeClass('active');
    });

    // ======================================
    // COLOR SWATCHES (círculos de color)
    // ======================================
    $('.color-swatch').on('click', function() {
        const $swatch = $(this);
        const $container = $swatch.closest('.color-swatches');
        const $hiddenInput = $container.find('input[type="hidden"]');
        const value = $swatch.data('value');
        
        // Remover selección previa
        $container.find('.color-swatch').removeClass('selected');
        
        // Marcar como seleccionado
        $swatch.addClass('selected');
        
        // Actualizar input hidden
        $hiddenInput.val(value).trigger('change');
        
        // ⭐ IMPORTANTE: Actualizar URL inmediatamente
        updateURLWithAttributes();
        
        console.log('Color seleccionado:', value || 'Cualquiera');
    });

    // ⭐ PRE-SELECCIÓN DE COLORES (SIEMPRE resetear al cargar/refrescar)
    function preselectColorSwatches() {
        // ⭐ PRIMERO: Limpiar URL completamente
        const currentPath = window.location.pathname;
        if (window.location.search) {
            window.history.replaceState({}, '', currentPath);
            console.log('URL limpiada');
        }
        
        // ⭐ SEGUNDO: Resetear visualización de colores a "Cualquiera"
        $('.color-swatches').each(function() {
            const $container = $(this);
            const $hiddenInput = $container.find('input[type="hidden"]');
            
            // Remover TODAS las selecciones previas
            $container.find('.color-swatch').removeClass('selected');
            
            // Pre-seleccionar "Cualquiera"
            $container.find('.color-swatch-any').addClass('selected');
            $hiddenInput.val('');
            
            console.log('Color reseteado a: Cualquiera');
        });
        
        // ⭐ TERCERO: Resetear selects de tamaño también
        $('select[data-attribute_name]').each(function() {
            $(this).val('');
        });
        
        console.log('Todo reseteado - usuario empieza desde cero');
    }

    // ⭐ Ejecutar reset con delay de 300ms
    setTimeout(function() {
        preselectColorSwatches();
    }, 300);

});

// ======================================
// ACTUALIZAR URL CON ATRIBUTOS (vanilla JS)
// ======================================
function updateURLWithAttributes() {
    const urlParams = new URLSearchParams(window.location.search);
    
    // Obtener todos los selects de atributos
    const selects = document.querySelectorAll('.custom-variations-form select[data-attribute_name]');
    
    selects.forEach(select => {
        const attributeName = select.getAttribute('data-attribute_name');
        const value = select.value;
        
        if (value) {
            urlParams.set(attributeName, value);
        } else {
            urlParams.delete(attributeName);
        }
    });
    
    // También obtener color swatches (inputs hidden)
    const colorInputs = document.querySelectorAll('.color-swatches input[type="hidden"][data-attribute_name]');
    
    colorInputs.forEach(input => {
        const attributeName = input.getAttribute('data-attribute_name');
        const value = input.value;
        
        if (value) {
            urlParams.set(attributeName, value);
        } else {
            urlParams.delete(attributeName);
        }
    });
    
    // Actualizar URL sin recargar página
    const newURL = window.location.pathname + (urlParams.toString() ? '?' + urlParams.toString() : '');
    window.history.replaceState({}, '', newURL);
    
    console.log('URL actualizada:', newURL);
}

// Ejecutar al cambiar cualquier atributo
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.custom-variations-form');
    
    if (form) {
        // Escuchar cambios en selects (tamaño)
        const selects = form.querySelectorAll('select[data-attribute_name]');
        selects.forEach(select => {
            select.addEventListener('change', function() {
                updateURLWithAttributes();
            });
        });
    }
});