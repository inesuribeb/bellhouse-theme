<?php
// ========================================
// ACF FIELDS: VARIACIONES DE PRODUCTOS
// ========================================

if (function_exists('acf_add_local_field_group')):

    acf_add_local_field_group(array(
        'key' => 'group_variaciones',
        'title' => 'Imágenes de la Variación',
        'fields' => array(

            // Imagen Hover de la Variación
            array(
                'key' => 'field_variacion_imagen_hover',
                'label' => 'Imagen Hover (Variación)',
                'name' => 'variacion_imagen_hover',
                'type' => 'image',
                'instructions' => 'Imagen que se muestra al pasar el ratón. Si está vacío, usa la del producto padre.',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),

            // Galería adicional de la Variación
            array(
                'key' => 'field_variacion_galeria',
                'label' => 'Galería Adicional (Variación)',
                'name' => 'variacion_galeria',
                'type' => 'gallery',
                'instructions' => 'Imágenes adicionales para esta variación específica. Si está vacío, usa la galería del producto padre.',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
            ),

            // Imagen PNG de la Variación
            array(
                'key' => 'field_variacion_imagen_png',
                'label' => 'Imagen PNG Silueteado (Variación)',
                'name' => 'variacion_imagen_png',
                'type' => 'image',
                'instructions' => 'Imagen sin fondo para esta variación. Si está vacío, usa la del producto padre.',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),

        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'product_variation',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
    ));

endif;