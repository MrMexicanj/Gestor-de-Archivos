<?php
session_start();
require_once('login_helper.php');
require_once('config.php');

// Verificar la autenticación del usuario
authenticate();

// Obtener el rol del usuario actual
$user_role = $_SESSION['user_role'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador de Archivos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Administrador de Archivos</h1>
        <nav>
            <?php if ($user_role === 'admin'): ?>
                <a href="upload.php">Subir Archivo</a>
            <?php endif; ?>
            <a href="logout.php">Cerrar Sesión</a>
        </nav>
    </header>
    <main>
        <h2>Listado de Archivos</h2>
        <?php include 'list_files.php'; ?>
    </main>
</body>
</html>
