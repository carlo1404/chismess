<?php
session_start(); // Iniciar la sesión al principio del archivo
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
    // Verificar si el usuario está autenticado
    if (isset($_SESSION['usuario_id'])) {
        // Si el usuario está autenticado, mostrar el botón de "Mis Datos"
        echo '<a href="mis-datos.php" class="boton-mis-datos">Mis Datos</a>';
    }

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
    ?>
        <div class="chismes-container">
            <?php while ($entrada = $resultadoEntradas->fetch_assoc()) { ?>
                <div class="chisme">
                    <div class="chisme-header">
                        <span class="usuario"><?= htmlspecialchars($entrada['usuario']) ?></span>
                        <span class="categoria"><?= htmlspecialchars($entrada['categoria']) ?></span>
                    </div>
                    <h3 class="titulo"><?= htmlspecialchars($entrada['titulo']) ?></h3>
                    <span class="fecha"><?= $entrada['fecha'] ?></span>
                    <p class="descripcion"><?= substr(htmlspecialchars($entrada['descripcion']), 0, 150) ?>...</p>
                    <a class="leer-mas" href="entrada.php?id=<?= $entrada['id'] ?>">Leer más</a>
                </div>
            <?php } ?>
        </div>
    <?php
    } else {
        echo "<p class='mensaje-error'>No hay entradas disponibles.</p>";
    }
    ?>

    <div id="ver-todas" class="ver-todass">
        <a id="ver-todas" href="entradas.php">Ver todos los chismes</a>
    </div>
</div> <!-- Fin principal -->

</div> <!-- Fin contenedor -->
<?php require_once 'includes/footer.php'; ?>
