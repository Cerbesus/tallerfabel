<?php declare(strict_types=1);

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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