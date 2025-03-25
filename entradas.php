<?php require_once 'includes/header.php'; ?>
<?php require_once 'includes/barra.php'; ?>
<?php require_once 'includes/db.php'; ?>

<!-- CAJA PRINCIPAL -->
<div id="principal">
    <h1>Todas las Entradas</h1>

    <?php
    // Consulta para obtener TODAS las entradas con usuario y categoría
    $queryEntradas = "SELECT e.id, e.titulo, e.descripcion, e.fecha, 
                            c.nombre AS categoria, u.nombre AS usuario 
                        FROM entradas e 
                        INNER JOIN categorias c ON e.categoria_id = c.id 
                        INNER JOIN usuarios u ON e.usuario_id = u.id 
                        ORDER BY e.fecha DESC"; // Sin límite, muestra todas las entradas

    $resultadoEntradas = $conn->query($queryEntradas);

    if ($resultadoEntradas && $resultadoEntradas->num_rows > 0) {
        while ($entrada = $resultadoEntradas->fetch_assoc()) {
    ?>
            <article class="entrada">
                <h3>Publicado por: <?= htmlspecialchars($entrada['usuario']) ?></h3>
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
        <a id="ver-todas" href="index.php">Volver al inicio</a>
    </div>
</div> <!-- Fin principal -->

</div> <!-- Fin contenedor -->
<?php require_once 'includes/footer.php'; ?>
