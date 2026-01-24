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

        // Función para encontrar variación coincidente
        function findMatchingVariation() {
            const selected = {};

            // Obtener valores de selects y inputs hidden
            $form.find('select, input[data-attribute_name]').each(function () {
                const attrName = $(this).data('attribute_name');
                const value = $(this).val();
                if (value) {
                    selected[attrName] = value;
                }
            });


            // Buscar variación que coincida
            for (let i = 0; i < variations.length; i++) {
                const variation = variations[i];
                let match = true;

                for (let attr in selected) {
                    if (variation.attributes[attr] !== selected[attr]) {
                        match = false;
                        break;
                    }
                }

                if (match) {
                    console.log('Matching variation found:', variation);
                    return variation;
                }
            }

            return null;
        }

        // Si solo hay inputs hidden (una sola opción), habilitar botón automáticamente
        const hasOnlyHiddenInputs = $form.find('select').length === 0;
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

        // Al cambiar cualquier select
        $form.on('change', 'select', function () {
            const matchedVariation = findMatchingVariation();

            if (matchedVariation) {
                // Variación encontrada
                $variationId.val(matchedVariation.variation_id);
                $addToCartBtn.prop('disabled', false);

                // Actualizar precio
                if (matchedVariation.price_html) {
                    $priceContainer.html(matchedVariation.price_html);
                }

                console.log('Variation selected:', matchedVariation.variation_id);
            } else {
                // No hay coincidencia
                $variationId.val(0);
                $addToCartBtn.prop('disabled', true);
                $priceContainer.html(originalPrice);

                console.log('No matching variation');
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
});