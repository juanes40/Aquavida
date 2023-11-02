<?php
// Conexión a la base de datos (reemplaza con tus propios datos)
function connection() {
    
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "aqua_vida";

    // Crear y verificar la conexión
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("La conexión a la base de datos falló: " . $conn->connect_error);
        
    }

    return $conn; // Devuelve la conexión
}

?>