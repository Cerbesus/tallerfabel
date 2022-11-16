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
    $intervienen = array(
        'CodEmpleado' => $_POST['CodEmpleado'],
        'IdReparacion' => $_POST['IdReparacion'],
        'Horas' => $_POST['Horas']
    );

    $stm = $conn->prepare("SELECT * from intervienen");
    $stm->execute();
    $intervienen2 = $stm->fetchAll();

    $errores = array();
    if(strlen($intervienen['CodEmpleado'])<=0) {
        $errores['CodEmpleado'] = 'se debe indicar el CodEmpleado';
    }
    if(strlen($intervienen['IdReparacion'])<=0) {
        $errores['IdReparacion'] = 'se debe indicar el IdReparacion';
    }

    if(count($errores) == 0){

        $coincide = false;

        foreach ($intervienen2 as $intervienen3) {  
            unset($intervienen3[0]);  
            unset($intervienen3[1]);  
            unset($intervienen3[2]);

            if ($intervienen['CodEmpleado'] == $intervienen3['CodEmpleado'] && $intervienen['IdReparacion'] == $intervienen3['IdReparacion']) {
                $coincide = true;
            }
        }

        if($coincide){
            $stm = $conn->prepare("UPDATE intervienen set Horas=:Horas where CodEmpleado=:CodEmpleado and IdReparacion=:IdReparacion");

        } else if (!$coincide) {           
            $stm = $conn->prepare("INSERT into intervienen (CodEmpleado, IdReparacion, Horas) values (:CodEmpleado, :IdReparacion, :Horas)");
        }

        $stm->execute($intervienen);
        $stm = null;
        $conn = null;
        header("location: show.php?CodEmpleado=".$intervienen['CodEmpleado']."&IdReparacion=".$intervienen['IdReparacion']);
        die();
    }
 
} else if (isset($_GET['CodEmpleado']) and isset($_GET['IdReparacion'])){
    $stm = $conn->prepare("SELECT * from intervienen where CodEmpleado=:CodEmpleado and IdReparacion=:IdReparacion");
    $stm->execute(array(':CodEmpleado' => $_GET['CodEmpleado'],':IdReparacion' => $_GET['IdReparacion']));

    $intervienen = $stm->fetch();

} else {
    $intervienen = array(
        'CodEmpleado' => '',
        'IdReparacion'       => '',
        'Horas'      => ''
    );
}

$stm = $conn->prepare("select * from reparaciones order by (IdReparacion)");
$stm -> execute();
$reparaciones = $stm->fetchAll();

$stm = $conn->prepare("select * from empleados order by SUBSTRING(CodEmpleado,2,100)*1");
$stm -> execute();
$empleados = $stm->fetchAll();

$stm = null;
$conn = null;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar intervienen</title>
</head>
<body>
    <?php if (isset($errores) && count($errores) > 0): ?>
        <p>Existen errores:</p>
        <?php foreach ($errores as $error): ?>
            <li><?=$error?></li>
        <?php endforeach; ?>
    <?php endif; ?>

    <form action="form.php" method="post">
            <input type="hidden" name="CodEmpleado" value="<?=$intervienen['CodEmpleado']?>">
            <input type="hidden" name="IdReparacion" value="<?=$intervienen['IdReparacion']?>">
            <p>
            <label for="CodEmpleado">CodEmpleado: </label>
                <select name="CodEmpleado">
                    <?php foreach($empleados as $empleado): ?>
                        <option value="<?=$empleado['CodEmpleado']?>"
                            <?=$intervienen['CodEmpleado']==$empleado['CodEmpleado']? 'selected': ''?>>
                            <?=$empleado['CodEmpleado'].' - '.$empleado['DNI'].' '.$empleado['Nombre'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>              
            <label for="IdReparacion">IdReparacion: </label>
                <select name="IdReparacion">
                    <?php foreach($reparaciones as $reparacion): ?>
                        <option value="<?=$reparacion['IdReparacion']?>"
                            <?=$intervienen['IdReparacion']==$reparacion['IdReparacion']? 'selected': ''?>>
                            <?=$reparacion['IdReparacion'].' - '.$reparacion['Matricula']?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </p> 
            <p>
                <label for="Horas">Horas: </label>
                <input type="text" name="Horas" id="Horas" placeholder="Horas" value="<?=$intervienen['Horas']?>">
            </p>
             
            
            <input type="submit" name="save" value="Guardar">
            <input type="submit" name="cancel" value="Cancelar">
        </form>
</body>
</html>