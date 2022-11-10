<?php declare(strict_types=1);

$conn = require "../database.php";

$stm = $conn->prepare("SELECT * from incluyen where IdRecambio = :IdRecambio and IdReparacion= :IdReparacion");
$stm->execute(array(':IdRecambio' => $_GET['IdRecambio'],':IdReparacion' => $_GET['IdReparacion']));

$incluyen = $stm->fetch();

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
    <h1>incluyen</h1>
    <p>IdRecambio: <?=$incluyen['IdRecambio']?></p>
    <p>IdReparacion: <?=$incluyen['IdReparacion']?></p>
    <p>Unidades: <?=$incluyen['Unidades']?></p>
    <p>
        <a href="list.php">Ver todos los incluyen</a>
    </p>
    <p>
        <a href="form.php?IdRecambio=<?=$incluyen['IdRecambio']."&IdReparacion=".$incluyen['IdReparacion']?>">Modificar</a>
    </p>
    <p>
        <a href="delete.php?IdRecambio=<?=$incluyen['IdRecambio']."&IdReparacion=".$incluyen['IdReparacion']?>">Eliminar</a>
    </p>
</body>
</html>