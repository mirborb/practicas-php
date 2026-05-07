<?php
$resultado = null;
$error     = '';
$vpalabra1 = '';
$vpalabra2 = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vpalabra1 = strtolower(trim($_POST['palabra1'] ?? ''));
    $vpalabra2 = strtolower(trim($_POST['palabra2'] ?? ''));

    if ($vpalabra1 === '') {
        $error = 'Ingresa la primera palabra.';
    } elseif ($vpalabra2 === '') {
        $error = 'Ingresa la segunda palabra.';
    } else {
        $letras1 = str_split($vpalabra1);
        sort($letras1);
        $ordenada1 = implode($letras1);

        $letras2 = str_split($vpalabra2);
        sort($letras2);
        $ordenada2 = implode($letras2);

        $resultado = ($ordenada1 === $ordenada2) ? 'Sí' : 'No';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 33 - Verificación de anagramas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Práctica 33 — Verificación de anagramas</h1>
    <a href="index.php">← Regresar</a>
</header>

<main>
    <h2>¿Son anagramas?</h2>
    <p class="subtitulo">Dos palabras son anagramas si tienen exactamente las mismas letras</p>

    <div class="contenedor">
        <form method="POST" action="practica33.php">
            <div class="campo">
                <label for="palabra1">Primera palabra</label>
                <input type="text" id="palabra1" name="palabra1"
                       value="<?= htmlspecialchars($vpalabra1) ?>"
                       placeholder="Ej. listen" autofocus>
            </div>
            <div class="campo">
                <label for="palabra2">Segunda palabra</label>
                <input type="text" id="palabra2" name="palabra2"
                       value="<?= htmlspecialchars($vpalabra2) ?>"
                       placeholder="Ej. silent">
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
