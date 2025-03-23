<?php
include 'includes/db.php';

// Verificar si se recibió un ID válido
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Eliminar la categoría
    $query = "DELETE FROM categorias WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: crear-categoria.php");
        exit;
    } else {
        echo "Error al eliminar la categoría.";
    }
} else {
    echo "ID no válido.";
}
?>
