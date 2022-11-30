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
    <link rel="stylesheet" href="../css/main.css">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>

    <title>Taller Faber - Editar recambios</title>
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
          <i class="fa-solid fa-dollar-sign bi me-2" width="16" height="16"></i>
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
          <a href="../recambios/list.php" class="nav-link active">
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
        <a href="../actuaciones/list.php" class="nav-link text-white">
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
        <li><a class="dropdown-item" href="../logout.php" onclick="cierreSesion()">Cerrar sesión</a></li>
      </ul>
    </div>
  </div>

  <div class="card border-0 scroll-mt-3">
    <div class="card-header">
      <h2>Añadir/Modificar Recambio</h2>
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
      <input type="hidden" name="IdRecambio" value="<?=$recambio['IdRecambio']?>">
      
      <div class="row mb-4">
        <div class="col-lg-3"><label class="col-form-label" for="IdRecambio">Id</label></div>
        <div class="col-lg"><input class="form-control" type="text" name="IdRecambio" id="IdRecambio" placeholder="IdRecambio" value="<?=$recambio['IdRecambio']?>" readonly></div>
      </div>
      <div class="row mb-4">
        <div class="col-lg-4"><label class="col-form-label" for="Descripcion">Descripción</label></div>
        <div class="col-lg"><input class="form-control" type="text" name="Descripcion" id="Descripcion" placeholder="Descripcion" value="<?=$recambio['Descripcion']?>"></div>
      </div>
      <div class="row mb-4">
        <div class="col-lg-3"><label class="col-form-label" for="UnidadBase">Unidad base</label></div>
        <div class="col-lg"><input class="form-control" type="text" name="UnidadBase" id="UnidadBase" placeholder="UnidadBase" value="<?=$recambio['UnidadBase']?>"></div>
      </div>
      <div class="row mb-4">
        <div class="col-lg-3"><label class="col-form-label" for="Stock">Stock</label></div>
        <div class="col-lg"><input class="form-control" type="text" name="Stock" id="Stock" placeholder="Stock" value="<?=$recambio['Stock']?>"></div>
      </div>
      <div class="row mb-4">
        <div class="col-lg-3"><label class="col-form-label" for="PrecioReferencia">Precio</label></div>
        <div class="col-lg"><input class="form-control" type="text" name="PrecioReferencia" id="PrecioReferencia" placeholder="PrecioReferencia" value="<?=$recambio['PrecioReferencia']?>">            </div>
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