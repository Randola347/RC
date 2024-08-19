<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);

    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);

        // Si el carrito está vacío después de eliminar el producto
        if (empty($_SESSION['cart'])) {
            unset($_SESSION['cart']);
        }

        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'invalid request';
}
?>
