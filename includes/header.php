<?php
include '../includes/session_start.php';

// Contar la cantidad de productos en el carrito
$cart_count = 0;
if (isset($_SESSION['cart'])) {
    $cart_count = array_sum($_SESSION['cart']);
}
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
                <li><a href="../pages/catalog.php?category=1">Hombre</a>
                    <ul class="dropdown">
                        <li><a href="../pages/catalog.php?category=1&subcategory=Tenis">Tenis</a></li>
                        <li><a href="../pages/catalog.php?category=1&subcategory=Botines">Botines</a></li>
                    </ul>
                </li>
                <li><a href="../pages/catalog.php?category=2">Mujer</a>
                    <ul class="dropdown">
                        <li><a href="../pages/catalog.php?category=2&subcategory=Tenis">Tenis</a></li>
                        <li><a href="../pages/catalog.php?category=2&subcategory=Botines">Botines</a></li>
                    </ul>
                </li>
                <li><a href="../pages/catalog.php?category=3">Niños</a>
                    <ul class="dropdown">
                        <li><a href="../pages/catalog.php?category=3&subcategory=Tenis">Tenis</a></li>
                        <li><a href="../pages/catalog.php?category=3&subcategory=Botines">Botines</a></li>
                    </ul>
                </li>
                <?php if (isset($_SESSION['name'])): ?>
                    <li><a href="../pages/profile.php"><?php echo htmlspecialchars($_SESSION['name']); ?></a></li>
                    <li><a href="../controller/logout_ctrl.php">Cerrar Sesión</a></li>
                    <li>
                        <a href="<?php echo $cart_count > 0 ? '../pages/cart.php' : '#'; ?>" class="cart-icon <?php echo $cart_count == 0 ? 'disabled' : ''; ?>">
                            <img src="../images/carrito-de-compras.png" alt="Cart">
                            <span class="cart-count"><?php echo $cart_count; ?></span>
                        </a>
                    </li>
                <?php else: ?>
                    <li><a href="../pages/login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
</body>
</html>
