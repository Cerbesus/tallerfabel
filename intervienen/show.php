<?php declare(strict_types=1);

session_start();

if (!isset($_SESSION['user'])) {
    header('location:../form_login.php');
    exit();
}

$conn = require "../database.php";

$stm = $conn->prepare("SELECT * from intervienen where CodEmpleado = :CodEmpleado and IdReparacion= :IdReparacion");
$stm->execute(array(':CodEmpleado' => $_GET['CodEmpleado'],':IdReparacion' => $_GET['IdReparacion']));

$intervienen = $stm->fetch();

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
    <h1>Clientes</h1>
    <p>CodEmpleado: <?=$intervienen['CodEmpleado'] ?></p>
    <p>IdReparacion: <?=$intervienen['IdReparacion'] ?></p>
    <p>Horas: <?=$intervienen['Horas'] ?></p>
    <p>
        <a href="list.php">Ver todos los clientes</a>
    </p>
    <p>
        <a href="form.php?CodEmpleado=<?=$intervienen['CodEmpleado']."&IdReparacion=".$intervienen['IdReparacion']?>">Modificar</a>
    </p>
    <p>
        <a href="delete.php?CodEmpleado=<?=$intervienen['CodEmpleado']."&IdReparacion=".$intervienen['IdReparacion']?>">Eliminar</a>
    </p>
</body>
</html>