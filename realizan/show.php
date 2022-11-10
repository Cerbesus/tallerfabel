<?php declare(strict_types=1);

$conn = require "../database.php";

$stm = $conn->prepare("SELECT * from realizan where Referencia = :Referencia and IdReparacion= :IdReparacion");
$stm->execute(array(':Referencia' => $_GET['Referencia'],':IdReparacion' => $_GET['IdReparacion']));

$realizan = $stm->fetch();

$stm = null;
$conn = null;

?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cliente</title>
</head>
<body>
    <h1>realizan</h1>
    <p>IdReparacion: <?=$realizan['IdReparacion']?></p>
    <p>Referencia: <?=$realizan['Referencia']?></p>
    <p>Horas: <?=$realizan['Horas']?></p>
    <p>
        <a href="list.php">Ver todos los realizan</a>
    </p>
    <p>
        <a href="form.php?Referencia=<?=$realizan['Referencia']."&IdReparacion=".$realizan['IdReparacion']?>">Modificar</a>
    </p>
    <p>
        <a href="delete.php?Referencia=<?=$realizan['Referencia']."&IdReparacion=".$realizan['IdReparacion']?>">Eliminar</a>
    </p>
</body>
</html>