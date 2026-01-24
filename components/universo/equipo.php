<?php
// Obtener campos ACF
$equipo_titulo = get_field('equipo_titulo');
$equipo_texto = get_field('equipo_texto');

// Recopilar miembros (solo los que tienen foto, nombre Y cargo)
$miembros = array();
for ($i = 1; $i <= 6; $i++) {
    $foto = get_field('equipo_' . $i . '_foto');
    $nombre = get_field('equipo_' . $i . '_nombre');
    $cargo = get_field('equipo_' . $i . '_cargo');
    
    // Solo añadir si están los 3 campos rellenos
    if ($foto && $nombre && $cargo) {
        $miembros[] = array(
            'foto' => $foto,
            'nombre' => $nombre,
            'cargo' => $cargo,
        );
    }
}
?>

<?php if (!empty($miembros) || $equipo_titulo || $equipo_texto): ?>
<section class="universo-equipo">
    
    <!-- Div 1: Título y texto -->
    <div class="equipo-header">
        <?php if ($equipo_titulo): ?>
            <h2 class="equipo-titulo"><?php echo esc_html($equipo_titulo); ?></h2>
        <?php endif; ?>
        
        <?php if ($equipo_texto): ?>
            <p class="equipo-texto"><?php echo nl2br(esc_html($equipo_texto)); ?></p>
        <?php endif; ?>
    </div>
    
    <!-- Div 2: Grid de miembros -->
    <?php if (!empty($miembros)): ?>
        <div class="equipo-grid" data-count="<?php echo count($miembros); ?>">
            <?php foreach ($miembros as $miembro): ?>
                <div class="equipo-card">
                    <div class="equipo-foto">
                        <img src="<?php echo esc_url($miembro['foto']['url']); ?>" alt="<?php echo esc_attr($miembro['nombre']); ?>">
                    </div>
                    <h3 class="equipo-nombre"><?php echo esc_html($miembro['nombre']); ?></h3>
                    <p class="equipo-cargo"><?php echo esc_html($miembro['cargo']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
</section>
<?php endif; ?>