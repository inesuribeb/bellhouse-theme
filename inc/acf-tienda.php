<?php
// ========================================
// ACF FIELDS: TIENDA (SHOP PAGE)
// ========================================

if (function_exists('acf_add_local_field_group')):

    acf_add_local_field_group(array(
        'key' => 'group_tienda',
        'title' => 'Tienda - Intro',
        'fields' => array(
            
            // Título de la tienda
            array(
                'key' => 'field_tienda_titulo',
                'label' => 'Título de la Tienda',
                'name' => 'tienda_titulo',
                'type' => 'text',
                'instructions' => 'Título principal de la página de tienda',
                'default_value' => 'Nuestra selección',
            ),
            
            // Texto descriptivo
            array(
                'key' => 'field_tienda_texto',
                'label' => 'Texto Descriptivo',
                'name' => 'tienda_texto',
                'type' => 'textarea',
                'instructions' => 'Texto que aparece debajo del título',
                'rows' => 4,
                'default_value' => 'Esta no es una tienda más. Es una selección viva de piezas que usamos en casa de nuestros clientes y en nuestros propios proyectos.',
            ),
            
            // Mensaje "Sin productos"
            array(
                'key' => 'field_tienda_sin_productos',
                'label' => 'Mensaje Sin Productos',
                'name' => 'tienda_sin_productos',
                'type' => 'text',
                'instructions' => 'Mensaje que aparece cuando una categoría no tiene productos',
                'default_value' => 'Aún no hay productos en esta categoría',
            ),
            
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page',
                    'operator' => '==',
                    'value' => wc_get_page_id('shop'), // ⭐ ID de la página Tienda
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
    ));

endif;