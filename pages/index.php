<?php
include '../includes/session_start.php';
include '../db/db_connect.php';

$query = "SELECT * FROM products LIMIT 6";
$result = $conn->query($query);

if ($result === false) {
    die("Error en la consulta a la base de datos: " . $conn->error);
}

// Definir la tasa de cambio de USD a CRC (Colones)
$exchange_rate = 550; // Ejemplo de tasa de cambio
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hogar</title>
    <link rel="stylesheet" href="../css/style_catalog.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="product-list">
        <?php while ($row = $result->fetch_assoc()): 
            // Calcular el precio en colones y formatear el precio
            $price_colones = number_format($row['price'] * $exchange_rate, 0, '', '');
            
            // Limitar a 5 dígitos el precio en colones
            if (strlen($price_colones) > 5) {
                $price_colones = substr($price_colones, 0, 5);
            }
        ?>
            <div class="product-item">
                <img src="../images/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                <h2><?php echo $row['name']; ?></h2>
                <p><?php echo $row['description']; ?></p>
                <p>₡<?php echo $price_colones; ?></p>
                <?php if (isset($_SESSION['name'])): ?>
                    <a href="product_details.php?id=<?php echo $row['id']; ?>">Ver Detalles</a>
                <?php else: ?>
                    <a href="login.php">Ver Detalles</a>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>
    
</body>
</html>

<?php
$conn->close();
?>
