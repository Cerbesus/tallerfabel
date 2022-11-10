<?php declare(strict_types=1);

$conn = require "../database.php";

$stm = $conn->prepare("select * from offices where officeCode = :officeCode");
$stm -> execute(array(':officeCode' => $_GET['officeCode']));

$office = $stm->fetch();

$stm = null;
$conn = null;

?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oficina</title>
</head>
<body>
    <h1>Oficina</h1>
    <p>
        officeCode: <?=$office['officeCode'] ?>
    </p>
    <p>
        city: <?=$office['city'] ?>
    </p>
    <p>
        phone: <?=$office['phone'] ?>
    </p>
    <p>
        addressLine1: <?=$office['addressLine1'] ?>
    </p>
    <p>
        addressLine2: <?=$office['addressLine2'] ?>
    </p>
    <p>
        state: <?=$office['state'] ?>
    </p>
    <p>
        country: <?=$office['country'] ?>
    </p>
    <p>
        postalCode: <?=$office['postalCode'] ?>
    </p>
    <p>
        territory: <?=$office['territory'] ?>
    </p>
    <p>
        <a href="list.php">Ver todas las oficina</a>
    </p>
    <p>
        <a href="form.php?officeCode=<?=$office['officeCode']?>">Modificar</a>
    </p>
    <p>
        <a href="delete.php?officeCode=<?=$office['officeCode']?>">Eliminar</a>
    </p>
</body>
</html>