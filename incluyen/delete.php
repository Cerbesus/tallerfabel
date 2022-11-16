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

    $stm = $conn->prepare("DELETE from incluyen where IdRecambio = :IdRecambio AND IdReparacion = :IdReparacion");
    $stm->execute(array(':IdRecambio' => $_POST['IdRecambio'],':IdReparacion' => $_POST['IdReparacion']));

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="delete.php" method="post">
        <input type="hidden" name="IdRecambio" value="<?=$_GET['IdRecambio']?>">
        <input type="hidden" name="IdReparacion" value="<?=$_GET['IdReparacion']?>">

        ¿Seguro que quiere eliminar la relacion del recambio con código <?=$_GET['IdRecambio']?> y la reparación con código <?=$_GET['IdReparacion']?>?

        <input type="submit" name="delete" value="Eliminar">
        <input type="submit" name="cancel" value="Cancelar">
    </form>
</body>
</html>