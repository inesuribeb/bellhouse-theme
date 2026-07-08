<?php
/**
 * Secciones adicionales del blog (10x)
 *
 * De momento todas las secciones usan la plantilla text1
 * (h2 izquierda / bloques h3+texto derecha).
 *
 * ------------------------------------------------------------------
 * COMENTADO PARA EL FUTURO:
 * En su día se planteó alternar dos plantillas según el número de
 * sección:
 *   - Impares (1,3,5,7,9)  -> plantilla text1 (h2 izq / bloques dcha)
 *   - Pares   (2,4,6,8,10) -> plantilla text2 (todo centrado)
 * La lógica de esa alternancia se ha dejado comentada más abajo
 * (variable $es_impar y el bloque <?php else: ?> con la plantilla
 * text2) por si se quiere retomar más adelante.
 * ------------------------------------------------------------------
 */

for ($i = 1; $i <= 10; $i++):

    $h2 = get_field("blog_seccion_{$i}_h2");
    if (!$h2) continue; // sección vacía, la saltamos

    // Recogemos los 4 bloques de esta sección
    $bloques = array();
    for ($j = 1; $j <= 4; $j++) {
        $h3    = get_field("blog_seccion_{$i}_bloque_{$j}_h3");
        $texto = get_field("blog_seccion_{$i}_bloque_{$j}_texto");
        if ($h3 || $texto) {
            $bloques[] = array('h3' => $h3, 'texto' => $texto);
        }
    }

    // $es_impar = ($i % 2 !== 0); // ⏸ desactivado: de momento todo usa text1
?>

    <!-- Sección <?php echo $i; ?> - plantilla text1 -->
    <section class="blog-text1">

        <div class="text1-left">
            <h2 class="text1-subtitulo"><?php echo esc_html($h2); ?></h2>
        </div>

        <div class="text1-right">
            <?php foreach ($bloques as $bloque): ?>
                <div class="text1-bloque">
                    <?php if ($bloque['h3']): ?>
                        <h3 class="text1-bloque-subtitulo"><?php echo esc_html($bloque['h3']); ?></h3>
                    <?php endif; ?>
                    <?php if ($bloque['texto']): ?>
                        <div class="text1-contenido">
                            <?php echo wp_kses_post($bloque['texto']); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

    </section>

    <?php
    /*
    ---------------------------------------------------------------
    ⏸ ALTERNANCIA text1 / text2 (desactivada de momento)
    ---------------------------------------------------------------
    Para reactivarla:
    1. Descomentar la línea "$es_impar = ..." de arriba.
    2. Envolver el <section class="blog-text1"> de arriba en:
       if ($es_impar): ... endif;
    3. Descomentar y añadir el bloque else de abajo justo después.
    ---------------------------------------------------------------

    if ($es_impar):
        // ... section class="blog-text1" (la de arriba) ...
    else:
    ?>

        <!-- Sección <?php echo $i; ?> - plantilla text2 -->
        <section class="blog-text2">

            <h2 class="text2-subtitulo"><?php echo esc_html($h2); ?></h2>

            <?php foreach ($bloques as $bloque): ?>
                <div class="text2-bloque">
                    <?php if ($bloque['h3']): ?>
                        <h3 class="text2-bloque-subtitulo"><?php echo esc_html($bloque['h3']); ?></h3>
                    <?php endif; ?>
                    <?php if ($bloque['texto']): ?>
                        <div class="text2-contenido">
                            <?php echo wp_kses_post($bloque['texto']); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

        </section>

    <?php
    // endif;
    */
    ?>

<?php endfor; ?>