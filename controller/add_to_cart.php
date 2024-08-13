<?php
include '../includes/session_start.php';

// Verificar si se ha recibido el ID del producto y la cantidad
if (!isset($_POST['id']) || !isset($_POST['quantity'])) {
    echo "Invalid request";
    exit();
}

$product_id = intval($_POST['id']);
$quantity = intval($_POST['quantity']);

// Asegurarse de que el carrito esté inicializado
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Agregar el producto al carrito
if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id] += $quantity;
} else {
    $_SESSION['cart'][$product_id] = $quantity;
}

// Devolver una respuesta de éxito (sin redirigir)
echo "Product added to cart";
exit();
?>
