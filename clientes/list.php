<?php declare(strict_types=1);

session_start();

if (!isset($_SESSION['user'])) {
    header('location:../form_login.php');
    exit();
}

$conn = require "../database.php";

$stm = $conn->query("select * from clientes order by SUBSTRING(CodCliente,2,100)*1");
$stm->execute();
$clientes = $stm->fetchAll();

$stm = null;
$conn = null;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
</head>
<body>
    <h1>Listado de clientes</h1>
    <table>
        <tr>
            <th>CodCliente</th>
            <th>DNI</th>
            <th>Apellidos</th>
            <th>Nombre</th>
            <th>Direccion</th>
            <th>Telefono</th>
        </tr>

        <?php foreach($clientes as $cliente): ?>
            <tr>
                <td>
                    <a href="show.php?CodCliente=<?=$cliente['CodCliente']?>"><?=$cliente['CodCliente']?></a>
                </td>
                <td><?=$cliente['CodCliente']?></td>
                <td><?=$cliente['DNI']?></td>
                <td><?=$cliente['Apellidos']?></td>
                <td><?=$cliente['Nombre']?></td>
                <td><?=$cliente['Direccion']?></td>
                <td><?=$cliente['Telefono']?></td>                
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="form.php">Nuevo cliente</a>
</body>
</html>