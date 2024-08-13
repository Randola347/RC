<?php
session_start();

$product_id = $_POST['id'];
$quantity = $_POST['quantity'];

if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id] = $quantity;
}

header('Location: ../pages/cart.php');
exit();
?>
