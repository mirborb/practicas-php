<?php
$resultado = [];
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
        $error = 'El valor de "a" no puede ser cero.';
    } else {
        $disc = ($b * $b) - (4 * $a * $c);
        if ($disc < 0) {
            $error = 'El discriminante es negativo (' . $disc . '). No hay raíces reales.';
        } elseif ($disc == 0) {
            $resultado[] = 'Raíz única: x = ' . (-$b / (2 * $a));
        } else {
            $resultado[] = 'x1 = ' . ((-$b + sqrt($disc)) / (2 * $a));
            $resultado[] = 'x2 = ' . ((-$b - sqrt($disc)) / (2 * $a));
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 22 - Fórmula general</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Práctica 22 — Fórmula general</h1>
    <a href="index.php">← Regresar</a>
</header>

<main>
    <h2>Fórmula general (ax² + bx + c = 0)</h2>
    <p class="subtitulo">Ingresa los tres coeficientes de la ecuación</p>

    <div class="contenedor">
        <form method="POST" action="practica22.php">
            <div class="campo">
                <label for="a">Valor a</label>
                <input type="text" id="a" name="a"
                       value="<?= htmlspecialchars($va) ?>"
                       placeholder="Coeficiente a" autofocus>
            </div>
            <div class="campo">
                <label for="b">Valor b</label>
                <input type="text" id="b" name="b"
                       value="<?= htmlspecialchars($vb) ?>"
                       placeholder="Coeficiente b">
            </div>
            <div class="campo">
                <label for="c">Valor c</label>
                <input type="text" id="c" name="c"
                       value="<?= htmlspecialchars($vc) ?>"
                       placeholder="Coeficiente c">
            </div>
            <div class="botones">
                <button type="submit">Calcular</button>
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
