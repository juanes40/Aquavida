<?php
// Incluir archivo de conexión a la base de datos
include("connection.php");

// Verificar si se han enviado los datos para actualizar la planta
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = connection(); // Función para establecer la conexión a la base de datos

    // Obtener los datos enviados desde el formulario de edición
    $idPlanta = $_POST['idPlanta'];
    $nombre = $_POST['nombre'];
    $tipo = $_POST['tipo'];
    $idUsuario =$_POST['user_id'];

    // Consulta SQL para actualizar los datos de la planta
    $sql = "UPDATE plantas SET nombre = ?, tipo = ? , user_id = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $nombre, $tipo,$idUsuario, $idPlanta); // "ssi" indica tipos de datos: string, string, entero
    $stmt->execute();

    // Verificar si se realizó la actualización correctamente
    if ($stmt->affected_rows > 0) {
        Header("Location: ../html/actualizarplantas.html");
    } else {
        // Manejar errores
    echo "Error: " . mysqli_error($conn);
    }

    // Cierra la conexión a la base de datos
    $conn->close();
} else {
    // Si no se recibieron datos POST, devuelve un mensaje de error como JSON
    echo json_encode(array('error' => 'No se recibieron datos para actualizar la planta'));
}
?>
