<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
} // Iniciar la sesión aquí si no lo has hecho en otro lugar
?>
<!DOCTYPE HTML>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <title>Chismes</title>
        <link rel="stylesheet" type="text/css" href="assets/css/style.css" />
        <link rel="icono" href="assets/img/imagen._icono.ico">
    </head>
    <body>
        <!-- CABECERA -->
        <header id="cabecera">
            <!-- LOGO -->
            <div id="logo">
                <a href="index.php">
                    Chismes
                </a>
            </div>
            
            <!-- MENU -->
            <nav id="menu" >
                <ul>
                    <li>
                        <a href="index.php">Inicio</a>
                    </li>
                    <li>
                        <a href="index.php">{Categorias}</a>
                    </li>
                    <li>
                        <a href="index.php">{Categorias}</a>
                    </li>
                    <li>
                        <a href="index.php">{Categorias}</a>
                    </li>
                    <li>
                        <a href="index.php">Sobre mí</a>
                    </li>
                    <li>
                        <a href="index.php">Contacto</a>
                    </li>
                </ul>
            </nav>
            
            <div class="clearfix"></div>
        </header>
