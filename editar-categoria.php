<?php
ob_start(); // Inicia el buffer de salida
include 'includes/header.php';
include 'includes/barra.php';
include 'includes/db.php';


$mensaje = '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$categoria_actual = null;

// Si se recibe un ID, buscamos la categoría
if ($id > 0) {
    $stmt = $conn->prepare("SELECT * FROM categorias WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $categoria_actual = $resultado->fetch_assoc();
    $stmt->close();
}

// Procesar formulario de edición
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $nombre = trim($_POST['nombre']);

    if (!empty($nombre) && $id > 0) {
        $stmt = $conn->prepare("UPDATE categorias SET nombre = ? WHERE id = ?");
        $stmt->bind_param("si", $nombre, $id);

        if ($stmt->execute()) {
            $mensaje = "<p class='mensaje-exito'>Categoría actualizada correctamente.</p>";
        } else {
            $mensaje = "<p class='mensaje-error'>Error al actualizar la categoría.</p>";
        }
        $stmt->close();
        
        // Recargar datos actualizados
        header("Location: editar-categoria.php?id=$id&actualizado=1");
        exit();
    } else {
        $mensaje = "<p class='mensaje-error'>El nombre no puede estar vacío.</p>";
    }
}

// Mensaje de actualización exitosa
if (isset($_GET['actualizado'])) {
    $mensaje = "<p class='mensaje-exito'>Categoría actualizada correctamente.</p>";
}
?>

<h2>Editar Categoría</h2>

<!-- Mostrar mensaje si existe -->
<?php echo $mensaje; ?>

<?php if ($categoria_actual): ?>
    <form action="editar-categoria.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $categoria_actual['id']; ?>">
        
        <label for="nombre">Nuevo Nombre de la Categoría:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($categoria_actual['nombre']); ?>" required>

        <button type="submit">Actualizar</button>
        <a href="crear-categoria.php">Cancelar</a>
    </form>
<?php else: ?>
    <p class="mensaje-error">Categoría no encontrada.</p>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
