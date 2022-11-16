<?php declare(strict_types=1);

session_start();

if (!isset($_SESSION['user'])) {
    header('location:../form_login.php');
    exit();
}

$conn = require "../database.php";

$stm = $conn->query("select * from incluyen order by SUBSTRING(IdRecambio,2,100)*1,IdReparacion");
$stm->execute();
$incluyen1 = $stm->fetchAll();

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
    <h1>Listado de incluyen</h1>
    <table>
        <tr>
            <th>IdRecambio</th>
            <th>IdReparacion</th>
            <th>Unidades</th>
        </tr>

        <?php foreach($incluyen1 as $incluyen2): ?>
            <tr>
                <td>
                    <a href="show.php?IdRecambio=<?=$incluyen2['IdRecambio']?>&IdReparacion=<?=$incluyen2['IdReparacion']?>"><?=$incluyen2['IdRecambio']?></a>
                </td>
                <td>
                    <a href="show.php?IdRecambio=<?=$incluyen2['IdRecambio']?>&IdReparacion=<?=$incluyen2['IdReparacion']?>"><?=$incluyen2['IdReparacion']?></a>
                </td>
                <td><?=$incluyen2['Unidades']?></td>               
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="form.php">Nuevo incluyen</a>
</body>
</html>