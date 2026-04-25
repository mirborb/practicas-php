<?php
$resultado  = null;
$error      = '';
$vnombre    = '';
$vapellido  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vnombre   = trim($_POST['nombre']   ?? '');
    $vapellido = trim($_POST['apellido'] ?? '');

    if ($vnombre === '') {
        $error = 'Ingresa un nombre.';
    } elseif ($vapellido === '') {
        $error = 'Ingresa un apellido.';
    } else {
        $usuario   = strtolower($vnombre . $vapellido);
        $iniciales = strtoupper(substr($vnombre, 0, 1) . substr($vapellido, 0, 1));
        $resultado = [
            'usuario'   => $usuario,
            'iniciales' => $iniciales,
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 30 - Crear usuario</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Práctica 30 — Crear usuario</h1>
    <a href="index.php">← Regresar</a>
</header>

<main>
    <h2>Generador de usuario e iniciales</h2>
    <p class="subtitulo">Ingresa tu nombre y apellido</p>

    <div class="contenedor">
        <form method="POST" action="practica30.php">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre"
                       value="<?= htmlspecialchars($vnombre) ?>"
                       placeholder="Ej. María" autofocus>
            </div>
            <div class="campo">
                <label for="apellido">Apellido</label>
                <input type="text" id="apellido" name="apellido"
                       value="<?= htmlspecialchars($vapellido) ?>"
                       placeholder="Ej. López">
            </div>
            <div class="botones">
                <button type="submit">Generar</button>
            </div>
        </form>

        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php elseif ($resultado !== null): ?>
            <div class="resultado">
                <p>Usuario: <?= htmlspecialchars($resultado['usuario']) ?></p>
                <p>Iniciales: <?= htmlspecialchars($resultado['iniciales']) ?></p>
            </div>
        <?php endif; ?>
    </div>
</main>

</body>
</html>
