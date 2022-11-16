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
    $incluyen = array(
        'IdRecambio' => $_POST['IdRecambio'],
        'IdReparacion' => $_POST['IdReparacion'],
        'Unidades' => $_POST['Unidades']
    );

    $stm = $conn->prepare("SELECT * from incluyen order by SUBSTRING(IdRecambio,2,100)*1,IdReparacion");
    $stm->execute();
    $incluyen2 = $stm->fetchAll();

    $errores = array();
    if(strlen($incluyen['IdRecambio'])<=0) {
        $errores['IdRecambio'] = 'se debe indicar el IdRecambio';
    }
    if(strlen($incluyen['IdReparacion'])<=0) {
        $errores['IdReparacion'] = 'se debe indicar el IdReparacion';
    }

    if(count($errores) == 0){

        $coincide = false;

        foreach ($incluyen2 as $incluyen3) {  
            unset($incluyen3[0]);  
            unset($incluyen3[1]);  
            unset($incluyen3[2]);

            if ($incluyen['IdRecambio'] == $incluyen3['IdRecambio'] && $incluyen['IdReparacion'] == $incluyen3['IdReparacion']) {
                $coincide = true;
            }
        }

        if($coincide){
            $stm = $conn->prepare("UPDATE incluyen set Unidades=:Unidades where IdRecambio=:IdRecambio and IdReparacion=:IdReparacion");

        } else if (!$coincide) {           
            $stm = $conn->prepare("INSERT into incluyen (IdRecambio, IdReparacion, Unidades) values (:IdRecambio, :IdReparacion, :Unidades)");
        }

        $stm->execute($incluyen);
        $stm = null;
        $conn = null;
        header("location: show.php?IdRecambio=".$incluyen['IdRecambio']."&IdReparacion=".$incluyen['IdReparacion']);
        die();
    }
 
} else if (isset($_GET['IdRecambio']) and isset($_GET['IdReparacion'])){
    $stm = $conn->prepare("SELECT * from incluyen where IdRecambio=:IdRecambio and IdReparacion=:IdReparacion");
    $stm->execute(array(':IdRecambio' => $_GET['IdRecambio'],':IdReparacion' => $_GET['IdReparacion']));

    $incluyen = $stm->fetch();

} else {
    $incluyen = array(
        'IdRecambio' => '',
        'IdReparacion'       => '',
        'Unidades'      => ''
    );
}

$stm = $conn->prepare("select * from reparaciones order by IdReparacion");
$stm -> execute();
$reparaciones = $stm->fetchAll();

$stm = $conn->prepare("select * from recambios order by SUBSTRING(IdRecambio,2,100)*1");
$stm -> execute();
$recambios = $stm->fetchAll();

$stm = null;
$conn = null;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar incluyen</title>
</head>
<body>
    <?php if (isset($errores) && count($errores) > 0): ?>
        <p>Existen errores:</p>
        <?php foreach ($errores as $error): ?>
            <li><?=$error?></li>
        <?php endforeach; ?>
    <?php endif; ?>

    <form action="form.php" method="post">
            <input type="hidden" name="IdRecambio" value="<?=$incluyen['IdRecambio']?>">
            <input type="hidden" name="IdReparacion" value="<?=$incluyen['IdReparacion']?>">
            <p>
                <label for="IdRecambio">IdRecambio: </label>
                <select name="IdRecambio">
                    <?php foreach($recambios as $recambio): ?>
                        <option value="<?=$recambio['IdRecambio']?>"
                            <?=$incluyen['IdRecambio']==$recambio['IdRecambio']? 'selected': ''?>>
                            <?=$recambio['IdRecambio'].' - '.$recambio['Descripcion']?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>            
                <label for="IdReparacion">IdReparacion: </label>
                <select name="IdReparacion">
                    <?php foreach($reparaciones as $reparacion): ?>
                        <option value="<?=$reparacion['IdReparacion']?>"
                            <?=$incluyen['IdReparacion']==$reparacion['IdReparacion']? 'selected': ''?>>
                            <?=$reparacion['IdReparacion'].' - '.$reparacion['Matricula']?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </p> 
            <p>
                <label for="Unidades">Unidades: </label>
                <input type="text" name="Unidades" id="Unidades" placeholder="Unidades" value="<?=$incluyen['Unidades']?>">
            </p>
             
            
            <input type="submit" name="save" value="Guardar">
            <input type="submit" name="cancel" value="Cancelar">
        </form>
</body>
</html>