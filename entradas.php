<?php
include 'crear-entrada.php';

$sql = "SELECT e.id, e.titulo, e.descripcion, e.fecha, c.nombre AS categoria
        FROM entradas e
        INNER JOIN categorias c ON e.categoria_id = c.id
        ORDER BY e.fecha DESC";

$result = mysqli_query($conn, $sql);

while ($entrada = mysqli_fetch_assoc($result)) {
    echo "<article class='entrada'>";
    echo "<a href='entrada.php?id=".$entrada['id']."'>";
    echo "<h2>".$entrada['titulo']."</h2>";
    echo "<span class='fecha'>".$entrada['categoria']." | ".$entrada['fecha']."</span>";
    echo "<p>".$entrada['descripcion']."</p>";
    echo "</a>";
    echo "</article>";
}
?>
