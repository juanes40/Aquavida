<?php
include("connection.php");
$conn = connection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica si se ha enviado el formulario
    $newTiempoTemp = $_POST["temperaturaSensor"];
    $newTiempoNivel = $_POST["nivelAguaSensor"];
    $newTiempoPH = $_POST["phSensor"];

    // Actualiza los campos en la base de datos
    $sql = "UPDATE sensordata SET tiempotemp = '$newTiempoTemp', tiemponivel = '$newTiempoNivel', tiempoph = '$newTiempoPH' ORDER BY id DESC LIMIT 1";

    if ($conn->query($sql) === TRUE) {
        echo "Valores actualizados correctamente";
    } else {
        echo "Error al actualizar los valores: " . $conn->error;
    }
}

$sql = "SELECT tiempotemp, tiemponivel, tiempoph FROM sensordata ORDER BY id DESC LIMIT 1";
$query = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($query)){
    $tiempotemp = $row['tiempotemp'];
    $tiemponivel = $row['tiemponivel'];
    $tiempoph = $row['tiempoph'];
    $sensorData = array(
        'phSensor' => $tiempoph,
        'temperaturaSensor' => $tiempotemp,
        'nivelAguaSensor' => $tiemponivel
    );

    // Imprimir los datos como JSON
    echo json_encode($sensorData);
}

// Cierra la conexión a la base de datos
$conn->close();
?>
