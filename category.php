<?php
/**
 * Template para blog principal
 */
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

    <main class="blog-archive">

        <!-- Sidebar (20%) -->
        <aside class="blog-sidebar">
            <h1 class="blog-title">Blog</h1>

            <nav class="blog-filters">
                <!-- ⭐ AÑADIDO: Flechas indicadoras -->
                <div class="blog-filter-arrow blog-filter-arrow-left" id="filterArrowLeft">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                </div>
                
                <div class="blog-filter-arrow blog-filter-arrow-right" id="filterArrowRight">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </div>
                <!-- ⭐ FIN AÑADIDO -->
                
                <ul id="filterList">
                    <li><a href="<?php echo get_post_type_archive_link('post'); ?>"
                            class="<?php echo !is_category() ? 'active' : ''; ?>">Todo</a></li>
                    <?php
                    $categories = get_categories();
                    foreach ($categories as $category):
                        $is_active = is_category($category->term_id) ? 'active' : '';
                        ?>
                        <li><a href="<?php echo get_category_link($category->term_id); ?>"
                                class="<?php echo $is_active; ?>"><?php echo $category->name; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </aside>

        <!-- Grid wrapper (80%) -->
        <div class="blog-grid-wrapper">
            <?php if (have_posts()): ?>
                <div class="blog-grid">
                    <?php
                    $position = 0;
                    while (have_posts()):
                        the_post();
                        $position++;

                        // Determinar columna y fila
                        $columna = (($position - 1) % 2) + 1; // 1 o 2
                        $fila = ceil($position / 2);

                        // Columna 1: V-H-V-H...
                        // Columna 2: H-V-H-V...
                        if ($columna == 1) {
                            $is_vertical = ($fila % 2 != 0); // Fila impar = V
                        } else {
                            $is_vertical = ($fila % 2 == 0); // Fila par = V
                        }

                        set_query_var('card_is_vertical', $is_vertical);
                        include(get_stylesheet_directory() . '/components/blog/blog-card.php');

                    endwhile;
                    ?>
                </div>

                <div class="blog-pagination">
                    <?php
                    the_posts_pagination(array(
                        'prev_text' => '← Anterior',
                        'next_text' => 'Siguiente →',
                    ));
                    ?>
                </div>

            <?php else: ?>
                <p class="no-posts">No hay posts disponibles.</p>
            <?php endif; ?>
        </div>

    </main>

    <?php
    get_footer();
    ?>
</body>
</html>