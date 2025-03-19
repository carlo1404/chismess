<?php
include 'includes/header.php';
include 'includes/barra.php';
include 'includes/db.php';

$mensaje = '';

// Procesamiento del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);

    if (!empty($nombre)) {
        // Usar consulta preparada para evitar SQL Injection
        $stmt = $conn->prepare("INSERT INTO categorias (nombre) VALUES (?)");
        $stmt->bind_param("s", $nombre);

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

// Consultar las categorías existentes
$query = "SELECT * FROM categorias";
$categorias = $conn->query($query);
?>

<h2>Estas son las categorías de momento</h2>

<div id="contenedor">
    <div id="tabla-categorias">
        <h3>Categorías Actuales</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
            </tr>
            <?php while ($categoria = $categorias->fetch_assoc()) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($categoria['id']); ?></td>
                    <td><?php echo htmlspecialchars($categoria['nombre']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <div id="crear-categoria">
        <h3>Crear Categoría</h3>
        <?php echo $mensaje; ?>
        <form class="form-crear-categoria" action="crear-categoria.php" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
            <button type="submit" id="btn-crear">Crear</button>
        </form>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
