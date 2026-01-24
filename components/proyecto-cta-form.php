<?php
/**
 * CTA Form Card - Mismo estilo que proyecto-card pero con formulario
 */

// Obtener campos ACF de la página "Nuestros Proyectos"
$cta_image = get_field('proyectos_cta_imagen');
$cta_titulo = get_field('proyectos_cta_titulo');
$cta_texto = get_field('proyectos_cta_texto');
$cta_link = get_field('proyectos_cta_link');
$cta_boton_texto = get_field('proyectos_cta_boton_texto'); // ⭐ NUEVO

// Fallbacks si no hay valores
if (!$cta_titulo) {
    $cta_titulo = '¿Quieres que tu casa sea la próxima?';
}

if (!$cta_texto) {
    $cta_texto = 'Si te gusta lo que ves y quieres que hablemos sobre tu proyecto, escríbenos sin compromiso y convierte tu casa en un hogar.';
}

if (!$cta_link) {
    $cta_link = '/contacto';
}

if (!$cta_boton_texto) { // ⭐ NUEVO
    $cta_boton_texto = 'Contactar';
}
?>

<div class="proyecto-card horizontal proyecto-cta-form">

    <!-- Imagen -->
    <div class="proyecto-card__image">
        <?php if ($cta_image): ?>
            <img src="<?php echo esc_url($cta_image['url']); ?>"
                alt="<?php echo esc_attr($cta_image['alt'] ? $cta_image['alt'] : 'Contacta con nosotros'); ?>">
        <?php else: ?>
            <!-- Placeholder si no hay imagen -->
            <div class="placeholder-image"></div>
        <?php endif; ?>
    </div>

    <!-- Form / Info -->
    <div class="proyecto-card__info">
        <h3 class="proyecto-card__title"><?php echo esc_html($cta_titulo); ?></h3>

        <p class="proyecto-cta-form__text">
            <?php echo esc_html($cta_texto); ?>
        </p>

        <!-- De momento, solo un botón -->
        <a href="<?php echo esc_url($cta_link); ?>" class="proyecto-cta-form__button">
            <?php echo esc_html($cta_boton_texto); ?>
            <svg class="boton-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 960 560">
                <path
                    d="M642.81,163.71,261.55,536l-48.3-48.67L587.18,107.17c-6.3-.5-10.87-1.23-15.44-1.18-91.46.81-182.94,1.46-274.4,2.83-15,.22-20.61-4.67-19.41-19.68,1.51-18.84-5.48-44.31,4.28-54.82,9.22-9.91,35.4-5.06,54.12-5.1,120.71-.3,241.43.17,362.15-.51,17-.1,21.55,5.19,21.48,21.64q-.8,199.64,0,399.27c.06,15.43-4.4,20.9-20.44,21-58.93.25-59.34.77-58.83-58.31.7-81.08,2.12-162.16,3.17-243.23C643.92,167.3,643.21,165.55,642.81,163.71Z" />
            </svg>
        </a>

        <!-- 
        ⭐ AQUÍ IRÁ EL FORMULARIO después 
        <form class="proyecto-cta-form__form">
            ...
        </form>
        -->
    </div>

</div>