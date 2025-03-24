<?php
include 'includes/header.php';
include 'includes/barra.php';
include 'includes/db.php';

$mensaje = '';

// Procesamiento del formulario para crear una categoría
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);

    if (!empty($nombre)) {
        // Preparar la consulta para insertar la categoría con el usuario_id
        $stmt = $conn->prepare("INSERT INTO categorias (nombre, fecha_creacion, usuario_id) VALUES (?, NOW(), ?)");
        $stmt->bind_param("si", $nombre, $_SESSION['usuario']['id']);

        if ($stmt->execute()) {
            $mensaje = "<p class='mensaje-exito'>Categoría creada con éxito.</p>";
        } else {
            $mensaje = "<p class='mensaje-error'>Error al crear la categoría.</p>";
        }
        $stmt->close();
    } else {
        $mensaje = "<p class='mensaje-error'>El nombre de la categoría no puede estar vacío.</p>";
    }
}

// Consultar las categorías existentes del usuario logueado
$query = "SELECT id, nombre, fecha_creacion FROM categorias WHERE usuario_id = ? ORDER BY fecha_creacion DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_SESSION['usuario']['id']);
$stmt->execute();
$categorias = $stmt->get_result();
?>

<h2>Administración de Categorías</h2>

<!-- Sección de la tabla de categorías -->
<div id="contenedor">
    <div id="tabla-categorias">
        <h3>Categorías Actuales</h3>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Fecha de Creación</th>
                <th>Hora de Creación</th>
                <th>Acciones</th> <!-- Nueva columna para botones -->
            </tr>
            <?php while ($categoria = $categorias->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($categoria['id']); ?></td>
                    <td><?php echo htmlspecialchars($categoria['nombre']); ?></td>
                    <td><?php echo date("d/m/Y", strtotime($categoria['fecha_creacion'])); ?></td>
                    <td><?php echo date("H:i:s", strtotime($categoria['fecha_creacion'])); ?></td>
                    <td>
                        <a href="editar-categoria.php?id=<?php echo $categoria['id']; ?>" class="btn-editar">Editar</a>
                        <a href="eliminar-categoria.php?id=<?php echo $categoria['id']; ?>" class="btn-eliminar" onclick="return confirm('¿Estás seguro de eliminar esta categoría?');">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>

<!-- Separación entre la tabla y el formulario -->
<hr>

<!-- Sección para crear una nueva categoría -->
<div id="crear-categoria">
    <h3>Crear Nueva Categoría</h3>
    <?php echo $mensaje; ?>
    <form class="form-crear-categoria" action="crear-categoria.php" method="POST">
        <label for="nombre">Nombre de la Categoría:</label>
        <input type="text" id="nombre" name="nombre" required>
        <button type="submit" id="btn-crear">Crear</button>
    </form>
</div>

<?php require_once 'includes/footer.php'; ?>
