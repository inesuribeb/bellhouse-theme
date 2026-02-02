<?php
// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if (!function_exists('chld_thm_cfg_locale_css')):
    function chld_thm_cfg_locale_css($uri)
    {
        if (empty($uri) && is_rtl() && file_exists(get_template_directory() . '/rtl.css'))
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;


add_filter('locale_stylesheet_uri', 'chld_thm_cfg_locale_css');

if (!function_exists('child_theme_configurator_css')):
    function child_theme_configurator_css()
    {
        wp_enqueue_style('chld_thm_cfg_child', trailingslashit(get_stylesheet_directory_uri()) . 'style.css', array('blockbase-ponyfill'));
    }
endif;
add_action('wp_enqueue_scripts', 'child_theme_configurator_css', 10);

// END ENQUEUE PARENT ACTION

// ========================================
// ⭐ IMPORTAR FUNCIONES PERSONALIZADAS
// ========================================
require_once get_stylesheet_directory() . '/inc/search-functions.php';


// Cargar fuentes de Adobe Fonts
function bellhouse_adobe_fonts()
{
    wp_enqueue_style('adobe-fonts', 'https://use.typekit.net/iiq1mdj.css', array(), null);
}
add_action('wp_enqueue_scripts', 'bellhouse_adobe_fonts');

// Cargar CSS del header
// function bellhouse_header_styles()
// {
//     wp_enqueue_style('bellhouse-header', get_stylesheet_directory_uri() . '/header.css', array(), '1.0');
//     wp_enqueue_style('bellhouse-header-mobile', get_stylesheet_directory_uri() . '/header-mobile.css', array(), '1.0'); // ⭐ AÑADIR
//     wp_enqueue_style('bellhouse-modal-search', get_stylesheet_directory_uri() . '/css/modal-search.css', array(), '1.0'); // ⭐ AÑADIR
// }
// add_action('wp_enqueue_scripts', 'bellhouse_header_styles');
function bellhouse_header_styles()
{
    wp_enqueue_style('bellhouse-header', get_stylesheet_directory_uri() . '/header.css', array(), filemtime(get_stylesheet_directory() . '/header.css'));
    wp_enqueue_style('bellhouse-header-mobile', get_stylesheet_directory_uri() . '/header-mobile.css', array(), filemtime(get_stylesheet_directory() . '/header-mobile.css'));
    wp_enqueue_style('bellhouse-modal-search', get_stylesheet_directory_uri() . '/css/modal-search.css', array(), filemtime(get_stylesheet_directory() . '/css/modal-search.css'));
}
add_action('wp_enqueue_scripts', 'bellhouse_header_styles');
function bellhouse_footer_styles()
{
    $footer_css_path = get_stylesheet_directory() . '/footer.css';
    $version = file_exists($footer_css_path) ? filemtime($footer_css_path) : '1.0';

    wp_enqueue_style('bellhouse-footer', get_stylesheet_directory_uri() . '/footer.css', array(), $version);
}
add_action('wp_enqueue_scripts', 'bellhouse_footer_styles');

function bellhouse_header_scripts()
{
    wp_enqueue_script('bellhouse-header', get_stylesheet_directory_uri() . '/header.js', array(), '1.0', true);

    // Header scroll solo en home
    if (is_front_page() || is_page('home')) {
        wp_enqueue_script('bellhouse-header-scroll', get_stylesheet_directory_uri() . '/js/header-scroll.js', array(), '1.0', true);
        wp_enqueue_script('bellhouse-header-universo', get_stylesheet_directory_uri() . '/js/header-universo.js', array(), '1.0', true);
    }

    // Header hidden en footer
    wp_enqueue_script('bellhouse-header-footer', get_stylesheet_directory_uri() . '/js/header-footer.js', array(), '1.0', true);

    // ⭐ Header mobile
    wp_enqueue_script('bellhouse-header-mobile', get_stylesheet_directory_uri() . '/js/header-mobile.js', array(), '1.0', true);

    // ⭐ Modal search (SIEMPRE cargado)
    wp_enqueue_script('bellhouse-modal-search', get_stylesheet_directory_uri() . '/js/modal-search.js', array(), '1.0', true);
}
add_action('wp_enqueue_scripts', 'bellhouse_header_scripts');

// Generar menú desplegable con Featured Images
// Generar menú desplegable con Featured Images
function bellhouse_menu_overlay()
{
    $tienda_visible = get_theme_mod('tienda_visible', false);
    $menu_promo_tipo = get_theme_mod('menu_promo_tipo', 'novedades'); // ⭐ NUEVO

    $menu_items = array(
        array('slug' => 'nuestros-proyectos', 'title' => 'Proyectos'),
        array('slug' => 'universo-bell-house', 'title' => 'Universo Bell House'),
        array('slug' => 'blog', 'title' => 'Blog'),
        array('slug' => 'contacto', 'title' => 'Contacto'),
    );

    // ⭐ CAMBIO: Añadir página promocional según elección
    if ($tienda_visible && class_exists('WooCommerce') && $menu_promo_tipo !== 'ninguna') {
        $promo_title = ($menu_promo_tipo === 'novedades') ? 'Novedades' : 'Ofertas';
        $promo_slug = $menu_promo_tipo;

        array_splice($menu_items, 1, 0, array(
            array('slug' => $promo_slug, 'title' => $promo_title)
        ));
    }

    // Añadir Tienda siempre al final (si está visible)
    if ($tienda_visible && class_exists('WooCommerce')) {
        array_splice($menu_items, 3, 0, array(
            array('slug' => 'tienda', 'title' => 'Tienda')
        ));
    }

    $colors = array('#D4C5B9', '#C9B8A8', '#BFA997', '#B39A86', '#A88B75', '#9C7C64');

    // Clase condicional para el grid
    $grid_class = $tienda_visible ? 'menu-grid' : 'menu-grid menu-grid-no-tienda';

    ob_start();
    ?>
    <div class="<?php echo $grid_class; ?>">
        <?php foreach ($menu_items as $index => $item):
            $page = get_page_by_path($item['slug']);
            if ($page && get_post_status($page->ID) === 'publish'):
                $featured_image = get_the_post_thumbnail_url($page->ID, 'large');
                $permalink = get_permalink($page->ID);
                $bg_color = $colors[$index % count($colors)];
                ?>
                <a href="<?php echo esc_url($permalink); ?>" class="menu-card">
                    <?php if ($featured_image): ?>
                        <div class="menu-card-bg"
                            style="background-image: url('<?php echo esc_url($featured_image); ?>'); background-size: cover; background-position: center;">
                        </div>
                    <?php else: ?>
                        <div class="menu-card-bg" style="background-color: <?php echo $bg_color; ?>;"></div>
                    <?php endif; ?>
                    <span class="menu-card-title"><?php echo esc_html($item['title']); ?></span>
                </a>
                <?php
            endif;
        endforeach;
        ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('bellhouse_menu', 'bellhouse_menu_overlay');


// ========================================
// CUSTOM POST TYPE: PROYECTOS
// ========================================

function bellhouse_register_proyectos_cpt()
{
    $labels = array(
        'name' => 'Proyectos',
        'singular_name' => 'Proyecto',
        'menu_name' => 'Proyectos',
        'add_new' => 'Añadir Nuevo',
        'add_new_item' => 'Añadir Nuevo Proyecto',
        'edit_item' => 'Editar Proyecto',
        'new_item' => 'Nuevo Proyecto',
        'view_item' => 'Ver Proyecto',
        'search_items' => 'Buscar Proyectos',
        'not_found' => 'No se encontraron proyectos',
        'not_found_in_trash' => 'No hay proyectos en la papelera',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-portfolio',
        'menu_position' => 5,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'has_archive' => true,
        'rewrite' => array('slug' => 'proyectos'),
        'show_in_rest' => true,
    );

    register_post_type('proyectos', $args);
}
add_action('init', 'bellhouse_register_proyectos_cpt');

// Registrar taxonomía (categorías de proyectos)
function bellhouse_register_proyectos_taxonomy()
{
    $labels = array(
        'name' => 'Categorías de Proyecto',
        'singular_name' => 'Categoría',
        'search_items' => 'Buscar Categorías',
        'all_items' => 'Todas las Categorías',
        'edit_item' => 'Editar Categoría',
        'update_item' => 'Actualizar Categoría',
        'add_new_item' => 'Añadir Nueva Categoría',
        'new_item_name' => 'Nuevo Nombre de Categoría',
        'menu_name' => 'Categorías',
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'show_ui' => true,
        'show_in_rest' => true,
        'rewrite' => array('slug' => 'categoria-proyecto'),
    );

    register_taxonomy('categoria_proyecto', array('proyectos'), $args);
}
add_action('init', 'bellhouse_register_proyectos_taxonomy');


// ========================================
// ACF FIELDS: PROYECTOS Y HOME
// ========================================

if (function_exists('acf_add_local_field_group')):


    // ===== PROYECTOS =====
    acf_add_local_field_group(array(
        'key' => 'group_proyectos',
        'title' => 'Información del Proyecto',
        'fields' => array(

            // MENSAJE de orientación
            array(
                'key' => 'field_orientacion_mensaje',
                'label' => '',
                'name' => '',
                'type' => 'message',
                'message' => '', // Se llenará dinámicamente
                'new_lines' => 'wpautop',
                'esc_html' => 0,
            ),

            // Image Card
            array(
                'key' => 'field_image_card',
                'label' => 'Imagen Card',
                'name' => 'image_card',
                'type' => 'image',
                'instructions' => 'Imagen para mostrar en listados',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),
            // Type
            array(
                'key' => 'field_type',
                'label' => 'Tipo de Proyecto',
                'name' => 'type',
                'type' => 'text',
                'instructions' => 'Ej: Residencial, Comercial, Interiorismo',
            ),
            // Destacado
            array(
                'key' => 'field_destacado',
                'label' => 'Proyecto Destacado',
                'name' => 'destacado',
                'type' => 'true_false',
                'instructions' => 'Marcar si es un proyecto destacado (máximo 4)',
                'ui' => 1,
            ),
            // Descripción corta
            array(
                'key' => 'field_descripcion_corta',
                'label' => 'Descripción Corta',
                'name' => 'descripcion_corta',
                'type' => 'textarea',
                'rows' => 3,
            ),
            // Intro
            array(
                'key' => 'field_intro',
                'label' => 'Introducción',
                'name' => 'intro',
                'type' => 'wysiwyg',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ),
            // Quote
            array(
                'key' => 'field_quote',
                'label' => 'Cita Destacada',
                'name' => 'quote',
                'type' => 'textarea',
                'rows' => 2,
            ),
            // Imagen Hero
            array(
                'key' => 'field_img_hero',
                'label' => 'Imagen Hero',
                'name' => 'img_hero',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'large',
            ),
            // Imagen Vertical
            array(
                'key' => 'field_img_vertical',
                'label' => 'Imagen Vertical',
                'name' => 'img_vertical',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),
            // Imagen Horizontal
            array(
                'key' => 'field_img_horizontal',
                'label' => 'Imagen Horizontal',
                'name' => 'img_horizontal',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),
            // Texto "El Cambio"
            array(
                'key' => 'field_texto_cambio',
                'label' => 'Texto "El Cambio"',
                'name' => 'texto_cambio',
                'type' => 'wysiwyg',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ),
            // Imagen Antes
            array(
                'key' => 'field_img_antes',
                'label' => 'Imagen Antes',
                'name' => 'img_antes',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),
            // Imagen Después
            array(
                'key' => 'field_img_despues',
                'label' => 'Imagen Después',
                'name' => 'img_despues',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),
            // Carousel 1-8
            array(
                'key' => 'field_carousel_1',
                'label' => 'Imagen Carousel 1',
                'name' => 'carousel_imagen_1',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
            ),
            array(
                'key' => 'field_carousel_2',
                'label' => 'Imagen Carousel 2',
                'name' => 'carousel_imagen_2',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
            ),
            array(
                'key' => 'field_carousel_3',
                'label' => 'Imagen Carousel 3',
                'name' => 'carousel_imagen_3',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
            ),
            array(
                'key' => 'field_carousel_4',
                'label' => 'Imagen Carousel 4',
                'name' => 'carousel_imagen_4',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
            ),
            array(
                'key' => 'field_carousel_5',
                'label' => 'Imagen Carousel 5',
                'name' => 'carousel_imagen_5',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
            ),
            array(
                'key' => 'field_carousel_6',
                'label' => 'Imagen Carousel 6',
                'name' => 'carousel_imagen_6',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
            ),
            array(
                'key' => 'field_carousel_7',
                'label' => 'Imagen Carousel 7',
                'name' => 'carousel_imagen_7',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
            ),
            array(
                'key' => 'field_carousel_8',
                'label' => 'Imagen Carousel 8',
                'name' => 'carousel_imagen_8',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'proyectos',
                ),
            ),
        ),
    ));

    // ===== HOME =====
    acf_add_local_field_group(array(
        'key' => 'group_home',
        'title' => 'Home - Configuración',
        'fields' => array(

            // ⭐ NUEVO: Selector de tipo de portada (solo si tienda activa)
            array(
                'key' => 'field_portada_tipo',
                'label' => 'Tipo de Portada',
                'name' => 'portada_tipo',
                'type' => 'radio',
                'instructions' => 'Elige qué tipo de portada mostrar',
                'choices' => array(
                    'con_cards' => 'Con Cards (Tienda + Inspírate)',
                    'sin_tienda' => 'Pantalla Completa (Imagen o Video)',
                ),
                'default_value' => 'con_cards',
                'layout' => 'vertical',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_tienda_activa_check', // ⭐ Esto lo crearemos después
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                ),
            ),

            // Tab Portada CON CARDS
            array(
                'key' => 'field_portada_tab',
                'label' => 'Portada Con Cards',
                'type' => 'tab',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_portada_tipo',
                            'operator' => '==',
                            'value' => 'con_cards',
                        ),
                    ),
                ),
            ),

            // Título principal
            array(
                'key' => 'field_portada_titulo',
                'label' => 'Título Principal',
                'name' => 'portada_titulo',
                'type' => 'text',
                'default_value' => 'Desde 1980 creando hogares con alma',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_portada_tipo',
                            'operator' => '==',
                            'value' => 'con_cards',
                        ),
                    ),
                ),
            ),

            // Card 1
            array(
                'key' => 'field_portada_card1_imagen',
                'label' => 'Card 1 - Imagen',
                'name' => 'portada_card1_imagen',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_portada_tipo',
                            'operator' => '==',
                            'value' => 'con_cards',
                        ),
                    ),
                ),
            ),
            array(
                'key' => 'field_portada_card1_texto',
                'label' => 'Card 1 - Texto Botón',
                'name' => 'portada_card1_texto',
                'type' => 'text',
                'default_value' => 'TIENDA',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_portada_tipo',
                            'operator' => '==',
                            'value' => 'con_cards',
                        ),
                    ),
                ),
            ),
            array(
                'key' => 'field_portada_card1_link',
                'label' => 'Card 1 - Enlace',
                'name' => 'portada_card1_link',
                'type' => 'text',
                'default_value' => '/tienda',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_portada_tipo',
                            'operator' => '==',
                            'value' => 'con_cards',
                        ),
                    ),
                ),
            ),

            // Card 2
            array(
                'key' => 'field_portada_card2_imagen',
                'label' => 'Card 2 - Imagen',
                'name' => 'portada_card2_imagen',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_portada_tipo',
                            'operator' => '==',
                            'value' => 'con_cards',
                        ),
                    ),
                ),
            ),
            array(
                'key' => 'field_portada_card2_texto',
                'label' => 'Card 2 - Texto Botón',
                'name' => 'portada_card2_texto',
                'type' => 'text',
                'default_value' => 'INSPÍRATE',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_portada_tipo',
                            'operator' => '==',
                            'value' => 'con_cards',
                        ),
                    ),
                ),
            ),
            array(
                'key' => 'field_portada_card2_link',
                'label' => 'Card 2 - Enlace',
                'name' => 'portada_card2_link',
                'type' => 'text',
                'default_value' => '/universo-bell-house',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_portada_tipo',
                            'operator' => '==',
                            'value' => 'con_cards',
                        ),
                    ),
                ),
            ),

            // ===== PORTADA SIN TIENDA =====
            array(
                'key' => 'field_portada_sin_tienda_tab',
                'label' => 'Portada Pantalla Completa',
                'type' => 'tab',
            ),
            array(
                'key' => 'field_portada_sin_tienda_titulo',
                'label' => 'Título',
                'name' => 'portada_sin_tienda_titulo',
                'type' => 'text',
                'instructions' => 'Título que aparecerá en la portada',
                'default_value' => 'Desde 1980 creando hogares con alma',
            ),
            array(
                'key' => 'field_portada_sin_tienda_tipo',
                'label' => 'Tipo de Fondo',
                'name' => 'portada_sin_tienda_tipo',
                'type' => 'radio',
                'instructions' => 'Elige entre imagen o video de fondo',
                'choices' => array(
                    'imagen' => 'Imagen',
                    'video' => 'Video',
                ),
                'default_value' => 'imagen',
                'layout' => 'horizontal',
            ),
            array(
                'key' => 'field_portada_sin_tienda_imagen',
                'label' => 'Imagen de Fondo',
                'name' => 'portada_sin_tienda_imagen',
                'type' => 'image',
                'instructions' => 'Imagen que se mostrará de fondo (1920x1080 recomendado)',
                'return_format' => 'array',
                'preview_size' => 'large',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_portada_sin_tienda_tipo',
                            'operator' => '==',
                            'value' => 'imagen',
                        ),
                    ),
                ),
            ),
            array(
                'key' => 'field_portada_sin_tienda_video',
                'label' => 'Video de Fondo',
                'name' => 'portada_sin_tienda_video',
                'type' => 'file',
                'instructions' => 'Video que se mostrará de fondo (formato MP4 recomendado)',
                'return_format' => 'array',
                'mime_types' => 'mp4,webm',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_portada_sin_tienda_tipo',
                            'operator' => '==',
                            'value' => 'video',
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

    // ===== PROYECTOS PAGE CTA =====
    acf_add_local_field_group(array(
        'key' => 'group_proyectos_page',
        'title' => 'CTA Formulario - Proyectos',
        'fields' => array(
            // Imagen CTA
            array(
                'key' => 'field_proyectos_cta_imagen',
                'label' => 'Imagen CTA',
                'name' => 'proyectos_cta_imagen',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),
            // Título CTA
            array(
                'key' => 'field_proyectos_cta_titulo',
                'label' => 'Título CTA',
                'name' => 'proyectos_cta_titulo',
                'type' => 'text',
                'default_value' => '¿Quieres que tu casa sea la próxima?',
            ),
            // Texto CTA
            array(
                'key' => 'field_proyectos_cta_texto',
                'label' => 'Texto CTA',
                'name' => 'proyectos_cta_texto',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Si te gusta lo que ves...',
            ),
            // Enlace botón
            array(
                'key' => 'field_proyectos_cta_link',
                'label' => 'Enlace del Botón',
                'name' => 'proyectos_cta_link',
                'type' => 'text',
                'default_value' => '/contacto',
                'placeholder' => '/contacto o https://ejemplo.com',
            ),
            // Texto botón
            array(
                'key' => 'field_proyectos_cta_boton_texto',
                'label' => 'Texto del Botón',
                'name' => 'proyectos_cta_boton_texto',
                'type' => 'text',
                'default_value' => 'Contactar',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page',
                    'operator' => '==',
                    'value' => get_page_by_path('nuestros-proyectos')->ID ?? 0,
                ),
            ),
        ),
    ));

    // ===== FAQ PROYECTOS =====
    acf_add_local_field_group(array(
        'key' => 'group_proyectos_faq',
        'title' => 'FAQ - Preguntas Frecuentes',
        'fields' => array(
            // Título sección
            array(
                'key' => 'field_faq_titulo',
                'label' => 'Título de la Sección',
                'name' => 'faq_titulo',
                'type' => 'text',
                'default_value' => 'Preguntas Frecuentes',
            ),

            // Pregunta 1
            array(
                'key' => 'field_faq_pregunta_1',
                'label' => 'Pregunta 1',
                'name' => 'faq_pregunta_1',
                'type' => 'text',
            ),
            array(
                'key' => 'field_faq_respuesta_1',
                'label' => 'Respuesta 1',
                'name' => 'faq_respuesta_1',
                'type' => 'wysiwyg',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ),

            // Pregunta 2
            array(
                'key' => 'field_faq_pregunta_2',
                'label' => 'Pregunta 2',
                'name' => 'faq_pregunta_2',
                'type' => 'text',
            ),
            array(
                'key' => 'field_faq_respuesta_2',
                'label' => 'Respuesta 2',
                'name' => 'faq_respuesta_2',
                'type' => 'wysiwyg',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ),

            // Pregunta 3
            array(
                'key' => 'field_faq_pregunta_3',
                'label' => 'Pregunta 3',
                'name' => 'faq_pregunta_3',
                'type' => 'text',
            ),
            array(
                'key' => 'field_faq_respuesta_3',
                'label' => 'Respuesta 3',
                'name' => 'faq_respuesta_3',
                'type' => 'wysiwyg',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ),

            // Pregunta 4
            array(
                'key' => 'field_faq_pregunta_4',
                'label' => 'Pregunta 4',
                'name' => 'faq_pregunta_4',
                'type' => 'text',
            ),
            array(
                'key' => 'field_faq_respuesta_4',
                'label' => 'Respuesta 4',
                'name' => 'faq_respuesta_4',
                'type' => 'wysiwyg',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ),

            // Pregunta 5
            array(
                'key' => 'field_faq_pregunta_5',
                'label' => 'Pregunta 5',
                'name' => 'faq_pregunta_5',
                'type' => 'text',
            ),
            array(
                'key' => 'field_faq_respuesta_5',
                'label' => 'Respuesta 5',
                'name' => 'faq_respuesta_5',
                'type' => 'wysiwyg',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ),

            // Pregunta 6
            array(
                'key' => 'field_faq_pregunta_6',
                'label' => 'Pregunta 6',
                'name' => 'faq_pregunta_6',
                'type' => 'text',
            ),
            array(
                'key' => 'field_faq_respuesta_6',
                'label' => 'Respuesta 6',
                'name' => 'faq_respuesta_6',
                'type' => 'wysiwyg',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ),

            // Pregunta 7
            array(
                'key' => 'field_faq_pregunta_7',
                'label' => 'Pregunta 7',
                'name' => 'faq_pregunta_7',
                'type' => 'text',
            ),
            array(
                'key' => 'field_faq_respuesta_7',
                'label' => 'Respuesta 7',
                'name' => 'faq_respuesta_7',
                'type' => 'wysiwyg',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ),

            // Pregunta 8
            array(
                'key' => 'field_faq_pregunta_8',
                'label' => 'Pregunta 8',
                'name' => 'faq_pregunta_8',
                'type' => 'text',
            ),
            array(
                'key' => 'field_faq_respuesta_8',
                'label' => 'Respuesta 8',
                'name' => 'faq_respuesta_8',
                'type' => 'wysiwyg',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ),

            // Pregunta 9
            array(
                'key' => 'field_faq_pregunta_9',
                'label' => 'Pregunta 9',
                'name' => 'faq_pregunta_9',
                'type' => 'text',
            ),
            array(
                'key' => 'field_faq_respuesta_9',
                'label' => 'Respuesta 9',
                'name' => 'faq_respuesta_9',
                'type' => 'wysiwyg',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ),

            // Pregunta 10
            array(
                'key' => 'field_faq_pregunta_10',
                'label' => 'Pregunta 10',
                'name' => 'faq_pregunta_10',
                'type' => 'text',
            ),
            array(
                'key' => 'field_faq_respuesta_10',
                'label' => 'Respuesta 10',
                'name' => 'faq_respuesta_10',
                'type' => 'wysiwyg',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ),

            // Pregunta 11
            array(
                'key' => 'field_faq_pregunta_11',
                'label' => 'Pregunta 11',
                'name' => 'faq_pregunta_11',
                'type' => 'text',
            ),
            array(
                'key' => 'field_faq_respuesta_11',
                'label' => 'Respuesta 11',
                'name' => 'faq_respuesta_11',
                'type' => 'wysiwyg',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ),

            // Pregunta 12
            array(
                'key' => 'field_faq_pregunta_12',
                'label' => 'Pregunta 12',
                'name' => 'faq_pregunta_12',
                'type' => 'text',
            ),
            array(
                'key' => 'field_faq_respuesta_12',
                'label' => 'Respuesta 12',
                'name' => 'faq_respuesta_12',
                'type' => 'wysiwyg',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ),

            // Pregunta 13
            array(
                'key' => 'field_faq_pregunta_13',
                'label' => 'Pregunta 13',
                'name' => 'faq_pregunta_13',
                'type' => 'text',
            ),
            array(
                'key' => 'field_faq_respuesta_13',
                'label' => 'Respuesta 13',
                'name' => 'faq_respuesta_13',
                'type' => 'wysiwyg',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ),

            // Pregunta 14
            array(
                'key' => 'field_faq_pregunta_14',
                'label' => 'Pregunta 14',
                'name' => 'faq_pregunta_14',
                'type' => 'text',
            ),
            array(
                'key' => 'field_faq_respuesta_14',
                'label' => 'Respuesta 14',
                'name' => 'faq_respuesta_14',
                'type' => 'wysiwyg',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ),

            // Pregunta 15
            array(
                'key' => 'field_faq_pregunta_15',
                'label' => 'Pregunta 15',
                'name' => 'faq_pregunta_15',
                'type' => 'text',
            ),
            array(
                'key' => 'field_faq_respuesta_15',
                'label' => 'Respuesta 15',
                'name' => 'faq_respuesta_15',
                'type' => 'wysiwyg',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page',
                    'operator' => '==',
                    'value' => get_page_by_path('nuestros-proyectos')->ID ?? 0,
                ),
            ),
        ),
    ));


endif; // Cierre del if de ACF

function bellhouse_proyectos_styles()
{
    if (is_page_template('template-proyectos.php') || is_post_type_archive('proyectos') || is_page('nuestros-proyectos')) {
        wp_enqueue_style('bellhouse-proyectos', get_stylesheet_directory_uri() . '/css/proyectos.css', array(), '1.0');
        wp_enqueue_style('bellhouse-proyecto-card', get_stylesheet_directory_uri() . '/css/proyecto-card.css', array(), '1.0');
        wp_enqueue_style('bellhouse-faq-proyectos', get_stylesheet_directory_uri() . '/css/faq-proyectos.css', array(), '1.0'); // ⭐ NUEVO

    }
}
add_action('wp_enqueue_scripts', 'bellhouse_proyectos_styles');

function bellhouse_proyectos_scripts()
{
    if (is_page_template('template-proyectos.php') || is_post_type_archive('proyectos') || is_page('nuestros-proyectos')) {
        wp_enqueue_script('bellhouse-faq-proyectos', get_stylesheet_directory_uri() . '/js/faq-proyectos.js', array(), '1.0', true);
        wp_enqueue_script('bellhouse-proyectos-scroll', get_stylesheet_directory_uri() . '/js/proyectos-scroll.js', array(), '1.0', true);
    }
}
add_action('wp_enqueue_scripts', 'bellhouse_proyectos_scripts');

// Cargar CSS de home
function bellhouse_home_styles()
{
    if (is_front_page() || is_page('home')) {
        wp_enqueue_style('bellhouse-home', get_stylesheet_directory_uri() . '/css/home.css', array(), '1.0');
        wp_enqueue_style('bellhouse-home-components', get_stylesheet_directory_uri() . '/css/home-components.css', array(), '1.0');
        wp_enqueue_style('bellhouse-home-components-2', get_stylesheet_directory_uri() . '/css/home-components-2.css', array(), '1.0');
        // CSS de CTA Tienda (Home)
        wp_enqueue_style('bellhouse-home-cta-tienda', get_stylesheet_directory_uri() . '/css/home/cta-tienda.css', array(), '1.0');
    }
}
add_action('wp_enqueue_scripts', 'bellhouse_home_styles');

// Cargar JS de home
function bellhouse_home_scripts()
{
    if (is_front_page() || is_page('home')) {
        wp_enqueue_script('bellhouse-home-intro', get_stylesheet_directory_uri() . '/js/home-intro.js', array(), '1.0', true);
        wp_enqueue_script('bellhouse-home-proyectos', get_stylesheet_directory_uri() . '/js/home-proyectos.js', array(), '1.0', true);
        wp_enqueue_script('bellhouse-home-video', get_stylesheet_directory_uri() . '/js/home-video.js', array(), '1.0', true);
        // JS de CTA Tienda (Home)
        wp_enqueue_script('bellhouse-home-cta-tienda', get_stylesheet_directory_uri() . '/js/home/cta-tienda.js', array(), '1.0', true);
    }
}
add_action('wp_enqueue_scripts', 'bellhouse_home_scripts');

// Cargar ACF Home Intro
require_once get_stylesheet_directory() . '/inc/acf-home-intro.php';

// Cargar ACF Home Proyectos
require_once get_stylesheet_directory() . '/inc/acf-home-proyectos.php';

// Cargar ACF Home Novedades
require_once get_stylesheet_directory() . '/inc/acf-home-novedades.php';

// ACF: Home Tienda
require_once get_stylesheet_directory() . '/inc/acf-home-tienda.php';
// AJAX: Home Tienda
require_once get_stylesheet_directory() . '/inc/ajax-home-tienda.php';
// Pasar ajaxurl a JavaScript
add_action('wp_head', 'bellhouse_ajax_url');
function bellhouse_ajax_url() {
    echo '<script>const ajaxurl = "' . admin_url('admin-ajax.php') . '";</script>';
}

// Cargar ACF Home Universo
require_once get_stylesheet_directory() . '/inc/acf-home-universo.php';

// Cargar ACF Home Video
require_once get_stylesheet_directory() . '/inc/acf-home-video.php';

// Cargar ACF Home Contacto
require_once get_stylesheet_directory() . '/inc/acf-home-contacto.php';

// Cargar ACF Footer
require_once get_stylesheet_directory() . '/inc/acf-footer.php';

// Cargar ACF Contacto
require_once get_stylesheet_directory() . '/inc/acf-contacto.php';

// Cargar CSS de contacto
function bellhouse_contacto_styles()
{
    if (is_page('contacto')) {
        wp_enqueue_style('bellhouse-contacto', get_stylesheet_directory_uri() . '/css/contacto.css', array(), '1.0');
        wp_enqueue_script('bellhouse-contacto', get_stylesheet_directory_uri() . '/js/contacto.js', array(), '1.0', true);
    }
}
add_action('wp_enqueue_scripts', 'bellhouse_contacto_styles');

// Cargar handler de contacto
require_once get_stylesheet_directory() . '/inc/contacto-handler.php';

// Cargar CSS de proyecto single
function bellhouse_proyecto_single_styles()
{
    if (is_singular('proyectos')) {
        wp_enqueue_style('bellhouse-proyecto-single', get_stylesheet_directory_uri() . '/css/proyecto/proyecto-single.css', array(), '1.0');
        wp_enqueue_script('bellhouse-proyecto-slider', get_stylesheet_directory_uri() . '/js/proyecto-slider.js', array(), '1.0', true);
        wp_enqueue_script('bellhouse-proyecto-hero', get_stylesheet_directory_uri() . '/js/proyecto-hero.js', array(), '1.0', true); // ⭐ NUEVO
    }
}
add_action('wp_enqueue_scripts', 'bellhouse_proyecto_single_styles');

// Cargar ACF Universo
require_once get_stylesheet_directory() . '/inc/acf-universo.php';

// Cargar CSS de universo
function bellhouse_universo_styles()
{
    if (is_page('universo-bell-house')) {
        wp_enqueue_style('bellhouse-universo', get_stylesheet_directory_uri() . '/css/universo/universo.css', array(), '1.0');
        wp_enqueue_style('bellhouse-home-components-2', get_stylesheet_directory_uri() . '/css/home-components-2.css', array(), '1.0');
    }
}
add_action('wp_enqueue_scripts', 'bellhouse_universo_styles');

// Cargar JS de universo
function bellhouse_universo_scripts()
{
    if (is_page('universo-bell-house')) {
        wp_enqueue_script('bellhouse-universo-hero', get_stylesheet_directory_uri() . '/js/universo-hero.js', array(), '1.0', true);
    }
}
add_action('wp_enqueue_scripts', 'bellhouse_universo_scripts');

// Cargar ACF Blog
require_once get_stylesheet_directory() . '/inc/acf-blog.php';

// Cargar JS de filtros de blog
function bellhouse_blog_filters_script()
{
    if (is_home() || is_archive() || is_category()) {
        wp_enqueue_script('bellhouse-blog-filters', get_stylesheet_directory_uri() . '/js/blog-filters.js', array(), '1.0', true);
    }
}
add_action('wp_enqueue_scripts', 'bellhouse_blog_filters_script');


// Cargar CSS de blog single
function bellhouse_blog_single_styles()
{
    if (is_single()) {
        wp_enqueue_style('bellhouse-blog-single', get_stylesheet_directory_uri() . '/css/blog/blog-single.css', array(), '1.0');
    }
}
add_action('wp_enqueue_scripts', 'bellhouse_blog_single_styles');

// Cargar JS de blog single
function bellhouse_blog_single_scripts()
{
    if (is_single()) {
        wp_enqueue_script('bellhouse-blog-hero', get_stylesheet_directory_uri() . '/js/blog-hero.js', array(), '1.0', true);
    }
}
add_action('wp_enqueue_scripts', 'bellhouse_blog_single_scripts');
function cargar_mensaje_orientacion($field)
{
    global $post;

    if (!$post || $post->post_type !== 'proyectos')
        return $field;

    // Calcular posición
    $args = array(
        'post_type' => 'proyectos',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'ASC',
        'fields' => 'ids',
    );
    $all_ids = get_posts($args);

    $position = array_search($post->ID, $all_ids);
    $position = ($position === false) ? count($all_ids) + 1 : $position + 1;

    $is_vertical = ($position % 2 != 0);
    $orientacion = $is_vertical ? '<strong style="color: #9b59b6;">VERTICAL (4:5)</strong>' : '<strong style="color: #3498db;">HORIZONTAL (5:4)</strong>';

    $field['message'] = '📐 <strong>Este proyecto (#' . $position . ') se mostrará con orientación ' . $orientacion . ' en el grid de proyectos.</strong>';

    return $field;
}

// Cargar CSS de blog archive
function bellhouse_blog_archive_styles()
{
    if (is_home() || is_archive() || is_category()) {
        wp_enqueue_style('bellhouse-blog-archive', get_stylesheet_directory_uri() . '/css/blog/blog-archive.css', array(), '1.0');
    }
}
add_action('wp_enqueue_scripts', 'bellhouse_blog_archive_styles');

// Cargar ACF Productos
require_once get_stylesheet_directory() . '/inc/acf-productos.php';

// Cargar JS de producto
function bellhouse_producto_scripts()
{
    if (is_product()) {
        wp_enqueue_script('wc-add-to-cart-variation');
        wp_enqueue_script('bellhouse-producto-galeria', get_stylesheet_directory_uri() . '/js/producto-galeria.js', array('jquery'), '1.0', true);
        wp_enqueue_script('bellhouse-producto-variaciones', get_stylesheet_directory_uri() . '/js/producto-variaciones.js', array('jquery', 'wc-add-to-cart-variation'), '1.0', true);
        wp_enqueue_script('bellhouse-producto-scroll', get_stylesheet_directory_uri() . '/js/producto-scroll.js', array(), '1.0', true);
        // ⭐ CAMBIO: Ahora depende de producto-variaciones
        wp_enqueue_script('bellhouse-producto-acordeones', get_stylesheet_directory_uri() . '/js/producto-acordeones.js', array('jquery', 'bellhouse-producto-variaciones'), '1.0', true);
    }
}
add_action('wp_enqueue_scripts', 'bellhouse_producto_scripts');

// Cargar CSS de producto single
function bellhouse_producto_single_styles()
{
    if (is_product()) {
        wp_enqueue_style('bellhouse-producto-single', get_stylesheet_directory_uri() . '/css/producto/single-product.css', array(), '1.0');
        wp_enqueue_style('bellhouse-producto-detalles', get_stylesheet_directory_uri() . '/css/producto/single-product2.css', array(), '1.0');
    }
}
add_action('wp_enqueue_scripts', 'bellhouse_producto_single_styles');

// Forzar template personalizado para productos
add_filter('template_include', 'bellhouse_custom_product_template', 99);

function bellhouse_custom_product_template($template)
{
    if (is_product()) {
        $custom_template = get_stylesheet_directory() . '/woocommerce/single-product.php';
        if (file_exists($custom_template)) {
            return $custom_template;
        }
    }
    return $template;
}

// ⭐ NUEVO: Forzar template personalizado para archivo de tienda (shop)
add_filter('template_include', 'bellhouse_custom_shop_template', 99);

function bellhouse_custom_shop_template($template)
{
    if (is_shop() || is_product_category() || is_product_tag()) {
        $custom_template = get_stylesheet_directory() . '/woocommerce/archive-product.php';
        if (file_exists($custom_template)) {
            return $custom_template;
        }
    }
    return $template;
}

// ========================================
// CUSTOMIZER: Mostrar/Ocultar Tienda
// ========================================

function bellhouse_customizer_tienda($wp_customize)
{
    // Crear una nueva sección
    $wp_customize->add_section('bellhouse_tienda_section', array(
        'title' => 'Configuración de Tienda',
        'priority' => 30,
        'description' => 'Activa o desactiva la visibilidad de la tienda en el sitio web.',
    ));

    // Añadir el control (checkbox)
    $wp_customize->add_setting('tienda_visible', array(
        'default' => false,
        'transport' => 'refresh', // 'refresh' para ver cambios al guardar
        'sanitize_callback' => 'bellhouse_sanitize_checkbox',
    ));

    $wp_customize->add_control('tienda_visible', array(
        'label' => 'Mostrar Tienda en la Web',
        'description' => 'Activa esta opción cuando la tienda esté lista para mostrarse al público.',
        'section' => 'bellhouse_tienda_section',
        'type' => 'checkbox',
    ));
}
add_action('customize_register', 'bellhouse_customizer_tienda');

// Función para sanitizar el checkbox
function bellhouse_sanitize_checkbox($checked)
{
    return ((isset($checked) && true == $checked) ? true : false);
}


// Cargar CSS de RGPD (Aviso Legal, Privacidad, Cookies)
function bellhouse_rgpd_styles()
{
    if (is_page('aviso-legal')) {
        wp_enqueue_style('bellhouse-aviso-legal', get_stylesheet_directory_uri() . '/css/rgdp/aviso-legal.css', array(), '1.0');
    }

    if (is_page('privacidad')) {
        wp_enqueue_style('bellhouse-privacidad', get_stylesheet_directory_uri() . '/css/rgdp/privacidad.css', array(), '1.0');
    }

    if (is_page('cookies')) {
        wp_enqueue_style('bellhouse-cookies', get_stylesheet_directory_uri() . '/css/rgdp/cookies.css', array(), '1.0');
    }

    if (is_page('compras')) {
        wp_enqueue_style('bellhouse-compras', get_stylesheet_directory_uri() . '/css/rgdp/compras.css', array(), '1.0');
    }

    if (is_page('devoluciones')) {
        wp_enqueue_style('bellhouse-devoluciones', get_stylesheet_directory_uri() . '/css/rgdp/devoluciones.css', array(), '1.0');
    }
}
add_action('wp_enqueue_scripts', 'bellhouse_rgpd_styles');


// Cargar CSS de 404
function bellhouse_404_styles()
{
    if (is_404()) {
        wp_enqueue_style('bellhouse-404', get_stylesheet_directory_uri() . '/css/404.css', array(), '1.0');
    }
}
add_action('wp_enqueue_scripts', 'bellhouse_404_styles');


// ACF Tienda
require_once get_stylesheet_directory() . '/inc/acf-tienda.php';


// Cargar CSS de tienda
function bellhouse_tienda_styles()
{
    if (is_shop() || is_product_category() || is_product_tag() || is_page('novedades') || is_page('ofertas')) {
        // CSS principal de tienda
        wp_enqueue_style('bellhouse-tienda', get_stylesheet_directory_uri() . '/css/tienda/tienda.css', array(), '1.0');
        // CSS de intro
        wp_enqueue_style('bellhouse-tienda-intro', get_stylesheet_directory_uri() . '/css/tienda/intro.css', array(), '1.0');
        // CSS de categorías
        wp_enqueue_style('bellhouse-tienda-categorias', get_stylesheet_directory_uri() . '/css/tienda/categorias.css', array(), '1.0');
        // CSS de subcategorías
        wp_enqueue_style('bellhouse-tienda-subcategorias', get_stylesheet_directory_uri() . '/css/tienda/subcategorias.css', array(), '1.0');
        // CSS de grid de productos
        wp_enqueue_style('bellhouse-tienda-grid', get_stylesheet_directory_uri() . '/css/tienda/grid-productos.css', array(), '1.0');
        // CSS de product card
        wp_enqueue_style('bellhouse-tienda-card', get_stylesheet_directory_uri() . '/css/tienda/product-card.css', array(), '1.2');
        wp_enqueue_script('bellhouse-tienda-categorias', get_stylesheet_directory_uri() . '/js/tienda/tienda-categorias.js', array(), '1.0', true);
        // JS de grid borders
        wp_enqueue_script('bellhouse-tienda-grid-borders', get_stylesheet_directory_uri() . '/js/tienda/grid-borders.js', array(), '1.0', true);
        // JS de subcategorías
        wp_enqueue_script('bellhouse-tienda-subcategorias', get_stylesheet_directory_uri() . '/js/tienda/tienda-subcategorias.js', array(), '1.0', true);
        // CSS de filtrar/ordenar
        wp_enqueue_style('bellhouse-tienda-filtrar', get_stylesheet_directory_uri() . '/css/tienda/filtrar-ordenar.css', array(), '1.0');
        // CSS de modal filtros
        wp_enqueue_style('bellhouse-modal-filtros', get_stylesheet_directory_uri() . '/css/tienda/modal-filtros.css', array(), '1.0');
        // JS de modal filtros
        wp_enqueue_script('bellhouse-modal-filtros', get_stylesheet_directory_uri() . '/js/tienda/modal-filtros.js', array(), '1.0', true);
        // CSS de filtros del modal
        wp_enqueue_style('bellhouse-modal-filtro-filtro', get_stylesheet_directory_uri() . '/css/tienda/modal-filtro-filtro.css', array(), '1.0');
        // CSS de ordenar del modal
        wp_enqueue_style('bellhouse-modal-filtro-ordenar', get_stylesheet_directory_uri() . '/css/tienda/modal-filtro-ordenar.css', array(), '1.0');
        // JS de sticky nav
        wp_enqueue_script('bellhouse-sticky-nav', get_stylesheet_directory_uri() . '/js/tienda/sticky-nav.js', array(), '1.0', true);
    }
}
add_action('wp_enqueue_scripts', 'bellhouse_tienda_styles');



// ACF: Novedades
require_once get_stylesheet_directory() . '/inc/acf-novedades.php';

// ACF: Ofertas
require_once get_stylesheet_directory() . '/inc/acf-ofertas.php';

// ========================================
// CUSTOMIZER: Opciones de Tienda
// ========================================

function bellhouse_customizer_settings($wp_customize)
{

    // ⭐ Crear sección de Tienda en el Customizer
    $wp_customize->add_section('tienda_settings', array(
        'title' => 'Tienda',
        'priority' => 30,
    ));

    // ⭐ Opción: Mostrar/Ocultar Tienda
    $wp_customize->add_setting('tienda_visible', array(
        'default' => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('tienda_visible', array(
        'label' => 'Mostrar Tienda',
        'description' => 'Activa o desactiva la tienda en el menú',
        'section' => 'tienda_settings',
        'type' => 'checkbox',
    ));

    // ⭐ Opción: Página promocional en menú (Novedades/Ofertas)
    $wp_customize->add_setting('menu_promo_tipo', array(
        'default' => 'novedades',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('menu_promo_tipo', array(
        'label' => 'Página promocional en menú overlay',
        'description' => 'Elige qué página mostrar en el menú desplegable',
        'section' => 'tienda_settings',
        'type' => 'radio',
        'choices' => array(
            'novedades' => 'Novedades',
            'ofertas' => 'Ofertas',
            'ninguna' => 'No mostrar',
        ),
    ));
}
add_action('customize_register', 'bellhouse_customizer_settings');