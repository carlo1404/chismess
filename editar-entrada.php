<?php include 'includes/header.php'; ?>
<?php include 'includes/barra.php'; ?>
<?php include 'includes/db.php'; ?> 

<div id="principal">
    <h1>Todas las Entradas</h1>

    <?php
    // Obtener todas las entradas
    $queryEntradas = "SELECT e.id, e.titulo, e.descripcion, e.fecha, c.nombre AS categoria 
                    FROM entradas e
                    INNER JOIN categorias c ON e.categoria_id = c.id
                    ORDER BY e.fecha DESC";

    $resultadoEntradas = $conn->query($queryEntradas);

    if ($resultadoEntradas->num_rows > 0) {
        while ($entrada = $resultadoEntradas->fetch_assoc()) {
            ?>
            <article class="entrada">
                <a href="entrada.php?id=<?= $entrada['id'] ?>">
                    <h2><?= htmlspecialchars($entrada['titulo']) ?></h2>
                    <span class="fecha"><?= htmlspecialchars($entrada['categoria']) ?> | <?= $entrada['fecha'] ?></span>
                    <p><?= substr(htmlspecialchars($entrada['descripcion']), 0, 150) ?>...</p>
                </a>
            </article>
            <?php
        }
    } else {
        echo "<p class='mensaje-error'>No hay entradas disponibles.</p>";
    }
    ?>

    <div id="ver-todas">
        <a href="index.php">Volver al inicio</a>
    </div>
</div> <!-- Fin principal -->

</div> <!-- Fin contenedor -->
<?php require_once 'includes/footer.php'; ?>
