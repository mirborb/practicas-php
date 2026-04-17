<?php
$dias  = ['domingo','lunes','martes','miércoles','jueves','viernes','sábado'];
$meses = [1=>'enero',2=>'febrero',3=>'marzo',4=>'abril',5=>'mayo',
          6=>'junio',7=>'julio',8=>'agosto',9=>'septiembre',
          10=>'octubre',11=>'noviembre',12=>'diciembre'];

$nombreDia = $dias[(int) date('w')];
$numDia    = (int) date('j');
$nombreMes = $meses[(int) date('n')];
$anio      = date('Y');
$hora      = date('H:i:s');

$texto = "Hoy es {$nombreDia} {$numDia} de {$nombreMes} de {$anio}";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 24 — Fecha actual</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Práctica 24 — Fecha actual</h1>
    <a class="back" href="index.php">← Inicio</a>
</header>

<main>
    <p class="page-title">
        Fecha generada por el servidor
        <small>PHP obtiene la fecha y hora en el momento de procesar la petición</small>
    </p>

    <div class="form-card">
        <div class="info-box"><?= htmlspecialchars($texto) ?></div>
        <p class="hora-info">Hora del servidor: <strong><?= $hora ?></strong></p>
    </div>
</main>

</body>
</html>
