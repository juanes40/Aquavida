<?php
// Establecer la conexión con la base de datos
include("connection.php");
$conn = connection();

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para obtener las IDs de usuarios
$sql = "SELECT id FROM users";
$result = $conn->query($sql);

// Crear un array para almacenar las IDs de usuarios
$user_ids = array();

if ($result->num_rows > 0) {
    // Almacenar las IDs de usuarios en el array
    while($row = $result->fetch_assoc()) {
        $user_ids[] = $row["id"];
    }
}

// Devolver las IDs de usuarios como JSON (u otro formato adecuado)
echo json_encode($user_ids);

// Cerrar la conexión con la base de datos
$conn->close();
?>
