<?php
$resultado = null;
$error     = '';
$vnumero   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vnumero = $_POST['numero'] ?? '';
    $numero  = filter_var($vnumero, FILTER_VALIDATE_INT);

    if ($numero === false) {
        $error = 'Ingresa un número entero válido.';
    } else {
        $tipo      = ($numero % 2 === 0) ? 'Par' : 'Impar';
        $resultado = $numero . ' es ' . $tipo . '.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 29 - Par o Impar</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Práctica 29 — Par o Impar</h1>
    <a href="index.php">← Regresar</a>
</header>

<main>
    <h2>¿El número es par o impar?</h2>
    <p class="subtitulo">Ingresa un número entero</p>

    <div class="contenedor">
        <form method="POST" action="practica29.php">
            <div class="campo">
                <label for="numero">Número</label>
                <input type="text" id="numero" name="numero"
                       value="<?= htmlspecialchars($vnumero) ?>"
                       placeholder="Ej. 7" autofocus>
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
