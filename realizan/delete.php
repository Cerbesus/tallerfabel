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

    $stm = $conn->prepare("DELETE from realizan where IdReparacion = :IdReparacion AND Referencia = :Referencia");
    $stm->execute(array(':IdReparacion' => $_POST['IdReparacion'],':Referencia' => $_POST['Referencia']));

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
        <input type="hidden" name="IdReparacion" value="<?=$_GET['IdReparacion']?>">
        <input type="hidden" name="Referencia" value="<?=$_GET['Referencia']?>">

        ¿Seguro que quiere eliminar la relacion de la reparacion con código <?=$_GET['IdReparacion']?> y la actuación con código <?=$_GET['Referencia']?>?

        <input type="submit" name="delete" value="Eliminar">
        <input type="submit" name="cancel" value="Cancelar">
    </form>
</body>
</html>