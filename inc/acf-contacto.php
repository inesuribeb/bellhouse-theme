<?php
// ========================================
// ACF FIELDS: CONTACTO
// ========================================

if (function_exists('acf_add_local_field_group')):

    acf_add_local_field_group(array(
        'key' => 'group_contacto',
        'title' => 'Contacto - Configuración',
        'fields' => array(
            
            array(
                'key' => 'field_contacto_label',
                'label' => 'Label Superior',
                'name' => 'contacto_label',
                'type' => 'text',
                'default_value' => 'Te responderemos en menos de 48h',
            ),
            
            array(
                'key' => 'field_contacto_titulo',
                'label' => 'Título',
                'name' => 'contacto_titulo',
                'type' => 'text',
                'default_value' => 'Hablemos de tu casa',
            ),
            
            array(
                'key' => 'field_contacto_texto',
                'label' => 'Texto Descriptivo',
                'name' => 'contacto_texto',
                'type' => 'textarea',
                'rows' => 4,
                'default_value' => 'Cuéntanos qué necesitas y adjunta fotos, planos o cualquier referencia. Te responderemos personalmente en la mayor brevedad posible.',
            ),
            
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page',
                    'operator' => '==',
                    'value' => get_page_by_path('contacto')->ID ?? 0,
                ),
            ),
        ),
    ));

endif;