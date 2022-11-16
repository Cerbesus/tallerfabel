<?php declare(strict_types=1);

$conn = require "../database.php";

$stm = $conn->prepare("select * from vehiculos where Matricula = :Matricula");
$stm->execute(array(':Matricula' => $_GET['Matricula']));

$vehiculo = $stm->fetch();

$stm = null;
$conn = null;

?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>vehiculo</title>
</head>
<body>
    <h1>vehiculos</h1>
    <p>Matricula: <?=$vehiculo['Matricula'] ?></p>
    <p>Marca: <?=$vehiculo['Marca'] ?></p>
    <p>Modelo: <?=$vehiculo['Modelo'] ?></p>
    <p>Color: <?=$vehiculo['Color'] ?></p>
    <p>FechaMatriculacion: <?=$vehiculo['FechaMatriculacion'] ?></p>
    <p>CodCliente: <?=$vehiculo['CodCliente'] ?></p>

    <p>
        <a href="list.php">Ver todas los vehiculos</a>
    </p>
    <p>
        <a href="form.php?Matricula=<?=$vehiculo['Matricula']?>">Modificar</a>
    </p>
    <p>
        <a href="delete.php?Matricula=<?=$vehiculo['Matricula']?>">Eliminar</a>
    </p>
</body>
</html>