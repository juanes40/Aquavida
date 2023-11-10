<?php
include("connection.php");
$conn = connection();

// Obtén el ID de la planta enviado desde el formulario
if (isset($_POST["idPlanta"])) {
    $idPlanta = $_POST["idPlanta"];

    // Realiza la consulta SQL para obtener los datos de la planta
    $sql = "SELECT id, nombre, tipo, user_id FROM plantas WHERE id = $idPlanta";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // La planta fue encontrada, obtén los datos
        $row = $result->fetch_assoc();
        $nombre = $row["nombre"];
        $tipo = $row["tipo"];
        $id =  $row["id"];
        $user_id = $row["user_id"];

        // Crea un arreglo asociativo con los datos de la planta
        $plantaEncontrada = array(
            "nombre" => $nombre,
            "tipo" => $tipo,
            "id" => $id,
            "user_id" => $user_id,
        );

        // Devuelve los datos en formato JSON
        echo json_encode($plantaEncontrada);
    } else {
        // La planta no fue encontrada
        $respuestaError = array(
            "error" => "Planta no encontrada"
        );
        echo json_encode($respuestaError);
    }
} else {
    echo "ID de la planta no proporcionado";
}

// Cierra la conexión a la base de datos
$conn->close();
?>
