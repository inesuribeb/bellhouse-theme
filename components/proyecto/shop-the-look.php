<?php
/**
 * Componente: Shop the Look (Proyectos)
 */

// Obtener los productos seleccionados
$productos = get_field('shop_the_look_productos');
$titulo = 'Shop the look';

// Incluir componente reutilizable
include(get_stylesheet_directory() . '/components/shared/productos-relacionados.php');
?>