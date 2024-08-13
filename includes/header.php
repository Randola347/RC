<?php
include '../includes/session_start.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/header.css">
</head>
<body>
    <header class="site-header">
        <nav class="navbar">
            <div class="logo">
                <a href="../pages/index.php"><img src="../images/RC.png" alt="Logo"></a>
            </div>
            <ul class="navbar-menu">
                <li><a href="../pages/catalog.php?category=1&subcategory=Hombre">Hombre</a>
                    <ul class="dropdown">
                        <li><a href="../pages/catalog.php?category=1&subcategory=Tenis">Tenis</a></li>
                        <li><a href="../pages/catalog.php?category=1&subcategory=Botines">Botines</a></li>
                    </ul>
                </li>
                <li><a href="../pages/catalog.php?category=2&subcategory=Mujer">Mujer</a>
                    <ul class="dropdown">
                        <li><a href="../pages/catalog.php?category=2&subcategory=Tenis">Tenis</a></li>
                        <li><a href="../pages/catalog.php?category=2&subcategory=Botines">Botines</a></li>
                    </ul>
                </li>
                <li><a href="../pages/catalog.php?category=3&subcategory=Niños">Niños</a>
                    <ul class="dropdown">
                        <li><a href="../pages/catalog.php?category=3&subcategory=Tenis">Tenis</a></li>
                        <li><a href="../pages/catalog.php?category=3&subcategory=Botines">Botines</a></li>
                    </ul>
                </li>
                <?php if (isset($_SESSION['name'])): ?>
                    <li><a href="../pages/profile.php"><?php echo htmlspecialchars($_SESSION['name']); ?></a></li>
                    <li><a href="../controller/logout_ctrl.php">Cerrar Sesión</a></li>
                    <li><a href="../pages/cart.php" class="cart-icon"><img src="../images/carrito-de-compras.png" alt="Cart"></a></li>
                <?php else: ?>
                    <li><a href="../pages/login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
</body>
</html>
