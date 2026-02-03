<?php
/**
 * Template para producto individual (WooCommerce)
 */

defined('ABSPATH') || exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <!-- Header personalizado -->
    <?php
    ob_start();
    include(get_stylesheet_directory() . '/parts/header.html');
    $header_content = ob_get_clean();
    echo do_shortcode($header_content);
    ?>

    <main class="product-single">

        <?php while (have_posts()):
            the_post(); ?>

            <!-- Info del producto -->
            <section class="product-info">

                <!-- Galería de imágenes -->
                <?php include(get_stylesheet_directory() . '/components/producto/galeria.php'); ?>

                <!-- Detalles del producto -->
                <?php include(get_stylesheet_directory() . '/components/producto/detalles.php'); ?>

            </section>

            <!-- Productos relacionados (Combínalo con) -->
            <?php
            $productos = get_field('combinalo_con_productos');
            if ($productos && count($productos) > 0):
                $titulo = 'Combínalo con';
                include(get_stylesheet_directory() . '/components/shared/productos-relacionados.php');
            endif;
            ?>

        <?php endwhile; ?>

    </main>

    <!-- ⭐ Modal FUERA de main, al mismo nivel que header -->
    <?php
    // Rewind posts para acceder de nuevo al producto
    rewind_posts();
    while (have_posts()):
        the_post();
        global $product;

        if ($product) {
            // Obtener todas las imágenes para el modal
            $image_id = $product->get_image_id();
            $image_url = wp_get_attachment_image_url($image_id, 'full');
            $imagen_hover = get_field('imagen_hover');
            $gallery_ids = $product->get_gallery_image_ids();

            $all_images = array();
            $image_ids_added = array();

            if ($image_id) {
                $all_images[] = array(
                    'id' => $image_id,
                    'url' => $image_url,
                    'type' => 'principal',
                    'variation_id' => null,
                    'attributes' => array()
                );
                $image_ids_added[] = $image_id;
            }

            if ($imagen_hover && isset($imagen_hover['id']) && !in_array($imagen_hover['id'], $image_ids_added)) {
                $all_images[] = array(
                    'id' => $imagen_hover['id'],
                    'url' => $imagen_hover['url'],
                    'type' => 'hover',
                    'variation_id' => null,
                    'attributes' => array()
                );
                $image_ids_added[] = $imagen_hover['id'];
            }

            foreach ($gallery_ids as $gallery_id) {
                if (!in_array($gallery_id, $image_ids_added)) {
                    $all_images[] = array(
                        'id' => $gallery_id,
                        'url' => wp_get_attachment_image_url($gallery_id, 'full'),
                        'type' => 'gallery',
                        'variation_id' => null,
                        'attributes' => array()
                    );
                    $image_ids_added[] = $gallery_id;
                }
            }

            if ($product->is_type('variable')) {
                $variation_ids = $product->get_children();
                foreach ($variation_ids as $variation_id) {
                    $variation_obj = wc_get_product($variation_id);
                    if (!$variation_obj)
                        continue;
                    $variation_image_id = $variation_obj->get_image_id();
                    if ($variation_image_id) {
                        $variation_attributes = array();
                        foreach ($variation_obj->get_variation_attributes() as $attr_key => $attr_value) {
                            $variation_attributes['attribute_' . $attr_key] = $attr_value;
                        }
                        $all_images[] = array(
                            'id' => $variation_image_id,
                            'url' => wp_get_attachment_image_url($variation_image_id, 'full'),
                            'type' => 'variation',
                            'variation_id' => $variation_id,
                            'attributes' => $variation_attributes
                        );
                    }
                }
            }

            // Incluir el modal
            include(get_stylesheet_directory() . '/components/producto/modal-galeria.php');
        }
    endwhile;
    ?>

    <?php
    get_footer();
    ?>
</body>

</html>