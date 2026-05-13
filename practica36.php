<?php
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
    $dbError = 'No se pudo conectar a la base de datos: ' . $e->getMessage();
}

// ── Estado inicial ────────────────────────────────────────────
$action   = $_GET['action'] ?? 'list';
$mensaje  = '';
$error    = '';
$usuarios = [];
$usuario  = null;

$vNombre   = '';
$vApellido = '';
$vCorreo   = '';

if ($pdo) {

    // ── REGISTRAR (POST) ──────────────────────────────────────
    if ($action === 'crear' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $vNombre   = trim($_POST['nombre']   ?? '');
        $vApellido = trim($_POST['apellido'] ?? '');
        $vCorreo   = trim($_POST['correo']   ?? '');
        $vPass     = $_POST['contrasena']    ?? '';

        if (!$vNombre || !$vApellido || !$vCorreo || !$vPass) {
            $error = 'Todos los campos son obligatorios.';
        } elseif (!filter_var($vCorreo, FILTER_VALIDATE_EMAIL)) {
            $error = 'Correo electrónico inválido.';
        } elseif (strlen($vPass) < 6) {
            $error = 'La contraseña debe tener al menos 6 caracteres.';
        } else {
            try {
                $hash = password_hash($vPass, PASSWORD_DEFAULT);
                $pdo->prepare(
                    'INSERT INTO usuarios (nombre, apellido, correo, contrasena) VALUES (?, ?, ?, ?)'
                )->execute([$vNombre, $vApellido, $vCorreo, $hash]);
                $mensaje = "Usuario «$vNombre $vApellido» registrado correctamente.";
                $action  = 'list';
            } catch (PDOException $e) {
                $error = 'Error al registrar: ese correo ya existe o hay un problema en la BD.';
            }
        }
    }

    // ── MODIFICAR (POST) ──────────────────────────────────────
    if ($action === 'editar' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $id        = (int)($_POST['id']       ?? 0);
        $vNombre   = trim($_POST['nombre']    ?? '');
        $vApellido = trim($_POST['apellido']  ?? '');
        $vCorreo   = trim($_POST['correo']    ?? '');
        $vPass     = $_POST['contrasena']     ?? '';

        if (!$vNombre || !$vApellido || !$vCorreo) {
            $error = 'Nombre, apellido y correo son obligatorios.';
        } elseif (!filter_var($vCorreo, FILTER_VALIDATE_EMAIL)) {
            $error = 'Correo electrónico inválido.';
        } else {
            try {
                if ($vPass !== '') {
                    $hash = password_hash($vPass, PASSWORD_DEFAULT);
                    $pdo->prepare(
                        'UPDATE usuarios SET nombre=?, apellido=?, correo=?, contrasena=? WHERE id=?'
                    )->execute([$vNombre, $vApellido, $vCorreo, $hash, $id]);
                } else {
                    $pdo->prepare(
                        'UPDATE usuarios SET nombre=?, apellido=?, correo=? WHERE id=?'
                    )->execute([$vNombre, $vApellido, $vCorreo, $id]);
                }
                $mensaje = 'Usuario modificado correctamente.';
                $action  = 'list';
            } catch (PDOException $e) {
                $error = 'Error al modificar: ese correo ya está en uso.';
            }
        }
    }

    // ── ELIMINAR (GET) ────────────────────────────────────────
    if ($action === 'eliminar' && isset($_GET['id'])) {
        $id = (int)$_GET['id'];
        $pdo->prepare('DELETE FROM usuarios WHERE id = ?')->execute([$id]);
        $mensaje = 'Usuario eliminado correctamente.';
        $action  = 'list';
    }

    // ── CARGAR DATOS PARA EDITAR (GET) ────────────────────────
    if ($action === 'editar' && $_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        $stmt    = $pdo->prepare('SELECT * FROM usuarios WHERE id = ?');
        $stmt->execute([(int)$_GET['id']]);
        $usuario = $stmt->fetch();
        if (!$usuario) {
            $error  = 'Usuario no encontrado.';
            $action = 'list';
        } else {
            $vNombre   = $usuario['nombre'];
            $vApellido = $usuario['apellido'];
            $vCorreo   = $usuario['correo'];
        }
    }

    // ── LISTAR ────────────────────────────────────────────────
    if ($action === 'list') {
        $stmt     = $pdo->query('SELECT id, nombre, apellido, correo FROM usuarios ORDER BY id DESC');
        $usuarios = $stmt->fetchAll();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 36 – CRUD Usuarios</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Práctica 36 — CRUD de Usuarios</h1>
    <a href="index.php">← Regresar</a>
</header>

<main>
    <h2>Gestión de usuarios</h2>
    <p class="subtitulo">Registrar, consultar, modificar y eliminar usuarios</p>

    <!-- Navegación -->
    <nav class="crud-nav">
        <a href="practica36.php"              class="<?= $action === 'list'  ? 'active' : '' ?>">Consultar</a>
        <a href="practica36.php?action=crear" class="<?= $action === 'crear' ? 'active' : '' ?>">Registrar</a>
    </nav>

    <!-- Error de BD -->
    <?php if ($dbError): ?>
        <div class="error"><?= htmlspecialchars($dbError) ?></div>

    <?php else: ?>

        <?php if ($mensaje): ?>
            <div class="resultado"><p><?= htmlspecialchars($mensaje) ?></p></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- ══ CONSULTAR ══════════════════════════════════════ -->
        <?php if ($action === 'list'): ?>
            <div class="crud-table-wrap">
                <table class="crud-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre(s)</th>
                            <th>Apellido(s)</th>
                            <th>Correo electrónico</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($usuarios)): ?>
                            <tr>
                                <td colspan="5" class="crud-empty">
                                    No hay usuarios registrados.
                                    <a href="practica36.php?action=crear">Registrar uno</a>.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($usuarios as $u): ?>
                            <tr>
                                <td><?= $u['id'] ?></td>
                                <td><?= htmlspecialchars($u['nombre']) ?></td>
                                <td><?= htmlspecialchars($u['apellido']) ?></td>
                                <td><?= htmlspecialchars($u['correo']) ?></td>
                                <td class="crud-actions">
                                    <a href="practica36.php?action=editar&id=<?= $u['id'] ?>"
                                       class="btn-edit">Modificar</a>
                                    <a href="practica36.php?action=eliminar&id=<?= $u['id'] ?>"
                                       class="btn-delete"
                                       onclick="return confirm('¿Eliminar a <?= htmlspecialchars(addslashes($u['nombre'])) ?>?')">Eliminar</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        <!-- ══ REGISTRAR ══════════════════════════════════════ -->
        <?php elseif ($action === 'crear'): ?>
            <div class="contenedor">
                <form method="POST" action="practica36.php?action=crear">
                    <div class="campo">
                        <label for="nombre">Nombre(s)</label>
                        <input type="text" id="nombre" name="nombre"
                               value="<?= htmlspecialchars($vNombre) ?>"
                               placeholder="Ej. María Fernanda" autofocus>
                    </div>
                    <div class="campo">
                        <label for="apellido">Apellido(s)</label>
                        <input type="text" id="apellido" name="apellido"
                               value="<?= htmlspecialchars($vApellido) ?>"
                               placeholder="Ej. López García">
                    </div>
                    <div class="campo">
                        <label for="correo">Correo electrónico</label>
                        <input type="text" id="correo" name="correo"
                               value="<?= htmlspecialchars($vCorreo) ?>"
                               placeholder="Ej. maria@correo.com">
                    </div>
                    <div class="campo">
                        <label for="contrasena">Contraseña</label>
                        <input type="password" id="contrasena" name="contrasena"
                               placeholder="Mínimo 6 caracteres">
                    </div>
                    <div class="botones">
                        <button type="submit">Registrar</button>
                        <a href="practica36.php" class="btn-cancel">Cancelar</a>
                    </div>
                </form>
            </div>

        <!-- ══ MODIFICAR ══════════════════════════════════════ -->
        <?php elseif ($action === 'editar' && $usuario): ?>
            <div class="contenedor">
                <form method="POST" action="practica36.php?action=editar">
                    <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                    <div class="campo">
                        <label for="nombre">Nombre(s)</label>
                        <input type="text" id="nombre" name="nombre"
                               value="<?= htmlspecialchars($vNombre) ?>" autofocus>
                    </div>
                    <div class="campo">
                        <label for="apellido">Apellido(s)</label>
                        <input type="text" id="apellido" name="apellido"
                               value="<?= htmlspecialchars($vApellido) ?>">
                    </div>
                    <div class="campo">
                        <label for="correo">Correo electrónico</label>
                        <input type="text" id="correo" name="correo"
                               value="<?= htmlspecialchars($vCorreo) ?>">
                    </div>
                    <div class="campo">
                        <label for="contrasena">Nueva contraseña
                            <span style="font-weight:normal;font-size:11px;color:#888">(vacío = no cambiar)</span>
                        </label>
                        <input type="password" id="contrasena" name="contrasena"
                               placeholder="Nueva contraseña">
                    </div>
                    <div class="botones">
                        <button type="submit">Guardar cambios</button>
                        <a href="practica36.php" class="btn-cancel">Cancelar</a>
                    </div>
                </form>
            </div>

        <?php endif; ?>

    <?php endif; ?>

</main>
</body>
</html>
