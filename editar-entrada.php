<?php
require_once 'db.php';
require_once 'header.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM entradas WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $entrada = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $categoria_id = $_POST['categoria'];

    if (!empty($titulo) && !empty($descripcion)) {
        $sql = "UPDATE entradas SET titulo='$titulo', descripcion='$descripcion', categoria_id='$categoria_id' WHERE id=$id";
        $update = mysqli_query($conn, $sql);

        if ($update) {
            echo "<p>Entrada actualizada con éxito.</p>";
        } else {
            echo "<p>Error al actualizar la entrada.</p>";
        }
    } else {
        echo "<p>Todos los campos son obligatorios.</p>";
    }
}
?>

<h2>Editar Entrada</h2>
<form action="editar-entrada.php?id=<?= $id ?>" method="POST">
    <label for="titulo">Título:</label>
    <input type="text" name="titulo" value="<?= $entrada['titulo'] ?>" required>

    <label for="descripcion">Descripción:</label>
    <textarea name="descripcion" required><?= $entrada['descripcion'] ?></textarea>

    <label for="categoria">Categoría:</label>
    <select name="categoria">
        <?php
        $categorias = mysqli_query($conn, "SELECT * FROM categorias");
        while ($cat = mysqli_fetch_assoc($categorias)) {
            $selected = ($cat['id'] == $entrada['categoria_id']) ? "selected" : "";
            echo "<option value='{$cat['id']}' $selected>{$cat['nombre']}</option>";
        }
        ?>
    </select>

    <button type="submit">Actualizar</button>
</form>

<?php require_once 'footer.php'; ?>
2