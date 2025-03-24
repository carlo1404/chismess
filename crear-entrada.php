<?php 
include 'includes/header.php'; 
include 'includes/barra.php'; 
include 'includes/db.php'; 

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario'])) {
    echo "No hay usuario en sesión.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $categoria_id = $_POST['categoria'];

    // Verificar si la categoría existe
    $queryCategoria = "SELECT id FROM categorias WHERE id = ?";
    $stmt = $conn->prepare($queryCategoria);
    $stmt->bind_param("i", $categoria_id);
    $stmt->execute();
    $resultadoCategoria = $stmt->get_result();

    if ($resultadoCategoria->num_rows == 0) {
        echo "La categoría seleccionada no existe.";
        exit;
    }

    // Usar sentencias preparadas para la inserción de la entrada
    $sql = "INSERT INTO entradas (titulo, descripcion, categoria_id, fecha, usuario_id) 
            VALUES (?, ?, ?, CURDATE(), ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $titulo, $descripcion, $categoria_id, $_SESSION['usuario']['id']);

    if ($stmt->execute()) {
        echo "Entrada creada correctamente.";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<form class="crear-entrada" method="POST">
    <label>Título:</label><br>
    <input type="text" name="titulo" required><br>
    <label>Descripción:</label><br>
    <textarea name="descripcion" required></textarea><br>
    <label>Categoría (ID):</label><br>
    <input type="number" name="categoria" required><br>
    <input type="submit" value="Crear Entrada">
</form>

<?php include 'includes/footer.php'; ?>
