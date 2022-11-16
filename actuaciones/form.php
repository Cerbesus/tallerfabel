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
    $actuacion = array(
        'Referencia' => $_POST['Referencia'],
        'Descripcion' => $_POST['Descripcion'],
        'TiempoEstimado' => $_POST['TiempoEstimado'],
        'Importe' => $_POST['Importe']
    );

    $errores = array();
 
    if(count($errores) == 0){
        if(strlen($actuacion['Referencia']) >0){
            $stm = $conn->prepare("update actuaciones set TiempoEstimado=:TiempoEstimado,Descripcion=:Descripcion, Importe=:Importe where Referencia=:Referencia");

        } else {

            $stm=$conn->prepare("select max(SUBSTRING(Referencia,2,100)*1) as maxReferencia from actuaciones");
            $stm->execute();
            $result=$stm->fetch();

            $actuacion['Referencia'] = "A".$result['maxReferencia'] + 1;
            
            $stm = $conn->prepare("insert into actuaciones (Referencia, Descripcion, TiempoEstimado, Importe) values (:Referencia, :Descripcion, :TiempoEstimado, :Importe)");
        }

        $stm->execute($actuacion);
        $stm = null;
        $conn = null;
        header("location: show.php?Referencia=".$actuacion['Referencia']);
        die();
    }
} else if (isset($_GET['Referencia'])){
    $stm = $conn->prepare("select * from actuaciones where Referencia=:Referencia");
    $stm->execute(array(':Referencia' => $_GET['Referencia']));

    $actuacion = $stm->fetch();

} else {
    $actuacion = array(
        'Referencia' => '',
        'Descripcion'       => '',
        'TiempoEstimado'      => '',
        'Importe'      => ''
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
    <title>Editar actuaciones</title>
</head>
<body>
    <?php if (isset($errores) && count($errores) > 0): ?>
        <p>Existen errores:</p>
        <?php foreach ($errores as $error): ?>
            <li><?=$error?></li>
        <?php endforeach; ?>
    <?php endif; ?>

    <form action="form.php" method="post">
            <input type="hidden" name="Referencia" value="<?=$actuacion['Referencia']?>">
            <p>
                <label for="Referencia">Referencia (automático): </label>
                <input type="text" name="Referencia" id="Referencia" placeholder="Referencia" value="<?=$actuacion['Referencia']?>" readonly>
            </p>
            <p>
                <label for="Descripcion">Descripcion: </label>
                <input type="text" name="Descripcion" id="Descripcion" placeholder="Descripcion" value="<?=$actuacion['Descripcion']?>">
            </p>
            <p>
                <label for="TiempoEstimado">TiempoEstimado: </label>
                <input type="text" name="TiempoEstimado" id="TiempoEstimado" placeholder="TiempoEstimado" value="<?=$actuacion['TiempoEstimado']?>">
            </p>
            <p>
                <label for="Importe">Importe: </label>
                <input type="text" name="Importe" id="Importe" placeholder="Importe" value="<?=$actuacion['Importe']?>">
            </p>        
            
            <input type="submit" name="save" value="Guardar">
            <input type="submit" name="cancel" value="Cancelar">
        </form>
</body>
</html>