<?php
session_start();
require_once('login_helper.php');
require_once('config.php');

// Verificar la autenticación del usuario
authenticate();

// Obtener el rol del usuario actual
$user_role = $_SESSION['user_role'];

// Verificar si el usuario es administrador
if ($user_role !== 'admin') {
    // Si no es un administrador, redirigir a index.php
    header('Location: index.php');
    exit;
}
// Ruta del directorio donde se encuentran los archivos subidos
$uploadDirectory = 'uploads/';

// Verificar si se ha especificado el nombre del archivo a borrar
if (isset($_GET['fileName'])) {
    $fileName = $_GET['fileName'];
    $filePath = $uploadDirectory . $fileName;

    // Verificar si el archivo existe antes de intentar borrarlo
    if (file_exists($filePath)) {
        // Intentar borrar el archivo
        if (unlink($filePath)) {
            // Archivo borrado exitosamente
            echo "El archivo $fileName ha sido borrado correctamente.";
        } else {
            // Error al intentar borrar el archivo
            echo "Error al intentar borrar el archivo $fileName.";
        }
    } else {
        // El archivo especificado no existe
        echo "El archivo $fileName no existe.";
    }
} else {
    // No se especificó el nombre del archivo a borrar
    echo "No se ha especificado el nombre del archivo a borrar.";
}
?>

<script>
// Función para confirmar y eliminar un archivo mediante AJAX
function deleteFile(fileName) {
    if (confirm("¿Estás seguro que deseas borrar " + fileName + "?")) {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Recargar la página después de borrar el archivo
                location.reload();
            }
        };
        xhr.open("GET", "delete_file.php?fileName=" + fileName, true);
        xhr.send();
    }
}
</script>