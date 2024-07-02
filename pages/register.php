<?php require_once '../controller/register_ctrl.php';?>
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
                        <!-- Registration form -->
                        <form method="post">
                            <!-- Display message -->
                            <?php if (!empty($message)) { echo $message; } ?>
                            <div>
                                <!-- Name input -->
                                <label for="name" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Nombre">

                                <!-- Lastname input -->
                                <label for="lastname" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Apellido">
                                
                                <!-- Phone input -->
                                <label for="phone" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Teléfono">

                                <!-- Email input -->
                                <label for="email" class="form-label">Correo</label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="email">

                                <!-- Password input -->
                                <label class="form-label">Contraseña</label>
                                <input type="password" class="form-control" name="password" placeholder="Contraseña">

                                <!-- Confirm Password input -->
                                <label class="form-label">Confirmar Contraseña</label>
                                <input type="password" class="form-control" name="confirm_password" placeholder="Confirmar Contraseña">

                                <!-- Link to login page -->
                                <p class="pUser"> ¿Ya tiene cuenta? <a href="login.php">Iniciar sesión</a></p>

                                <!-- Button to submit registration -->
                                <button type="submit" class="btn btn-primary">Registrarse</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>