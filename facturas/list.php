<?php declare(strict_types=1);

session_start();

if (!isset($_SESSION['user'])) {
    header('location:../form_login.php');
    exit();
}

$conn = require "../database.php";

$stm = $conn->query("select * from facturas order by IdFactura");
$stm->execute();
$facturas = $stm->fetchAll();

$stm = null;
$conn = null;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>facturas</title>
</head>
<body>
    <h1>Listado de facturas</h1>
    <table>
        <tr>
            <th>IdFactura</th>
            <th>FechaFactura</th>
            <th>CodCliente</th>
            <th>IdReparacion</th>
        </tr>

        <?php foreach($facturas as $factura): ?>
            <tr>
                <td>
                    <a href="show.php?IdFactura=<?=$factura['IdFactura']?>"><?=$factura['IdFactura']?></a>
                </td>
                <td><?=$factura['FechaFactura']?></td>
                <td><?=$factura['CodCliente']?></td>
                <td><?=$factura['IdReparacion']?></td>            
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="form.php">Nuevo cliente</a>
</body>
</html>