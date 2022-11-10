<?php declare(strict_types=1);

$conn = require "../database.php";

$stm = $conn->query("select * from actuaciones order by SUBSTRING(Referencia,2,100)*1");
$stm->execute();
$actuaciones = $stm->fetchAll();

$stm = null;
$conn = null;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>actuaciones</title>
</head>
<body>
    <h1>Listado de actuaciones</h1>
    <table>
        <tr>
            <th>Referencia</th>
            <th>Descripcion</th>
            <th>TiempoEstimado</th>
            <th>Importe</th>
        </tr>

        <?php foreach($actuaciones as $recambio): ?>
            <tr>
                <td>
                    <a href="show.php?Referencia=<?=$recambio['Referencia']?>"><?=$recambio['Referencia']?></a>
                </td>
                <td><?=$recambio['Descripcion']?></td>
                <td><?=$recambio['TiempoEstimado']?></td>
                <td><?=$recambio['Importe']?></td>             
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="form.php">Nueva actuacion</a>
</body>
</html>