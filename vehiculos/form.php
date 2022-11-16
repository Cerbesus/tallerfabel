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

$stm = $conn->prepare("select * from vehiculos");
$stm -> execute();
$vehiculos = $stm->fetchAll();


if (isset($_POST['save'])) {
    $vehiculo = array(
        'Matricula' => $_POST['Matricula'],
        'Marca' => $_POST['Marca'],
        'Modelo' => $_POST['Modelo'],
        'Color' => $_POST['Color'],
        'FechaMatriculacion' => $_POST['FechaMatriculacion'],
        'CodCliente' => $_POST['CodCliente']
    );

    foreach ($vehiculos as $v) {
        if(in_array($vehiculo['Matricula'], $v)){
            $existe = true;
        }
    }

    $errores = array();
    if(strlen($vehiculo['Matricula'])<=0) {
        $errores['Matricula'] = 'se debe indicar el Matricula';
    }

    $hola = in_array($vehiculo['Matricula'], $vehiculos);
    

    if(count($errores) == 0){
        if($existe){
            $stm = $conn->prepare("update vehiculos set Marca=:Marca, Modelo=:Modelo, Color=:Color, FechaMatriculacion=:FechaMatriculacion, CodCliente=:CodCliente where Matricula=:Matricula");

        } else {           
            $stm = $conn->prepare("INSERT INTO vehiculos (Matricula,Marca,Modelo,Color,FechaMatriculacion,CodCliente) VALUES (:Matricula,:Marca,:Modelo,:Color,:FechaMatriculacion,:CodCliente)");
        }

        $stm->execute($vehiculo);
        $stm = null;
        $conn = null;
        header("location: show.php?Matricula=".$vehiculo['Matricula']);
        die();
    }
} else if (isset($_GET['Matricula'])){
    $stm = $conn->prepare("select * from vehiculos where Matricula=:Matricula");
    $stm->execute(array(':Matricula' => $_GET['Matricula']));

    $vehiculo = $stm->fetch();

} else {
    $vehiculo = array(
        'Matricula' => '',
        'Marca'       => '',
        'Modelo'      => '',
        'Color'      => '',
        'FechaMatriculacion'      => '',
        'CodCliente'      => ''
    );
}

$stm = $conn->prepare("select * from clientes");
$stm -> execute();
$clientes = $stm->fetchAll();

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
    <title>Editar reparaciones</title>
</head>
<body>
    <?php if (isset($errores) && count($errores) > 0): ?>
        <p>Existen errores:</p>
        <?php foreach ($errores as $error): ?>
            <li><?=$error?></li>
        <?php endforeach; ?>
    <?php endif; ?>

    <form action="form.php" method="post">
            <input type="hidden" name="Matricula" value="<?=$vehiculo['Matricula']?>">
            <p>
                <label for="Matricula">Matricula (automático): </label>
                <input type="text" name="Matricula" id="Matricula" placeholder="Matricula" value="<?=$vehiculo['Matricula']?>">
            </p>
            <p>
                <label for="Marca">Marca: </label>
                <input type="text" name="Marca" id="Marca" placeholder="Marca" value="<?=$vehiculo['Marca']?>">
            </p>
            <p>
                <label for="Modelo">Modelo: </label>
                <input type="text" name="Modelo" id="Modelo" placeholder="Modelo" value="<?=$vehiculo['Modelo']?>">
            </p>
            <p>
                <label for="Color">Color: </label>
                <input type="text" name="Color" id="Color" placeholder="Color" value="<?=$vehiculo['Color']?>">
            </p>
            <p>
                <label for="FechaMatriculacion">FechaMatriculacion: </label>
                <input type="text" name="FechaMatriculacion" id="FechaMatriculacion" placeholder="FechaMatriculacion" value="<?=$vehiculo['FechaMatriculacion']?>">
            </p>
            <p>
              <label for="CodCliente">CodCliente: </label>
              <select name="CodCliente">
               <?php foreach($clientes as $cliente): ?>
                <option value="<?=$cliente['CodCliente']?>"
                    <?=$vehiculo['CodCliente']==$cliente['CodCliente']? 'selected': ''?>>
                    <?=$cliente['CodCliente'].' - '.$cliente['Nombre']?>
                </option>
              <?php endforeach; ?>
             </select>
            </p>        
            
            <input type="submit" name="save" value="Guardar">
            <input type="submit" name="cancel" value="Cancelar">
        </form>
</body>
</html>