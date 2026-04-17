<?php
$resultado = null;
$error     = '';
$valorA    = '';
$valorB    = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $valorA    = $_POST['valorA']    ?? '';
    $valorB    = $_POST['valorB']    ?? '';
    $operacion = $_POST['operacion'] ?? '';

    $a = filter_var($valorA, FILTER_VALIDATE_FLOAT);
    $b = filter_var($valorB, FILTER_VALIDATE_FLOAT);

    if ($a === false || $b === false) {
        $error = 'Ingresa valores numéricos válidos en ambos campos.';
    } else {
        switch ($operacion) {
            case 'suma':
                $resultado = 'Suma: ' . ($a + $b);
                break;
            case 'resta':
                $resultado = 'Resta: ' . ($a - $b);
                break;
            case 'division':
                if ($b == 0) {
                    $error = 'No es posible dividir entre cero.';
                } else {
                    $resultado = 'División: ' . ($a / $b);
                }
                break;
            case 'exponenciacion':
                $resultado = 'Exponenciación: ' . pow($a, $b);
                break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 21 — Operaciones aritméticas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Práctica 21 — Operaciones aritméticas</h1>
    <a class="back" href="index.php">← Inicio</a>
</header>

<main>
    <p class="page-title">
        Operaciones aritméticas
        <small>Introduce dos valores y elige la operación a realizar</small>
    </p>

    <div class="form-card">
        <form method="POST" action="practica21.php">

            <div class="form-group">
                <label for="valorA">Valor A</label>
                <input type="text" id="valorA" name="valorA"
                       value="<?= htmlspecialchars($valorA) ?>"
                       placeholder="Ej. 12" autofocus>
            </div>

            <div class="form-group">
                <label for="valorB">Valor B</label>
                <input type="text" id="valorB" name="valorB"
                       value="<?= htmlspecialchars($valorB) ?>"
                       placeholder="Ej. 4">
            </div>

            <div class="btn-group">
                <button type="submit" name="operacion" value="suma">Suma</button>
                <button type="submit" name="operacion" value="resta">Resta</button>
                <button type="submit" name="operacion" value="division">División</button>
                <button type="submit" name="operacion" value="exponenciacion">Exponenciación</button>
            </div>

        </form>

        <?php if ($error): ?>
            <div class="error-box"><?= htmlspecialchars($error) ?></div>
        <?php elseif ($resultado !== null): ?>
            <div class="result-box"><?= htmlspecialchars($resultado) ?></div>
        <?php endif; ?>
    </div>
</main>

</body>
</html>
