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
    header('Location: ../pages/index.php'); // Redirigir a la página principal si el carrito está vacío
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Su Carrito</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Incluir el SDK de PayPal -->
    <script src="https://www.paypal.com/sdk/js?client-id=AfDDJ82yqDrmGJAR_x6AdQX5-WAS1HZOGidxh0YJryy6N-6qgf9gcjvEabPhUn5V-n_Mus-N6vFrSx1C&currency=USD"></script>
</head>
<body>
    <div class="container mt-5 cart-container">
        <h1 class="mb-4">Su Carrito</h1>
        <table class="table table-hover table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Producto</th>
                    <th>Precio por unidad</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <?php if (!$read_only): ?>
                        <th>Acción</th>
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

                    // Convertir el precio unitario a colones
                    $price_per_unit = $product['price'] * 550; // Ejemplo de tasa de cambio

                    // Calcular el precio total por producto
                    $total_item_price = $price_per_unit * $quantity;
                    $total_price += $total_item_price;

                    // Truncar los últimos seis dígitos y quitar la última coma
                    $price_per_unit_display = rtrim(substr(number_format($price_per_unit, 2), 0, -6), ',');
                    $total_item_price_display = rtrim(substr(number_format($total_item_price, 2), 0, -6), ',');
                    ?>
                    <tr id="product-<?php echo $product_id; ?>">
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td>₡<span class="price-per-unit" data-full-price="<?php echo $price_per_unit; ?>"><?php echo htmlspecialchars($price_per_unit_display); ?></span></td>
                        <td>
                            <input type="number" class="form-control quantity" data-product-id="<?php echo $product_id; ?>" value="<?php echo $quantity; ?>" min="1" <?php if ($read_only) echo 'disabled'; ?>>
                        </td>
                        <td>₡<span class="total-price"><?php echo htmlspecialchars($total_item_price_display); ?></span></td>
                        <?php if (!$read_only): ?>
                            <td>
                                <button class="btn btn-danger remove-item" data-product-id="<?php echo $product_id; ?>">Eliminar</button>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="<?php echo $read_only ? '3' : '4'; ?>" class="text-right">Precio total</th>
                    <th>₡<span id="cart-total"><?php echo htmlspecialchars(rtrim(substr(number_format($total_price, 2), 0, -6), ',')); ?></span></th>
                </tr>
            </tfoot>
        </table>
        <div class="text-right">
            <?php if (!$read_only): ?>
                <!-- Div para el botón de PayPal -->
                <div id="paypal-button-container"></div>
                <button class="btn btn-success" onclick="window.location.href='../controller/complete_purchase.php'" style="display: none;">Complete Purchase</button>
            <?php else: ?>
                <button class="btn btn-secondary" onclick="window.location.href='profile.php'">Volver al perfil</button>
            <?php endif; ?>
        </div>
    </div>

    <?php if (!$read_only): ?>
    <script>
        $(document).ready(function() {
            // Actualizar el precio total en tiempo real
            $('.quantity').on('input', function() {
                var quantity = $(this).val();
                var productId = $(this).data('product-id');
                var pricePerUnit = parseFloat($(this).closest('tr').find('.price-per-unit').data('full-price'));
                var totalItemPrice = (pricePerUnit * quantity).toFixed(2);

                // Truncar los últimos seis dígitos y quitar la última coma
                var totalItemPriceDisplay = totalItemPrice.slice(0, -6).replace(/,$/, '');

                // Actualizar el precio total del item
                $(this).closest('tr').find('.total-price').text(totalItemPriceDisplay);

                // Recalcular el precio total del carrito
                var totalPrice = 0;
                $('.total-price').each(function() {
                    totalPrice += parseFloat($(this).text().replace(',', ''));
                });
                var totalPriceDisplay = totalPrice.toFixed(2).slice(0, -6).replace(/,$/, '');
                $('#cart-total').text(totalPriceDisplay);
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
                                totalPrice += parseFloat($(this).text().replace(',', ''));
                            });
                            var totalPriceDisplay = totalPrice.toFixed(2).slice(0, -6).replace(/,$/, '');
                            $('#cart-total').text(totalPriceDisplay);

                            // Si el carrito está vacío, redirigir al index.php
                            if ($('.total-price').length === 0) {
                                window.location.href = '../pages/index.php';
                            }
                        } else {
                            alert('There was a problem removing the item from the cart.');
                        }
                    }
                });
            });

            // Configurar PayPal
            paypal.Buttons({
                createOrder: function(data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: $('#cart-total').text() // Total del carrito
                            }
                        }]
                    });
                },
                onApprove: function(data, actions) {
                    return actions.order.capture().then(function(details) {
                        // Redirigir a completar la compra después de un pago exitoso
                        window.location.href = '../controller/complete_purchase.php';
                    });
                },
                onError: function (err) {
                    alert("Ocurrió un error en el proceso.");
                }
            }).render('#paypal-button-container'); // Renderizar el botón de PayPal en el contenedor especificado
        });
    </script>
    <?php endif; ?>
</body>
</html>

<?php
$conn->close();
?>
