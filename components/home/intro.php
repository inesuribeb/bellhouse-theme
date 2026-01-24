<?php
// Obtener campos ACF
$label = get_field('intro_label');
$titulo = get_field('intro_titulo');
$texto = get_field('intro_texto');

$servicios = array();
for ($i = 1; $i <= 4; $i++) {
    $nombre = get_field("servicio{$i}_nombre");
    $imagen = get_field("servicio{$i}_imagen");
    if ($nombre && $imagen) {
        $servicios[] = array(
            'nombre' => $nombre,
            'imagen' => $imagen
        );
    }
}
?>

<section class="home-intro">
    <div class="container">
        <div class="intro-content">

            <!-- Columna izquierda -->
            <div class="intro-left">
                <?php if ($label): ?>
                    <span class="intro-label"><?php echo esc_html($label); ?></span>
                <?php endif; ?>

                <?php if ($titulo): ?>
                    <h2 class="intro-titulo"><?php echo esc_html($titulo); ?></h2>
                <?php endif; ?>

                <?php if ($texto): ?>
                    <p class="intro-texto"><?php echo esc_html($texto); ?></p>
                <?php endif; ?>


                <?php if (!empty($servicios)): ?>
                    <ul class="intro-servicios">
                        <?php foreach ($servicios as $index => $servicio): ?>
                            <li class="servicio-item <?php echo $index === 0 ? 'active' : ''; ?>"
                                data-servicio="<?php echo $index; ?>">
                                <!-- <span class="servicio-arrow"></span> -->
                                <span class="servicio-arrow">
                                    <svg id="Capa_1" data-name="Capa 1" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 1466 560">
                                        <path
                                            d="M1327.54,271.11c-33.14-32.55-66.28-65.1-100.27-98.5l8.49-9,117.24,117L1235.73,397.24l-7.86-7.5L1330.07,288h-15.56q-628.17,0-1256.33-.37c-5.62,0-16.7,6-16.48-6.68.19-11.28,10.42-6.11,15.95-6.12q627-.37,1253.92-.23h14.06Z" />
                                    </svg>
                                </span>
                                <span class="servicio-nombre"><?php echo esc_html($servicio['nombre']); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?php
                $boton_texto = get_field('intro_boton_texto');
                $boton_link = get_field('intro_boton_link');
                if ($boton_texto && $boton_link):
                    ?>
                    <a href="<?php echo esc_url($boton_link); ?>" class="intro-boton">
                        <?php echo esc_html($boton_texto); ?>
                        <svg class="boton-arrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 960 560">
                            <path
                                d="M642.81,163.71,261.55,536l-48.3-48.67L587.18,107.17c-6.3-.5-10.87-1.23-15.44-1.18-91.46.81-182.94,1.46-274.4,2.83-15,.22-20.61-4.67-19.41-19.68,1.51-18.84-5.48-44.31,4.28-54.82,9.22-9.91,35.4-5.06,54.12-5.1,120.71-.3,241.43.17,362.15-.51,17-.1,21.55,5.19,21.48,21.64q-.8,199.64,0,399.27c.06,15.43-4.4,20.9-20.44,21-58.93.25-59.34.77-58.83-58.31.7-81.08,2.12-162.16,3.17-243.23C643.92,167.3,643.21,165.55,642.81,163.71Z" />
                        </svg>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Columna derecha - Imagen -->
            <div class="intro-right">
                <div class="intro-imagen-container">
                    <?php foreach ($servicios as $index => $servicio): ?>
                        <img src="<?php echo esc_url($servicio['imagen']['url']); ?>"
                            alt="<?php echo esc_attr($servicio['nombre']); ?>"
                            class="intro-imagen <?php echo $index === 0 ? 'active' : ''; ?>"
                            data-servicio="<?php echo $index; ?>">
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>
</section>