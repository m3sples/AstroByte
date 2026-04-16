<?php
session_start(); // Iniciar sesión para mensajes flash

$pageTitle = 'AstroByte | Contacto';
$activePage = 'contacto';

// Redirigir si se accede con método POST (para evitar reenvío al recargar)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesar el formulario
    $website = trim($_POST['website'] ?? '');
    if ($website !== '') {
        $_SESSION['estadoTipo'] = 'ok';
        $_SESSION['estadoMensaje'] = 'Gracias. Tu solicitud fue enviada.';
        $_SESSION['debug_info'] = '';
        // Limpiar campos
        $_SESSION['limpiar'] = true;
    } else {
        $nombre = trim($_POST['nombre'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $problema = trim($_POST['problema'] ?? '');

        $errores = [];
        if (strlen($nombre) < 2) $errores[] = 'Nombre válido';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = 'Email válido';
        if (!preg_match('/^[0-9+\-\s()]{7,25}$/', $telefono)) $errores[] = 'Teléfono válido';
        if (strlen($problema) < 10) $errores[] = 'Mensaje (mínimo 10 caracteres)';

        if (empty($errores)) {
            // Intentar envío con PHPMailer...
            $enviado = false;
            $error_msg = '';

            $phpmailerPath = __DIR__ . '/PHPMailer/src/';
            if (!file_exists($phpmailerPath . 'PHPMailer.php')) {
                $error_msg = 'PHPMailer no encontrado';
            } else {
                require_once $phpmailerPath . 'Exception.php';
                require_once $phpmailerPath . 'PHPMailer.php';
                require_once $phpmailerPath . 'SMTP.php';

                try {
                    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
                    $mail->CharSet = 'UTF-8';
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'segundomesplesbesel@gmail.com';
                    $mail->Password = 'rykgeazrqkwgnrbq';
                    $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;
                    $mail->setFrom('segundomesplesbesel@gmail.com', 'AstroByte');
                    $mail->addAddress('segundomesplesbesel@gmail.com', 'AstroByte');
                    $mail->addReplyTo($email, $nombre);
                    $mail->Subject = 'Nuevo contacto desde AstroByte';
                    $mail->Body = "Nombre: $nombre\nEmail: $email\nTeléfono: $telefono\n\nMensaje:\n$problema";
                    $mail->send();
                    $enviado = true;
                } catch (Exception $e) {
                    $error_msg = 'Error SMTP: ' . $mail->ErrorInfo;
                }
            }

            if ($enviado) {
                $_SESSION['estadoTipo'] = 'ok';
                $_SESSION['estadoMensaje'] = 'Mensaje enviado correctamente.';
                $_SESSION['debug_info'] = '';
                $_SESSION['limpiar'] = true; // Marcar para limpiar campos
            } else {
                $_SESSION['estadoTipo'] = 'error';
                $_SESSION['estadoMensaje'] = 'Error al enviar: ' . $error_msg;
                $_SESSION['debug_info'] = $error_msg;
                $_SESSION['campos'] = ['nombre' => $nombre, 'email' => $email, 'telefono' => $telefono, 'problema' => $problema];
                $_SESSION['limpiar'] = false;
            }
        } else {
            // Errores de validación
            $_SESSION['estadoTipo'] = 'error';
            $_SESSION['estadoMensaje'] = 'Corrige los errores: ' . implode(', ', $errores);
            $_SESSION['debug_info'] = '';
            $_SESSION['campos'] = ['nombre' => $nombre, 'email' => $email, 'telefono' => $telefono, 'problema' => $problema];
            $_SESSION['limpiar'] = false;
        }
    }

    // Redirigir a la misma página para evitar reenvío al recargar
    header('Location: contacto.php');
    exit;
}

// Recuperar mensajes flash de sesión
$estadoTipo = $_SESSION['estadoTipo'] ?? '';
$estadoMensaje = $_SESSION['estadoMensaje'] ?? '';
$debug_info = $_SESSION['debug_info'] ?? '';
$campos = $_SESSION['campos'] ?? ['nombre' => '', 'email' => '', 'telefono' => '', 'problema' => ''];
$limpiar = $_SESSION['limpiar'] ?? false;

// Si se debe limpiar, sobreescribir campos vacíos
if ($limpiar) {
    $campos = ['nombre' => '', 'email' => '', 'telefono' => '', 'problema' => ''];
}

// Limpiar sesión para que no persistan los mensajes después de recargar
unset($_SESSION['estadoTipo']);
unset($_SESSION['estadoMensaje']);
unset($_SESSION['debug_info']);
unset($_SESSION['campos']);
unset($_SESSION['limpiar']);
?>

<?php include 'header.php'; ?>
<link rel="stylesheet" href="css/estilos.css">
<main>
    <section class="contact-hero reveal">
        <img src="images/banner7.jpg" alt="Banner de contacto" class="contact-banner">
    </section>
    <section class="contact-wrap">
        <div class="contact-box reveal">
            <h1 class="contact-title">Contacto</h1>
            <p class="intro">Déjanos tus datos y cuéntanos tu problema para ayudarte mejor.</p>

            <form action="" method="POST" novalidate>
                <input type="text" name="website" class="hp-field" tabindex="-1" autocomplete="off">
                <div class="form-row">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Ej: Juan Pérez" value="<?php echo htmlspecialchars($campos['nombre']); ?>" required>
                </div>
                <div class="form-row">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="tuemail@ejemplo.com" value="<?php echo htmlspecialchars($campos['email']); ?>" required>
                </div>
                <div class="form-row">
                    <label for="telefono">Teléfono</label>
                    <input type="text" id="telefono" name="telefono" placeholder="+54 11 1234 5678" value="<?php echo htmlspecialchars($campos['telefono']); ?>" required>
                </div>
                <div class="form-row">
                    <label for="problema">Mensaje</label>
                    <textarea id="problema" name="problema" rows="5" placeholder="Describe tu consulta o problema..." required><?php echo htmlspecialchars($campos['problema']); ?></textarea>
                </div>
                <button type="submit" class="send-btn">Enviar</button>

                <?php if ($estadoMensaje !== ''): ?>
                    <div class="form-status <?php echo $estadoTipo === 'ok' ? 'ok' : 'error'; ?>" style="margin-top: 20px;">
                        <?php echo htmlspecialchars($estadoMensaje); ?>
                        <?php if ($debug_info): ?>
                            <br><small style="font-size:12px;"><?php echo htmlspecialchars($debug_info); ?></small>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </section>
</main>
<script>
(function () {
    var items = document.querySelectorAll('.reveal');
    if ('IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function (entries, obs) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });
        items.forEach(function (el) { observer.observe(el); });
    } else {
        items.forEach(function (el) { el.classList.add('show'); });
    }
})();
</script>
<?php include 'footer.php'; ?>