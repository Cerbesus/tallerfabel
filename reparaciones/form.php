<?php declare(strict_types=1);

if (isset($_POST['cancel'])) { // el usuario cancela la posible modificación
    header("location: list.php");
} else if (isset($_POST['save'])) { //guarda una oficina nueva o modifica una ya registrada
    $office = array(
        'currentOfficeCode' => $_POST['currentOfficeCode'],
        'officeCode' => $_POST['officeCode'],
        'city'       => $_POST['city'],
        'phone'       => $_POST['phone'],
        'addressLine1'       => $_POST['addressLine1'],
        'addressLine2'       => $_POST['addressLine2'],
        'state'       => $_POST['state'],
        'country'       => $_POST['country'],
        'postalCode'       => $_POST['postalCode'],
        'territory'       => $_POST['territory']
    );


  //validación
  $errores = array();

  if (strlen($office['city']) <=0) {
    $errores['city'] = 'Se debe indicar la city';
  }
  if (strlen($office['phone']) <=0) {
    $errores['phone'] = 'Se debe indicar la phone';
  }
  if (strlen($office['addressLine1']) <=0) {
    $errores['addressLine1'] = 'Se debe indicar la addressLine1';
  }
  if (strlen($office['country']) <=0) {
    $errores['country'] = 'Se debe indicar la country';
  }
  if (strlen($office['postalCode']) <=0) {
    $errores['postalCode'] = 'Se debe indicar la postalCode';
  }
  if (strlen($office['territory']) <=0) {
    $errores['territory'] = 'Se debe indicar la territory';
  }

  if (count($errores) == 0) {
    //no hay errores de validación por lo que  se procede a insertar una oficina o a actualizar una ya creada
    $conn = require "../database.php";

    if (strlen($office['currentOfficeCode']) > 0) { //se desea modificar una oficina ya registrada porque ya tiene un codigo asignado
        $stm = $conn->prepare("update offices set city=:city, officeCode=:officeCode, phone=:phone,addressLine1=:addressLine1,addressLine2=:addressLine2,state=:state,country=:country,postalCode=:postalCode,territory=:territory where officeCode=:currentOfficeCode");
        $params = $office;
    } else { //se crea una nueva oficina
        $stm = $conn->prepare("select max(CAST(officeCode AS UNSIGNED)) as maxOfficeCode from offices");
        $stm->execute();
        $result=$stm->fetch();

        $office['officeCode'] = $result['maxOfficeCode'] + 1; //el código de la nueva oficina se asigna directamente

        $stm = $conn->prepare("insert into offices (officeCode, city, phone,addressLine1,addressLine2,state,country,postalCode,territory) values (:officeCode, :city, :phone,:addressLine1,:addressLine2,:state,:country,:postalCode,:territory)");
        //se inserta la oficina en la abse de datos
        $params = array_slice($office, 1); //se excluye 'currentOfficeCode' que no se usa en la sql de insert

        }

        $stm->execute($params);
        $stm = null;
        $conn = null;
        header("location: list.php");
    }
} else if (isset($_GET['officeCode'])) { // modificar una oficina ya registrada
    $conn = require "../database.php";

    $stm = $conn->prepare("select * from offices where officeCode =:officeCode");
    $stm->execute(array(':officeCode' => $_GET['officeCode']));

    $office = $stm->fetch();
    $office['currentOfficeCode'] = $office['officeCode'];

    $stm = null;
    $conn = null;
}else{ //se desea crear una nueva oficina
    $office = array(
        'currentOfficeCode' => '',
        'officeCode' => '',
        'city' => '',
        'phone' => '',
        'addressLine1' => '',
        'addressLine2' => '',
        'state' => '',
        'country' => '',
        'postalCode' => '',
        'territory' => ''
    );
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar oficina</title>
</head>
<body>
    <?php if (isset($errores) && count($errores) > 0): ?>
        <p>Existen errores:</p>
        <?php foreach ($errores as $error): ?>
            <li><?=$error?></li>
        <?php endforeach; ?>
    <?php endif; ?>

    <form action="form.php" method="post">
        <input type="hidden" name="currentOfficeCode" value="<?=$office['currentOfficeCode']?>">
        <p>
            <label for="officeCode">Código de Oficina</label>
            <input type="text" name="officeCode" id="city" value="<?=$office['officeCode']?>" readonly>
    
        </p>
        <p>
            <label for="city">city</label>
            <input type="text" name="city" id="city" value="<?=$office['city']?>">
        </p>
        <p>
            <label for="phone">phone</label>
            <input type="text" name="phone" id="phone" value="<?=$office['phone']?>">
        </p>
        <p>
            <label for="addressLine1">addressLine1</label>
            <input type="text" name="addressLine1" id="addressLine1" value="<?=$office['addressLine1']?>">
        </p>
        <p>
            <label for="addressLine2">addressLine2</label>
            <input type="text" name="addressLine2" id="addressLine2" value="<?=$office['addressLine2']?>">
        </p>
        <p>
            <label for="state">state</label>
            <input type="text" name="state" id="state" value="<?=$office['state']?>">
        </p>
        <p>
            <label for="country">country</label>
            <input type="text" name="country" id="country" value="<?=$office['country']?>">
        </p>
        <p>
            <label for="postalCode">postalCode</label>
            <input type="text" name="postalCode" id="postalCode" value="<?=$office['postalCode']?>">
        </p>
        <p>
            <label for="territory">territory</label>
            <input type="text" name="territory" id="territory" value="<?=$office['territory']?>">
        </p>

        <input type="submit" name="save" value="Guardar">
        <input type="submit" name="cancel" value="Cancelar">
    </form>
</body>
</html>