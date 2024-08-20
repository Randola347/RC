<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['id'];

// Leer el archivo JSON y obtener la información del usuario
$users = json_decode(file_get_contents('../controller/users.json'), true);

$user = null;
foreach ($users as $u) {
    if ($u['id'] == $user_id) {
        $user = $u;
        break;
    }
}

// Verificar si se encontró el usuario
if (!$user) {
    echo "Usuario no encontrado.";
    exit();
}

// Suponiendo que el historial de compras aún esté en la base de datos, lo dejamos como está
include '../db/db_connect.php';
$query_orders = "SELECT * FROM orders WHERE user_id = ? ORDER BY date DESC";
$stmt_orders = $conn->prepare($query_orders);
$stmt_orders->bind_param("i", $user_id);
$stmt_orders->execute();
$orders = $stmt_orders->get_result();

function clean_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Perfil</title>
    <link rel="stylesheet" href="../css/style_catalog.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1>Perfil</h1>
                
                <!-- Mostrar mensajes de éxito o error -->
                <?php if (isset($_SESSION['success_message'])): ?>
                    <div class="alert alert-success">
                        <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="alert alert-danger">
                        <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
                    </div>
                <?php endif; ?>

                <!-- Formulario para Actualizar Información del Usuario -->
                <form action="../controller/update_user_ctrl.php" method="post">
                    <div class="form-group">
                        <label for="name">Nombre:</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Apellido:</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['lastname']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Teléfono:</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Actualizar información</button>
                </form>

                <!-- Historial de Compras -->
                <h2 class="mt-5">Historial de compras</h2>
                <?php if ($orders->num_rows > 0): ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID de pedido</th>
                                <th>Fecha</th>
                                <th>Monto total</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($order = $orders->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($order['id']); ?></td>
                                    <td><?php echo htmlspecialchars($order['date']); ?></td>
                                    <td>₡<?php echo number_format($order['total'], 2); ?></td>
                                    <td>
                                        <form method="post" action="cart.php">
                                            <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['id']); ?>">
                                            <button type="submit" class="btn btn-primary">View Cart</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No tienes historial de compras.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>

<?php
$stmt_orders->close();
$conn->close();
?>
