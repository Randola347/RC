<?php
session_start();
include '../db/db_connect.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id'])) {
    header('Location: ../pages/login.php');
    exit();
}

$user_id = $_SESSION['id'];
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total = 0;

if (empty($cart)) {
    echo "El carrito está vacío.";
    exit();
}

foreach ($cart as $product_id => $quantity) {
    $query = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();
    $total += $product['price'] * $quantity;
    $stmt->close();
}

// Insertar la orden en la tabla de órdenes
$query_order = "INSERT INTO orders (user_id, date, total) VALUES (?, NOW(), ?)";
$stmt_order = $conn->prepare($query_order);
$stmt_order->bind_param("id", $user_id, $total);
$stmt_order->execute();

$order_id = $stmt_order->insert_id;

// Guardar los detalles del pedido en la base de datos
foreach ($cart as $product_id => $quantity) {
    $query_order_items = "INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)";
    $stmt_order_items = $conn->prepare($query_order_items);
    $stmt_order_items->bind_param("iii", $order_id, $product_id, $quantity);
    $stmt_order_items->execute();
    $stmt_order_items->close();
}

// Limpiar el carrito actual para permitir nuevas compras
unset($_SESSION['cart']);

header('Location: ../pages/profile.php');

$stmt_order->close();
$conn->close();
?>
