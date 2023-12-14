<?php
// Incluir archivo de conexión a la base de datos
include("connection.php");

// Verificar si se ha enviado un ID de planta
if (isset($_POST['idPlanta'])) {
    $conn = connection(); // Función para establecer la conexión a la base de datos

    // Obtener el ID de la planta enviado desde el formulario
    $idPlanta = $_POST['idPlanta'];

    // Consulta SQL para obtener los datos de la planta con el ID proporcionado
    $sql = "SELECT id, nombre, tipo, user_id FROM plantas WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idPlanta); // "i" indica que el parámetro es de tipo entero
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Si se encuentra la planta, devuelve sus datos como JSON
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        // Si no se encuentra la planta, devuelve un mensaje de error como JSON
        echo json_encode(array('error' => 'Planta no encontrada'));
    }

    // Cierra la conexión a la base de datos
    $conn->close();
} else {
    // Si no se envió un ID de planta, devuelve un mensaje de error como JSON
    echo json_encode(array('error' => 'ID de planta no especificado'));
}
?>
