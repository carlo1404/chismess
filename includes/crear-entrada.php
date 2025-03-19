<?php
include 'index.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $categoria_id = $_POST['categoria'];

    $sql = "INSERT INTO entradas (titulo, descripcion, categoria_id, fecha) 
            VALUES ('$titulo', '$descripcion', $categoria_id, CURDATE())";
    
    if (mysqli_query($conn, $sql)) {
        echo "Entrada creada correctamente.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<form method="POST">
    <label>Título:</label><br>
    <input type="text" name="titulo"><br>
    <label>Descripción:</label><br>
    <textarea name="descripcion"></textarea><br>
    <label>Categoría (ID):</label><br>
    <input type="number" name="categoria"><br>
    <input type="submit" value="Crear Entrada">
</form>
