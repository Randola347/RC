<?php
session_start();
include '../db/db_connect.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id'])) {
    header('Location: ../pages/login.php');
    exit();
}

$user_id = $_SESSION['id'];

// Limpiar y validar los datos del formulario
$name = clean_input($_POST['name']);
$last_name = clean_input($_POST['last_name']);
$email = clean_input($_POST['email']);
$phone = clean_input($_POST['phone']);

function clean_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Actualizar la información del usuario en la base de datos
$query = "UPDATE users SET name = ?, last_name = ?, email = ?, phone = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssi", $name, $last_name, $email, $phone, $user_id);

if ($stmt->execute()) {
    $_SESSION['success_message'] = "Your information has been updated successfully.";
} else {
    $_SESSION['error_message'] = "There was an error updating your information. Please try again.";
}

$stmt->close();
$conn->close();

// Redirigir de vuelta al perfil con un mensaje de éxito o error
header('Location: ../pages/profile.php');
exit();
?>
