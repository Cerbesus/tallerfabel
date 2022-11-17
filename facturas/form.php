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
    $factura = array(
        'IdFactura' => $_POST['IdFactura'],
        'FechaFactura' => $_POST['FechaFactura'],
        'CodCliente' => $_POST['CodCliente'],
        'IdReparacion' => $_POST['IdReparacion']
    );

    $errores = array();
    if(strlen($factura['FechaFactura'])<=0) {
        $errores['FechaFactura'] = 'se debe indicar el FechaFactura';
    }
    if(strlen($factura['CodCliente'])<=0) {
        $errores['CodCliente'] = 'se debe indicar el CodCliente';
    }
 
    if(count($errores) == 0){
        if(strlen($factura['IdFactura']) >0){
            $stm = $conn->prepare("update facturas set CodCliente=:CodCliente,FechaFactura=:FechaFactura, IdReparacion=:IdReparacion where IdFactura=:IdFactura");

        } else {

            $stm=$conn->prepare("select max(IdFactura) as maxIdFactura from facturas");
            $stm->execute();
            $result=$stm->fetch();

            $factura['IdFactura'] = $result['maxIdFactura'] + 1;
            
            $stm = $conn->prepare("insert into facturas (IdFactura, FechaFactura, CodCliente, IdReparacion) values (:IdFactura, :FechaFactura, :CodCliente, :IdReparacion)");
        }

        $stm->execute($factura);
        $stm = null;
        $conn = null;
        header("location: show.php?IdFactura=".$factura['IdFactura']);
        die();
    }
} else if (isset($_GET['IdFactura'])){
    $stm = $conn->prepare("select * from facturas where IdFactura=:IdFactura");
    $stm->execute(array(':IdFactura' => $_GET['IdFactura']));

    $factura = $stm->fetch();

} else {
    $factura = array(
        'IdFactura' => '',
        'FechaFactura'       => '',
        'CodCliente'      => '',
        'IdReparacion'      => ''
    );
}

$stm = $conn->prepare("select * from clientes");
$stm -> execute();
$clientes = $stm->fetchAll();

$stm = $conn->prepare("select * from reparaciones");
$stm -> execute();
$reparaciones = $stm->fetchAll();

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

    <title>Editar facturas</title>
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
        <a href="../facturas/list.php" class="nav-link active">
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
    <?php if (isset($errores) && count($errores) > 0): ?>
        <p>Existen errores:</p>
        <?php foreach ($errores as $error): ?>
            <li><?=$error?></li>
        <?php endforeach; ?>
    <?php endif; ?>

    <form action="form.php" method="post">
            <input type="hidden" name="IdFactura" value="<?=$factura['IdFactura']?>">
            <p>
                <label for="IdFactura">IdFactura (automático): </label>
                <input type="text" name="IdFactura" id="IdFactura" placeholder="IdFactura" value="<?=$factura['IdFactura']?>" readonly>
            </p>
            <p>
                <label for="FechaFactura">FechaFactura: </label>
                <input type="text" name="FechaFactura" id="FechaFactura" placeholder="YYYY-MM-DD" value="<?=$factura['FechaFactura']?>">
            </p>
            <p>
              <label for="CodCliente">CodCliente: </label>
              <select name="CodCliente">
               <?php foreach($clientes as $cliente): ?>
                <option value="<?=$cliente['CodCliente']?>"
                    <?=$factura['CodCliente']==$cliente['CodCliente']? 'selected': ''?>>
                    <?=$cliente['CodCliente'].' - '.$cliente['Nombre']?>
                </option>
              <?php endforeach; ?>
             </select>
            </p>
            <p>
              <label for="IdReparacion">IdReparacion: </label>
              <select name="IdReparacion">
               <?php foreach($reparaciones as $reparacion): ?>
                <option value="<?=$reparacion['IdReparacion']?>"
                    <?=$factura['IdReparacion']==$reparacion['IdReparacion']? 'selected': ''?>>
                    <?=$reparacion['IdReparacion'].' - '.$reparacion['Matricula']?>
                </option>
              <?php endforeach; ?>
             </select>
            </p>

            
            
            <input type="submit" name="save" value="Guardar">
            <input type="submit" name="cancel" value="Cancelar">
        </form>
</body>
</html>