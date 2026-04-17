<?php
$resultado = null;
$error     = '';
$va = $vb = $vc = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $va = $_POST['a'] ?? '';
    $vb = $_POST['b'] ?? '';
    $vc = $_POST['c'] ?? '';

    $a = filter_var($va, FILTER_VALIDATE_FLOAT);
    $b = filter_var($vb, FILTER_VALIDATE_FLOAT);
    $c = filter_var($vc, FILTER_VALIDATE_FLOAT);

    if ($a === false || $b === false || $c === false) {
        $error = 'Los tres campos deben tener valores numéricos.';
    } elseif ($a == 0) {
        $error = 'El valor de "a" no puede ser 0.';
    } else {
        $disc = ($b * $b) - (4 * $a * $c);
        if ($disc < 0) {
            $error = 'El discriminante es negativo (' . $disc . '). La ecuación no tiene raíces reales.';
        } elseif ($disc == 0) {
            $x = -$b / (2 * $a);
            $resultado = ['Raíz única: x = ' . $x];
        } else {
            $x1 = (-$b + sqrt($disc)) / (2 * $a);
            $x2 = (-$b - sqrt($disc)) / (2 * $a);
            $resultado = ['x₁ = ' . $x1, 'x₂ = ' . $x2];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 22 — Fórmula general</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Práctica 22 — Fórmula general</h1>
    <a class="back" href="index.php">← Inicio</a>
</header>

<main>
    <p class="page-title">
        Fórmula general &nbsp;(ax² + bx + c = 0)
        <small>Ingresa los coeficientes para encontrar las raíces</small>
    </p>

    <div class="form-card">
        <form method="POST" action="practica22.php">

            <div class="form-group">
                <label for="a">Coeficiente a</label>
                <input type="text" id="a" name="a"
                       value="<?= htmlspecialchars($va) ?>"
                       placeholder="Valor de a (distinto de 0)" autofocus>
            </div>

            <div class="form-group">
                <label for="b">Coeficiente b</label>
                <input type="text" id="b" name="b"
                       value="<?= htmlspecialchars($vb) ?>"
                       placeholder="Valor de b">
            </div>

            <div class="form-group">
                <label for="c">Coeficiente c</label>
                <input type="text" id="c" name="c"
                       value="<?= htmlspecialchars($vc) ?>"
                       placeholder="Valor de c">
            </div>

            <div class="btn-group">
                <button type="submit">Calcular raíces</button>
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
