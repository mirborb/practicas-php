<?php
$resultado = null;
$error     = '';
$vcantidad = '';
$vtasa     = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vcantidad = $_POST['cantidad'] ?? '';
    $vtasa     = $_POST['tasa']     ?? '';
    $cantidad  = filter_var($vcantidad, FILTER_VALIDATE_FLOAT);
    $tasa      = filter_var($vtasa,     FILTER_VALIDATE_FLOAT);

    if ($cantidad === false) {
        $error = 'Ingresa una cantidad numérica válida.';
    } elseif ($tasa === false) {
        $error = 'Ingresa un tipo de cambio válido.';
    } else {
        $cambio    = $cantidad * $tasa;
        $resultado = 'El resultado es ' . number_format($cambio, 2);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 34 - Cambio de divisas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Práctica 34 — Cambio de divisas</h1>
    <a href="index.php">← Regresar</a>
</header>

<main>
    <h2>Conversión de divisas</h2>
    <p class="subtitulo">Fórmula: Resultado = Cantidad × Tipo de cambio</p>

    <div class="contenedor">
        <form method="POST" action="practica34.php">
            <div class="campo">
                <label for="cantidad">Cantidad</label>
                <input type="text" id="cantidad" name="cantidad"
                       value="<?= htmlspecialchars($vcantidad) ?>"
                       placeholder="Ej. 100" autofocus>
            </div>
            <div class="campo">
                <label for="tasa">Tipo de cambio</label>
                <input type="text" id="tasa" name="tasa"
                       value="<?= htmlspecialchars($vtasa) ?>"
                       placeholder="Ej. 0.85">
            </div>
            <div class="botones">
                <button type="submit">Convertir</button>
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
