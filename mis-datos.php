<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    // Redirigir a login.php si no está autenticado
    header("Location: login.php");
    exit();
}

// Obtener los datos del usuario
require_once 'includes/db.php';
$usuario_id = $_SESSION['usuario_id'];
$query = $conn->prepare("SELECT nombre, email, foto_perfil FROM usuarios WHERE id = ?");
$query->bind_param("i", $usuario_id);
$query->execute();
$resultado = $query->get_result();
$usuario = $resultado->fetch_assoc();

// Definir la foto de perfil
$foto = !empty($usuario['foto_perfil']) ? "uploads/" . htmlspecialchars($usuario['foto_perfil']) : "assets/img/default-profile.png";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Datos</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="contenedor">
        <h2>Mis Datos</h2>

        <div class="foto-perfil">
            <img src="<?= $foto; ?>" alt="Foto de perfil">
        </div>

        <form action="subir-foto.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="foto" required>
            <button type="submit">Actualizar Foto</button>
        </form>

        <p><strong>Nombre:</strong> <?= htmlspecialchars($usuario['nombre']); ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($usuario['email']); ?></p>

        <h3>Cambiar Contraseña</h3>
        <form action="procesar-cambio.php" method="POST">
            <label for="actual">Contraseña Actual:</label>
            <input type="password" name="actual" required>
            <label for="nueva">Nueva Contraseña:</label>
            <input type="password" name="nueva" required>
            <label for="confirmar">Confirmar Nueva Contraseña:</label>
            <input type="password" name="confirmar" required>
            <button type="submit">Actualizar Contraseña</button>
        </form>

        <?php if (isset($_GET['mensaje'])): ?>
            <p class="mensaje"><?= htmlspecialchars($_GET['mensaje']); ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
