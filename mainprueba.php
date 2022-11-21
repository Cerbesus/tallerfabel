<?php declare(strict_types=1);

session_start();

if (!isset($_SESSION['user'])) {
    header('location:form_login.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <title>Taller Faber</title>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp"
      rel="stylesheet">
    <!-- Google Fonts (Poppins)-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- StyleSheet -->
    <link rel="stylesheet" href="css/estilosprueba.css">
    <!-- Javascript -->
</head>
<body>
    <nav>
        <div class="container">
            <img src="img/logo.png" class="logo">
            <div class="search-bar">
            <span class="material-icons-sharp">search</span>
                <input type="search" placeholder="Buscar">
            </div>
            <div class="profile-area">
                <div class="theme-btn">
                    <span class="material-icons-sharp active">light_mode</span>
                    <span class="material-icons-sharp">dark_mode</span>
                </div>
                <div class="profile">
                    <div class="profile-photo">
                        <img src="img/profile.jpg">
                    </div>
                    <h5><?=$_SESSION['user']?></h5>
                    <span class="material-icons-sharp">expand_more</span>
                </div>
                <button id="menu-btn">
                    <span class="material-icons-sharp">menu</span>
                </button>
            </div>
        </div>
    </nav>
    <!-- Final del NAVBAR -->

    <main>
        <aside>
            <button id="close-btn">
                <span class="material-icons-sharp">close</span>
            </button>

            <div class="sidebar">
                <a href="#" class="active">
                    <span class="material-icons-sharp">dashboard</span>
                    <h4>Dashboard</h4>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">person</span>
                    <h4>Clientes</h4>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">receipt</span>
                    <h4>Facturas</h4>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">directions_car</span>
                    <h4>Vehículos</h4>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">assignment</span>
                    <h4>Reparaciones</h4>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">work</span>
                    <h4>Empleados</h4>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">engineering</span>
                    <h4>Intervienen</h4>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">cached</span>
                    <h4>Recambios</h4>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">manage_history</span>
                    <h4>Incluyen</h4>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">build</span>
                    <h4>Actuaciones</h4>
                </a>
                <a href="#">
                    <span class="material-icons-sharp">done</span>
                    <h4>Realizan</h4>
                </a>
            </div>
        </aside>
        <!-- Final del Aside -->

        <section class="middle">
            <div class="header">
                <h1>Overview</h1>
                <input type="date">
            </div>
            
        </section>
        <!-- Final del Middle -->

        <section class="right">

        </section>
        <!-- Final del Derecho -->

    </main>
    <!-- ====================== FINAL DEL ASIDE ======================= -->
    <script src="js/main.js"></script>
</body>
</html>