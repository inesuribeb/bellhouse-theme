<?php
// Obtener campos ACF
$titulo = get_field('proyectos_titulo');
$texto = get_field('proyectos_texto');

// Query para obtener proyectos destacados
$args = array(
    'post_type' => 'proyectos',
    'posts_per_page' => 4,
    'meta_query' => array(
        array(
            'key' => 'destacado',
            'value' => '1',
            'compare' => '='
        )
    ),
    'orderby' => 'date',
    'order' => 'DESC'
);

$proyectos_destacados = new WP_Query($args);
?>

<section class="home-proyectos">
    <div class="container">

        <!-- Header: Título + Texto -->
        <div class="proyectos-header">
            <div class="proyectos-header-left">
                <?php if ($titulo): ?>
                    <h2 class="proyectos-titulo"><?php echo esc_html($titulo); ?></h2>
                <?php endif; ?>
            </div>

            <div class="proyectos-header-right">
                <?php if ($texto): ?>
                    <p class="proyectos-texto"><?php echo esc_html($texto); ?></p>
                <?php endif; ?>

                <!-- <a href="/nuestros-proyectos/" class="proyectos-ver-todos">
                    Ver todos →
                </a> -->
                <a href="/nuestros-proyectos/" class="proyectos-ver-todos">
                    Ver todos
                    <svg class="boton-arrow-proyectos" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 960 560">
                        <path
                            d="M642.81,163.71,261.55,536l-48.3-48.67L587.18,107.17c-6.3-.5-10.87-1.23-15.44-1.18-91.46.81-182.94,1.46-274.4,2.83-15,.22-20.61-4.67-19.41-19.68,1.51-18.84-5.48-44.31,4.28-54.82,9.22-9.91,35.4-5.06,54.12-5.1,120.71-.3,241.43.17,362.15-.51,17-.1,21.55,5.19,21.48,21.64q-.8,199.64,0,399.27c.06,15.43-4.4,20.9-20.44,21-58.93.25-59.34.77-58.83-58.31.7-81.08,2.12-162.16,3.17-243.23C643.92,167.3,643.21,165.55,642.81,163.71Z" />
                    </svg>
                </a>

            </div>
        </div>

        <!-- Carousel -->
        <?php if ($proyectos_destacados->have_posts()): ?>
            <div class="proyectos-carousel-wrapper">
                <div class="proyectos-carousel">
                    <!-- Primera copia -->
                    <?php while ($proyectos_destacados->have_posts()):
                        $proyectos_destacados->the_post();
                        $imagen = get_field('image_card');
                        $type = get_field('type');
                        ?>
                        <a href="<?php the_permalink(); ?>" class="proyecto-carousel-card">
                            <?php if ($imagen): ?>
                                <div class="proyecto-carousel-card__image">
                                    <img src="<?php echo esc_url($imagen['url']); ?>" alt="<?php the_title(); ?>">
                                    <div class="proyecto-carousel-card__overlay"></div>
                                </div>
                            <?php endif; ?>

                            <div class="proyecto-carousel-card__info">
                                <?php if ($type): ?>
                                    <span class="proyecto-carousel-card__type"><?php echo esc_html($type); ?></span>
                                <?php endif; ?>
                                <h3 class="proyecto-carousel-card__title"><?php the_title(); ?></h3>
                            </div>
                        </a>
                    <?php endwhile; ?>

                    <!-- Segunda copia para bucle infinito -->
                    <?php
                    $proyectos_destacados->rewind_posts();
                    while ($proyectos_destacados->have_posts()):
                        $proyectos_destacados->the_post();
                        $imagen = get_field('image_card');
                        $type = get_field('type');
                        ?>
                        <a href="<?php the_permalink(); ?>" class="proyecto-carousel-card">
                            <?php if ($imagen): ?>
                                <div class="proyecto-carousel-card__image">
                                    <img src="<?php echo esc_url($imagen['url']); ?>" alt="<?php the_title(); ?>">
                                    <div class="proyecto-carousel-card__overlay"></div>
                                </div>
                            <?php endif; ?>

                            <div class="proyecto-carousel-card__info">
                                <?php if ($type): ?>
                                    <span class="proyecto-carousel-card__type"><?php echo esc_html($type); ?></span>
                                <?php endif; ?>
                                <h3 class="proyecto-carousel-card__title"><?php the_title(); ?></h3>
                            </div>
                        </a>
                    <?php endwhile;
                    wp_reset_postdata(); ?>
                </div>
            </div>
        <?php else: ?>
            <p class="no-proyectos">No hay proyectos destacados disponibles.</p>
        <?php endif; ?>

    </div>
</section>