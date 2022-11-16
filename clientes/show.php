<?php declare(strict_types=1);

session_start();

if (!isset($_SESSION['user'])) {
    header('location:../form_login.php');
    exit();
}

$conn = require "../database.php";

$stm = $conn->prepare("select * from clientes where CodCliente = :CodCliente");
$stm->execute(array(':CodCliente' => $_GET['CodCliente']));

$cliente = $stm->fetch();

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
    <title>Cliente</title>
</head>
<body>
    <h1>Clientes</h1>
    <p>CodCliente: <?=$cliente['CodCliente'] ?></p>
    <p>DNI: <?=$cliente['DNI'] ?></p>
    <p>Apellidos: <?=$cliente['Apellidos'] ?></p>
    <p>Nombre: <?=$cliente['Nombre'] ?></p>
    <p>Direccion: <?=$cliente['Direccion'] ?></p>
    <p>Telefono: <?=$cliente['Telefono'] ?></p>
    <p>
        <a href="list.php">Ver todos los clientes</a>
    </p>
    <p>
        <a href="form.php?CodCliente=<?=$cliente['CodCliente']?>">Modificar</a>
    </p>
    <p>
        <a href="delete.php?CodCliente=<?=$cliente['CodCliente']?>">Eliminar</a>
    </p>
</body>
</html>