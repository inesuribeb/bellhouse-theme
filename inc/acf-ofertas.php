<?php
// ========================================
// ACF FIELDS: PÁGINA OFERTAS
// ========================================

if (function_exists('acf_add_local_field_group')):

    acf_add_local_field_group(array(
        'key' => 'group_ofertas',
        'title' => 'Contenido de Ofertas',
        'fields' => array(
            
            // Título
            array(
                'key' => 'field_ofertas_titulo',
                'label' => 'Título',
                'name' => 'ofertas_titulo',
                'type' => 'text',
                'instructions' => 'Título principal que se muestra en la página de Ofertas',
                'default_value' => 'Ofertas',
                'placeholder' => 'Ej: Precios especiales',
            ),
            
            // Texto
            array(
                'key' => 'field_ofertas_texto',
                'label' => 'Texto descriptivo',
                'name' => 'ofertas_texto',
                'type' => 'textarea',
                'instructions' => 'Texto descriptivo que aparece debajo del título',
                'rows' => 4,
                'default_value' => 'Productos seleccionados con descuentos exclusivos.',
                'placeholder' => 'Ej: Aprovecha estas ofertas limitadas...',
            ),
            
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page', // ⭐ CAMBIO: de page_template a page
                    'operator' => '==',
                    'value' => get_page_by_path('ofertas')->ID, // ⭐ ID de la página
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
    ));

endif;