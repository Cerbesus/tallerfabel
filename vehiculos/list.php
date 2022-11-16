<?php declare(strict_types=1);

session_start();

if (!isset($_SESSION['user'])) {
    header('location:../form_login.php');
    exit();
}

$conn = require "../database.php";

$stm = $conn->query("select * from vehiculos order by Matricula");
$stm->execute();
$vehiculos = $stm->fetchAll();

$stm = null;
$conn = null;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>vehiculos</title>
</head>
<body>
    <h1>Listado de vehiculos</h1>
    <table>
        <tr>
            <th>Matricula</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Color</th>
            <th>FechaMatriculacion</th>
            <th>CodCliente</th>
        </tr>

        <?php foreach($vehiculos as $vehiculo): ?>
            <tr>
                <td>
                    <a href="show.php?Matricula=<?=$vehiculo['Matricula']?>"><?=$vehiculo['Matricula']?></a>
                </td>
                <td><?=$vehiculo['Marca']?></td>
                <td><?=$vehiculo['Modelo']?></td>           
                <td><?=$vehiculo['Color']?></td>           
                <td><?=$vehiculo['FechaMatriculacion']?></td>           
                <td><?=$vehiculo['CodCliente']?></td>           
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="form.php">Nuevo vehiculo</a>
</body>
</html>