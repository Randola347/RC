<?php
session_start();
include '../db/db_connect.php';

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$read_only_cart = null;
$total_price = 0;

// Si se solicita ver un carrito de un pedido anterior
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id'])) {
    $order_id = intval($_POST['order_id']);

    // Obtener los detalles del pedido desde la base de datos
    $query = "SELECT * FROM order_items WHERE order_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $order_items = $stmt->get_result();

    if ($order_items->num_rows > 0) {
        $read_only_cart = [];
        while ($item = $order_items->fetch_assoc()) {
            $read_only_cart[$item['product_id']] = $item['quantity'];
        }
    }
    $stmt->close();
}

// Si estamos en modo de solo lectura, usamos el carrito de la orden pasada
if ($read_only_cart !== null) {
    $cart = $read_only_cart;
    $read_only = true;
} else {
    $read_only = false;
}

if (empty($cart)) {
    echo "<p class='text-center'>Your cart is empty.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1>Your Cart</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price per unit</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <?php if (!$read_only): ?>
                        <th>Action</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $product_id => $quantity): ?>
                    <?php
                    $query = "SELECT * FROM products WHERE id = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i", $product_id);
                    $stmt->execute();
                    $product = $stmt->get_result()->fetch_assoc();
                    $stmt->close();

                    $total_item_price = $product['price'] * $quantity;
                    $total_price += $total_item_price;
                    ?>
                    <tr id="product-<?php echo $product_id; ?>">
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td>$<span class="price-per-unit"><?php echo htmlspecialchars($product['price']); ?></span></td>
                        <td>
                            <input type="number" class="form-control quantity" data-product-id="<?php echo $product_id; ?>" value="<?php echo $quantity; ?>" min="1" <?php if ($read_only) echo 'disabled'; ?>>
                        </td>
                        <td>$<span class="total-price"><?php echo number_format($total_item_price, 2); ?></span></td>
                        <?php if (!$read_only): ?>
                            <td>
                                <button class="btn btn-danger remove-item" data-product-id="<?php echo $product_id; ?>">Remove</button>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="<?php echo $read_only ? '3' : '4'; ?>">Total Price</th>
                    <th>$<span id="cart-total"><?php echo number_format($total_price, 2); ?></span></th>
                </tr>
            </tfoot>
        </table>
        <?php if (!$read_only): ?>
            <button class="btn btn-success" onclick="window.location.href='../controller/complete_purchase.php'">Complete Purchase</button>
        <?php else: ?>
            <button class="btn btn-secondary" onclick="window.location.href='profile.php'">Back to Profile</button>
        <?php endif; ?>
    </div>

    <?php if (!$read_only): ?>
    <script>
        $(document).ready(function() {
            // Actualizar el precio total en tiempo real
            $('.quantity').on('input', function() {
                var quantity = $(this).val();
                var productId = $(this).data('product-id');
                var pricePerUnit = parseFloat($(this).closest('tr').find('.price-per-unit').text());
                var totalItemPrice = (pricePerUnit * quantity).toFixed(2);
                
                // Actualizar el precio total del item
                $(this).closest('tr').find('.total-price').text(totalItemPrice);

                // Recalcular el precio total del carrito
                var totalPrice = 0;
                $('.total-price').each(function() {
                    totalPrice += parseFloat($(this).text());
                });
                $('#cart-total').text(totalPrice.toFixed(2));

                // Opcional: Podrías enviar una solicitud AJAX para actualizar la cantidad en el servidor
            });

            // Eliminar un producto del carrito
            $('.remove-item').click(function() {
                var productId = $(this).data('product-id');
                var row = $(this).closest('tr');

                // Enviar una solicitud AJAX para eliminar el producto del carrito en la sesión
                $.ajax({
                    url: '../controller/remove_from_cart.php',
                    method: 'POST',
                    data: { product_id: productId },
                    success: function(response) {
                        if (response == 'success') {
                            // Eliminar la fila de la tabla
                            row.remove();

                            // Recalcular el precio total del carrito después de la eliminación
                            var totalPrice = 0;
                            $('.total-price').each(function() {
                                totalPrice += parseFloat($(this).text());
                            });
                            $('#cart-total').text(totalPrice.toFixed(2));
                        } else {
                            alert('There was a problem removing the item from the cart.');
                        }
                    }
                });
            });
        });
    </script>
    <?php endif; ?>
</body>
</html>

<?php
$conn->close();
?>
