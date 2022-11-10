<?php declare(strict_types=1);

if(isset($_POST['cancel'])) {
   header("location: list.php");
   die();
} 

$conn = require "../database.php";

if (isset($_POST['save'])) {
    $realizan = array(
        'Referencia' => $_POST['Referencia'],
        'IdReparacion' => $_POST['IdReparacion'],
        'Horas' => $_POST['Horas']
    );

    $stm = $conn->prepare("SELECT * from realizan order by IdReparacion,SUBSTRING(Referencia,2,100)*1");
    $stm->execute();
    $realizan2 = $stm->fetchAll();

    $errores = array();
    if(strlen($realizan['Referencia'])<=0) {
        $errores['Referencia'] = 'se debe indicar el Referencia';
    }
    if(strlen($realizan['IdReparacion'])<=0) {
        $errores['IdReparacion'] = 'se debe indicar el IdReparacion';
    }

    if(count($errores) == 0){

        $coincide = false;

        foreach ($realizan2 as $realizan3) {  
            unset($realizan3[0]);  
            unset($realizan3[1]);  
            unset($realizan3[2]);

            if ($realizan['Referencia'] == $realizan3['Referencia'] && $realizan['IdReparacion'] == $realizan3['IdReparacion']) {
                $coincide = true;
            }
        }

        if($coincide){
            $stm = $conn->prepare("UPDATE realizan set Horas=:Horas where Referencia=:Referencia and IdReparacion=:IdReparacion");

        } else if (!$coincide) {           
            $stm = $conn->prepare("INSERT into realizan (Referencia, IdReparacion, Horas) values (:Referencia, :IdReparacion, :Horas)");
        }

        $stm->execute($realizan);
        $stm = null;
        $conn = null;
        header("location: show.php?Referencia=".$realizan['Referencia']."&IdReparacion=".$realizan['IdReparacion']);
        die();
    }
 
} else if (isset($_GET['Referencia']) and isset($_GET['IdReparacion'])){
    $stm = $conn->prepare("SELECT * from realizan where Referencia=:Referencia and IdReparacion=:IdReparacion");
    $stm->execute(array(':Referencia' => $_GET['Referencia'],':IdReparacion' => $_GET['IdReparacion']));

    $realizan = $stm->fetch();

} else {
    $realizan = array(
        'Referencia' => '',
        'IdReparacion'       => '',
        'Horas'      => ''
    );
}

$stm = $conn->prepare("select * from reparaciones order by IdReparacion");
$stm -> execute();
$reparaciones = $stm->fetchAll();

$stm = $conn->prepare("select * from actuaciones order by Referencia,SUBSTRING(Referencia,2,100)*1");
$stm -> execute();
$actuaciones = $stm->fetchAll();

$stm = null;
$conn = null;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar realizan</title>
</head>
<body>
    <?php if (isset($errores) && count($errores) > 0): ?>
        <p>Existen errores:</p>
        <?php foreach ($errores as $error): ?>
            <li><?=$error?></li>
        <?php endforeach; ?>
    <?php endif; ?>

    <form action="form.php" method="post">
            <input type="hidden" name="Referencia" value="<?=$realizan['Referencia']?>">
            <input type="hidden" name="IdReparacion" value="<?=$realizan['IdReparacion']?>">
            <p>            
                <label for="IdReparacion">IdReparacion: </label>
                <select name="IdReparacion">
                    <?php foreach($reparaciones as $reparacion): ?>
                        <option value="<?=$reparacion['IdReparacion']?>"
                        <?=$realizan['IdReparacion']==$reparacion['IdReparacion']? 'selected': ''?>>
                        <?=$reparacion['IdReparacion'].' - '.$reparacion['Matricula']?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </p> 
            <p>
                <label for="Referencia">Referencia: </label>
                <select name="Referencia">
                    <?php foreach($actuaciones as $actuacion): ?>
                        <option value="<?=$actuacion['Referencia']?>"
                            <?=$realizan['Referencia']==$actuacion['Referencia']? 'selected': ''?>>
                            <?=$actuacion['Referencia'].' - '.$actuacion['Descripcion']?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <label for="Horas">Horas: </label>
                <input type="text" name="Horas" id="Horas" placeholder="Horas" value="<?=$realizan['Horas']?>">
            </p>
             
            
            <input type="submit" name="save" value="Guardar">
            <input type="submit" name="cancel" value="Cancelar">
        </form>
</body>
</html>