<?php
// ========================================
// ACF FIELDS: HOME - SECCIÓN TIENDA
// ========================================

if (function_exists('acf_add_local_field_group')):

    acf_add_local_field_group(array(
        'key' => 'group_home_tienda',
        'title' => 'Home - Sección Tienda',
        'fields' => array(
            
            // Label SEO
            array(
                'key' => 'field_home_tienda_label',
                'label' => 'Label SEO',
                'name' => 'home_tienda_label',
                'type' => 'text',
                'instructions' => 'Pequeño texto que aparece arriba del título',
                'default_value' => '/tienda',
                'placeholder' => 'Ej: /tienda',
            ),
            
            // Título
            array(
                'key' => 'field_home_tienda_titulo',
                'label' => 'Título',
                'name' => 'home_tienda_titulo',
                'type' => 'text',
                'instructions' => 'Título principal de la sección',
                'default_value' => 'Selección Bell House',
                'placeholder' => 'Ej: Nuestra tienda',
            ),
            
            // Texto
            array(
                'key' => 'field_home_tienda_texto',
                'label' => 'Texto descriptivo',
                'name' => 'home_tienda_texto',
                'type' => 'textarea',
                'instructions' => 'Texto descriptivo debajo del título',
                'rows' => 3,
                'default_value' => 'Nuestros favoritos. Ahora online.',
                'placeholder' => 'Ej: Descubre nuestra selección...',
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
        'menu_order' => 1,
        'position' => 'normal',
        'style' => 'default',
    ));

endif;