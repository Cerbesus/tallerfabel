<?php declare(strict_types=1);

session_start();

if (!isset($_SESSION['user'])) {
    header('location:../form_login.php');
    exit();
}

if (isset($_POST['cancel'])) { //has cancelado porque no quieres eliminar la oficina
    header("location: list.php"); //vuelves al listado de oficinas
} else if (isset($_POST['delete'])){ //has seleccionado que quieres eliminar la oficina
    $conn = require "../database.php";

    $stm = $conn->prepare("DELETE from intervienen where CodEmpleado = :CodEmpleado AND IdReparacion = :IdReparacion");
    $stm->execute(array(':CodEmpleado' => $_POST['CodEmpleado'],':IdReparacion' => $_POST['IdReparacion']));

    $stm = null; //se cierra la conexión
    $conn = null;

    header("location: list.php");
}
?>

<!DOCTYPE html>
<html lang="en">
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
    <title>Document</title>
</head>
<body>
    <form action="delete.php" method="post">
        <input type="hidden" name="CodEmpleado" value="<?=$_GET['CodEmpleado']?>">
        <input type="hidden" name="IdReparacion" value="<?=$_GET['IdReparacion']?>">

        ¿Seguro que quiere eliminar la relacion del empleado con código <?=$_GET['CodEmpleado']?> y la reparación <?=$_GET['IdReparacion']?>?

        <input type="submit" name="delete" value="Eliminar">
        <input type="submit" name="cancel" value="Cancelar">
    </form>
</body>
</html>