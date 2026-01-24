<?php
// Obtener campos ACF
$texto_cambio = get_field('texto_cambio');
$img_antes = get_field('img_antes');
$img_despues = get_field('img_despues');
?>

<?php if ($img_antes && $img_despues): ?>
    <section class="project-antes-despues">

        <!-- Contenedor superior: Texto (izq) + Comparador (der) -->
        <div class="antes-despues-top">

            <!-- Columna izquierda: Título y texto -->
            <div class="antes-despues-left">
                <h2 class="antes-despues-titulo">El cambio</h2>
            </div>
            <?php if ($texto_cambio): ?>
                <div class="antes-despues-texto">
                    <?php echo wp_kses_post($texto_cambio); ?>
                </div>
            <?php endif; ?>

            </div>
            <!-- Columna derecha: Comparador de imágenes -->
            <div class="image-compare" id="imageCompare">
                <!-- Imagen Después (fondo) -->
                <img src="<?php echo esc_url($img_despues['url']); ?>" alt="Después" class="image-after">

                <!-- Imagen Antes (overlay que se desliza) -->
                <div class="image-before-wrapper" id="beforeWrapper">
                    <img src="<?php echo esc_url($img_antes['url']); ?>" alt="Antes" class="image-before">
                </div>

                <!-- Slider (la línea con el círculo) -->
                <div class="image-slider" id="imageSlider">
                    <div class="slider-button">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </div>
                </div>
            </div>


        </section>
<?php endif; ?>