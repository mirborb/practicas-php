<?php
$resultado = null;
$error     = '';
$vsegundos = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vsegundos = $_POST['segundos'] ?? '';
    $total     = filter_var($vsegundos, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);

    if ($total === false) {
        $error = 'Ingresa un número entero de segundos mayor o igual a 0.';
    } else {
        $horas   = intdiv($total, 3600);
        $minutos = intdiv($total % 3600, 60);
        $segs    = $total % 60;
        $resultado = $total . ' segundos corresponden a ' .
                     $horas . 'h, ' . $minutos . 'm y ' . $segs . 's';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 35 - Convertidor de tiempo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Práctica 35 — Convertidor de tiempo</h1>
    <a href="index.php">← Regresar</a>
</header>

<main>
    <h2>Conversión de segundos</h2>
    <p class="subtitulo">Convierte segundos a horas, minutos y segundos</p>

    <div class="contenedor">
        <form method="POST" action="practica35.php">
            <div class="campo">
                <label for="segundos">Segundos</label>
                <input type="text" id="segundos" name="segundos"
                       value="<?= htmlspecialchars($vsegundos) ?>"
                       placeholder="Ej. 3661" autofocus>
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
