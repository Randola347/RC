<?php
require_once '../db/db_connect.php';

session_start();

// Variable to store messages
$message = "";

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
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
    function validatePhone($phone)
    {
        // Solo números y el símbolo más (+)
        return preg_match('/^[0-9\s+]+$/', $phone);
    }

    // Función para verificar si el nombre y apellido son solo letras y espacios
    function validateName($name)
    {
        // Solo letras y espacios, incluyendo caracteres en español
        return preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $name);
    }

    // Check if all mandatory fields are filled
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
        // Check if email or phone number already exists in the database
        $query = "SELECT * FROM users WHERE email = '$email' OR phone = '$phone'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $message = "<span style='color: red;'>Ya existe un usuario con el mismo correo electrónico o número de teléfono.</span>";
        } else {
            // Insert user into the database
            $query = "INSERT INTO users (name, last_name, phone, email, password) 
                      VALUES ('$name', '$lastname', '$phone', '$email', '$password')";

            if (mysqli_query($conn, $query)) {
                // Get the ID of the newly inserted user
                $user_id = mysqli_insert_id($conn);

                $_SESSION['loggedin'] = true;
                $_SESSION['name'] = $_POST['name'];
                header('Location: ../pages/index.php');
                exit();
            } else {
                $message = "<span style='color: red;'>Error al registrar al usuario: " . mysqli_error($conn) . "</span>";
            }
        }
    }
}
