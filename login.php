<?php declare(strict_types=1);

session_start();
unset($_SESSION['user']);

if (!isset($_POST['user']) || !isset($_POST['password'])) {
    $_SESSION['message'] = "Debe especificar usuario y contraseña";
    header("location:form_login.php");
    exit();
}

$user = $_POST['user'];
$password = md5($_POST['password']);

$conn = require "database.php";

$query = $conn->prepare("SELECT * FROM usuarios WHERE nombre= :user AND passwd = :passwd");
$query->bindParam(":user", $user);
$query->bindParam(":passwd", $password);
$query->execute();
$usuario = $query->fetch(PDO::FETCH_ASSOC);

if ($usuario) {
    $_SESSION['user'] = $usuario["nombre"];
    header('location:main.php');
    exit();
} else {
    $_SESSION['message'] = "Usuario o contraseña incorrectos";
    header("location:form_login.php?");
    exit();
}

?>