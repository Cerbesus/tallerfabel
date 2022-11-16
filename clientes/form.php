<?php declare(strict_types=1);

session_start();

if (!isset($_SESSION['user'])) {
    header('location:../form_login.php');
    exit();
}

if(isset($_POST['cancel'])) {
   header("location: list.php");
   die();
} 

$conn = require "../database.php";

if (isset($_POST['save'])) {
    $cliente = array(
        'CodCliente' => $_POST['CodCliente'],
        'DNI' => $_POST['DNI'],
        'Apellidos' => $_POST['Apellidos'],
        'Nombre' => $_POST['Nombre'],
        'Direccion' => $_POST['Direccion'],
        'Telefono' => $_POST['Telefono']
    );

    $errores = array();

    if(strlen($cliente['DNI'])<=0) {
        $errores['DNI'] = 'se debe indicar el DNI';
    }
 
    if(count($errores) == 0){
        if(strlen($cliente['CodCliente']) >0){
            $stm = $conn->prepare("update clientes set Apellidos=:Apellidos,DNI=:DNI, Nombre=:Nombre, Direccion=:Direccion, Telefono=:Telefono where CodCliente=:CodCliente");

        } else {

            $stm=$conn->prepare("select max(SUBSTRING(CodCliente,2,100)*1) as maxCodCliente from clientes");
            $stm->execute();
            $result=$stm->fetch();

            $cliente['CodCliente'] = "C".$result['maxCodCliente'] + 1;
            
            $stm = $conn->prepare("insert into clientes (CodCliente, DNI, Apellidos, Nombre, Direccion, Telefono) values (:CodCliente, :DNI, :Apellidos, :Nombre, :Direccion, :Telefono)");
        }

        $stm->execute($cliente);
        $stm = null;
        $conn = null;
        header("location: show.php?CodCliente=".$cliente['CodCliente']);
        die();
    }
} else if (isset($_GET['CodCliente'])){
    $stm = $conn->prepare("select * from clientes where CodCliente=:CodCliente");
    $stm->execute(array(':CodCliente' => $_GET['CodCliente']));

    $cliente = $stm->fetch();

} else {
    $cliente = array(
        'CodCliente' => '',
        'DNI'       => '',
        'Apellidos'      => '',
        'Nombre'      => '',
        'Direccion'          => '',
        'Telefono'     => ''
    );
}

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
    <title>Editar clientes</title>
</head>
<body>
    <?php if (isset($errores) && count($errores) > 0): ?>
        <p>Existen errores:</p>
        <?php foreach ($errores as $error): ?>
            <li><?=$error?></li>
        <?php endforeach; ?>
    <?php endif; ?>

    <form action="form.php" method="post">
            <input type="hidden" name="CodCliente" value="<?=$cliente['CodCliente']?>">
            <p>
                <label for="CodCliente">CodCliente (automático): </label>
                <input type="text" name="CodCliente" id="CodCliente" placeholder="CodCliente" value="<?=$cliente['CodCliente']?>" readonly>
            </p>
            <p>
                <label for="DNI">DNI: </label>
                <input type="text" name="DNI" id="DNI" placeholder="DNI" value="<?=$cliente['DNI']?>">
            </p>
            <p>
                <label for="Apellidos">Apellidos: </label>
                <input type="text" name="Apellidos" id="Apellidos" placeholder="Apellidos" value="<?=$cliente['Apellidos']?>">
            </p>
            <p>
                <label for="Nombre">Nombre: </label>
                <input type="text" name="Nombre" id="Nombre" placeholder="Nombre" value="<?=$cliente['Nombre']?>">
            </p>
            <p>
                <label for="Direccion">Direccion: </label>
                <input type="text" name="Direccion" id="Direccion" placeholder="Direccion" value="<?=$cliente['Direccion']?>">
            </p>
            <p>
                <label for="Telefono">Telefono: </label>
                <input type="text" name="Telefono" id="Telefono" placeholder="Telefono" value="<?=$cliente['Telefono']?>">
            </p>
            
            
            <input type="submit" name="save" value="Guardar">
            <input type="submit" name="cancel" value="Cancelar">
        </form>
</body>
</html>