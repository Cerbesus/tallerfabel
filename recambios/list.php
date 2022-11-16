<?php declare(strict_types=1);

session_start();

if (!isset($_SESSION['user'])) {
    header('location:../form_login.php');
    exit();
}

$conn = require "../database.php";

$stm = $conn->query("select * from recambios order by SUBSTRING(IdRecambio,2,100)*1");
$stm->execute();
$recambios = $stm->fetchAll();

$stm = null;
$conn = null;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>recambios</title>
</head>
<body>
    <h1>Listado de recambios</h1>
    <table>
        <tr>
            <th>IdRecambio</th>
            <th>Descripcion</th>
            <th>UnidadBase</th>
            <th>Stock</th>
            <th>PrecioReferencia</th>
        </tr>

        <?php foreach($recambios as $recambio): ?>
            <tr>
                <td>
                    <a href="show.php?IdRecambio=<?=$recambio['IdRecambio']?>"><?=$recambio['IdRecambio']?></a>
                </td>
                <td><?=$recambio['Descripcion']?></td>
                <td><?=$recambio['UnidadBase']?></td>
                <td><?=$recambio['Stock']?></td>
                <td><?=$recambio['PrecioReferencia']?></td>             
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="form.php">Nuevo recambio</a>
</body>
</html>