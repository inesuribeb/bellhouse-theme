<?php
// ========================================
// ACF FIELDS: FOOTER SETTINGS
// ========================================

if (function_exists('acf_add_local_field_group')):

    acf_add_local_field_group(array(
        'key' => 'group_footer',
        'title' => 'Footer - Configuración',
        'fields' => array(

            // Tab: Ven a vernos
            array(
                'key' => 'field_footer_tab_address',
                'label' => 'Ven a vernos',
                'type' => 'tab',
            ),

            array(
                'key' => 'field_footer_direccion',
                'label' => 'Dirección',
                'name' => 'footer_direccion',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Calle Mayor 10B, Las Arenas, 48930 Getxo',
            ),

            array(
                'key' => 'field_footer_telefono',
                'label' => 'Teléfono',
                'name' => 'footer_telefono',
                'type' => 'text',
                'default_value' => '+ 34 944 80 14 72',
            ),

            array(
                'key' => 'field_footer_email',
                'label' => 'Email',
                'name' => 'footer_email',
                'type' => 'email',
                'default_value' => 'bellhousesl@gmail.com',
            ),

            // Tab: Newsletter
            array(
                'key' => 'field_footer_tab_newsletter',
                'label' => 'Newsletter',
                'type' => 'tab',
            ),

            array(
                'key' => 'field_footer_newsletter_texto',
                'label' => 'Texto Newsletter',
                'name' => 'footer_newsletter_texto',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Déjanos tu email y te enviaremos una promo del 10% para tu primera compra',
            ),

            // Tab: Networks
            array(
                'key' => 'field_footer_tab_networks',
                'label' => 'Networks',
                'type' => 'tab',
            ),

            array(
                'key' => 'field_footer_instagram',
                'label' => 'Instagram URL',
                'name' => 'footer_instagram',
                'type' => 'url',
                'default_value' => 'https://instagram.com',
            ),

            array(
                'key' => 'field_footer_linkedin',
                'label' => 'LinkedIn URL',
                'name' => 'footer_linkedin',
                'type' => 'url',
                'default_value' => 'https://linkedin.com',
            ),

            array(
                'key' => 'field_footer_whatsapp',
                'label' => 'WhatsApp URL',
                'name' => 'footer_whatsapp',
                'type' => 'url',
                'default_value' => 'https://wa.me/',
            ),

            array(
                'key' => 'field_footer_email_network',
                'label' => 'Email (Networks)',
                'name' => 'footer_email_network',
                'type' => 'email',
                'default_value' => 'bellhousesl@gmail.com',
            ),

        ),
        'location' => array(
            array(
                array(
                    'param' => 'page',
                    'operator' => '==',
                    'value' => get_page_by_path('footer-settings')->ID ?? 0,
                ),
            ),
        ),
    ));

endif;