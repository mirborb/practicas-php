<?php
$resultado = null;
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

        if ($imc < 18.5) {
            $clasificacion = 'Bajo peso';
        } elseif ($imc < 25.0) {
            $clasificacion = 'Peso normal';
        } elseif ($imc < 30.0) {
            $clasificacion = 'Sobrepeso';
        } else {
            $clasificacion = 'Obesidad';
        }

        $resultado = [
            'IMC: ' . number_format($imc, 2),
            'Clasificación: ' . $clasificacion,
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 23 — IMC</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Práctica 23 — Índice de Masa Corporal</h1>
    <a class="back" href="index.php">← Inicio</a>
</header>

<main>
    <p class="page-title">
        Cálculo del IMC
        <small>Ingresa tu peso y estatura para obtener el resultado</small>
    </p>

    <div class="form-card">
        <form method="POST" action="practica23.php">

            <div class="form-group">
                <label for="peso">Peso (kg)</label>
                <input type="text" id="peso" name="peso"
                       value="<?= htmlspecialchars($vpeso) ?>"
                       placeholder="Ej. 65" autofocus>
            </div>

            <div class="form-group">
                <label for="estatura">Estatura (m)</label>
                <input type="text" id="estatura" name="estatura"
                       value="<?= htmlspecialchars($vestatura) ?>"
                       placeholder="Ej. 1.68">
            </div>

            <div class="btn-group">
                <button type="submit">Calcular IMC</button>
            </div>

        </form>

        <?php if ($error): ?>
            <div class="error-box"><?= htmlspecialchars($error) ?></div>
        <?php elseif ($resultado !== null): ?>
            <div class="result-box">
                <?php foreach ($resultado as $linea): ?>
                    <span><?= htmlspecialchars($linea) ?></span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

</body>
</html>
