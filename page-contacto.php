<?php
/**
 * Template Name: Contacto
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

    <main class="page-contacto">

        <?php
        // Obtener campos ACF
        $label = get_field('contacto_label');
        $titulo = get_field('contacto_titulo');
        $texto = get_field('contacto_texto');
        ?>

        <div class="contacto-container">

            <!-- Columna izquierda -->
            <div class="contacto-left">
                <?php if ($label): ?>
                    <span class="contacto-label"><?php echo esc_html($label); ?></span>
                <?php endif; ?>

                <?php if ($titulo): ?>
                    <h1 class="contacto-titulo"><?php echo esc_html($titulo); ?></h1>
                <?php endif; ?>

                <?php if ($texto): ?>
                    <p class="contacto-texto"><?php echo nl2br(esc_html($texto)); ?></p>
                <?php endif; ?>
            </div>

            <!-- Columna derecha - Formulario -->
            <div class="contacto-right">

                <?php if (isset($_GET['enviado']) && $_GET['enviado'] == 'true'): ?>
                    <!-- Modal de éxito -->
                    <div class="modal-overlay" id="modalExito" style="display: flex;">
                        <div class="modal-content">
                            <button class="modal-close" onclick="cerrarModal()">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                            </button>
                            <div class="modal-text">
                                <span class="modal-letter">T</span>
                                <span class="modal-letter-right">H</span>
                                <span class="modal-letter">A</span>
                                <span class="modal-letter-left">N</span>
                                <span class="modal-letter">K</span>
                            </div>
                            <div class="modal-text">
                                <span class="modal-letter">Y</span>
                                <span class="modal-letter-right">O</span>
                                <span class="modal-letter">U</span>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['enviado']) && $_GET['enviado'] == 'false'): ?>
                    <div class="mensaje-error">
                        Hubo un error al enviar el mensaje. Por favor, inténtalo de nuevo.
                    </div>
                <?php endif; ?>

                <!-- <form class="contacto-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>"> -->

                <form class="contacto-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>"
                    enctype="multipart/form-data">

                    <input type="hidden" name="action" value="enviar_contacto">
                    <?php wp_nonce_field('contacto_form', 'contacto_nonce'); ?>

                    <div class="form-row">
                        <div class="form-field">
                            <label for="nombre">Tu nombre *</label>
                            <input type="text" id="nombre" name="nombre" required>
                        </div>

                        <div class="form-field">
                            <label for="apellido">Tu apellido *</label>
                            <input type="text" id="apellido" name="apellido" required>
                        </div>
                    </div>

                    <div class="form-field">
                        <label for="telefono">Tu teléfono *</label>
                        <input type="tel" id="telefono" name="telefono" required>
                    </div>

                    <div class="form-field">
                        <label for="email">Tu email *</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <!-- ⭐ NUEVO: Campo de mensaje opcional -->
                    <div class="form-field">
                        <label for="mensaje">Tu mensaje</label>
                        <textarea id="mensaje" name="mensaje" rows="5"></textarea>
                    </div>

                    <div class="form-field-main-label">
                        <label>¿Qué necesitas? *</label>
                        <div class="form-radios">
                            <label class="radio-option">
                                <input type="radio" name="necesidad" value="Quiero hacer una reforma" required>
                                <span>Quiero hacer una reforma</span>
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="necesidad" value="Quiero hacer una decoración">
                                <span>Quiero hacer una decoración</span>
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="necesidad" value="Tengo dudas sobre un producto">
                                <span>Tengo dudas sobre un producto</span>
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="necesidad" value="Otro">
                                <span>Otro</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-field form-upload">
                        <label>Adjuntar archivos (opcional)</label>
                        <label class="file-upload-label">
                            <input type="file" name="archivos[]" multiple accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                            <span class="file-upload-text">Seleccionar archivos</span>
                        </label>
                        <p class="file-upload-hint">Puedes adjuntar fotos, planos o referencias (máx. 10MB por archivo)
                        </p>
                        <p id="file-list" class="file-list"></p>
                    </div>

                    <div class="form-field form-checkbox">
                        <label>
                            <input type="checkbox" name="privacidad" required>
                            <span>* He leído y acepto la <a href="/privacidad" class="privacy-link">política de
                                    privacidad</a> y consiento el tratamiento de mis datos personales con la finalidad
                                de atender mi solicitud de contacto.</span>
                        </label>
                    </div>

                    <button type="submit" class="form-submit">ENVIAR</button>
                </form>
            </div>

        </div>

    </main>

    <?php
    get_footer();