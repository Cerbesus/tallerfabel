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
    <link rel="stylesheet" href="../css/main.css">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
    <title>Taller Faber - Editar actuaciones</title>
</head>
<body>
    <!-- Barra de navegaci??n -->
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
          <i class="fa-solid fa-dollar-sign bi me-2" width="16" height="16"></i>
          Facturas
        </a>
      </li>
      <li>
        <a href="../vehiculos/list.php" class="nav-link text-white">
          <i class="fa-solid fa-car bi me-2" width="16" height="16"></i>
          Veh??culos
        </a>
      </li>
      <li>
        <a href="../reparaciones/list.php" class="nav-link text-white">
          <i class="fa-solid fa-file-pen bi me-2" width="16" height="16"></i>
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
          <i class="fa-solid fa-file-pen" width="16" height="16"></i>
          <i class="fa-solid fa-plus"></i>
          <i class="fa-solid fa-briefcase bi me-2" width="16" height="16"></i>
          Intervienen
        </a>
      </li>
      <li>
          <a href="../recambios/list.php" class="nav-link text-white">
            <i class="fa-solid fa-repeat bi me-2" width="16" height="16"></i>
            Recambios
          </a>
      </li>
      <li>
        <a href="../incluyen/list.php" class="nav-link text-white">
          <i class="fa-solid fa-file-pen" width="16" height="16"></i>
          <i class="fa-solid fa-plus"></i>
          <i class="fa-solid fa-repeat bi me-2" width="16" height="16"></i>
          Incluyen
        </a>
      </li>
      <li>
        <a href="../actuaciones/list.php" class="nav-link active">
          <i class="fa-solid fa-screwdriver-wrench bi me-2" width="16" height="16"></i>
          Actuaciones
        </a>
      </li>
      <li>
        <a href="../realizan/list.php" class="nav-link text-white">
          <i class="fa-solid fa-file-pen" width="16" height="16"></i>
          <i class="fa-solid fa-plus"></i>
          <i class="fa-solid fa-screwdriver-wrench bi me-2" width="16" height="16"></i>
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
        <li><a class="dropdown-item" href="../logout.php" onclick="cierreSesion()">Cerrar sesi??n</a></li>
      </ul>
    </div>
  </div>
  
  <div class="card border-0 scroll-mt-3 ">
    <div class="card-header">
      <h2>A??adir/Modificar Actuaci??n</h2>
    </div>
    <div class="card-body">
      <div class="row mb-4">
        <?php if (isset($errores) && count($errores) > 0): ?>
            <p>Existen errores:</p>
            <?php foreach ($errores as $error): ?>
                <li><?=$error?></li>
            <?php endforeach; ?>
        <?php endif; ?>
      </div>
      <form action="form.php" method="post">
        <input type="hidden" name="Referencia" value="<?=$actuacion['Referencia']?>">
        <div class="row mb-4">
          <div class="col-lg-3"><label for="Referencia" class="col-form-label">Referencia</label></div>
          <div class="col-lg"><input type="text" class="form-control" name="Referencia" id="Referencia" placeholder="Referencia" value="<?=$actuacion['Referencia']?>" readonly></div>
        </div>
        <div class="row mb-4">
          <div class="col-lg-3">
            <label for="Descripcion" class="col-form-label">Descripci??n</label>
          </div>
          <div class="col-lg">
            <input type="text" name="Descripcion" id="Descripcion" placeholder="Descripci??n" class="form-control" value="<?=$actuacion['Descripcion']?>">
          </div>
        </div>
        <div class="row mb-4">
          <div class="col-lg-3">
            <label for="TiempoEstimado" class="col-form-label">Tiempo estimado</label>
          </div>
          <div class="col-lg">
            <input type="text" name="TiempoEstimado" id="TiempoEstimado" placeholder="Tiempo estimado" class="form-control" value="<?=$actuacion['TiempoEstimado']?>">
          </div>
        </div>
        <div class="row mb-4">
          <div class="col-lg-3">
            <label for="Importe" class="col-form-label">Importe</label>
          </div>
          <div class="col-lg">
            <input type="text" name="Importe" id="Importe" placeholder="Importe" class="form-control" value="<?=$actuacion['Importe']?>">
          </div>
        </div>    
        <div class="d-flex justify-content-end mt-5">
          <input type="submit" class="btn btn-primary" name="save" value="Guardar">
          <input type="submit" class="btn btn-danger" name="cancel" value="Cancelar">
        </div>
      </form>
    </div>
  </div>

  
  
</body>
</html>