<?php include 'includes/header.php'; ?>
<?php include 'includes/barra.php'; ?>
<?php include 'includes/db.php'; ?> 

<div id="principal">
    <?php
    // Obtener el ID de la categoría desde la URL
    $id_categoria = isset($_GET['id']) ? intval($_GET['id']) : 0;

    // Verificar si la categoría existe
    $queryCategoria = "SELECT nombre FROM categorias WHERE id = ?";
    $stmt = $conn->prepare($queryCategoria);
    $stmt->bind_param("i", $id_categoria);
    $stmt->execute();
    $resultadoCategoria = $stmt->get_result();
    
    if ($resultadoCategoria->num_rows == 1) {
        $categoria = $resultadoCategoria->fetch_assoc();
        echo "<h1>Entradas en la categoría: " . htmlspecialchars($categoria['nombre']) . "</h1>";
    } else {
        echo "<h1 class='mensaje-error'>Categoría no encontrada</h1>";
        exit;
    }

    // Obtener las entradas de la categoría seleccionada (máximo 5)
    $queryEntradas = "SELECT id, titulo, descripcion, fecha 
                    FROM entradas 
                    WHERE categoria_id = ? 
                    ORDER BY fecha DESC 
                    LIMIT 5"; // Se limita a 5 entradas

    $stmt = $conn->prepare($queryEntradas);
    $stmt->bind_param("i", $id_categoria);
    $stmt->execute();
    $resultadoEntradas = $stmt->get_result();

    if ($resultadoEntradas->num_rows > 0) {
        while ($entrada = $resultadoEntradas->fetch_assoc()) {
            ?>
            <article class="entrada">
                <a href="entrada.php?id=<?= $entrada['id'] ?>">
                    <h2><?= htmlspecialchars($entrada['titulo']) ?></h2>
                    <span class="fecha"><?= $entrada['fecha'] ?></span>
                    <p><?= substr(htmlspecialchars($entrada['descripcion']), 0, 150) ?>...</p>
                </a>
            </article>
            <?php
        }
    } else {
        echo "<p class='mensaje-error'>No hay entradas en esta categoría.</p>";
    }
    ?>
    
    <!-- Botón para ver todas las entradas de esta categoría -->
    <div id="ver-todas">
        <a href="todas-entradas.php?id=<?= $id_categoria ?>">Ver todas las entradas</a>
    </div>

    <!-- Botón para volver al inicio -->
    <div id="ver-todas">
        <a href="index.php">Volver al inicio</a>
    </div>
</div> <!-- Fin principal -->

</div> <!-- Fin contenedor -->
<?php require_once 'includes/footer.php'; ?>
