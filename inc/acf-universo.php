<?php
// ========================================
// ACF FIELDS: UNIVERSO BELL HOUSE
// ========================================

if (function_exists('acf_add_local_field_group')):

    acf_add_local_field_group(array(
        'key' => 'group_universo',
        'title' => 'Universo Bell House - Configuración',
        'fields' => array(

            // Tab: Hero
            array(
                'key' => 'field_universo_tab_hero',
                'label' => 'Hero',
                'type' => 'tab',
            ),

            array(
                'key' => 'field_universo_hero_titulo',
                'label' => 'Título Hero',
                'name' => 'universo_hero_titulo',
                'type' => 'text',
                'default_value' => 'Universo Bell House',
            ),

            array(
                'key' => 'field_universo_hero_img_pequena',
                'label' => 'Imagen Pequeña',
                'name' => 'universo_hero_img_pequena',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),

            array(
                'key' => 'field_universo_hero_img_grande',
                'label' => 'Imagen Grande',
                'name' => 'universo_hero_img_grande',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'large',
            ),

            // Tab: Historia
            array(
                'key' => 'field_universo_tab_historia',
                'label' => 'Historia',
                'type' => 'tab',
            ),

            array(
                'key' => 'field_universo_historia_texto',
                'label' => 'Texto Historia',
                'name' => 'universo_historia_texto',
                'type' => 'wysiwyg',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ),

            array(
                'key' => 'field_universo_historia_imagen',
                'label' => 'Imagen Historia',
                'name' => 'universo_historia_imagen',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),

            array(
                'key' => 'field_universo_tab_equipo',
                'label' => 'Equipo',
                'type' => 'tab',
            ),

            array(
                'key' => 'field_equipo_titulo',
                'label' => 'Título Equipo',
                'name' => 'equipo_titulo',
                'type' => 'text',
                'default_value' => 'Nuestro equipo',
            ),

            array(
                'key' => 'field_equipo_texto',
                'label' => 'Texto Equipo',
                'name' => 'equipo_texto',
                'type' => 'textarea',
                'rows' => 3,
            ),

            // Miembro 1
            array(
                'key' => 'field_equipo_1_foto',
                'label' => 'Miembro 1 - Foto',
                'name' => 'equipo_1_foto',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
            ),
            array(
                'key' => 'field_equipo_1_nombre',
                'label' => 'Miembro 1 - Nombre',
                'name' => 'equipo_1_nombre',
                'type' => 'text',
            ),
            array(
                'key' => 'field_equipo_1_cargo',
                'label' => 'Miembro 1 - Cargo',
                'name' => 'equipo_1_cargo',
                'type' => 'text',
            ),

            // Miembro 2
            array(
                'key' => 'field_equipo_2_foto',
                'label' => 'Miembro 2 - Foto',
                'name' => 'equipo_2_foto',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
            ),
            array(
                'key' => 'field_equipo_2_nombre',
                'label' => 'Miembro 2 - Nombre',
                'name' => 'equipo_2_nombre',
                'type' => 'text',
            ),
            array(
                'key' => 'field_equipo_2_cargo',
                'label' => 'Miembro 2 - Cargo',
                'name' => 'equipo_2_cargo',
                'type' => 'text',
            ),

            // Miembro 3
            array(
                'key' => 'field_equipo_3_foto',
                'label' => 'Miembro 3 - Foto',
                'name' => 'equipo_3_foto',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
            ),
            array(
                'key' => 'field_equipo_3_nombre',
                'label' => 'Miembro 3 - Nombre',
                'name' => 'equipo_3_nombre',
                'type' => 'text',
            ),
            array(
                'key' => 'field_equipo_3_cargo',
                'label' => 'Miembro 3 - Cargo',
                'name' => 'equipo_3_cargo',
                'type' => 'text',
            ),

            // Miembro 4
            array(
                'key' => 'field_equipo_4_foto',
                'label' => 'Miembro 4 - Foto',
                'name' => 'equipo_4_foto',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
            ),
            array(
                'key' => 'field_equipo_4_nombre',
                'label' => 'Miembro 4 - Nombre',
                'name' => 'equipo_4_nombre',
                'type' => 'text',
            ),
            array(
                'key' => 'field_equipo_4_cargo',
                'label' => 'Miembro 4 - Cargo',
                'name' => 'equipo_4_cargo',
                'type' => 'text',
            ),

            // Miembro 5
            array(
                'key' => 'field_equipo_5_foto',
                'label' => 'Miembro 5 - Foto',
                'name' => 'equipo_5_foto',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
            ),
            array(
                'key' => 'field_equipo_5_nombre',
                'label' => 'Miembro 5 - Nombre',
                'name' => 'equipo_5_nombre',
                'type' => 'text',
            ),
            array(
                'key' => 'field_equipo_5_cargo',
                'label' => 'Miembro 5 - Cargo',
                'name' => 'equipo_5_cargo',
                'type' => 'text',
            ),

            // Miembro 6
            array(
                'key' => 'field_equipo_6_foto',
                'label' => 'Miembro 6 - Foto',
                'name' => 'equipo_6_foto',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
            ),
            array(
                'key' => 'field_equipo_6_nombre',
                'label' => 'Miembro 6 - Nombre',
                'name' => 'equipo_6_nombre',
                'type' => 'text',
            ),
            array(
                'key' => 'field_equipo_6_cargo',
                'label' => 'Miembro 6 - Cargo',
                'name' => 'equipo_6_cargo',
                'type' => 'text',
            ),

                // Tab: Publicaciones
            array(
                'key' => 'field_universo_tab_publicaciones',
                'label' => 'Publicaciones',
                'type' => 'tab',
            ),

            array(
                'key' => 'field_publicaciones_titulo',
                'label' => 'Título Publicaciones',
                'name' => 'publicaciones_titulo',
                'type' => 'text',
                'default_value' => 'Apariciones en medios',
            ),

            // Publicación 1
            array(
                'key' => 'field_pub_1_imagen',
                'label' => 'Publicación 1 - Imagen',
                'name' => 'pub_1_imagen',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
            ),
            array(
                'key' => 'field_pub_1_nombre',
                'label' => 'Publicación 1 - Nombre',
                'name' => 'pub_1_nombre',
                'type' => 'text',
            ),
            array(
                'key' => 'field_pub_1_link',
                'label' => 'Publicación 1 - Link',
                'name' => 'pub_1_link',
                'type' => 'url',
            ),

            // Publicación 2
            array(
                'key' => 'field_pub_2_imagen',
                'label' => 'Publicación 2 - Imagen',
                'name' => 'pub_2_imagen',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
            ),
            array(
                'key' => 'field_pub_2_nombre',
                'label' => 'Publicación 2 - Nombre',
                'name' => 'pub_2_nombre',
                'type' => 'text',
            ),
            array(
                'key' => 'field_pub_2_link',
                'label' => 'Publicación 2 - Link',
                'name' => 'pub_2_link',
                'type' => 'url',
            ),

            // Publicación 3
            array(
                'key' => 'field_pub_3_imagen',
                'label' => 'Publicación 3 - Imagen',
                'name' => 'pub_3_imagen',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
            ),
            array(
                'key' => 'field_pub_3_nombre',
                'label' => 'Publicación 3 - Nombre',
                'name' => 'pub_3_nombre',
                'type' => 'text',
            ),
            array(
                'key' => 'field_pub_3_link',
                'label' => 'Publicación 3 - Link',
                'name' => 'pub_3_link',
                'type' => 'url',
            ),

            // Publicación 4
            array(
                'key' => 'field_pub_4_imagen',
                'label' => 'Publicación 4 - Imagen',
                'name' => 'pub_4_imagen',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
            ),
            array(
                'key' => 'field_pub_4_nombre',
                'label' => 'Publicación 4 - Nombre',
                'name' => 'pub_4_nombre',
                'type' => 'text',
            ),
            array(
                'key' => 'field_pub_4_link',
                'label' => 'Publicación 4 - Link',
                'name' => 'pub_4_link',
                'type' => 'url',
            ),

            // Publicación 5
            array(
                'key' => 'field_pub_5_imagen',
                'label' => 'Publicación 5 - Imagen',
                'name' => 'pub_5_imagen',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
            ),
            array(
                'key' => 'field_pub_5_nombre',
                'label' => 'Publicación 5 - Nombre',
                'name' => 'pub_5_nombre',
                'type' => 'text',
            ),
            array(
                'key' => 'field_pub_5_link',
                'label' => 'Publicación 5 - Link',
                'name' => 'pub_5_link',
                'type' => 'url',
            ),

            // Publicación 6
            array(
                'key' => 'field_pub_6_imagen',
                'label' => 'Publicación 6 - Imagen',
                'name' => 'pub_6_imagen',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
            ),
            array(
                'key' => 'field_pub_6_nombre',
                'label' => 'Publicación 6 - Nombre',
                'name' => 'pub_6_nombre',
                'type' => 'text',
            ),
            array(
                'key' => 'field_pub_6_link',
                'label' => 'Publicación 6 - Link',
                'name' => 'pub_6_link',
                'type' => 'url',
            ),

        ),
        'location' => array(
            array(
                array(
                    'param' => 'page',
                    'operator' => '==',
                    'value' => get_page_by_path('universo-bell-house')->ID ?? 0,
                ),
            ),
        ),
    ));

endif;