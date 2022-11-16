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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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