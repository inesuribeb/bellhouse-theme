<?php
error_log('ACF Home Intro cargado'); // Debug

// ========================================
// ACF FIELDS: HOME - INTRO
// ========================================

if (function_exists('acf_add_local_field_group')):

    acf_add_local_field_group(array(
        'key' => 'group_home_intro',
        'title' => 'Home - Intro',
        'fields' => array(
            // Tab Intro
            array(
                'key' => 'field_intro_tab',
                'label' => 'Intro',
                'type' => 'tab',
            ),

            // Label SEO
            array(
                'key' => 'field_intro_label',
                'label' => 'Label SEO',
                'name' => 'intro_label',
                'type' => 'text',
                'default_value' => 'interiorismo',
            ),

            // Título
            array(
                'key' => 'field_intro_titulo',
                'label' => 'Título',
                'name' => 'intro_titulo',
                'type' => 'text',
                'default_value' => 'Creamos espacios que inspiran',
            ),

            // Texto
            array(
                'key' => 'field_intro_texto',
                'label' => 'Texto Descriptivo',
                'name' => 'intro_texto',
                'type' => 'textarea',
                'rows' => 4,
            ),

                // Botón
            array(
                'key' => 'field_intro_boton_texto',
                'label' => 'Texto del Botón',
                'name' => 'intro_boton_texto',
                'type' => 'text',
                'default_value' => 'Quiero saber más',
            ),
            array(
                'key' => 'field_intro_boton_link',
                'label' => 'Enlace del Botón',
                'name' => 'intro_boton_link',
                'type' => 'text',
                'default_value' => '/universo-bell-house',
            ),

            // Servicio 1
            array(
                'key' => 'field_servicio1_nombre',
                'label' => 'Servicio 1 - Nombre',
                'name' => 'servicio1_nombre',
                'type' => 'text',
                'default_value' => 'Diseño de interiores',
            ),
            array(
                'key' => 'field_servicio1_imagen',
                'label' => 'Servicio 1 - Imagen',
                'name' => 'servicio1_imagen',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),

            // Servicio 2
            array(
                'key' => 'field_servicio2_nombre',
                'label' => 'Servicio 2 - Nombre',
                'name' => 'servicio2_nombre',
                'type' => 'text',
                'default_value' => 'Reformas integrales',
            ),
            array(
                'key' => 'field_servicio2_imagen',
                'label' => 'Servicio 2 - Imagen',
                'name' => 'servicio2_imagen',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),

            // Servicio 3
            array(
                'key' => 'field_servicio3_nombre',
                'label' => 'Servicio 3 - Nombre',
                'name' => 'servicio3_nombre',
                'type' => 'text',
                'default_value' => 'Decoración personalizada',
            ),
            array(
                'key' => 'field_servicio3_imagen',
                'label' => 'Servicio 3 - Imagen',
                'name' => 'servicio3_imagen',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),

            // Servicio 4
            array(
                'key' => 'field_servicio4_nombre',
                'label' => 'Servicio 4 - Nombre',
                'name' => 'servicio4_nombre',
                'type' => 'text',
                'default_value' => 'Asesoramiento',
            ),
            array(
                'key' => 'field_servicio4_imagen',
                'label' => 'Servicio 4 - Imagen',
                'name' => 'servicio4_imagen',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
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