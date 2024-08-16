<?php
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

    function validatePhone($phone) {
        return preg_match('/^[0-9\s+]+$/', $phone);
    }

    function validateName($name) {
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
        $file_path = '../controller/users.json';

        // Leer el archivo JSON existente
        $users = json_decode(file_get_contents($file_path), true);

        // Verificar si el correo electrónico o número de teléfono ya existen
        foreach ($users as $user) {
            if ($user['email'] === $email || $user['phone'] === $phone) {
                $message = "<span style='color: red;'>Ya existe un usuario con el mismo correo electrónico o número de teléfono.</span>";
                exit;
            }
        }

        // Asignar un nuevo ID
        $new_id = empty($users) ? 1 : end($users)['id'] + 1;

        // Crear un nuevo usuario
        $new_user = [
            "id" => $new_id,
            "name" => $name,
            "lastname" => $lastname,
            "phone" => $phone,
            "email" => $email,
            "password" => $password
        ];

        // Agregar el nuevo usuario al array y guardar en el archivo JSON
        $users[] = $new_user;
        file_put_contents($file_path, json_encode($users, JSON_PRETTY_PRINT));

        // Autenticar al usuario y redirigir
        $_SESSION['loggedin'] = true;
        $_SESSION['id'] = $new_id;
        $_SESSION['name'] = $name;
        header('Location: ../pages/index.php');
        exit();
    }
}
?>
