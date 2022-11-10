<?php declare(strict_types=1);

if (isset($_POST['cancel'])) { //has cancelado porque no quieres eliminar al empleado
    header("location: list.php"); //vuelves al listado de recambios
} else if (isset($_POST['delete'])){ //has seleccionado que quieres eliminar el recambios
    $conn = require "../database.php";

    $stm = $conn->prepare("delete from recambios where IdRecambio = :IdRecambio");
    $stm->execute(array(':IdRecambio' => $_POST['IdRecambio']));

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
    <title>Eliminar</title>
</head>
<body>
    <form action="delete.php" method="post">
        <input type="hidden" name="IdRecambio" value="<?=$_GET['IdRecambio']?>">

        ¿Seguro que quiere eliminar el recambio con código <?=$_GET['IdRecambio']?>?

        <input type="submit" name="delete" value="Eliminar">
        <input type="submit" name="cancel" value="Cancelar">
    </form>
</body>
</html>