<?php
// ========================================
// ACF FIELDS: HOME - CONTACTO
// ========================================

if (function_exists('acf_add_local_field_group')):

    acf_add_local_field_group(array(
        'key' => 'group_home_contacto',
        'title' => 'Home - Contacto',
        'fields' => array(
            // Tab
            array(
                'key' => 'field_contacto_tab',
                'label' => 'Contacto',
                'type' => 'tab',
            ),
            
            // Título
            array(
                'key' => 'field_contacto_titulo',
                'label' => 'Título',
                'name' => 'contacto_titulo',
                'type' => 'text',
                'default_value' => '¿Hablamos?',
            ),
            
            // Enlace
            array(
                'key' => 'field_contacto_link',
                'label' => 'Enlace',
                'name' => 'contacto_link',
                'type' => 'text',
                'default_value' => '/contacto',
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