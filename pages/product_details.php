<?php
session_start();
include '../db/db_connect.php';

// Verificar si se ha pasado un ID de producto en la URL
if (!isset($_GET['id'])) {
    echo "No se ha especificado un producto.";
    exit();
}

$product_id = $_GET['id'];

// Obtener la información del producto desde la base de datos
$query = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Verificar si el producto existe
if (!$product) {
    echo "Producto no encontrado.";
    exit();
}

// Definir la tasa de cambio de USD a CRC (Colones)
$exchange_rate = 550; // Ejemplo de tasa de cambio

// Definir el costo de envío por unidad
$shipping_cost_per_unit = 1500; // Ejemplo de costo de envío por unidad en CRC

// Convertir el precio a colones
$price_colones = $product['price'] * $exchange_rate;
$total_price_colones = $price_colones + $shipping_cost_per_unit; // Sumar el costo de envío al total inicial
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($product['name']); ?></title>
    <link rel="stylesheet" href="../css/style_catalog.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="container mt-5">
        <h1><?php echo htmlspecialchars($product['name']); ?></h1>
        <div class="row">
            <div class="col-md-6">
                <img src="../images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="img-fluid">
            </div>
            <div class="col-md-6">
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <p>Precio: ₡<span id="price-colones"></span></p>
                <p>Talla: <?php echo htmlspecialchars($product['size']); ?></p>
                <p>Costo de envío por unidad: ₡<span id="shipping-cost"></span></p>
                <p>Total Precio (Incluido envío): ₡<span id="total-price"></span></p>

                <!-- Formulario para agregar al carrito -->
                <form id="add-to-cart-form">
                    <div class="form-group">
                        <label for="quantity">Cantidad:</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Agregar al carrito</button>
                </form>

                <!-- Mensaje de confirmación -->
                <div id="confirmation-message" class="alert alert-success mt-3" style="display: none;">
                    ¡Producto añadido al carrito!
                </div>
            </div>
        </div>
    </div>

    <script>
    function truncatePrice(price, digitsToShow) {
        let priceStr = price.toFixed(2).toString();
        return priceStr.slice(0, digitsToShow);
    }

    $(document).ready(function() {
        var pricePerUnit = parseFloat(<?php echo $price_colones; ?>);
        var shippingCostPerUnit = parseFloat(<?php echo $shipping_cost_per_unit; ?>);

        function updatePrices() {
            var quantity = parseInt($('#quantity').val());
            var totalPrice = (pricePerUnit * quantity) + (shippingCostPerUnit * quantity);

            $('#price-colones').text(truncatePrice(pricePerUnit, -6));
            $('#shipping-cost').text(truncatePrice(shippingCostPerUnit, -2)); // Mostrar costo de envío por unidad
            $('#total-price').text(truncatePrice(totalPrice, -6)); // Mostrar total de precio incluido el costo de envío
        }

        $('#quantity').on('input', function() {
            updatePrices();
        });

        updatePrices(); // Inicializar con el valor por defecto

        $('#add-to-cart-form').on('submit', function(e) {
            e.preventDefault();

            var quantity = $('#quantity').val();

            $.post('../controller/add_to_cart.php', {
                id: <?php echo $product_id; ?>,
                quantity: quantity
            }, function(response) {
                if (response !== 'Invalid request') {
                    $('#confirmation-message').fadeIn().delay(2000).fadeOut();
                    $('.cart-count').text(response);

                    if (parseInt(response) > 0) {
                        $('.cart-icon').removeClass('disabled').attr('href', '../pages/cart.php');
                    }
                } else {
                    alert('Error al agregar el producto al carrito.');
                }
            });
        });
    });
    </script>

</body>
</html>
