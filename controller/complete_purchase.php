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

// Verificar si el total de la compra está definido y no es cero
if (!isset($_SESSION['total_amount']) || $_SESSION['total_amount'] <= 0) {
    echo "No se pudo obtener el total de la compra o el total es 0.";
    exit();
}

$total = $_SESSION['total_amount'];

if (empty($cart)) {
    echo "El carrito está vacío.";
    exit();
}

// Verificación para depuración - para asegurarse de que el total no sea 0
var_dump($total); // Debe mostrar el total calculado en la página anterior

// Insertar la orden en la tabla de órdenes
$query_order = "INSERT INTO orders (user_id, date, total) VALUES (?, NOW(), ?)";
$stmt_order = $conn->prepare($query_order);
$stmt_order->bind_param("id", $user_id, $total);
$stmt_order->execute();

if ($stmt_order->affected_rows === 0) {
    echo "Hubo un error al insertar la orden.";
    exit();
}

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
unset($_SESSION['total_amount']); // Limpiar también el total

$stmt_order->close();
$conn->close();

header('Location: ../pages/profile.php');
?>
