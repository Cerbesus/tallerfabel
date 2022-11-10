<?php declare(strict_types=1);

if(isset($_POST['cancel'])) {
   header("location: list.php");
   die();
} 

$conn = require "../database.php";

if (isset($_POST['save'])) {
    $vehiculo = array(
        'Matricula' => $_POST['Matricula'],
        'Marca' => $_POST['Marca'],
        'Modelo' => $_POST['Modelo'],
        'Color' => $_POST['Color'],
        'FechaMatriculacion' => $_POST['FechaMatriculacion'],
        'CodCliente' => $_POST['CodCliente']
    );

    $errores = array();
    if(strlen($vehiculo['Matricula'])<=0) {
        $errores['Matricula'] = 'se debe indicar el Matricula';
    }
 
    if(count($errores) == 0){
        if(strlen($vehiculo['Matricula']) >0){
            $stm = $conn->prepare("update vehiculos set Marca=:Marca, Modelo=:Modelo, Color=:Color, FechaMatriculacion=:FechaMatriculacion, CodCliente=:CodCliente  where Matricula=:Matricula");

        } else {

            // $stm=$conn->prepare("select max(Matricula) as maxMatricula from vehiculos");
            // $stm->execute();
            // $result=$stm->fetch();

            $vehiculo['Matricula'] = $_POST['Matricula'];
            
            return $stm = $conn->prepare("INSERT INTO vehiculos (Matricula,Marca,Modelo,Color,FechaMatriculacion,CodCliente) VALUES (:Matricula,:Marca,:Modelo,:Color,:FechaMatriculacion,:CodCliente)");
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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