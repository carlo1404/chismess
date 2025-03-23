<?php
session_start();
include 'includes/db.php';

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? trim($_POST['email']) : "";
    $password = isset($_POST['password']) ? trim($_POST['password']) : "";

    if (!empty($email) && !empty($password)) {
        // Buscar usuario en la base de datos
        $query = "SELECT id, nombre, email, password FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows == 1) {
            $usuario = $resultado->fetch_assoc();

            // Verificar la contraseña
            if (password_verify($password, $usuario['password'])) {
                $_SESSION['usuario'] = [
                    'id' => $usuario['id'],
                    'nombre' => $usuario['nombre'],
                    'email' => $usuario['email']
                ];

                $_SESSION['mensaje'] = "¡Inicio de sesión exitoso!";
                $_SESSION['tipo_mensaje'] = "exito";
                header("Location: index.php");
                exit();
            } else {
                $_SESSION['mensaje'] = "Contraseña incorrecta.";
                $_SESSION['tipo_mensaje'] = "error";
            }
        } else {
            $_SESSION['mensaje'] = "No existe una cuenta con ese correo.";
            $_SESSION['tipo_mensaje'] = "error";
        }
    } else {
        $_SESSION['mensaje'] = "Por favor, complete todos los campos.";
        $_SESSION['tipo_mensaje'] = "error";
    }
}

header("Location: index.php");
exit();
?>