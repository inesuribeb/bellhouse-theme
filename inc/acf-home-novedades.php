<?php
// ========================================
// ACF FIELDS: HOME - NOVEDADES
// ========================================

if (function_exists('acf_add_local_field_group')):

    acf_add_local_field_group(array(
        'key' => 'group_home_novedades',
        'title' => 'Home - Novedades',
        'fields' => array(
            // Tab
            array(
                'key' => 'field_novedades_tab',
                'label' => 'Novedades',
                'type' => 'tab',
            ),

            array(
                'key' => 'field_novedades_activar',
                'label' => 'Activar esta sección',
                'name' => 'novedades_activar',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'message' => 'Mostrar sección de Novedades en la home',
            ),

            // Label SEO
            array(
                'key' => 'field_novedades_label',
                'label' => 'Label SEO',
                'name' => 'novedades_label',
                'type' => 'text',
                'default_value' => 'novedades',
            ),

            // Título
            array(
                'key' => 'field_novedades_titulo',
                'label' => 'Título',
                'name' => 'novedades_titulo',
                'type' => 'text',
                'default_value' => 'El rincón de las novedades',
            ),

            // Imagen de fondo
            array(
                'key' => 'field_novedades_imagen',
                'label' => 'Imagen de Fondo',
                'name' => 'novedades_imagen',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'large',
            ),

                // ¿Tiene enlace?
            array(
                'key' => 'field_novedades_tiene_enlace',
                'label' => '¿Añadir enlace a la imagen?',
                'name' => 'novedades_tiene_enlace',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
                'message' => 'Si está desactivado, la imagen será solo decorativa',
            ),

                // Enlace (con conditional logic)
            array(
                'key' => 'field_novedades_link',
                'label' => 'Enlace',
                'name' => 'novedades_link',
                'type' => 'text',
                'default_value' => '/tienda?filter=novedades',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_novedades_tiene_enlace',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page',
                    'operator' => '==',
                    'value' => get_page_by_path('home')->ID ?? 0,
                ),
            ),
        ),
    ));

endif;