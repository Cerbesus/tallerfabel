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
    $recambio = array(
        'IdRecambio' => $_POST['IdRecambio'],
        'Descripcion' => $_POST['Descripcion'],
        'UnidadBase' => $_POST['UnidadBase'],
        'Stock' => $_POST['Stock'],
        'PrecioReferencia' => $_POST['PrecioReferencia']
    );

    $errores = array();
 
    if(count($errores) == 0){
        if(strlen($recambio['IdRecambio']) >0){
            $stm = $conn->prepare("update recambios set UnidadBase=:UnidadBase,Descripcion=:Descripcion, Stock=:Stock, PrecioReferencia=:PrecioReferencia where IdRecambio=:IdRecambio");

        } else {

            $stm=$conn->prepare("select max(SUBSTRING(IdRecambio,2,100)*1) as maxIdRecambio from recambios");
            $stm->execute();
            $result=$stm->fetch();

            $recambio['IdRecambio'] = "R".$result['maxIdRecambio'] + 1;
            
            $stm = $conn->prepare("insert into recambios (IdRecambio, Descripcion, UnidadBase, Stock, PrecioReferencia) values (:IdRecambio, :Descripcion, :UnidadBase, :Stock, :PrecioReferencia)");
        }

        $stm->execute($recambio);
        $stm = null;
        $conn = null;
        header("location: show.php?IdRecambio=".$recambio['IdRecambio']);
        die();
    }
} else if (isset($_GET['IdRecambio'])){
    $stm = $conn->prepare("select * from recambios where IdRecambio=:IdRecambio");
    $stm->execute(array(':IdRecambio' => $_GET['IdRecambio']));

    $recambio = $stm->fetch();

} else {
    $recambio = array(
        'IdRecambio' => '',
        'Descripcion'       => '',
        'UnidadBase'      => '',
        'Stock'      => '',
        'PrecioReferencia'          => ''
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
    <title>Editar recambios</title>
</head>
<body>
    <?php if (isset($errores) && count($errores) > 0): ?>
        <p>Existen errores:</p>
        <?php foreach ($errores as $error): ?>
            <li><?=$error?></li>
        <?php endforeach; ?>
    <?php endif; ?>

    <form action="form.php" method="post">
            <input type="hidden" name="IdRecambio" value="<?=$recambio['IdRecambio']?>">
            <p>
                <label for="IdRecambio">IdRecambio (automático): </label>
                <input type="text" name="IdRecambio" id="IdRecambio" placeholder="IdRecambio" value="<?=$recambio['IdRecambio']?>" readonly>
            </p>
            <p>
                <label for="Descripcion">Descripcion: </label>
                <input type="text" name="Descripcion" id="Descripcion" placeholder="Descripcion" value="<?=$recambio['Descripcion']?>">
            </p>
            <p>
                <label for="UnidadBase">UnidadBase: </label>
                <input type="text" name="UnidadBase" id="UnidadBase" placeholder="UnidadBase" value="<?=$recambio['UnidadBase']?>">
            </p>
            <p>
                <label for="Stock">Stock: </label>
                <input type="text" name="Stock" id="Stock" placeholder="Stock" value="<?=$recambio['Stock']?>">
            </p>
            <p>
                <label for="PrecioReferencia">PrecioReferencia: </label>
                <input type="text" name="PrecioReferencia" id="PrecioReferencia" placeholder="PrecioReferencia" value="<?=$recambio['PrecioReferencia']?>">
            </p>            
            
            <input type="submit" name="save" value="Guardar">
            <input type="submit" name="cancel" value="Cancelar">
        </form>
</body>
</html>