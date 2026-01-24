<?php
/**
 * Funciones de búsqueda Ajax para Bell House
 */

if (!defined('ABSPATH')) {
    exit; // Seguridad: no acceso directo
}

/**
 * Buscar en PROYECTOS
 */
function bellhouse_search_proyectos($query, $limit = 5) {
    // Palabras clave para mostrar TODOS los proyectos
    $keywords_proyectos = ['proyecto', 'proyectos'];
    $show_all = in_array(strtolower(trim($query)), $keywords_proyectos);
    
    $args = [
        'post_type' => 'proyectos',
        'posts_per_page' => $limit,
        'post_status' => 'publish',
        'orderby' => $show_all ? 'date' : 'relevance'
    ];
    
    // Solo añadir búsqueda si NO es palabra clave
    if (!$show_all) {
        $args['s'] = $query;
    }
    
    $proyectos_query = new WP_Query($args);
    
    $proyectos = [];
    
    if ($proyectos_query->have_posts()) {
        while ($proyectos_query->have_posts()) {
            $proyectos_query->the_post();
            
            // Obtener imagen destacada
            $image_id = get_post_thumbnail_id();
            $image_url = $image_id 
                ? wp_get_attachment_image_url($image_id, 'thumbnail') 
                : get_stylesheet_directory_uri() . '/images/placeholder.jpg';
            
            // Obtener tipo de proyecto (campo ACF)
            $tipo = get_field('proyecto_tipo') ? get_field('proyecto_tipo') : 'Proyecto';
            
            $proyectos[] = [
                'title' => get_the_title(),
                'link' => get_permalink(),
                'image' => $image_url,
                'type' => $tipo
            ];
        }
    }
    
    wp_reset_postdata();
    
    return $proyectos;
}

/**
 * Buscar en POSTS (Blog)
 */
function bellhouse_search_posts($query, $limit = 5) {
    // Palabras clave para mostrar TODOS los posts
    $keywords_blog = ['blog', 'blogs', 'post', 'posts'];
    $show_all = in_array(strtolower(trim($query)), $keywords_blog);
    
    $args = [
        'post_type' => 'post',
        'posts_per_page' => $limit,
        'post_status' => 'publish',
        'orderby' => $show_all ? 'date' : 'relevance'
    ];
    
    // Solo añadir búsqueda si NO es palabra clave
    if (!$show_all) {
        $args['s'] = $query;
    }
    
    $posts_query = new WP_Query($args);
    
    $posts = [];
    
    if ($posts_query->have_posts()) {
        while ($posts_query->have_posts()) {
            $posts_query->the_post();
            
            // Obtener imagen destacada
            $image_id = get_post_thumbnail_id();
            $image_url = $image_id 
                ? wp_get_attachment_image_url($image_id, 'thumbnail') 
                : get_stylesheet_directory_uri() . '/images/placeholder.jpg';
            
            $posts[] = [
                'title' => get_the_title(),
                'link' => get_permalink(),
                'image' => $image_url,
                'date' => get_the_date('d M Y')
            ];
        }
    }
    
    wp_reset_postdata();
    
    return $posts;
}

/**
 * Buscar en PRODUCTOS (WooCommerce)
 */
function bellhouse_search_productos($query, $limit = 5) {
    $productos = [];
    
    // Solo buscar si tienda está activa y WooCommerce instalado
    $tienda_visible = get_theme_mod('tienda_visible', false);
    
    if (!$tienda_visible || !class_exists('WooCommerce')) {
        return $productos;
    }
    
    // Palabras clave para mostrar TODOS los productos
    $keywords_productos = ['producto', 'productos', 'tienda', 'shop'];
    $show_all = in_array(strtolower(trim($query)), $keywords_productos);
    
    $args = [
        'post_type' => 'product',
        'posts_per_page' => $limit,
        'post_status' => 'publish',
        'orderby' => $show_all ? 'date' : 'relevance'
    ];
    
    // Solo añadir búsqueda si NO es palabra clave
    if (!$show_all) {
        $args['s'] = $query;
    }
    
    $productos_query = new WP_Query($args);
    
    if ($productos_query->have_posts()) {
        while ($productos_query->have_posts()) {
            $productos_query->the_post();
            
            $product = wc_get_product(get_the_ID());
            
            // Obtener imagen del producto
            $image_id = $product->get_image_id();
            $image_url = $image_id 
                ? wp_get_attachment_image_url($image_id, 'thumbnail') 
                : wc_placeholder_img_src();
            
            // Obtener precio
            $precio = $product->get_price_html();
            
            $productos[] = [
                'title' => get_the_title(),
                'link' => get_permalink(),
                'image' => $image_url,
                'price' => strip_tags($precio)
            ];
        }
    }
    
    wp_reset_postdata();
    
    return $productos;
}

/**
 * Endpoint Ajax para búsqueda en tiempo real
 */
function bellhouse_search_ajax() {
    // Obtener y sanitizar query
    $query = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : '';
    
    // Si no hay query, devolver vacío
    if (empty($query)) {
        wp_send_json([
            'proyectos' => [],
            'posts' => [],
            'productos' => []
        ]);
        wp_die();
    }
    
    // Buscar en los diferentes tipos de contenido
    $proyectos = bellhouse_search_proyectos($query);
    $posts = bellhouse_search_posts($query);
    $productos = bellhouse_search_productos($query);
    
    // Devolver resultados en JSON
    wp_send_json([
        'proyectos' => $proyectos,
        'posts' => $posts,
        'productos' => $productos
    ]);
    
    wp_die();
}

// Registrar endpoints Ajax
add_action('wp_ajax_bellhouse_search', 'bellhouse_search_ajax');
add_action('wp_ajax_nopriv_bellhouse_search', 'bellhouse_search_ajax');