<?php
session_start();
require_once 'includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        $query = "SELECT id, nombre, apellidos, email, password FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows == 1) {
            $usuario = $resultado->fetch_assoc();
            if (password_verify($password, $usuario['password'])) {
                $_SESSION['usuario'] = [
                    'id' => $usuario['id'],
                    'nombre' => $usuario['nombre'],
                    'apellidos' => $usuario['apellidos'],
                    'email' => $usuario['email']
                ];

                // Depuración: Verificar si la sesión contiene el usuario
                echo 'Usuario autenticado correctamente: ' . $_SESSION['usuario']['nombre']; 
                header("Location: index.php"); // Solo redirigir aquí después de que todo esté correcto
                exit();
            } else {
                $_SESSION['mensaje'] = "Contraseña incorrecta.";
                $_SESSION['tipo_mensaje'] = "mensaje-error";
            }
        } else {
            $_SESSION['mensaje'] = "El correo no está registrado.";
            $_SESSION['tipo_mensaje'] = "mensaje-error";
        }

        $stmt->close();
    } else {
        $_SESSION['mensaje'] = "Todos los campos son obligatorios.";
        $_SESSION['tipo_mensaje'] = "mensaje-error";
    }

    // Redirigir siempre al final del flujo después de todo el proceso de login
    header("Location: index.php");
    exit();
}
