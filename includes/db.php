<?php
// Configuración de la base de datos
$servidor = "localhost";
$usuario = "root"; // Usuario por defecto en XAMPP
$password = ""; // Sin contraseña en XAMPP
$basededatos = "chismea"; // Asegúrate de que el nombre esté correcto

// Activar el informe de errores de MySQLi
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Crear conexión
    $conn = new mysqli($servidor, $usuario, $password, $basededatos);
    
    // Establecer el conjunto de caracteres a UTF-8
    $conn->set_charset("utf8");

} catch (mysqli_sql_exception $e) {
    // Manejo de errores más seguro
    die("❌ Error de conexión a la base de datos: " . $e->getMessage());
}
?>
