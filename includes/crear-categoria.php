<?php
require_once 'db.php'; // Asegúrate de tener una conexión a la base de datos
require_once 'header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);

    if (!empty($nombre)) {
        $sql = "INSERT INTO categorias (nombre) VALUES ('$nombre')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "<p>Categoría creada con éxito.</p>";
        } else {
            echo "<p>Error al crear la categoría.</p>";
        }
    } else {
        echo "<p>El nombre de la categoría no puede estar vacío.</p>";
    }
}
?>

<h2>Crear Categoría</h2>
<form action="crear-categoria.php" method="POST">
    <label for="nombre">Nombre de la categoría:</label>
    <input type="text" name="nombre" required>
    <button type="submit">Crear</button>
</form>

<?php require_once 'footer.php'; ?>
