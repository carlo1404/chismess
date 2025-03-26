<?php
session_start();
require_once 'includes/db.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");  // Redirige al login si no está autenticado
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['foto'])) {
    $foto = $_FILES['foto'];

    // Verificar si el archivo es una imagen
    $permitidos = ['image/jpeg', 'image/png', 'image/jpg'];
    if (!in_array($foto['type'], $permitidos)) {
        header("Location: mis-datos.php?mensaje=Formato de imagen no permitido.");
        exit();
    }

    // Generar un nombre único para la imagen
    $nombreArchivo = time() . "_" . basename($foto['name']);
    $rutaDestino = "uploads/" . $nombreArchivo;

    // Mover la imagen a la carpeta "uploads"
    if (move_uploaded_file($foto['tmp_name'], $rutaDestino)) {
        // Guardar el nombre en la base de datos
        $query = $conn->prepare("UPDATE usuarios SET foto_perfil = ? WHERE id = ?");
        $query->bind_param("si", $nombreArchivo, $usuario_id);
        if ($query->execute()) {
            header("Location: mis-datos.php?mensaje=Foto actualizada con éxito.");
            exit();
        } else {
            header("Location: mis-datos.php?mensaje=Error al actualizar la foto.");
            exit();
        }
    } else {
        header("Location: mis-datos.php?mensaje=Error al subir la imagen.");
        exit();
    }
}
?>
