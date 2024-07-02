<?php require_once '../db/db_connect.php' ?>
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
    <!-- Container for page content -->
    <div class="container">
        <!-- Row for content, centered -->
        <div class="row justify-content-center mt-5">
            <!-- Column with a width of 5 for medium-sized screens -->
            <div class="col-md-5">
                <!-- Card container -->
                <div class="card">
                    <!-- Card body -->
                    <div class="card-body">
                        <!-- Login form -->
                        <form method="post">
                            <div>
                                <!-- Username input -->
                                <label for="fromLocation" class="form-label">Nombre de Usuario</label>
                                <input type="text" class="form-control" id="fromLocation" name="username"
                                    placeholder="Usuario">

                                <!-- Password input -->
                                <label class="form-label">Contraseña</label>
                                <input type="password" class="form-control" name="password" placeholder="Contraseña">

                                <!-- Link to registration page -->
                                <p class="pUser"> ¿No tiene cuenta? <a href="register.php">Regístrese aquí</a></p>

                                <!-- Button to submit login -->
                                <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
