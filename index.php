<?php require_once 'includes/header.php'; ?>
<?php require_once 'includes/barra.php'; ?>
<?php require_once 'includes/db.php'; ?>

<!-- CAJA PRINCIPAL -->
<div id="principal">
    <h1>Últimos Chismes</h1>

    <?php
    // Obtener las últimas 5 entradas con su usuario y categoría
    $queryEntradas = "SELECT e.id, e.titulo, e.descripcion, e.fecha, 
                            c.nombre AS categoria, u.nombre AS usuario 
                        FROM entradas e 
                        INNER JOIN categorias c ON e.categoria_id = c.id 
                        INNER JOIN usuarios u ON e.usuario_id = u.id 
                        ORDER BY e.fecha DESC 
                        LIMIT 5"; // Solo 5 últimas entradas

    $resultadoEntradas = $conn->query($queryEntradas);

    if ($resultadoEntradas && $resultadoEntradas->num_rows > 0) {
        while ($entrada = $resultadoEntradas->fetch_assoc()) {
    ?>
            <div class="entrada-container">
                <h3 class="usuario"><?= htmlspecialchars($entrada['usuario']) ?></h3> <!-- Usuario arriba -->
                <span class="categoria"><?= htmlspecialchars($entrada['categoria']) ?></span> <!-- Categoría debajo -->
                <article class="entrada">
                    <a href="entrada.php?id=<?= $entrada['id'] ?>">
                        <h2><?= htmlspecialchars($entrada['titulo']) ?></h2>
                        <span class="fecha"><?= $entrada['fecha'] ?></span>
                        <p><?= substr(htmlspecialchars($entrada['descripcion']), 0, 150) ?>...</p>
                    </a>
                </article>
            </div>
    <?php
        }
    } else {
        echo "<p class='mensaje-error'>No hay entradas disponibles.</p>";
    }
    ?>

    <!-- Botón para ver todas las entradas -->
    <div id="ver-todas">
        <a href="entradas.php">Ver todas las entradas</a>
    </div>
</div> <!-- Fin principal -->

</div> <!-- Fin contenedor -->
<?php require_once 'includes/footer.php'; ?>
