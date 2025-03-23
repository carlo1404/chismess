<?php 
session_start();
include 'includes/header.php'; 
include 'includes/barra.php'; 
include 'includes/db.php'; 

// Obtener mensaje de sesión si existe
$mensaje = isset($_SESSION['mensaje']) ? $_SESSION['mensaje'] : "";
$tipo_mensaje = isset($_SESSION['tipo_mensaje']) ? $_SESSION['tipo_mensaje'] : "";

// Limpiar mensajes después de mostrarlos
unset($_SESSION['mensaje']);
unset($_SESSION['tipo_mensaje']);
?>

<!-- CAJA PRINCIPAL -->
<div id="principal">
    <h1>Últimos Chismes</h1>

    <?php if (!empty($mensaje)) : ?>
        <div id="mensaje-alerta" class="alerta <?= $tipo_mensaje; ?>">
            <?= htmlspecialchars($mensaje); ?>
        </div>
        <script>
            setTimeout(function() {
                var mensajeAlerta = document.getElementById('mensaje-alerta');
                if (mensajeAlerta) {
                    mensajeAlerta.style.display = 'none';
                }
            }, 3000);
        </script>
    <?php endif; ?>

    <?php
    // Obtener las últimas 5 entradas con su usuario y categoría
    $queryEntradas = "SELECT e.id, e.titulo, e.descripcion, e.fecha, 
                            c.nombre AS categoria, u.nombre AS usuario 
                        FROM entradas e 
                        INNER JOIN categorias c ON e.categoria_id = c.id 
                        INNER JOIN usuarios u ON e.usuario_id = u.id 
                        ORDER BY e.fecha DESC 
                        LIMIT 5"; 

    $resultadoEntradas = $conn->query($queryEntradas);

    if ($resultadoEntradas && $resultadoEntradas->num_rows > 0) {
        while ($entrada = $resultadoEntradas->fetch_assoc()) {
    ?>
            <div class="entrada-container">
                <h3 class="usuario"><?= htmlspecialchars($entrada['usuario']) ?></h3>
                <span class="categoria"><?= htmlspecialchars($entrada['categoria']) ?></span>
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

    <div id="ver-todas">
        <a href="entradas.php">Ver todas las entradas</a>
    </div>
</div> <!-- Fin principal -->

</div> <!-- Fin contenedor -->
<?php require_once 'includes/footer.php'; ?>