<?php

// Root de la aplicación a partir de http://localhost/
define("APP_ROOT", "/pwe2024/practica06_FileManager/");

// Ruta física de la aplicación
define("APP_PATH", "/opt/lampp/htdocs/practica06_FileManager/");

// Directorio donde se van a subir los archivos
define("DIR_UPLOAD", "/opt/lampp/htdocs/archivos_subidos/");

// Extensiones de archivos con su correspondiente content-type.
$CONTENT_TYPES_EXT = [
    "jpg" => "image/jpeg",
    "jpeg" => "image/jpeg",
    "gif" => "image/gif",
    "png" => "image/png",
    "json" => "application/json",
    "pdf" => "application/pdf",
    "bin" => "application/octet-stream"
];
