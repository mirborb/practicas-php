<?php
session_start();

// ── Conexión a la base de datos ───────────────────────────────
$host = getenv('DB_HOST') ?: '';
$db   = getenv('DB_NAME') ?: '';
$usr  = getenv('DB_USER') ?: '';
$pwd  = getenv('DB_PASS') ?: '';

$pdo     = null;
$dbError = '';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8mb4",
        $usr, $pwd,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    $dbError = 'No se pudo conectar a la base de datos.';
}

// ── Cerrar sesión ─────────────────────────────────────────────
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header('Location: practica37.php');
    exit;
}

// ── Iniciar sesión (POST) ─────────────────────────────────────
$error   = '';
$vCorreo = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pdo) {
    $vCorreo     = trim($_POST['correo']    ?? '');
    $vContrasena = $_POST['contrasena']     ?? '';

    if (!$vCorreo || !$vContrasena) {
        $error = 'Por favor completa todos los campos.';
    } elseif (!filter_var($vCorreo, FILTER_VALIDATE_EMAIL)) {
        $error = 'Correo electrónico inválido.';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE correo = ?');
        $stmt->execute([$vCorreo]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($vContrasena, $usuario['contrasena'])) {
            $_SESSION['usuario'] = [
                'id'       => $usuario['id'],
                'nombre'   => $usuario['nombre'],
                'apellido' => $usuario['apellido'],
                'correo'   => $usuario['correo'],
            ];
            header('Location: practica37.php');
            exit;
        } else {
            $error = 'Correo o contraseña incorrectos.';
        }
    }
}

$sesionActiva = isset($_SESSION['usuario']);
$u            = $sesionActiva ? $_SESSION['usuario'] : null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 37 – Sesiones PHP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Práctica 37 — Sesiones en PHP</h1>
    <a href="index.php">← Regresar</a>
</header>

<main>
    <h2>Inicio de sesión</h2>
    <p class="subtitulo">Accede con tu cuenta registrada en la Práctica 36</p>

    <?php if ($dbError): ?>
        <div class="error"><?= htmlspecialchars($dbError) ?></div>

    <?php elseif ($sesionActiva): ?>
        <!-- ══ SECCIÓN EXCLUSIVA ══ -->
        <div class="session-card">
            <div class="session-avatar"><?= strtoupper(substr($u['nombre'], 0, 1) . substr($u['apellido'], 0, 1)) ?></div>
            <div>
                <p class="session-welcome">¡Bienvenido/a!</p>
                <p class="session-name"><?= htmlspecialchars($u['nombre'] . ' ' . $u['apellido']) ?></p>
                <p class="session-email"><?= htmlspecialchars($u['correo']) ?></p>
            </div>
        </div>

        <div class="session-content">
            <strong>Sección exclusiva</strong>
            <p>Esta sección solo es visible para usuarios con sesión activa.<br>
               Has iniciado sesión correctamente con tu correo y contraseña.</p>
            <div class="session-actions">
                <a href="practica36.php" class="btn-session-link">Gestionar usuarios (CRUD)</a>
                <a href="practica37.php?action=logout" class="btn-session-logout"
                   onclick="return confirm('¿Cerrar sesión?')">Cerrar sesión</a>
            </div>
        </div>

    <?php else: ?>
        <!-- ══ FORMULARIO LOGIN ══ -->
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <div class="contenedor">
            <form method="POST" action="practica37.php">
                <div class="campo">
                    <label for="correo">Correo electrónico</label>
                    <input type="text" id="correo" name="correo"
                           value="<?= htmlspecialchars($vCorreo) ?>"
                           placeholder="tu@correo.com" autofocus>
                </div>
                <div class="campo">
                    <label for="contrasena">Contraseña</label>
                    <input type="password" id="contrasena" name="contrasena"
                           placeholder="Tu contraseña">
                </div>
                <div class="botones">
                    <button type="submit">Iniciar sesión</button>
                </div>
            </form>
        </div>

        <p style="margin-top:14px; font-size:13px; color:#777;">
            ¿No tienes cuenta?
            <a href="practica36.php?action=crear" style="color:#2e7d32; font-weight:bold;">Regístrate aquí</a>
        </p>

    <?php endif; ?>

</main>
</body>
</html>
