<?php
// ========================================
// ACF FIELDS: BLOG POSTS
// ========================================

if (function_exists('acf_add_local_field_group')):

    acf_add_local_field_group(array(
        'key' => 'group_blog',
        'title' => 'Blog - Campos Adicionales',
        'fields' => array(
            
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
            array(
                'key' => 'field_blog_subtitulo',
                'label' => 'Subtítulo 1',
                'name' => 'blog_subtitulo',
                'type' => 'text',
            ),
            
            // Texto 1
            array(
                'key' => 'field_blog_texto',
                'label' => 'Texto 1',
                'name' => 'blog_texto',
                'type' => 'wysiwyg',
                'toolbar' => 'full',
                'media_upload' => 1,
            ),
            
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
            array(
                'key' => 'field_blog_subtitulo_2',
                'label' => 'Subtítulo 2',
                'name' => 'blog_subtitulo_2',
                'type' => 'text',
            ),
            
            // Texto 2
            array(
                'key' => 'field_blog_texto_2',
                'label' => 'Texto 2',
                'name' => 'blog_texto_2',
                'type' => 'wysiwyg',
                'toolbar' => 'full',
                'media_upload' => 1,
            ),
            
            // Imagen Horizontal Final
            array(
                'key' => 'field_blog_img_final',
                'label' => 'Imagen Horizontal Final',
                'name' => 'blog_img_final',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),
            
        ),
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