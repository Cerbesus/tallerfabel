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
    <title>Editar realizan</title>
</head>
<body>
    <!-- Barra de navegación -->
    <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px; min-height: 100vh;">
    <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
      <img class="bi me-2" width="40" height="40" src="../img/logo.png" alt="">
      <span class="fs-4">Taller Faber</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
      <li class="nav-item">
        <a href="../main.php" class="nav-link text-white" aria-current="page">
          <i class="fa-solid fa-house bi me-2" width="16" height="16"></i>
          Inicio
        </a>
      </li>
      <li>
        <a href="../clientes/list.php" class="nav-link text-white">
          <i class="fa-solid fa-user bi me-2" width="16" height="16"></i>
          Clientes
        </a>
      </li>
      <li>
        <a href="../facturas/list.php" class="nav-link text-white">
          <i class="fa-solid fa-file bi me-2" width="16" height="16"></i>
          Facturas
        </a>
      </li>
      <li>
        <a href="../vehiculos/list.php" class="nav-link text-white">
          <i class="fa-solid fa-car bi me-2" width="16" height="16"></i>
          Vehículos
        </a>
      </li>
      <li>
        <a href="../reparaciones/list.php" class="nav-link text-white">
          <i class="fa-solid fa-screwdriver-wrench bi me-2" width="16" height="16"></i>
          Reparaciones
        </a>
      </li>
      <li>
        <a href="../empleados/list.php" class="nav-link text-white">
          <i class="fa-solid fa-briefcase bi me-2" width="16" height="16"></i>
          Empleados
        </a>
      </li>
      <li>
        <a href="../intervienen/list.php" class="nav-link text-white">
          <i class="fa-solid fa-screwdriver-wrench" width="16" height="16"></i>
          <i class="fa-solid fa-plus"></i>
          <i class="fa-solid fa-briefcase bi me-2" width="16" height="16"></i>
          Intervienen
        </a>
      </li>
      <li>
          <a href="../recambios/list.php" class="nav-link text-white">
            <i class="fa-solid fa-rotate-right bi me-2" width="16" height="16"></i>
            Recambios
          </a>
      </li>
      <li>
        <a href="../incluyen/list.php" class="nav-link text-white">
          <i class="fa-solid fa-screwdriver-wrench" width="16" height="16"></i>
          <i class="fa-solid fa-plus"></i>
          <i class="fa-solid fa-rotate-right bi me-2" width="16" height="16"></i>
          Incluyen
        </a>
      </li>
      <li>
        <a href="../actuaciones/list.php" class="nav-link text-white">
          <i class="fa-solid fa-ticket bi me-2" width="16" height="16"></i>
          Actuaciones
        </a>
      </li>
      <li>
        <a href="../realizan/list.php" class="nav-link text-white">
          <i class="fa-solid fa-screwdriver-wrench" width="16" height="16"></i>
          <i class="fa-solid fa-plus"></i>
          <i class="fa-solid fa-ticket bi me-2" width="16" height="16"></i>
          Realizan
        </a>
      </li>
    </ul>
    <hr>
    <div class="dropdown">
      <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="../img/profile.jpg" alt="" width="32" height="32" class="rounded-circle me-2">
        <strong><?=$_SESSION['user']?></strong>
      </a>
      <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
        <li><a class="dropdown-item" href="#">Preferencias</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="logout.php" onclick="cierreSesion()">Cerrar sesión</a></li>
      </ul>
    </div>
  </div>
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