<?php declare(strict_types=1);

$conn = require "../database.php";

$stm = $conn->query("select * from intervienen order by SUBSTRING(CodEmpleado,2,100)*1,IdReparacion");
$stm->execute();
$intervienen1 = $stm->fetchAll();

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
    <h1>Listado de intervienen</h1>
    <table>
        <tr>
            <th>CodEmpleado</th>
            <th>IdReparacion</th>
            <th>Horas</th>
        </tr>

        <?php foreach($intervienen1 as $intervienen2): ?>
            <tr>
                <td>
                    <a href="show.php?CodEmpleado=<?=$intervienen2['CodEmpleado']?>&IdReparacion=<?=$intervienen2['IdReparacion']?>"><?=$intervienen2['CodEmpleado']?></a>
                </td>
                <td>
                    <a href="show.php?CodEmpleado=<?=$intervienen2['CodEmpleado']?>&IdReparacion=<?=$intervienen2['IdReparacion']?>"><?=$intervienen2['IdReparacion']?></a>
                </td>
                <td><?=$intervienen2['Horas']?></td>               
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="form.php">Nuevo cliente</a>
</body>
</html>