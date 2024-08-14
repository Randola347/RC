<?php 
require_once '../db/db_connect.php';
require_once('../controller/login_ctrl.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style_login_register.css">
    <title>RC</title>
</head>

<body>
    <!-- Contenedor para el contenido de la página -->
    <div class="container">
        <!-- Fila para el contenido, centrado -->
        <div class="row justify-content-center mt-5">
            <!-- Columna con un ancho de 5 para pantallas medianas -->
            <div class="col-md-5">
                <!-- Contenedor de la tarjeta -->
                <div class="card">
                    <!-- Cuerpo de la tarjeta -->
                    <div class="card-body">
                        <!-- Imagen decorativa sobre los inputs -->
                        <img src="../images/icon_login.webp" class="form-icon" alt="Icono de Usuario">
                        
                        <!-- Formulario de inicio de sesión -->
                        <form method="post" action="../controller/login_ctrl.php">
                            <div>
                                <!-- Campo de entrada para el nombre de usuario -->
                                <label for="fromLocation" class="form-label">Nombre de Usuario</label>
                                <input type="text" class="form-control" id="fromLocation" name="name" placeholder="Usuario">

                                <!-- Campo de entrada para la contraseña -->
                                <label class="form-label">Contraseña</label>
                                <input type="password" class="form-control" name="password" placeholder="Contraseña">

                                <!-- Enlace a la página de registro -->
                                <p class="pUser"> ¿No tiene cuenta? <a href="register.php">Regístrese aquí</a></p>

                                <!-- Botón para enviar el formulario de inicio de sesión -->
                                <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                            </div>
                        </form>

                        <?php
                        // Mostrar mensaje de error si existe
                        if (isset($_SESSION['error'])) {
                            echo '<div class="alert alert-danger mt-3">' . $_SESSION['error'] . '</div>';
                            unset($_SESSION['error']);
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
