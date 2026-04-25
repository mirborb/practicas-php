<?php
$resultado = null;
$error     = '';
$vcelsius  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vcelsius = $_POST['celsius'] ?? '';
    $celsius  = filter_var($vcelsius, FILTER_VALIDATE_FLOAT);

    if ($celsius === false) {
        $error = 'Ingresa un valor numérico válido.';
    } else {
        $fahrenheit = $celsius * 9 / 5 + 32;
        $resultado  = $celsius . ' Celsius = ' . number_format($fahrenheit, 1) . ' Fahrenheit';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 28 - Celsius a Fahrenheit</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Práctica 28 — Celsius a Fahrenheit</h1>
    <a href="index.php">← Regresar</a>
</header>

<main>
    <h2>Conversión de temperatura</h2>
    <p class="subtitulo">Fórmula: F = C × 9/5 + 32</p>

    <div class="contenedor">
        <form method="POST" action="practica28.php">
            <div class="campo">
                <label for="celsius">Temperatura en Celsius</label>
                <input type="text" id="celsius" name="celsius"
                       value="<?= htmlspecialchars($vcelsius) ?>"
                       placeholder="Ej. 25" autofocus>
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
