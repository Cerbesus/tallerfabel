<?php declare(strict_types=1);

$conn = require "../database.php";

$stm = $conn->prepare("select * from actuaciones where Referencia = :Referencia");
$stm->execute(array(':Referencia' => $_GET['Referencia']));

$empleado = $stm->fetch();

$stm = null;
$conn = null;

?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>actuacion</title>
</head>
<body>
    <h1>actuaciones</h1>
    <p>Referencia: <?=$empleado['Referencia'] ?></p>
    <p>Descripcion: <?=$empleado['Descripcion'] ?></p>
    <p>TiempoEstimado: <?=$empleado['TiempoEstimado'] ?></p>
    <p>Importe: <?=$empleado['Importe'] ?></p>
    <p>
        <a href="list.php">Ver todas los actuaciones</a>
    </p>
    <p>
        <a href="form.php?Referencia=<?=$empleado['Referencia']?>">Modificar</a>
    </p>
    <p>
        <a href="delete.php?Referencia=<?=$empleado['Referencia']?>">Eliminar</a>
    </p>
</body>
</html>