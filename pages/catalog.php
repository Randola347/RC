<?php
include '../db/db_connect.php';
include '../includes/session_start.php';
$category = $_GET['category'];
$subcategory = $_GET['subcategory'];

$query = "SELECT * FROM products WHERE category_id = ? AND subcategory = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("is", $category, $subcategory);
$stmt->execute();
$result = $stmt->get_result();

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
    <h1>Product Catalog</h1>
    <div class="product-list">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="product-item">
                <img src="../images/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                <h2><?php echo $row['name']; ?></h2>
                <p><?php echo $row['description']; ?></p>
                <p>$<?php echo $row['price']; ?></p>
                <a href="product_details.php?id=<?php echo $row['id']; ?>">Ver detalles</a>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
