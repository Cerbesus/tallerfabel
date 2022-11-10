<?php declare(strict_types=1);

if (isset($_POST['cancel'])) { //has cancelado porque no quieres eliminar al empleado
    header("location: list.php"); //vuelves al listado de actuaciones
} else if (isset($_POST['delete'])){ //has seleccionado que quieres eliminar el actuaciones
    $conn = require "../database.php";

    $stm = $conn->prepare("delete from actuaciones where Referencia = :Referencia");
    $stm->execute(array(':Referencia' => $_POST['Referencia']));

    $stm = null; //se cierra la conexión
    $conn = null;

    header("location: list.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar</title>
</head>
<body>
    <form action="delete.php" method="post">
        <input type="hidden" name="Referencia" value="<?=$_GET['Referencia']?>">

        ¿Seguro que quiere eliminar la actuacion con código <?=$_GET['Referencia']?>?

        <input type="submit" name="delete" value="Eliminar">
        <input type="submit" name="cancel" value="Cancelar">
    </form>
</body>
</html>