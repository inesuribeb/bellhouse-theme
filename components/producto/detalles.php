<?php
/**
 * Detalles del producto (info derecha)
 */

global $product;

// Obtener datos
$product_name = $product->get_name();
$price = $product->get_price_html();
$description = $product->get_description();
$short_description = $product->get_short_description();
$attributes = $product->get_attributes();

// Categorías para breadcrumb
$categories = get_the_terms($product->get_id(), 'product_cat');
$category_hierarchy = array();
if ($categories && !is_wp_error($categories)) {
    foreach ($categories as $cat) {
        if ($cat->parent == 0) {
            $category_hierarchy[] = $cat;
            // Buscar subcategorías
            foreach ($categories as $subcat) {
                if ($subcat->parent == $cat->term_id) {
                    $category_hierarchy[] = $subcat;
                    break;
                }
            }
            break;
        }
    }
}

// Campos ACF
$color_acabado = get_field('color_acabado');
$plazo_entrega = get_field('plazo_entrega');
$ficha_tecnica = get_field('ficha_tecnica');
$a_medida = get_field('a_medida');

?>

<div class="product-detalles">

    <!-- Breadcrumb -->
    <nav class="product-breadcrumb">
        <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>">Tienda</a>
        <?php foreach ($category_hierarchy as $cat): ?>
            <span class="separator">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </span>
            <a href="<?php echo get_term_link($cat); ?>"><?php echo $cat->name; ?></a>
        <?php endforeach; ?>
    </nav>

    <!-- URL del producto para el carrito -->
    <input type="hidden" name="product_url" value="<?php echo esc_url($product->get_permalink()); ?>" />

    <!-- Nombre del producto -->
    <h1 class="product-name"><?php echo esc_html($product_name); ?></h1>

    <!-- Precio -->
    <div class="product-price" data-product-id="<?php echo $product->get_id(); ?>">
        <?php if ($product->is_type('variable')): ?>
            <?php
            $variations = $product->get_available_variations();
            $min_regular = PHP_INT_MAX;
            $max_regular = 0;
            $min_sale = PHP_INT_MAX;
            $max_sale = 0;
            $has_sale = false;

            foreach ($variations as $variation) {
                $variation_obj = wc_get_product($variation['variation_id']);
                $regular = (float) $variation_obj->get_regular_price();
                $sale = (float) $variation_obj->get_sale_price();

                if ($sale) {
                    $has_sale = true;
                    $min_sale = min($min_sale, $sale);
                    $max_sale = max($max_sale, $sale);
                }

                $min_regular = min($min_regular, $regular);
                $max_regular = max($max_regular, $regular);
            }

            if ($has_sale) {
                echo '<ins class="sale-price">';
                if ($min_sale == $max_sale) {
                    echo wc_price($min_sale);
                } else {
                    echo wc_price($min_sale) . ' – ' . wc_price($max_sale);
                }
                echo '</ins> ';

                echo '<del class="regular-price">';
                if ($min_regular == $max_regular) {
                    echo wc_price($min_regular);
                } else {
                    echo wc_price($min_regular) . ' – ' . wc_price($max_regular);
                }
                echo '</del>';
            } else {
                if ($min_regular == $max_regular) {
                    echo wc_price($min_regular);
                } else {
                    echo wc_price($min_regular) . ' – ' . wc_price($max_regular);
                }
            }
            ?>
        <?php else: ?>
            <?php echo $price; ?>
        <?php endif; ?>
    </div>

    <!-- Formulario personalizado para productos variables -->
    <?php if ($product->is_type('variable')): ?>

        <form class="cart custom-variations-form" method="post" enctype='multipart/form-data'
            data-product_id="<?php echo $product->get_id(); ?>"
            data-product_variations='<?php echo json_encode($product->get_available_variations()); ?>'>

            <?php
            // ⭐ Obtener atributos y forzar orden: Color primero, luego Tamaño
            $product_attributes = $product->get_variation_attributes();

            // Orden deseado
            $orden_atributos = array('pa_color', 'tamano', 'tamaño', 'pa_tamano');
            $attributes_ordenados = array();

            // Añadir en orden
            foreach ($orden_atributos as $attr) {
                if (isset($product_attributes[$attr])) {
                    $attributes_ordenados[$attr] = $product_attributes[$attr];
                }
            }

            // Añadir cualquier otro atributo que no esté en el orden
            foreach ($product_attributes as $attr_name => $options) {
                if (!isset($attributes_ordenados[$attr_name])) {
                    $attributes_ordenados[$attr_name] = $options;
                }
            }

            foreach ($attributes_ordenados as $attribute_name => $options):
                $attribute_label = wc_attribute_label($attribute_name);
                $sanitized_name = sanitize_title($attribute_name);
                $has_multiple_options = count($options) > 1;

                // ⭐ Detectar tipo de atributo
                $is_size_attribute = (stripos($attribute_name, 'tamano') !== false || stripos($attribute_name, 'tamaño') !== false);
                $is_color_attribute = (stripos($attribute_name, 'color') !== false);
                ?>

                <div class="custom-variation-select"
                    data-has-multiple="<?php echo $has_multiple_options ? 'true' : 'false'; ?>">

                    <?php if ($has_multiple_options): ?>

                        <?php if ($is_color_attribute): ?>
                            <!-- ⭐ CÍRCULOS DE COLOR -->
                            <div class="color-swatches-wrapper">
                                <!-- <label class="variation-label"><?php echo esc_html($attribute_label); ?>:</label> -->
                                <div class="color-swatches">
                                    <input type="hidden" name="attribute_<?php echo $sanitized_name; ?>"
                                        data-attribute_name="attribute_<?php echo $sanitized_name; ?>" value="">

                                    <!-- ⭐ OPCIÓN "CUALQUIERA" -->
                                    <button type="button" class="color-swatch color-swatch-any" data-value="" data-color="cualquiera"
                                        title="Cualquiera">
                                        <span class="color-swatch-inner">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2">
                                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                                <line x1="6" y1="6" x2="18" y2="18"></line>
                                            </svg>
                                        </span>
                                    </button>

                                    <?php foreach ($options as $option): ?>
                                        <button type="button" class="color-swatch" data-value="<?php echo esc_attr($option); ?>"
                                            data-color="<?php echo esc_attr(strtolower($option)); ?>"
                                            title="<?php echo esc_attr(ucfirst($option)); ?>">
                                            <span class="color-swatch-inner"></span>
                                        </button>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                        <?php else: ?>
                            <!-- DROPDOWN para otros atributos (Tamaño, etc) -->
                            <select name="attribute_<?php echo $sanitized_name; ?>"
                                data-attribute_name="attribute_<?php echo $sanitized_name; ?>"
                                data-label="<?php echo esc_attr($attribute_label); ?>">
                                <option value=""><?php echo esc_html($attribute_label); ?>: Selecciona un
                                    <?php echo strtolower(esc_html($attribute_label)); ?>
                                </option>
                                <?php foreach ($options as $option):
                                    // ⭐ Si es tamaño, formatear bonito
                                    if ($is_size_attribute) {
                                        $clean_option = str_replace(' ', '', $option);
                                        $partes = explode('x', $clean_option);

                                        if (count($partes) === 3) {
                                            $display_value = "Alto " . trim($partes[0]) . " x Ancho " . trim($partes[1]) . " x Fondo " . trim($partes[2]) . " cm";
                                        } else {
                                            $display_value = $option;
                                        }
                                    } else {
                                        $display_value = $option;
                                    }
                                    ?>
                                    <option value="<?php echo esc_attr($option); ?>">
                                        <?php echo esc_html($display_value); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>

                    <?php else: ?>
                        <!-- Mostrar texto simple si solo hay una opción -->
                        <?php
                        $single_option = $options[0];

                        // ⭐ Si es tamaño con una sola opción, formatear bonito
                        if ($is_size_attribute) {
                            $clean_option = str_replace(' ', '', $single_option);
                            $partes = explode('x', $clean_option);

                            if (count($partes) === 3) {
                                $display_value = "Alto " . trim($partes[0]) . " x Ancho " . trim($partes[1]) . " x Fondo " . trim($partes[2]) . " cm";
                            } else {
                                $display_value = $single_option;
                            }
                        } else {
                            $display_value = $single_option;
                        }
                        ?>
                        <div class="single-option">
                            <span class="option-label"><?php echo esc_html($attribute_label); ?>:</span>
                            <span class="option-value"><?php echo esc_html($display_value); ?></span>
                        </div>
                        <input type="hidden" name="attribute_<?php echo $sanitized_name; ?>"
                            value="<?php echo esc_attr($single_option); ?>"
                            data-attribute_name="attribute_<?php echo $sanitized_name; ?>" />
                    <?php endif; ?>
                </div>

            <?php endforeach; ?>

            <input type="hidden" name="variation_id" class="variation_id" value="0" />
            <input type="hidden" name="product_id" value="<?php echo $product->get_id(); ?>" />

            <div class="custom-add-to-cart-wrapper">
                <div class="quantity">
                    <input type="number" name="quantity" value="1" min="1" step="1" />
                </div>
                <button type="submit" name="add-to-cart" value="<?php echo $product->get_id(); ?>"
                    class="button custom-add-to-cart-button">
                    Añadir a la cesta
                </button>
            </div>

        </form>

    <?php else: ?>

        <!-- Producto simple -->
        <?php
        // ⭐ Mostrar color del producto simple (solo visual, sin funcionalidad)
        $simple_color_attr = null;
        foreach ($attributes as $attribute) {
            $attr_name = $attribute->get_name();
            if (stripos($attr_name, 'color') !== false) {
                $simple_color_attr = $attribute;
                break;
            }
        }

        if ($simple_color_attr):
            $color_values = array();
            if ($simple_color_attr->is_taxonomy()) {
                $terms = wc_get_product_terms($product->get_id(), $simple_color_attr->get_name(), array('fields' => 'names'));
                if (!is_wp_error($terms) && !empty($terms)) {
                    $color_values = $terms;
                }
            } else {
                $color_values = $simple_color_attr->get_options();
            }

            if (!empty($color_values)):
                ?>
                <div class="color-swatches-wrapper" style="margin-bottom: 30px;">
                    <!-- <label class="variation-label">Color:</label> -->
                    <div class="color-swatches">
                        <?php foreach ($color_values as $color): ?>
                            <div class="color-swatch" data-color="<?php echo esc_attr(strtolower($color)); ?>"
                                title="<?php echo esc_attr(ucfirst($color)); ?>">
                                <span class="color-swatch-inner"></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php
            endif;
        endif;
        ?>

        <form class="cart"
            action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>"
            method="post" enctype='multipart/form-data'>

            <div class="product-add-to-cart">
                <?php
                woocommerce_quantity_input(array(
                    'min_value' => 1,
                    'max_value' => $product->get_max_purchase_quantity(),
                    'input_value' => 1,
                ));
                ?>

                <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>"
                    class="button add-to-cart-button">
                    Añadir a la cesta
                </button>
            </div>

        </form>

    <?php endif; ?>

    <!-- Descripción corta -->
    <?php if ($short_description): ?>
        <div class="product-short-description">
            <?php echo wp_kses_post($short_description); ?>
        </div>
    <?php endif; ?>

    <!-- Descripción completa -->
    <?php if ($description): ?>
        <div class="product-description">
            <?php echo wp_kses_post($description); ?>
        </div>
    <?php endif; ?>

    <!-- Desplegables de información -->
    <div class="product-acordeones">

        <!-- 1. Detalles y Materiales -->
        <?php
        // Preparar contenido del acordeón
        $detalles_content = '';

        // Atributos del producto (excluyendo Color y Tamaño que ya se muestran arriba)
        foreach ($attributes as $attribute) {
            $attribute_label = wc_attribute_label($attribute->get_name());

            // Saltar atributos que ya se muestran en variaciones
            $attr_lower = strtolower($attribute_label);
            if (in_array($attr_lower, array('color', 'tamaño', 'tamano'))) {
                continue;
            }

            // Obtener valores
            $values = array();
            if ($attribute->is_taxonomy()) {
                $terms = wc_get_product_terms($product->get_id(), $attribute->get_name(), array('fields' => 'names'));
                if (!is_wp_error($terms) && !empty($terms)) {
                    $values = $terms;
                }
            } else {
                $values = $attribute->get_options();
            }

            // Solo añadir si tiene valores
            if (!empty($values)) {
                $detalles_content .= '<p><strong>' . esc_html($attribute_label) . ':</strong> ' . esc_html(implode(', ', $values)) . '</p>';
            }
        }

        // Dimensiones - solo mostrar si tienen valores
        $dimensions = wc_format_dimensions($product->get_dimensions(false));
        if ($product->has_dimensions() && $dimensions && $dimensions !== 'N/A') {
            $detalles_content .= '<p><strong>Dimensiones:</strong> ' . esc_html($dimensions) . '</p>';
        }

        // Peso - solo mostrar si tiene valor
        $weight = $product->get_weight();
        if ($product->has_weight() && $weight && $weight !== '' && $weight !== '0') {
            $detalles_content .= '<p><strong>Peso:</strong> ' . esc_html($weight . ' ' . get_option('woocommerce_weight_unit')) . '</p>';
        }

        // Solo mostrar el acordeón si hay contenido
        if (!empty($detalles_content)):
            ?>
            <div class="acordeon-item">
                <button class="acordeon-header" type="button">
                    <span>Detalles y Materiales</span>
                    <span class="acordeon-icon">+</span>
                </button>
                <div class="acordeon-content">
                    <?php echo $detalles_content; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- 2. Ficha Técnica -->
        <?php if ($ficha_tecnica): ?>
            <div class="acordeon-item">
                <button class="acordeon-header" type="button">
                    <span>Ficha Técnica</span>
                    <span class="acordeon-icon">+</span>
                </button>
                <div class="acordeon-content">
                    <p>Descarga el PDF con todas las especificaciones técnicas del producto.</p>
                    <a href="<?php echo esc_url($ficha_tecnica['url']); ?>" class="button-download" download>
                        Descargar Ficha Técnica (PDF)
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <!-- 3. Envío y Devoluciones -->
        <div class="acordeon-item">
            <button class="acordeon-header" type="button">
                <span>Envío y Devoluciones</span>
                <span class="acordeon-icon">+</span>
            </button>
            <div class="acordeon-content">
                <?php if ($plazo_entrega): ?>
                    <p><strong>Plazo de entrega:</strong> <?php echo esc_html($plazo_entrega); ?></p>
                <?php endif; ?>
                <p>Consulta nuestra <a
                        href="<?php echo get_permalink(get_page_by_path('politica-de-devoluciones')); ?>">política de
                        devoluciones</a>.</p>
            </div>
        </div>

        <!-- 4. A Medida -->
        <?php if ($a_medida): ?>
            <div class="acordeon-item">
                <button class="acordeon-header" type="button">
                    <span>A Medida</span>
                    <span class="acordeon-icon">+</span>
                </button>
                <div class="acordeon-content">
                    <p>Este producto se puede fabricar a medida según tus necesidades.</p>
                    <a href="<?php echo get_permalink(get_page_by_path('contacto')); ?>" class="button-contacto">
                        Contáctanos para más información
                    </a>
                </div>
            </div>
        <?php endif; ?>

    </div>

</div>