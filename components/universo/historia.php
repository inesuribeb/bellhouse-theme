<?php
// Obtener campos ACF
$historia_texto = get_field('universo_historia_texto');
$historia_imagen = get_field('universo_historia_imagen');
$img_hero_pequena = get_field('universo_hero_img_pequena');

// ⭐ Verificar que no sea false o null
if ($img_hero_pequena === false || $img_hero_pequena === null) {
    $img_hero_pequena = '';
}
?>

<?php if ($historia_texto || $historia_imagen): ?>
    <section class="universo-historia">

        <div class="text-historia">
            <div class="historia-vacio"></div>
            <div class="historia-texto">
                <?php echo wp_kses_post($historia_texto); ?>
            </div>
        </div>

        <?php if (!empty($img_hero_pequena) && isset($img_hero_pequena['url'])): ?>
            <div class="huecoEimagen">
                <div class="hueco"></div>
                <div class="historia-imagen-pequena">
                    <img src="<?php echo esc_url($img_hero_pequena['url']); ?>"
                        alt="<?php echo esc_attr($img_hero_pequena['alt'] ?? ''); ?>">
                </div>
            </div>
        <?php endif; ?>

        <?php if ($historia_imagen): ?>
            <div class="historia-imagen">
                <img src="<?php echo esc_url($historia_imagen['url']); ?>"
                    alt="<?php echo esc_attr($historia_imagen['alt']); ?>">
            </div>
        <?php endif; ?>

    </section>
<?php endif; ?>