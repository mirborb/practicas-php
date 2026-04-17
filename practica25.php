<?php $generar = isset($_POST['generar']); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 25 — Tablas del 1 al 10</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Práctica 25 — Tablas del 1 al 10</h1>
    <a class="back" href="index.php">← Inicio</a>
</header>

<main>
    <p class="page-title">
        Tablas de multiplicar del 1 al 10
        <small>Generadas por el servidor con PHP</small>
    </p>

    <div class="form-card" style="max-width:100%;">
        <form method="POST" action="practica25.php">
            <div class="btn-group">
                <button type="submit" name="generar">Generar tablas</button>
            </div>
        </form>

        <?php if ($generar): ?>
            <div class="tablas-wrap">
                <?php for ($i = 1; $i <= 10; $i++): ?>
                    <div class="tabla-item">
                        <h3>Tabla del <?= $i ?></h3>
                        <p>
                            <?php for ($j = 1; $j <= 10; $j++): ?>
                                <?= $i ?> &times; <?= $j ?> = <?= $i * $j ?><br>
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
