<?php declare(strict_types=1);

if (isset($_POST['cancel'])) { // el usuario cancela la posible modificación
    header("location: list.php");
    die();
} 

$conn = require "../database.php";

if (isset($_POST['save'])) { //guarda una oficina nueva o modifica una ya registrada
    $reparacion = array(
        'IdReparacion' => $_POST['IdReparacion'],
        'Matricula' => $_POST['Matricula'],
        'FechaEntrada' => $_POST['FechaEntrada'],
        'Km' => $_POST['Km'],
        'Averia' => $_POST['Averia'],
        'FechaSalida' => $_POST['FechaSalida'],
        'Reparado' => $_POST['Reparado'],
        'Observaciones' => $_POST['Observaciones'],
    );


  //validación
  $errores = array();

  if (strlen($reparacion['Matricula']) <=0) {
    $errores['Matricula'] = 'Se debe indicar la Matricula';
  }

  if (count($errores) == 0) {
    if (strlen($reparacion['IdReparacion']) > 0) { //se desea modificar una oficina ya registrada porque ya tiene un codigo asignado
        $stm = $conn->prepare("UPDATE reparaciones SET IdReparacion=:IdReparacion,Matricula=:Matricula, FechaEntrada=:FechaEntrada, Km=:Km, Averia=:Averia, FechaSalida=:FechaSalida, Reparado=:Reparado, Observaciones=:Observaciones WHERE IdReparacion=:IdReparacion");

    } else { //se crea una nueva oficina
        $stm = $conn->prepare("SELECT max(IdReparacion) as maxIdReparacion from reparaciones");
        $stm->execute();
        $result=$stm->fetch();

        $reparacion['IdReparacion'] = $result['maxIdReparacion'] + 1; //el código de la nueva oficina se asigna directamente

        $stm = $conn->prepare("INSERT into reparaciones (IdReparacion, Matricula, FechaEntrada,Km,Averia,FechaSalida,Reparado,Observaciones) values (:IdReparacion, :Matricula, :FechaEntrada,:Km,:Averia,:FechaSalida,:Reparado,:Observaciones)");
        //se inserta la oficina en la base de datos
        }

        $stm->execute($reparacion);
        $stm = null;
        $conn = null;
        header("location: show.php?IdReparacion=".$reparacion['IdReparacion']);
        die();
    }
} else if (isset($_GET['IdReparacion'])) { // modificar una oficina ya registrada

    $stm = $conn->prepare("select * from reparaciones where IdReparacion =:IdReparacion");
    $stm->execute(array(':IdReparacion' => $_GET['IdReparacion']));

    $reparacion = $stm->fetch();

}else{ //se desea crear una nueva oficina
    $reparacion = array(
        'IdReparacion' => '',
        'Matricula' => '',
        'FechaEntrada' => '',
        'Km' => '',
        'Averia' => '',
        'FechaSalida' => '',
        'Reparado' => '',
        'Observaciones' => ''
    );
}

$stm = $conn->prepare("select * from vehiculos");
$stm -> execute();
$vehiculos = $stm->fetchAll();

$stm = null;
$conn = null;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar reparacion</title>
</head>
<body>
    <?php if (isset($errores) && count($errores) > 0): ?>
        <p>Existen errores:</p>
        <?php foreach ($errores as $error): ?>
            <li><?=$error?></li>
        <?php endforeach; ?>
    <?php endif; ?>

    <form action="form.php" method="post">
        <input type="hidden" name="IdReparacion" value="<?=$reparacion['IdReparacion']?>">
        <p>
            <label for="IdReparacion">IdReparacion</label>
            <input type="text" name="IdReparacion" id="IdReparacion" value="<?=$reparacion['IdReparacion']?>" readonly>
        </p>
        <p>
            <label for="Matricula">Matricula: </label>
            <select name="Matricula">
                <?php foreach($vehiculos as $vehiculo): ?>
                    <option value="<?=$vehiculo['Matricula']?>"
                        <?=$reparacion['Matricula']==$vehiculo['Matricula']? 'selected': ''?>>
                        <?=$vehiculo['Matricula'].' - '.$vehiculo['Marca'].' '.$vehiculo['Modelo'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>  
        <p>
            <label for="FechaEntrada">FechaEntrada</label>
            <input type="text" name="FechaEntrada" id="FechaEntrada" value="<?=$reparacion['FechaEntrada']?>">
        </p>
        <p>
            <label for="Km">Km</label>
            <input type="text" name="Km" id="Km" value="<?=$reparacion['Km']?>">
        </p>
        <p>
            <label for="Averia">Averia</label>
            <input type="text" name="Averia" id="Averia" value="<?=$reparacion['Averia']?>">
        </p>
        <p>
            <label for="FechaSalida">FechaSalida</label>
            <input type="text" name="FechaSalida" id="FechaSalida" value="<?=$reparacion['FechaSalida']?>">
        </p>
        <p>
            <label for="Reparado">Reparado</label>
            <input type="text" name="Reparado" id="Reparado" value="<?=$reparacion['Reparado']?>">
        </p>
        <p>
            <label for="Observaciones">Observaciones</label>
            <input type="text" name="Observaciones" id="Observaciones" value="<?=$reparacion['Observaciones']?>">
        </p>

        <input type="submit" name="save" value="Guardar">
        <input type="submit" name="cancel" value="Cancelar">
    </form>
</body>
</html>