<?php
$limite  = null;
$error   = '';
$vlimite = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vlimite = $_POST['limite'] ?? '';
    $limite  = filter_var($vlimite, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    if ($limite === false) {
        $error  = 'Ingresa un número entero mayor que cero.';
        $limite = null;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 26 - Tablas hasta N</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Práctica 26 — Tablas hasta N</h1>
    <a href="index.php">← Regresar</a>
</header>

<main>
    <h2>Tablas de multiplicar personalizadas</h2>
    <p class="subtitulo">Indica cuántas tablas quieres generar</p>

    <div class="contenedor" style="max-width:100%;">
        <form method="POST" action="practica26.php">
            <div class="campo" style="max-width:250px;">
                <label for="limite">Número de tablas</label>
                <input type="number" id="limite" name="limite" min="1"
                       value="<?= htmlspecialchars($vlimite) ?>"
                       placeholder="Ej. 5" autofocus>
            </div>
            <div class="botones">
                <button type="submit">Generar tablas</button>
            </div>
        </form>

        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php elseif ($limite !== null): ?>
            <div class="tablas-wrap">
                <?php for ($i = 1; $i <= $limite; $i++): ?>
                    <div class="tabla-item">
                        <h3>Tabla del <?= $i ?></h3>
                        <p>
                            <?php for ($j = 1; $j <= 10; $j++): ?>
                                <?= $i ?> x <?= $j ?> = <?= $i * $j ?><br>
                            <?php endfor; ?>
                        </p>
                    </div>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

</body>
</html>
