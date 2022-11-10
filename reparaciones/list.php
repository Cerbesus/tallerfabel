<?php declare(strict_types=1);

$conn = require "../database.php";

$stm = $conn->query("select * from reparaciones order by IdReparacion");
$stm->execute();
$reparaciones = $stm->fetchAll();

$stm = null;
$conn = null;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reparaciones</title>
</head>
<body>
    <h1>Listado de oficinas</h1>
    <table>
        <tr>
            <th>IdReparacion</th>
            <th>Matricula</th>
            <th>FechaEntrada</th>
            <th>Km</th>
            <th>Averia</th>
            <th>FechaSalida</th>
            <th>Reparado</th>
            <th>Observaciones</th>
        </tr>

        <?php foreach($reparaciones as $reparacion): ?>
            <tr>
                <td>
                    <a href="show.php?IdReparacion=<?=$reparacion['IdReparacion']?>">
                        <?=$reparacion['IdReparacion']?>
                    </a>
                </td>
                <td><?=$reparacion['Matricula']?></td>
                <td><?=$reparacion['FechaEntrada']?></td>
                <td><?=$reparacion['Km']?></td>
                <td><?=$reparacion['Averia']?></td>
                <td><?=$reparacion['FechaSalida']?></td>
                <td><?=$reparacion['Reparado']?></td>
                <td><?=$reparacion['Observaciones']?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="form.php">Nueva Reparacion</a>
</body>
</html>