<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
</head>
<body>
    <h2>Iniciar sesión</h2>

    <?php if (isset($_SESSION['mensaje'])): ?>
        <p class="<?= $_SESSION['tipo_mensaje']; ?>">
            <?= $_SESSION['mensaje']; ?>
        </p>
        <?php unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']); ?>
    <?php endif; ?>

    <form action="procesar-login.php" method="POST">
        <label for="email">Correo electrónico:</label>
        <input type="email" name="email" required>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" required>

        <button type="submit">Iniciar sesión</button>
    </form>
</body>
</html>

