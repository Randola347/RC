<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>RC</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/header.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="company.php">
            <img src="../images/RC.png" alt="RC Logo" class="cart-icon">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php"><?php echo htmlspecialchars($_SESSION["name"]); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../controller/logout_ctrl.php">Cerrar Sesion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php">
                            <img src="../images/carrito-de-compras.png" alt="Cart" class="cart-icon">
                        </a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/login.php">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</body>

</html>
