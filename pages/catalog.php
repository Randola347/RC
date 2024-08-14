<?php
include '../includes/session_start.php';
include '../db/db_connect.php';

// Verificar si se ha pasado una categoría en la URL
if (!isset($_GET['category'])) {
    die("No se ha especificado una categoría.");
}

$category_id = intval($_GET['category']);
$subcategory = isset($_GET['subcategory']) ? $_GET['subcategory'] : null;

// Definir la tasa de cambio de USD a CRC (Colones)
$exchange_rate = 550; // Ejemplo de tasa de cambio

// Construir la consulta SQL para obtener los productos
$query = "SELECT * FROM products WHERE category_id = ?";
if ($subcategory) {
    $query .= " AND subcategory = ?";
}

$stmt = $conn->prepare($query);
if ($subcategory) {
    $stmt->bind_param("is", $category_id, $subcategory);
} else {
    $stmt->bind_param("i", $category_id);
}

$stmt->execute();
$result = $stmt->get_result();

// Verificar si se encontraron productos
if ($result->num_rows === 0) {
    die("No se encontraron productos en esta categoría.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Catalog</title>
    <link rel="stylesheet" href="../css/style_catalog.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="product-list">
        <?php while ($row = $result->fetch_assoc()): 
            // Convertir el precio a colones
            $price_colones = $row['price'] * $exchange_rate;

            // Formatear el precio a 5 dígitos significativos
            $price_colones_formatted = number_format($price_colones, 0, '', '');
            if (strlen($price_colones_formatted) > 5) {
                $price_colones_formatted = substr($price_colones_formatted, 0, 5);
            }
        ?>
            <div class="product-item">
                <img src="../images/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
                <h2><?php echo htmlspecialchars($row['name']); ?></h2>
                <p><?php echo htmlspecialchars($row['description']); ?></p>
                <p>₡<?php echo $price_colones_formatted; ?></p>
                <?php if (isset($_SESSION['name'])): ?>
                    <a href="product_details.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Ver Detalles</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-primary">Ver Detalles</a>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
