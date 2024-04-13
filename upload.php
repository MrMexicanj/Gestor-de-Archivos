<?php
session_start();
require_once('login_helper.php');
require_once('config.php');

// Verificar la autenticación del usuario
authenticate();

// Verificar si el usuario es administrador
if ($_SESSION['user_role'] !== 'admin') {
    // Redirigir a index.php si el usuario no es un administrador
    header('Location: index.php');
    exit;
}

// Carpeta donde se guardarán los archivos subidos
$uploadDirectory = 'uploads/';

// Si se envió el formulario de carga de archivo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['uploadedFile'])) {
    $uploadedFile = $_FILES['uploadedFile'];

    // Obtener la información del archivo
    $fileName = $uploadedFile['name'];
    $fileSize = $uploadedFile['size'];
    $fileTmpName = $uploadedFile['tmp_name'];
    $fileType = $uploadedFile['type'];
    $fileError = $uploadedFile['error'];

    // Obtener la extensión del archivo
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Extensiones permitidas
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];

    // Verificar si la extensión del archivo es válida
    if (!in_array($fileExtension, $allowedExtensions)) {
        $uploadError = "Solo se permiten archivos de imagen (jpg, jpeg, png, gif) y archivos PDF.";
    } elseif ($fileError !== UPLOAD_ERR_OK) {
        $uploadError = "Error al subir el archivo. Por favor, inténtelo de nuevo.";
    } else {
        // Crear un nombre único para el archivo
        $uniqueFileName = uniqid('file_') . '.' . $fileExtension;

        // Mover el archivo subido al directorio de carga
        if (move_uploaded_file($fileTmpName, $uploadDirectory . $uniqueFileName)) {
            $uploadMessage = "El archivo se ha subido correctamente.";
        } else {
            $uploadError = "Error al subir el archivo. Por favor, inténtelo de nuevo.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Archivo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Subir Archivo</h1>
        <nav>
            <a href="index.php">Volver al inicio</a>
            <a href="logout.php">Cerrar Sesión</a>
        </nav>
    </header>
    <main>
        <h2>Formulario de Subida de Archivo</h2>
        <?php if (isset($uploadError)): ?>
            <p class="error"><?php echo $uploadError; ?></p>
        <?php endif; ?>
        <?php if (isset($uploadMessage)): ?>
            <p class="success"><?php echo $uploadMessage; ?></p>
        <?php endif; ?>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="uploadedFile">Seleccione un archivo:</label>
                <input type="file" id="uploadedFile" name="uploadedFile" accept=".jpeg,.jpg,.png,.gif,.pdf" required>
            </div>
            <button type="submit">Subir Archivo</button>
        </form>
    </main>
</body>
</html>
