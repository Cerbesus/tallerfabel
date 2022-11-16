<?php declare(strict_types=1);

session_start();

if (!isset($_SESSION['user'])) {
    header('location:../form_login.php');
    exit();
}

$conn = require "../database.php";

$stm = $conn->prepare("select * from facturas where IdFactura = :IdFactura");
$stm->execute(array(':IdFactura' => $_GET['IdFactura']));

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
    <h1>facturas</h1>
    <p>IdFactura: <?=$factura['IdFactura'] ?></p>
    <p>FechaFactura: <?=$factura['FechaFactura'] ?></p>
    <p>CodCliente: <?=$factura['CodCliente'] ?></p>
    <p>IdReparacion: <?=$factura['IdReparacion'] ?></p>
    <p>
        <a href="list.php">Ver todas los facturas</a>
    </p>
    <p>
        <a href="form.php?IdFactura=<?=$factura['IdFactura']?>">Modificar</a>
    </p>
    <p>
        <a href="delete.php?IdFactura=<?=$factura['IdFactura']?>">Eliminar</a>
    </p>
</body>
</html>