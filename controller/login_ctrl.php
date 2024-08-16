<?php
session_start();

function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function authenticate($name, $password) {
    $file_path = '../controller/users.json';
    
    // Leer el archivo JSON y decodificarlo
    $users = json_decode(file_get_contents($file_path), true);

    foreach ($users as $user) {
        if ($user['name'] === $name && $user['password'] === $password) {
            return $user;
        }
    }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = clean_input($_POST['name']);
    $password = clean_input($_POST['password']);

    $user = authenticate($name, $password);

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
?>
