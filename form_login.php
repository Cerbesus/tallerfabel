<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="css/form_login.css">
    <script src="js/script.js"></script>
    <title>Inicio de sesión</title>
</head>
<body>
    <div class="box">
        <form action="login.php" method="post">
            <h2>Inicio de sesión</h2>
            <div class="inputBox">
                <input type="text" name="user" id="user" required>
                <span>Usuario</span>
                <i></i>
            </div>
            <div class="inputBox">
                <input type="password" name="password" id="password" required>  
                <span>Contraseña</span>
                <i></i>
            </div>
            
            

            <input type="submit" value="Iniciar sesión">
            <div class="links">
                <?php
                    if (isset($_SESSION['message'])): ?>
                        <p id="error">
                            <?php
                                echo $_SESSION['message'];
                                unset($_SESSION['message']);
                            ?>
                        </p>
                <?php endif; ?>
            </div>
        </form>
    </div>
</body>
</html>