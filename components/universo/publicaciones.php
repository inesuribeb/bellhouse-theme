<?php
// Obtener campos ACF
$publicaciones_titulo = get_field('publicaciones_titulo');

// Recopilar publicaciones (solo las que tienen imagen, nombre Y link)
$publicaciones = array();
for ($i = 1; $i <= 6; $i++) {
    $imagen = get_field('pub_' . $i . '_imagen');
    $nombre = get_field('pub_' . $i . '_nombre');
    $link = get_field('pub_' . $i . '_link');
    
    // Solo añadir si están los 3 campos rellenos
    if ($imagen && $nombre && $link) {
        $publicaciones[] = array(
            'imagen' => $imagen,
            'nombre' => $nombre,
            'link' => $link,
        );
    }
}
?>

<?php if (!empty($publicaciones) || $publicaciones_titulo): ?>
<section class="universo-publicaciones">
    
    <!-- Div 1: Título -->
    <?php if ($publicaciones_titulo): ?>
        <h2 class="publicaciones-titulo"><?php echo esc_html($publicaciones_titulo); ?></h2>
    <?php endif; ?>
    
    <!-- Div 2: Grid de publicaciones -->
    <?php if (!empty($publicaciones)): ?>
        <div class="publicaciones-grid" data-count="<?php echo count($publicaciones); ?>">
        <?php foreach ($publicaciones as $pub): ?>
                <a href="<?php echo esc_url($pub['link']); ?>" target="_blank" class="publicacion-card">
                    <span class="publicacion-nombre"><?php echo esc_html($pub['nombre']); ?></span>
                    <div class="publicacion-imagen">
                        <img src="<?php echo esc_url($pub['imagen']['url']); ?>" alt="<?php echo esc_attr($pub['nombre']); ?>">
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
</section>
<?php endif; ?>