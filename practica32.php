<?php
$resultado   = null;
$error       = '';
$vpuntuacion = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vpuntuacion = $_POST['puntuacion'] ?? '';
    $puntuacion  = filter_var($vpuntuacion, FILTER_VALIDATE_INT,
                    ['options' => ['min_range' => 0, 'max_range' => 100]]);

    if ($puntuacion === false) {
        $error = 'Ingresa un número entero entre 0 y 100.';
    } else {
        if ($puntuacion >= 90) {
            $resultado = 'A';
        } elseif ($puntuacion >= 80) {
            $resultado = 'B';
        } elseif ($puntuacion >= 70) {
            $resultado = 'C';
        } elseif ($puntuacion >= 60) {
            $resultado = 'D';
        } else {
            $resultado = 'F';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 32 - Calculadora de calificaciones</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Práctica 32 — Calculadora de calificaciones</h1>
    <a href="index.php">← Regresar</a>
</header>

<main>
    <h2>Calificación con letra</h2>
    <p class="subtitulo">Ingresa una puntuación del 0 al 100</p>

    <div class="contenedor">
        <form method="POST" action="practica32.php">
            <div class="campo">
                <label for="puntuacion">Puntuación (0 - 100)</label>
                <input type="text" id="puntuacion" name="puntuacion"
                       value="<?= htmlspecialchars($vpuntuacion) ?>"
                       placeholder="Ej. 85" autofocus>
            </div>
            <div class="botones">
                <button type="submit">Calcular</button>
            </div>
        </form>

        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php elseif ($resultado !== null): ?>
            <div class="resultado"><p>Calificación: <?= htmlspecialchars($resultado) ?></p></div>
        <?php endif; ?>
    </div>

    <?php if ($resultado === null && !$error): ?>
    <div class="tabla-calificaciones">
        <strong>Tabla de calificaciones:</strong>
        <ul>
            <li>90 – 100 &nbsp;→&nbsp; A</li>
            <li>80 – 89 &nbsp;&nbsp;→&nbsp; B</li>
            <li>70 – 79 &nbsp;&nbsp;→&nbsp; C</li>
            <li>60 – 69 &nbsp;&nbsp;→&nbsp; D</li>
            <li>0 – 59 &nbsp;&nbsp;&nbsp;→&nbsp; F</li>
        </ul>
    </div>
    <?php endif; ?>
</main>

</body>
</html>
