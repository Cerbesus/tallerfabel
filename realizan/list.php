<?php declare(strict_types=1);

session_start();

if (!isset($_SESSION['user'])) {
    header('location:../form_login.php');
    exit();
}

$conn = require "../database.php";

$stm = $conn->query("select * from realizan order by IdReparacion,Referencia,SUBSTRING(Referencia,2,100)*1");
$stm->execute();
$realizan1 = $stm->fetchAll();

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
    <h1>Listado de realizan</h1>
    <table>
        <tr>
            <th>IdReparacion</th>
            <th>Referencia</th>
            <th>Horas</th>
        </tr>

        <?php foreach($realizan1 as $realizan2): ?>
            <tr>
                <td>
                    <a href="show.php?Referencia=<?=$realizan2['Referencia']?>&IdReparacion=<?=$realizan2['IdReparacion']?>"><?=$realizan2['IdReparacion']?></a>
                </td>
                <td>
                    <a href="show.php?Referencia=<?=$realizan2['Referencia']?>&IdReparacion=<?=$realizan2['IdReparacion']?>"><?=$realizan2['Referencia']?></a>
                </td>
                <td><?=$realizan2['Horas']?></td>               
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="form.php">Nuevo realizan</a>
</body>
</html>