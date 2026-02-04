<?php
// ========================================
// PROCESAMIENTO DEL FORMULARIO DE CONTACTO
// ========================================

add_action('admin_post_nopriv_enviar_contacto', 'procesar_formulario_contacto');
add_action('admin_post_enviar_contacto', 'procesar_formulario_contacto');

function procesar_formulario_contacto()
{

    // Verificar nonce
    if (!isset($_POST['contacto_nonce']) || !wp_verify_nonce($_POST['contacto_nonce'], 'contacto_form')) {
        wp_die('Error de seguridad');
    }

    // Recoger datos del formulario
    $nombre = sanitize_text_field($_POST['nombre']);
    $apellido = sanitize_text_field($_POST['apellido']);
    $telefono = sanitize_text_field($_POST['telefono']);
    $email = sanitize_email($_POST['email']);
    $necesidad = sanitize_text_field($_POST['necesidad']);
    $mensaje_usuario = sanitize_textarea_field($_POST['mensaje'] ?? '');

    // Email de destino
    $email_destino = 'inesuribeb@gmail.com';

    // Asunto del email
    $asunto = 'Nuevo contacto desde la web - ' . $nombre . ' ' . $apellido;

    // Cuerpo del email
    $mensaje = "Has recibido un nuevo mensaje de contacto:\n\n";
    $mensaje .= "Nombre: $nombre $apellido\n";
    $mensaje .= "Teléfono: $telefono\n";
    $mensaje .= "Email: $email\n";
    $mensaje .= "Necesidad: $necesidad\n";
    
    if (!empty($mensaje_usuario)) {
        $mensaje .= "\nMensaje adicional:\n$mensaje_usuario\n";
    }
    
    $mensaje .= "\n---\n";
    $mensaje .= "Mensaje enviado desde: " . home_url();

    // Headers
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <noreply@' . $_SERVER['HTTP_HOST'] . '>',
        'Reply-To: ' . $email
    );

    // Procesar archivos adjuntos
    $attachments = array();
    if (!empty($_FILES['archivos']['name'][0])) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');

        $files = $_FILES['archivos'];
        foreach ($files['name'] as $key => $value) {
            if ($files['name'][$key]) {
                $file = array(
                    'name' => $files['name'][$key],
                    'type' => $files['type'][$key],
                    'tmp_name' => $files['tmp_name'][$key],
                    'error' => $files['error'][$key],
                    'size' => $files['size'][$key]
                );

                // Verificar tamaño (máx 10MB)
                if ($file['size'] <= 10485760) {
                    $upload = wp_handle_upload($file, array('test_form' => false));
                    if ($upload && !isset($upload['error'])) {
                        $attachments[] = $upload['file'];
                    }
                }
            }
        }
    }

    // Enviar email
    $enviado = wp_mail($email_destino, $asunto, $mensaje, $headers, $attachments);

    // Eliminar archivos temporales
    foreach ($attachments as $file) {
        @unlink($file);
    }

    // Redireccionar con mensaje
    if ($enviado) {
        wp_redirect(add_query_arg('enviado', 'true', wp_get_referer()));
    } else {
        wp_redirect(add_query_arg('enviado', 'false', wp_get_referer()));
    }
    exit;
}