<?php
$resultado = [];
$error     = '';
$vpeso = $vestatura = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vpeso     = $_POST['peso']     ?? '';
    $vestatura = $_POST['estatura'] ?? '';

    $peso     = filter_var($vpeso,     FILTER_VALIDATE_FLOAT);
    $estatura = filter_var($vestatura, FILTER_VALIDATE_FLOAT);

    if ($peso === false || $estatura === false) {
        $error = 'Ingresa valores numéricos válidos.';
    } elseif ($peso <= 0 || $estatura <= 0) {
        $error = 'El peso y la estatura deben ser mayores que cero.';
    } else {
        $imc = $peso / ($estatura * $estatura);

        if ($imc < 18.5)       $clasificacion = 'Bajo peso';
        elseif ($imc < 25.0)   $clasificacion = 'Peso normal';
        elseif ($imc < 30.0)   $clasificacion = 'Sobrepeso';
        else                   $clasificacion = 'Obesidad';

        $resultado[] = 'IMC: ' . number_format($imc, 2);
        $resultado[] = 'Clasificación: ' . $clasificacion;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 23 - IMC</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Práctica 23 — Índice de Masa Corporal</h1>
    <a href="index.php">← Regresar</a>
</header>

<main>
    <h2>Cálculo del IMC</h2>
    <p class="subtitulo">Ingresa tu peso y estatura</p>

    <div class="contenedor">
        <form method="POST" action="practica23.php">
            <div class="campo">
                <label for="peso">Peso (kg)</label>
                <input type="text" id="peso" name="peso"
                       value="<?= htmlspecialchars($vpeso) ?>"
                       placeholder="Ej. 65" autofocus>
            </div>
            <div class="campo">
                <label for="estatura">Estatura (m)</label>
                <input type="text" id="estatura" name="estatura"
                       value="<?= htmlspecialchars($vestatura) ?>"
                       placeholder="Ej. 1.68">
            </div>
            <div class="botones">
                <button type="submit">Calcular IMC</button>
            </div>
        </form>

        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php elseif ($resultado): ?>
            <div class="resultado">
                <?php foreach ($resultado as $r): ?>
                    <p><?= htmlspecialchars($r) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

</body>
</html>
