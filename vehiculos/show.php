<?php declare(strict_types=1);

$conn = require "../database.php";

$stm = $conn->prepare("select * from vehiculos where Matricula = :Matricula");
$stm->execute(array(':Matricula' => $_GET['Matricula']));

$factura = $stm->fetch();

$stm = null;
$conn = null;

?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>factura</title>
</head>
<body>
    <h1>vehiculos</h1>
    <p>Matricula: <?=$factura['Matricula'] ?></p>
    <p>Marca: <?=$factura['Marca'] ?></p>
    <p>Modelo: <?=$factura['Modelo'] ?></p>
    <p>Color: <?=$factura['Color'] ?></p>
    <p>FechaMatriculacion: <?=$factura['FechaMatriculacion'] ?></p>
    <p>CodCliente: <?=$factura['CodCliente'] ?></p>

    <p>
        <a href="list.php">Ver todas los vehiculos</a>
    </p>
    <p>
        <a href="form.php?Matricula=<?=$factura['Matricula']?>">Modificar</a>
    </p>
    <p>
        <a href="delete.php?Matricula=<?=$factura['Matricula']?>">Eliminar</a>
    </p>
</body>
</html>