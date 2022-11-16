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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/main.css">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>

    <title>Editar incluyen</title>
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
        <a href="../incluyen/list.php" class="nav-link active">
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