<?php
// Query 1: Obtener todos los IDs en orden de publicación (ASC)
$args_ids = array(
    'post_type' => 'proyectos',
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'ASC',
    'fields' => 'ids', // Solo IDs
);
$all_ids = get_posts($args_ids);

// Crear un array con ID => posición
$id_positions = array();
foreach ($all_ids as $position => $id) {
    $id_positions[$id] = $position + 1; // Posición 1, 2, 3...
}

// Query 2: Mostrar proyectos en orden DESC (más reciente primero)
$args = array(
    'post_type' => 'proyectos',
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'DESC',
);

$proyectos_query = new WP_Query($args);

if ($proyectos_query->have_posts()) : ?>
    
    <div class="grid-proyectos">
        <?php 
        while ($proyectos_query->have_posts()) : 
            $proyectos_query->the_post();
            
            // Obtener la posición original según fecha de publicación
            $post_id = get_the_ID();
            $card_index = $id_positions[$post_id];
            
            set_query_var('card_index', $card_index);
            include(get_stylesheet_directory() . '/components/proyecto-card.php');
            
        endwhile; 
        wp_reset_postdata();
        ?>
    </div>

<?php else : ?>
    
    <p class="no-proyectos">No hay proyectos disponibles.</p>

<?php endif; ?>