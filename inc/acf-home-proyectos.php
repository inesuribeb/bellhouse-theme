<?php
// ========================================
// ACF FIELDS: HOME - PROYECTOS RECIENTES
// ========================================

if (function_exists('acf_add_local_field_group')):

    acf_add_local_field_group(array(
        'key' => 'group_home_proyectos',
        'title' => 'Home - Proyectos Recientes',
        'fields' => array(
            // Tab
            array(
                'key' => 'field_proyectos_tab',
                'label' => 'Proyectos Recientes',
                'type' => 'tab',
            ),
            
            // Título
            array(
                'key' => 'field_proyectos_titulo',
                'label' => 'Título',
                'name' => 'proyectos_titulo',
                'type' => 'text',
                'default_value' => 'Proyectos recientes',
            ),
            
            // Texto
            array(
                'key' => 'field_proyectos_texto',
                'label' => 'Texto Descriptivo',
                'name' => 'proyectos_texto',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Aquí encontrarás una selección de obras y decoraciones integrales que reflejan nuestra manera de entender el interiorismo: belleza práctica, duradera y sin artificios.',
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