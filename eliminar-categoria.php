<?php
include 'includes/db.php';
session_start();

// Verificar que el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    echo "No estás logueado.";
    exit;
}

// Obtener el ID de la categoría a eliminar
$categoria_id = $_GET['id'];

// Verificar que la categoría pertenezca al usuario logueado
$query = "SELECT usuario_id FROM categorias WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $categoria_id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $categoria = $resultado->fetch_assoc();

    // Verificar que el usuario logueado sea el dueño de la categoría
    if ($categoria['usuario_id'] == $_SESSION['usuario']['id']) {
        // Eliminar la categoría
        $queryDelete = "DELETE FROM categorias WHERE id = ?";
        $stmtDelete = $conn->prepare($queryDelete);
        $stmtDelete->bind_param("i", $categoria_id);
        if ($stmtDelete->execute()) {
            echo "Categoría eliminada correctamente.";
        } else {
            echo "Error al eliminar la categoría.";
        }
    } else {
        echo "No puedes eliminar esta categoría.";
    }
} else {
    echo "La categoría no existe.";
}
?>
