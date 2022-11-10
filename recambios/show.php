<?php declare(strict_types=1);

$conn = require "../database.php";

$stm = $conn->prepare("select * from recambios where IdRecambio = :IdRecambio");
$stm->execute(array(':IdRecambio' => $_GET['IdRecambio']));

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
    <h1>recambios</h1>
    <p>IdRecambio: <?=$empleado['IdRecambio'] ?></p>
    <p>Descripcion: <?=$empleado['Descripcion'] ?></p>
    <p>UnidadBase: <?=$empleado['UnidadBase'] ?></p>
    <p>Stock: <?=$empleado['Stock'] ?></p>
    <p>PrecioReferencia: <?=$empleado['PrecioReferencia'] ?></p>
    <p>
        <a href="list.php">Ver todos los recambios</a>
    </p>
    <p>
        <a href="form.php?IdRecambio=<?=$empleado['IdRecambio']?>">Modificar</a>
    </p>
    <p>
        <a href="delete.php?IdRecambio=<?=$empleado['IdRecambio']?>">Eliminar</a>
    </p>
</body>
</html>