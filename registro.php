<?php
session_start();
require_once 'includes/header.php'; 
require_once 'includes/barra.php'; 
require_once 'includes/db.php'; 

// Obtener mensaje de sesión si existe
$mensaje = isset($_SESSION['mensaje']) ? $_SESSION['mensaje'] : "";
$tipo_mensaje = isset($_SESSION['tipo_mensaje']) ? $_SESSION['tipo_mensaje'] : "";

// Limpiar mensajes después de mostrarlos
unset($_SESSION['mensaje']);
unset($_SESSION['tipo_mensaje']);

// Si se envió el formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($nombre) && !empty($apellidos) && !empty($email) && !empty($password)) {
        $query_verificar = "SELECT id FROM usuarios WHERE email = ?";
        $stmt_verificar = $conn->prepare($query_verificar);
        $stmt_verificar->bind_param("s", $email);
        $stmt_verificar->execute();
        $stmt_verificar->store_result();

        if ($stmt_verificar->num_rows > 0) {
            $_SESSION['mensaje'] = "El correo ya está registrado. Intente con otro.";
            $_SESSION['tipo_mensaje'] = "mensaje-error";
        } else {
            $password_segura = password_hash($password, PASSWORD_BCRYPT, ['cost' => 4]);
            $query_insertar = "INSERT INTO usuarios (nombre, apellidos, email, password, fecha) VALUES (?, ?, ?, ?, NOW())";
            $stmt_insertar = $conn->prepare($query_insertar);
            $stmt_insertar->bind_param("ssss", $nombre, $apellidos, $email, $password_segura);

            if ($stmt_insertar->execute()) {
                // Iniciar sesión automáticamente
                $_SESSION['usuario'] = [
                    'id' => $stmt_insertar->insert_id, // ID del nuevo usuario
                    'nombre' => $nombre,
                    'apellidos' => $apellidos,
                    'email' => $email
                ];
                
                $_SESSION['mensaje'] = "Registro exitoso. ¡Bienvenido!";
                $_SESSION['tipo_mensaje'] = "mensaje-exito";

                // Redirigir al index.php
                header("Location: index.php");
                exit;
            } else {
                $_SESSION['mensaje'] = "Error al registrar usuario.";
                $_SESSION['tipo_mensaje'] = "mensaje-error";
            }
            $stmt_insertar->close();
        }
        $stmt_verificar->close();
    } else {
        $_SESSION['mensaje'] = "Todos los campos son obligatorios.";
        $_SESSION['tipo_mensaje'] = "mensaje-error";
    }
}
?>

<div id="registro-container">
    <h2>Registro de Usuario</h2>

    <?php if (!empty($mensaje)) : ?>
        <div id="mensaje-alerta" class="alerta <?= $tipo_mensaje; ?>">
            <?= htmlspecialchars($mensaje); ?>
        </div>
        <script>
            setTimeout(function() {
                var mensajeAlerta = document.getElementById('mensaje-alerta');
                if (mensajeAlerta) {
                    mensajeAlerta.style.display = 'none';
                }
            }, 3000);
        </script>
    <?php endif; ?>

    <form action="registro.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required>

        <label for="apellidos">Apellidos:</label>
        <input type="text" name="apellidos" required>

        <label for="email">Correo Electrónico:</label>
        <input type="email" name="email" required>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" required>

        <input type="submit" name="submit" value="Registrarse">
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>
