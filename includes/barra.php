<?php
// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Eliminar la variable de sesión para mostrar el formulario de registro
unset($_SESSION['ocultar_registro']);

require_once 'includes/db.php';
?>

<div id="contenedor">
    <aside id="sidebar">
        <!-- Buscador -->
        <div id="buscador" class="bloque">
            <h3>Buscar</h3>
            <form action="buscar.php" method="POST">
                <input type="text" name="busqueda" required />
                <input type="submit" value="Buscar" />
            </form>
        </div>

        <?php if (!empty($_SESSION['usuario'])) : ?>
            <!-- Usuario autenticado -->
            <div id="usuario-logueado" class="bloque">
                <h3>Bienvenido, <?= htmlspecialchars($_SESSION['usuario']['nombre']); ?></h3>
                <a href="crear-entrada.php" class="boton boton-verde">Crear entradas</a>
                <a href="crear-categoria.php" class="boton">Crear categorías</a>
                <a href="mis-datos.php" class="boton boton-naranja">Mis datos</a>
                <a href="cerrar.php" class="boton boton-rojo">Cerrar sesión</a>
            </div>
        <?php else : ?>
            <!-- Login -->
            <div  id="login" class="bloque">
                <h3>Inicia Sesión</h3>
                <form action="procesar_login.php" method="POST">
                    <label for="email">Email</label>
                    <input type="email" name="email" required />
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" required />
                    <input type="submit" value="Entrar" />
                </form>
            </div>

            <!-- Registro -->
            <div id="register" class="bloque">
                <h3>Registrarse</h3>

                <?php if (!empty($_SESSION['mensaje'])) : ?>
                    <div id="mensaje-alerta" class="alerta <?= ($_SESSION['tipo_mensaje'] == 'mensaje-exito') ? 'alerta-exito' : 'alerta-error'; ?>">
                        <?= $_SESSION['mensaje']; ?>
                    </div>
                    <script>
                        setTimeout(function() {
                            var mensajeAlerta = document.getElementById('mensaje-alerta');
                            if (mensajeAlerta) {
                                mensajeAlerta.style.display = 'none';
                            }
                        }, 3000);
                    </script>
                    <?php
                    unset($_SESSION['mensaje']);
                    unset($_SESSION['tipo_mensaje']);
                    ?>
                <?php endif; ?>

                <form id="registro"" method="POST" action="registro.php">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" required />
                    <label for="apellidos">Apellidos</label>
                    <input type="text" name="apellidos" required />
                    <label for="email">Email</label>
                    <input type="email" name="email" required />
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" required />
                    <input type="submit" name="submit" value="Registrar" />
                </form>
            </div>
        <?php endif; ?>
    </aside>
</div>
