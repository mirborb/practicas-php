<?php $generar = isset($_POST['generar']); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 25 - Tablas del 1 al 10</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Práctica 25 — Tablas del 1 al 10</h1>
    <a href="index.php">← Regresar</a>
</header>

<main>
    <h2>Tablas de multiplicar del 1 al 10</h2>
    <p class="subtitulo">Generadas por PHP en el servidor</p>

    <div class="contenedor" style="max-width:100%;">
        <form method="POST" action="practica25.php">
            <div class="botones">
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
