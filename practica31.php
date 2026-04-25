<?php
$resultado = null;
$error     = '';
$vnombre   = '';
$vedad     = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vnombre = trim($_POST['nombre'] ?? '');
    $vedad   = $_POST['edad'] ?? '';
    $edad    = filter_var($vedad, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);

    if ($vnombre === '') {
        $error = 'Ingresa un nombre.';
    } elseif ($edad === false) {
        $error = 'Ingresa una edad válida.';
    } else {
        if ($edad >= 18) {
            $resultado = $vnombre . ' puede votar.';
        } else {
            $resultado = $vnombre . ' no puede votar.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 31 - Edad para votar</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Práctica 31 — Edad para votar</h1>
    <a href="index.php">← Regresar</a>
</header>

<main>
    <h2>¿Puede votar?</h2>
    <p class="subtitulo">Ingresa el nombre y la edad de la persona</p>

    <div class="contenedor">
        <form method="POST" action="practica31.php">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre"
                       value="<?= htmlspecialchars($vnombre) ?>"
                       placeholder="Ej. María" autofocus>
            </div>
            <div class="campo">
                <label for="edad">Edad</label>
                <input type="text" id="edad" name="edad"
                       value="<?= htmlspecialchars($vedad) ?>"
                       placeholder="Ej. 25">
            </div>
            <div class="botones">
                <button type="submit">Verificar</button>
            </div>
        </form>

        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php elseif ($resultado !== null): ?>
            <div class="resultado"><p><?= htmlspecialchars($resultado) ?></p></div>
        <?php endif; ?>
    </div>
</main>

</body>
</html>
