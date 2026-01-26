<?php
// ========================================
// ACF FIELDS: PÁGINA NOVEDADES
// ========================================

if (function_exists('acf_add_local_field_group')):

    acf_add_local_field_group(array(
        'key' => 'group_novedades',
        'title' => 'Contenido de Novedades',
        'fields' => array(
            
            // Título
            array(
                'key' => 'field_novedades_titulo',
                'label' => 'Título',
                'name' => 'novedades_titulo',
                'type' => 'text',
                'instructions' => 'Título principal que se muestra en la página de Novedades',
                'default_value' => 'Novedades',
                'placeholder' => 'Ej: Lo último en diseño',
            ),
            
            // Texto
            array(
                'key' => 'field_novedades_texto',
                'label' => 'Texto descriptivo',
                'name' => 'novedades_texto',
                'type' => 'textarea',
                'instructions' => 'Texto descriptivo que aparece debajo del título',
                'rows' => 4,
                'default_value' => 'Descubre las últimas incorporaciones a nuestro catálogo.',
                'placeholder' => 'Ej: Piezas únicas que acaban de llegar...',
            ),
            
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page', // ⭐ CAMBIO: de page_template a page
                    'operator' => '==',
                    'value' => get_page_by_path('novedades')->ID, // ⭐ ID de la página
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
    ));

endif;