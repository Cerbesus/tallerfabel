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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
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