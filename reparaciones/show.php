<?php declare(strict_types=1);

session_start();

if (!isset($_SESSION['user'])) {
    header('location:../form_login.php');
    exit();
}

$conn = require "../database.php";

$stm = $conn->prepare("select * from reparaciones where IdReparacion = :IdReparacion");
$stm -> execute(array(':IdReparacion' => $_GET['IdReparacion']));

$reparacion = $stm->fetch();

$stm = null;
$conn = null;

?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reparacion</title>
</head>
<body>
    <h1>Oficina</h1>
    <p>
        IdReparacion: <?=$reparacion['IdReparacion'] ?>
    </p>
    <p>
        Matricula: <?=$reparacion['Matricula'] ?>
    </p>
    <p>
        FechaEntrada: <?=$reparacion['FechaEntrada'] ?>
    </p>
    <p>
        Km: <?=$reparacion['Km'] ?>
    </p>
    <p>
        Averia: <?=$reparacion['Averia'] ?>
    </p>
    <p>
        FechaSalida: <?=$reparacion['FechaSalida'] ?>
    </p>
    <p>
        Reparado: <?=$reparacion['Reparado'] ?>
    </p>
    <p>
        Observaciones: <?=$reparacion['Observaciones'] ?>
    </p>
    <p>
        <a href="list.php">Ver todas las reparaciones</a>
    </p>
    <p>
        <a href="form.php?IdReparacion=<?=$reparacion['IdReparacion']?>">Modificar</a>
    </p>
    <p>
        <a href="delete.php?IdReparacion=<?=$reparacion['IdReparacion']?>">Eliminar</a>
    </p>
</body>
</html>