<?php
// ========================================
// ACF FIELDS: BLOG POSTS
// ========================================

// if (function_exists('acf_add_local_field_group')):

//     acf_add_local_field_group(array(
//         'key' => 'group_blog',
//         'title' => 'Blog - Campos Adicionales',
//         'fields' => array(
            
//             array(
//                 'key' => 'field_blog_main_image',
//                 'label' => 'Imagen Principal',
//                 'name' => 'blog_main_image',
//                 'type' => 'image',
//                 'instructions' => 'Imagen grande al inicio del post',
//                 'return_format' => 'array',
//                 'preview_size' => 'large',
//             ),
            
//             array(
//                 'key' => 'field_blog_subtitulo',
//                 'label' => 'Subtítulo 1',
//                 'name' => 'blog_subtitulo',
//                 'type' => 'text',
//             ),
            
//             array(
//                 'key' => 'field_blog_texto',
//                 'label' => 'Texto 1',
//                 'name' => 'blog_texto',
//                 'type' => 'wysiwyg',
//                 'toolbar' => 'full',
//                 'media_upload' => 1,
//             ),
            
//             array(
//                 'key' => 'field_blog_img_vertical',
//                 'label' => 'Imagen Vertical',
//                 'name' => 'blog_img_vertical',
//                 'type' => 'image',
//                 'return_format' => 'array',
//                 'preview_size' => 'medium',
//             ),
            
//             array(
//                 'key' => 'field_blog_img_horizontal',
//                 'label' => 'Imagen Horizontal',
//                 'name' => 'blog_img_horizontal',
//                 'type' => 'image',
//                 'return_format' => 'array',
//                 'preview_size' => 'medium',
//             ),
            
//             array(
//                 'key' => 'field_blog_subtitulo_2',
//                 'label' => 'Subtítulo 2',
//                 'name' => 'blog_subtitulo_2',
//                 'type' => 'text',
//             ),
            
//             array(
//                 'key' => 'field_blog_texto_2',
//                 'label' => 'Texto 2',
//                 'name' => 'blog_texto_2',
//                 'type' => 'wysiwyg',
//                 'toolbar' => 'full',
//                 'media_upload' => 1,
//             ),
            
//             array(
//                 'key' => 'field_blog_img_final',
//                 'label' => 'Imagen Horizontal Final',
//                 'name' => 'blog_img_final',
//                 'type' => 'image',
//                 'return_format' => 'array',
//                 'preview_size' => 'medium',
//             ),
            
//         ),
//         'location' => array(
//             array(
//                 array(
//                     'param' => 'post_type',
//                     'operator' => '==',
//                     'value' => 'post',
//                 ),
//             ),
//         ),
//     ));

// endif;


if (function_exists('acf_add_local_field_group')):

    // ----------------------------------------
    // Campos existentes (sin tocar)
    // ----------------------------------------
    $blog_fields = array(

        // Main Image
        array(
            'key' => 'field_blog_main_image',
            'label' => 'Imagen Principal',
            'name' => 'blog_main_image',
            'type' => 'image',
            'instructions' => 'Imagen grande al inicio del post',
            'return_format' => 'array',
            'preview_size' => 'large',
        ),

        // Subtítulo 1
        // array(
        //     'key' => 'field_blog_subtitulo',
        //     'label' => 'Subtítulo 1',
        //     'name' => 'blog_subtitulo',
        //     'type' => 'text',
        // ),

        // Texto 1
        // array(
        //     'key' => 'field_blog_texto',
        //     'label' => 'Texto 1',
        //     'name' => 'blog_texto',
        //     'type' => 'wysiwyg',
        //     'toolbar' => 'full',
        //     'media_upload' => 1,
        // ),

        // Imagen Vertical
        array(
            'key' => 'field_blog_img_vertical',
            'label' => 'Imagen Vertical',
            'name' => 'blog_img_vertical',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
        ),

        // Imagen Horizontal
        array(
            'key' => 'field_blog_img_horizontal',
            'label' => 'Imagen Horizontal',
            'name' => 'blog_img_horizontal',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
        ),

        // Subtítulo 2
        // array(
        //     'key' => 'field_blog_subtitulo_2',
        //     'label' => 'Subtítulo 2',
        //     'name' => 'blog_subtitulo_2',
        //     'type' => 'text',
        // ),

        // Texto 2
        // array(
        //     'key' => 'field_blog_texto_2',
        //     'label' => 'Texto 2',
        //     'name' => 'blog_texto_2',
        //     'type' => 'wysiwyg',
        //     'toolbar' => 'full',
        //     'media_upload' => 1,
        // ),

        // Imagen Horizontal Final
        array(
            'key' => 'field_blog_img_final',
            'label' => 'Imagen Horizontal Final',
            'name' => 'blog_img_final',
            'type' => 'image',
            'return_format' => 'array',
            'preview_size' => 'medium',
        ),

    );

    // ----------------------------------------
    // NUEVO: 10 secciones x (H2 + 4x(H3+Texto))
    // Generado por bucle, sin repeater (ACF free)
    // ----------------------------------------
    $secciones_fields = array();

    for ($i = 1; $i <= 10; $i++) {

        // Separador visual en el editor (opcional pero útil)
        $secciones_fields[] = array(
            'key'   => "field_blog_seccion_{$i}_tab",
            'label' => "Sección {$i}",
            'name'  => '',
            'type'  => 'tab',
            'placement' => 'top',
        );

        // H2 de la sección
        $secciones_fields[] = array(
            'key'   => "field_blog_seccion_{$i}_h2",
            'label' => "Subtítulo {$i} (H2)",
            'name'  => "blog_seccion_{$i}_h2",
            'type'  => 'text',
        );

        // 4 bloques H3 + Texto
        for ($j = 1; $j <= 4; $j++) {

            $secciones_fields[] = array(
                'key'   => "field_blog_seccion_{$i}_bloque_{$j}_h3",
                'label' => "Bloque {$j} - Subtítulo (H3)",
                'name'  => "blog_seccion_{$i}_bloque_{$j}_h3",
                'type'  => 'text',
            );

            $secciones_fields[] = array(
                'key'   => "field_blog_seccion_{$i}_bloque_{$j}_texto",
                'label' => "Bloque {$j} - Texto",
                'name'  => "blog_seccion_{$i}_bloque_{$j}_texto",
                'type'  => 'wysiwyg',
                'toolbar' => 'full',
                'media_upload' => 1,
            );
        }
    }

    // Unimos todo
    $blog_fields = array_merge($blog_fields, $secciones_fields);

    acf_add_local_field_group(array(
        'key' => 'group_blog',
        'title' => 'Blog - Campos Adicionales',
        'fields' => $blog_fields,
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'post',
                ),
            ),
        ),
    ));

endif;