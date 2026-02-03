<?php
// ========================================
// ACF FIELDS: PRODUCTOS WOOCOMMERCE
// ========================================

if (function_exists('acf_add_local_field_group')):

    acf_add_local_field_group(array(
        'key' => 'group_productos',
        'title' => 'Información Adicional del Producto',
        'fields' => array(

            // ⭐ NUEVO: Orientación de la card
            array(
                'key' => 'field_orientacion_card',
                'label' => 'Orientación en Tienda',
                'name' => 'orientacion_card',
                'type' => 'radio',
                'instructions' => 'Elige cómo se mostrará este producto en el grid de la tienda',
                'choices' => array(
                    'vertical' => 'Vertical (1 columna)',
                    'horizontal' => 'Horizontal (2 columnas)',
                ),
                'default_value' => 'vertical',
                'layout' => 'horizontal',
            ),

            // ⭐ NUEVO: Novedad
            array(
                'key' => 'field_novedad',
                'label' => 'Novedad',
                'name' => 'novedad',
                'type' => 'true_false',
                'instructions' => 'Marca si este producto es una novedad',
                'message' => 'Este producto es una novedad',
                'default_value' => 0,
                'ui' => 1,
            ),

            // Imagen Hover
            array(
                'key' => 'field_imagen_hover',
                'label' => 'Imagen Hover',
                'name' => 'imagen_hover',
                'type' => 'image',
                'instructions' => 'Imagen que se muestra al pasar el ratón sobre el producto en listados',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),

            // Imagen PNG Silueteado
            array(
                'key' => 'field_imagen_png',
                'label' => 'Imagen PNG Silueteado',
                'name' => 'imagen_png',
                'type' => 'image',
                'instructions' => 'Imagen del producto sin fondo (PNG transparente)',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),

            // Plazo de Entrega
            array(
                'key' => 'field_plazo_entrega',
                'label' => 'Plazo de Entrega',
                'name' => 'plazo_entrega',
                'type' => 'text',
                'instructions' => 'Ej: 2-3 semanas, 4-6 semanas, Envío inmediato',
                'placeholder' => '2-3 semanas',
            ),

            // Ficha Técnica (PDF descargable)
            array(
                'key' => 'field_ficha_tecnica',
                'label' => 'Ficha Técnica (PDF)',
                'name' => 'ficha_tecnica',
                'type' => 'file',
                'instructions' => 'Sube un PDF con las especificaciones técnicas del producto',
                'return_format' => 'array',
                'library' => 'all',
                'mime_types' => 'pdf',
            ),

            // A Medida (Booleano)
            array(
                'key' => 'field_a_medida',
                'label' => 'Disponible a Medida',
                'name' => 'a_medida',
                'type' => 'true_false',
                'instructions' => 'Marca si este producto se puede fabricar a medida',
                'message' => 'Este producto está disponible a medida',
                'default_value' => 0,
                'ui' => 1,
            ),

                // Combínalo con - Productos relacionados
            array(
                'key' => 'field_combinalo_con',
                'label' => 'Combínalo con - Productos',
                'name' => 'combinalo_con_productos',
                'type' => 'relationship',
                'instructions' => 'Selecciona hasta 3 productos para mostrar en "Combínalo con"',
                'post_type' => array(
                    0 => 'product', // WooCommerce products
                ),
                'filters' => array(
                    0 => 'search',
                    1 => 'post_type',
                ),
                'return_format' => 'object',
                'min' => 0,
                'max' => 3, // Máximo 3 productos
            ),

        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'product',
                ),
            ),
        ),
    ));

endif;