<?php
include 'crear-entrada.php';
include 'includes/db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "SELECT e.titulo, e.descripcion, e.fecha, c.nombre AS categoria
            FROM entradas e
            INNER JOIN categorias c ON e.categoria_id = c.id
            WHERE e.id = $id";
    $result = mysqli_query($conn, $sql);

    if ($entrada = mysqli_fetch_assoc($result)) {
        echo "<h1>".$entrada['titulo']."</h1>";
        echo "<span>".$entrada['categoria']." | ".$entrada['fecha']."</span>";
        echo "<p>".$entrada['descripcion']."</p>";
    } else {
        echo "Entrada no encontrada.";
    }
} else {
    echo "ID de entrada no especificado.";
}   
?>