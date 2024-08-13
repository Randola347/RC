<?php
session_start();

if (isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);

    // Verificar si el producto está en el carrito y eliminarlo
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'error';
}
?>
