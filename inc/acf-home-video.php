<?php
// ========================================
// ACF FIELDS: HOME - VIDEO
// ========================================

if (function_exists('acf_add_local_field_group')):

    acf_add_local_field_group(array(
        'key' => 'group_home_video',
        'title' => 'Home - Video',
        'fields' => array(
            // Tab
            array(
                'key' => 'field_video_tab',
                'label' => 'Video',
                'type' => 'tab',
            ),
            
            // Tipo de contenido
            array(
                'key' => 'field_video_tipo',
                'label' => 'Tipo de Contenido',
                'name' => 'video_tipo',
                'type' => 'select',
                'choices' => array(
                    'video' => 'Video',
                    'imagen' => 'Imagen',
                ),
                'default_value' => 'video',
            ),
            
            // Video
            array(
                'key' => 'field_video_archivo',
                'label' => 'Video',
                'name' => 'video_archivo',
                'type' => 'file',
                'return_format' => 'array',
                'mime_types' => 'mp4,mov,avi',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_video_tipo',
                            'operator' => '==',
                            'value' => 'video',
                        ),
                    ),
                ),
            ),
            
            // Imagen
            array(
                'key' => 'field_video_imagen',
                'label' => 'Imagen',
                'name' => 'video_imagen',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'large',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_video_tipo',
                            'operator' => '==',
                            'value' => 'imagen',
                        ),
                    ),
                ),
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