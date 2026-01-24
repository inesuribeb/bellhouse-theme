<?php
// ========================================
// ACF FIELDS: HOME - UNIVERSO BELL HOUSE
// ========================================

if (function_exists('acf_add_local_field_group')):

    acf_add_local_field_group(array(
        'key' => 'group_home_universo',
        'title' => 'Home - Universo Bell House',
        'fields' => array(
            // Tab
            array(
                'key' => 'field_universo_tab',
                'label' => 'Universo Bell House',
                'type' => 'tab',
            ),
            
            // Label SEO
            array(
                'key' => 'field_universo_label',
                'label' => 'Label SEO',
                'name' => 'universo_label',
                'type' => 'text',
                'default_value' => 'universo Bell House',
            ),
            
            // Título
            array(
                'key' => 'field_universo_titulo',
                'label' => 'Título',
                'name' => 'universo_titulo',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Un estudio de interiorismo, una tienda y un pequeño (gran) equipo',
            ),
            
            // Imagen
            array(
                'key' => 'field_universo_imagen',
                'label' => 'Imagen',
                'name' => 'universo_imagen',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),
            
            // Enlace
            array(
                'key' => 'field_universo_link',
                'label' => 'Enlace',
                'name' => 'universo_link',
                'type' => 'text',
                'default_value' => '/universo-bell-house',
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