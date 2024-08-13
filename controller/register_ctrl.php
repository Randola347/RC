<?php
require_once '../db/db_connect.php';

session_start();

// Variable para almacenar mensajes
$message = "";

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar datos del formulario
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validación de campos
    $name_pattern = '/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/';
    $phone_pattern = '/^[0-9\s+]+$/';

    // Función para verificar si el teléfono no tiene caracteres especiales
    function validatePhone($phone) {
        // Solo números y el símbolo más (+)
        return preg_match('/^[0-9\s+]+$/', $phone);
    }

    // Función para verificar si el nombre y apellido son solo letras y espacios
    function validateName($name) {
        // Solo letras y espacios, incluyendo caracteres en español
        return preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $name);
    }

    // Verificar si todos los campos obligatorios están completos
    if (empty($name) || empty($lastname) || empty($phone) || empty($email) || empty($password) || empty($confirm_password)) {
        $message = "<span style='color: red;'>Por favor complete todos los campos.</span>";
    } elseif (!validateName($name)) {
        $message = "<span style='color: red;'>El nombre solo puede contener letras y espacios.</span>";
    } elseif (!validateName($lastname)) {
        $message = "<span style='color: red;'>El apellido solo puede contener letras y espacios.</span>";
    } elseif (!validatePhone($phone)) {
        $message = "<span style='color: red;'>El teléfono solo puede contener números y el símbolo '+'.</span>";
    } elseif ($password != $confirm_password) {
        $message = "<span style='color: red;'>Las contraseñas no coinciden.</span>";
    } else {
        // Verificar si el correo electrónico o número de teléfono ya existen en la base de datos
        $query = "SELECT * FROM users WHERE email = '$email' OR phone = '$phone'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $message = "<span style='color: red;'>Ya existe un usuario con el mismo correo electrónico o número de teléfono.</span>";
        } else {
            // Insertar el usuario en la base de datos
            $query = "INSERT INTO users (name, last_name, phone, email, password) 
                      VALUES ('$name', '$lastname', '$phone', '$email', '$password')";

            if (mysqli_query($conn, $query)) {
                // Obtener el ID del usuario recién insertado
                $user_id = mysqli_insert_id($conn);

                // Configurar todas las variables de sesión necesarias
                $_SESSION['loggedin'] = true;
                $_SESSION['id'] = $user_id; // Almacenar el ID del usuario en la sesión
                $_SESSION['name'] = $name; // Almacenar el nombre del usuario en la sesión
                $_SESSION['email'] = $email; // Almacenar el correo electrónico del usuario en la sesión

                // Redirigir al usuario a la página principal
                header('Location: ../pages/index.php');
                exit();
            } else {
                $message = "<span style='color: red;'>Error al registrar al usuario: " . mysqli_error($conn) . "</span>";
            }
        }
    }
}
?>
