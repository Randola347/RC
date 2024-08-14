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
                <p>Price per unit: $<span id="price-per-unit"><?php echo htmlspecialchars($product['price']); ?></span></p>
                <p>Total Price: $<span id="total-price"><?php echo htmlspecialchars($product['price']); ?></span></p>

                <!-- Formulario para agregar al carrito -->
                <form id="add-to-cart-form">
                    <div class="form-group">
                        <label for="quantity">Quantity:</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                </form>

                <!-- Mensaje de confirmación -->
                <div id="confirmation-message" class="alert alert-success mt-3" style="display: none;">
                    Product added to cart!
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $('#quantity').on('input', function() {
            var pricePerUnit = parseFloat($('#price-per-unit').text());
            var quantity = parseInt($(this).val());
            var totalPrice = (pricePerUnit * quantity).toFixed(2);
            $('#total-price').text(totalPrice);
        });

        // Manejar el envío del formulario sin redirigir
        $('#add-to-cart-form').on('submit', function(e) {
            e.preventDefault(); // Prevenir la redirección

            var quantity = $('#quantity').val();

            // Realizar la llamada AJAX para agregar al carrito
            $.post('../controller/add_to_cart.php', {
                id: <?php echo $product_id; ?>,
                quantity: quantity
            }, function(response) {
                if (response !== 'Invalid request') {
                    // Mostrar mensaje de confirmación
                    $('#confirmation-message').fadeIn().delay(2000).fadeOut();

                    // Actualizar el contador del carrito con el valor devuelto
                    $('.cart-count').text(response);
                    
                    // Activar el enlace al carrito si hay al menos un producto
                    if (parseInt(response) > 0) {
                        $('.cart-icon').removeClass('disabled').attr('href', '../pages/cart.php');
                    }
                } else {
                    alert('Error adding product to cart.');
                }
            });
        });
    });
</script>


</body>
</html>
