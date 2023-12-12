<?php
session_start(); // Inicia la sesión

if (isset($_SESSION['user_id'])) {
    include("connection.php");
    $conn = connection();

    // Obtén el ID del usuario de la sesión
    $usuario_actual = $_SESSION['user_id'];

    // Consulta para obtener las plantas asignadas al usuario actual
    $sql = "SELECT id, nombre, tipo FROM plantas WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_actual); // "i" indica que el parámetro es de tipo entero
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $plantas = array();
        while ($row = $result->fetch_assoc()) {
            $plantas[] = $row; // Almacena los datos de las plantas en un arreglo
        }

        // Devuelve los datos de las plantas como JSON
        header('Content-Type: application/json');
        echo json_encode($plantas);
    } else {
        // Si no hay plantas asignadas al usuario, devuelve un JSON con un mensaje indicando esto
        $mensaje = array('mensaje' => 'El usuario no tiene plantas asignadas.');
        header('Content-Type: application/json');
        echo json_encode($mensaje);
    }

    // Cierra la conexión a la base de datos
    $conn->close();
} else {
    // Si no se ha iniciado sesión, devuelve un JSON con un mensaje de error
    $mensaje_error = array('error' => 'No se ha iniciado sesión.');
    header('Content-Type: application/json');
    echo json_encode($mensaje_error);
}
?>
