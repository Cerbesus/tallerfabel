<?php declare(strict_types=1);

$conn = require "../database.php";

$stm = $conn->query("select * from offices order by officeCode");
$stm->execute();
$offices = $stm->fetchAll();

$stm = null;
$conn = null;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oficinas</title>
</head>
<body>
    <h1>Listado de oficinas</h1>
    <table>
        <tr>
            <th>code</th>
            <th>ciudad</th>
            <th>phone</th>
            <th>addressLine1</th>
            <th>addressLine2</th>
            <th>state</th>
            <th>country</th>
            <th>postalCode</th>
            <th>territory</th>
        </tr>

        <?php foreach($offices as $office): ?>
            <tr>
                <td>
                    <a href="show.php?officeCode=<?=$office['officeCode']?>">
                        <?=$office['officeCode']?>
                    </a>
                </td>
                <td><?=$office['city']?></td>
                <td><?=$office['phone']?></td>
                <td><?=$office['addressLine1']?></td>
                <td><?=$office['addressLine2']?></td>
                <td><?=$office['state']?></td>
                <td><?=$office['country']?></td>
                <td><?=$office['postalCode']?></td>
                <td><?=$office['territory']?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="form.php">Nueva Oficina</a>
</body>
</html>