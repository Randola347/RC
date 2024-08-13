<?php
include '../db/db_connect.php';
include '../includes/session_start.php';
$search_query = $_GET['query'];

$query = "SELECT * FROM products WHERE name LIKE ? OR description LIKE ?";
$search_query_param = "%" . $search_query . "%";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $search_query_param, $search_query_param);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Results</title>
    <link rel="stylesheet" href="../css/style_catalog.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <h1>Search Results for "<?php echo htmlspecialchars($search_query); ?>"</h1>
    <div class="product-list">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="product-item">
                <img src="../images/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                <h2><?php echo $row['name']; ?></h2>
                <p><?php echo $row['description']; ?></p>
                <p>$<?php echo $row['price']; ?></p>
                <a href="product_details.php?id=<?php echo $row['id']; ?>">View Details</a>
                <a href="../controller/add_to_cart.php?id=<?php echo $row['id']; ?>">Add to Cart</a>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
