<?php
// Configuración de la base de datos
$servidor = "localhost";
$usuario = "root"; // Usuario de phpMyAdmin en XAMPP
$password = ""; // En XAMPP, root no tiene contraseña
$basededatos = "chismea"; // Aquí colocamos el nombre correcto de la BD

// Crear conexión
$conn = mysqli_connect($servidor, $usuario, $password, $basededatos);

// Verificar conexión
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8"); // Para que acepte caracteres especiales como tildes
?>
