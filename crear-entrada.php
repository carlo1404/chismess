<?php include 'includes/header.php'; ?>
<?php include 'includes/barra.php'; ?>
<?php include 'includes/db.php'; ?>

<div id="contenedor">
    <div id="principal">
        <h1>Crear Nueva Entrada</h1>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'];
            $categoria_id = $_POST['categoria'];

            $sql = "INSERT INTO entradas (titulo, descripcion, categoria_id, fecha) 
                    VALUES ('$titulo', '$descripcion', $categoria_id, CURDATE())";

            if (mysqli_query($conn, $sql)) {
                echo "<p class='alerta'>Entrada creada correctamente.</p>";
            } else {
                echo "<p class='alerta-error'>Error: " . mysqli_error($conn) . "</p>";
            }
        }
        ?>

        <form class="crear-entrada" method="POST">
            <label>Título:</label>
            <input type="text" name="titulo" required>

            <label>Descripción:</label>
            <textarea name="descripcion" required></textarea>

            <label>Categoría (ID):</label>
            <input type="number" name="categoria" required>

            <input type="submit" value="Crear Entrada">
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>