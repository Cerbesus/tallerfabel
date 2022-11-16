<?php declare(strict_types=1);

session_start();
session_destroy();

header('location:form_login.php');
?>