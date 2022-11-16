<?php declare(strict_types=1);

session_start();

if (!isset($_SESSION['user'])) {
    header('location:../form_login.php');
    exit();
}

if (isset($_POST['cancel'])) { //has cancelado porque no quieres eliminar al empleado
    header("location: list.php"); //vuelves al listado de empleados
} else if (isset($_POST['delete'])){ //has seleccionado que quieres eliminar el empleados
    $conn = require "../database.php";

    $stm = $conn->prepare("delete from vehiculos where Matricula = :Matricula");
    $stm->execute(array(':Matricula' => $_POST['Matricula']));

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
        <input type="hidden" name="Matricula" value="<?=$_GET['Matricula']?>">

        ¿Seguro que quiere eliminar el vehiculo con matricula <?=$_GET['Matricula']?>?

        <input type="submit" name="delete" value="Eliminar">
        <input type="submit" name="cancel" value="Cancelar">
    </form>
</body>
</html>