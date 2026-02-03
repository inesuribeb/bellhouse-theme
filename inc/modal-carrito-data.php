<?php
/**
 * Datos del modal carrito para JS
 */

defined('ABSPATH') || exit;

function bellhouse_modal_carrito_data() {
    if (!is_product()) return;

    global $product;

    $stock_data = array();

    if ($product->is_type('variable')) {
        foreach ($product->get_children() as $variation_id) {
            $variation = wc_get_product($variation_id);
            if ($variation) {
                $stock_data[$variation_id] = array(
                    'stock' => $variation->is_purchasable() ? $variation->get_stock_quantity() : 0,
                    'manage_stock' => $variation->managing_stock(),
                );
            }
        }
    }

    $stock_data[$product->get_id()] = array(
        'stock' => $product->is_purchasable() ? $product->get_stock_quantity() : 0,
        'manage_stock' => $product->managing_stock(),
    );

    wp_localize_script('bellhouse-modal-carrito', 'modalCarritoData', array(
        'checkoutUrl' => esc_url(wc_get_checkout_url()),
        'stockData' => $stock_data,
    ));
}
add_action('wp_enqueue_scripts', 'bellhouse_modal_carrito_data');