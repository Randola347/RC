<?php
require_once '../db/db_connect.php';

// Iniciar sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function authenticate($name, $password, $conn) {
    $stmt = $conn->prepare('SELECT id, name FROM users WHERE name = ? AND password = ?');
    $stmt->bind_param('ss', $name, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = clean_input($_POST['name']);
    $password = clean_input($_POST['password']);

    $user = authenticate($name, $password, $conn);

    if ($user) {
        // Autenticación exitosa
        $_SESSION['loggedin'] = true;
        $_SESSION['id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        
        // Redirigir a la página de inicio
        header("Location: ../pages/index.php");
        exit();
    } else {
        // Autenticación fallida
        $_SESSION['error'] = 'Nombre de usuario o contraseña incorrectos.';
        header('Location: ../pages/login.php');
        exit();
    }
}
