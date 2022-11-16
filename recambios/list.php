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