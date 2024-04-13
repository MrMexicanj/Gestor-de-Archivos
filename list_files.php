<?php
// Ruta del directorio donde se encuentran los archivos subidos
$uploadDirectory = 'uploads/';

// Obtener la lista de archivos en el directorio
$fileList = scandir($uploadDirectory);

// Excluir los directorios '.' y '..'
$fileList = array_diff($fileList, array('.', '..'));

// Verificar si hay archivos para mostrar
if (empty($fileList)) {
    echo "<p>No hay archivos disponibles.</p>";
} else {
    echo "<table>";
    echo "<tr><th>Nombre del Archivo</th><th>Tamaño (KB)</th><th>Acciones</th></tr>";
    foreach ($fileList as $file) {
        $filePath = $uploadDirectory . $file;
        $fileSizeKB = round(filesize($filePath) / 1024, 2); // Convertir tamaño a KB y redondear a 2 decimales
        echo "<tr>";
        echo "<td><a href=\"archivo.php?nombre=$file\" target=\"_blank\">$file</a></td>";
        echo "<td>$fileSizeKB</td>";
        // Mostrar el botón de borrar solo para administradores
        if ($_SESSION['user_role'] === 'admin') {
            echo "<td><button onclick=\"deleteFile('$file')\">Borrar</button></td>";
        } else {
            echo "<td>No disponible</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
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

