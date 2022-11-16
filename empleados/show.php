<?php declare(strict_types=1);

session_start();

if (!isset($_SESSION['user'])) {
    header('location:../form_login.php');
    exit();
}

$conn = require "../database.php";

$stm = $conn->prepare("select * from empleados where CodEmpleado = :CodEmpleado");
$stm->execute(array(':CodEmpleado' => $_GET['CodEmpleado']));

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
    <title>empleado</title>
</head>
<body>
    <h1>empleados</h1>
    <p>CodEmpleado: <?=$empleado['CodEmpleado'] ?></p>
    <p>DNI: <?=$empleado['DNI'] ?></p>
    <p>Apellidos: <?=$empleado['Apellidos'] ?></p>
    <p>Nombre: <?=$empleado['Nombre'] ?></p>
    <p>Direccion: <?=$empleado['Direccion'] ?></p>
    <p>Telefono: <?=$empleado['Telefono'] ?></p>
    <p>CP: <?=$empleado['CP'] ?></p>
    <p>FechaAlta: <?=$empleado['FechaAlta'] ?></p>
    <p>Categoria: <?=$empleado['Categoria'] ?></p>
    <p>
        <a href="list.php">Ver todos los empleados</a>
    </p>
    <p>
        <a href="form.php?CodEmpleado=<?=$empleado['CodEmpleado']?>">Modificar</a>
    </p>
    <p>
        <a href="delete.php?CodEmpleado=<?=$empleado['CodEmpleado']?>">Eliminar</a>
    </p>
</body>
</html>