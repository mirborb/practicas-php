<?php
$dias  = ['domingo','lunes','martes','miércoles','jueves','viernes','sábado'];
$meses = [1=>'enero',2=>'febrero',3=>'marzo',4=>'abril',5=>'mayo',
          6=>'junio',7=>'julio',8=>'agosto',9=>'septiembre',
          10=>'octubre',11=>'noviembre',12=>'diciembre'];

$dia  = $dias[(int) date('w')];
$num  = (int) date('j');
$mes  = $meses[(int) date('n')];
$anio = date('Y');
$hora = date('H:i:s');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 24 - Fecha actual</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Práctica 24 — Fecha actual</h1>
    <a href="index.php">← Regresar</a>
</header>

<main>
    <h2>Fecha actual del servidor</h2>
    <p class="subtitulo">PHP genera la fecha en el momento de la petición</p>

    <div class="contenedor">
        <div class="fecha-box">
            Hoy es <?= $dia ?> <?= $num ?> de <?= $mes ?> de <?= $anio ?>
            <div class="hora">Hora del servidor: <?= $hora ?></div>
        </div>
    </div>
</main>

</body>
</html>
