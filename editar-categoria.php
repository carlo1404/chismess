<?php
include 'includes/header.php';
include 'includes/barra.php';
include 'includes/db.php';

// Verificar si se recibió un ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de categoría no proporcionado.");
}

$id = intval($_GET['id']); // Asegurar que el ID es un número

// Obtener los datos de la categoría
$query = "SELECT nombre FROM categorias WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$categoria = $result->fetch_assoc();

if (!$categoria) {
    die("Categoría no encontrada.");
}

// Procesar la actualización
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nuevoNombre = trim($_POST['nombre']);

    if (!empty($nuevoNombre)) {
        $updateQuery = "UPDATE categorias SET nombre = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("si", $nuevoNombre, $id);

        if ($updateStmt->execute()) {
            header("Location: crear-categoria.php"); // Redirecciona tras actualizar
            exit;
        } else {
            echo "<p class='mensaje-error'>Error al actualizar la categoría.</p>";
        }
    } else {
        echo "<p class='mensaje-error'>El nombre de la categoría no puede estar vacío.</p>";
    }
}
?>

<h2>Editar Categoría</h2>
<form action="editar-categoria.php?id=<?php echo $id; ?>" method="POST">
    <label for="nombre">Nuevo Nombre de la Categoría:</label>
    <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($categoria['nombre']); ?>" required>
    <button type="submit">Actualizar</button>
</form>
<a href="crear-categoria.php">Cancelar</a>

<?php include 'includes/footer.php'; ?>
