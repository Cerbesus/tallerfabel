<?php declare(strict_types=1);

session_start();

if (!isset($_SESSION['user'])) {
    header('location:../form_login.php');
    exit();
}

$conn = require "../database.php";

$stm = $conn->query("select * from empleados order by SUBSTRING(CodEmpleado,2,100)*1");
$stm->execute();
$empleados = $stm->fetchAll();

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
    <title>empleados</title>
</head>
<body>
    <h1>Listado de empleados</h1>
    <table>
        <tr>
            <th>CodEmpleado</th>
            <th>DNI</th>
            <th>Apellidos</th>
            <th>Nombre</th>
            <th>Direccion</th>
            <th>Telefono</th>
            <th>CP</th>
            <th>FechaAlta</th>
            <th>Categoria</th>
        </tr>

        <?php foreach($empleados as $empleado): ?>
            <tr>
                <td>
                    <a href="show.php?CodEmpleado=<?=$empleado['CodEmpleado']?>"><?=$empleado['CodEmpleado']?></a>
                </td>
                <td><?=$empleado['DNI']?></td>
                <td><?=$empleado['Apellidos']?></td>
                <td><?=$empleado['Nombre']?></td>
                <td><?=$empleado['Direccion']?></td>
                <td><?=$empleado['Telefono']?></td>                
                <td><?=$empleado['CP']?></td>                
                <td><?=$empleado['FechaAlta']?></td>                
                <td><?=$empleado['Categoria']?></td>                
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="form.php">Nuevo empleado</a>
</body>
</html>