<?php
/**
 * FAQ Proyectos - Preguntas frecuentes
 */

// Obtener título de la sección
$faq_titulo = get_field('faq_titulo');
if (!$faq_titulo) {
    $faq_titulo = 'Preguntas Frecuentes';
}

// Recopilar todas las preguntas que tengan contenido
$faqs = array();
for ($i = 1; $i <= 15; $i++) {
    $pregunta = get_field("faq_pregunta_$i");
    $respuesta = get_field("faq_respuesta_$i");
    
    // Solo añadir si AMBOS campos están rellenos
    if ($pregunta && $respuesta) {
        $faqs[] = array(
            'pregunta' => $pregunta,
            'respuesta' => $respuesta
        );
    }
}

// Si no hay FAQs, no mostrar nada
if (empty($faqs)) {
    return;
}
?>

<section class="faq-proyectos">
    <div class="faq-container">
        <h2 class="faq-titulo"><?php echo esc_html($faq_titulo); ?></h2>
        
        <div class="faq-list">
            <?php foreach ($faqs as $index => $faq): ?>
                <div class="faq-item">
                    <button class="faq-pregunta" data-faq="<?php echo $index; ?>">
                        <?php echo esc_html($faq['pregunta']); ?>
                        <svg class="faq-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                    <div class="faq-respuesta">
                        <?php echo wp_kses_post($faq['respuesta']); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>