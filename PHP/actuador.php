<?php
include("connection.php");
$conn = connection();

if ($_SERVER["REQUEST_METHOD"] === "POST" || isset($_POST['switchValue'])) {
    $newEstado = isset($_POST['switchValue']) ? $_POST['switchValue']: null;

    $sql = "UPDATE actuadorLuz SET switch_estado = '$newEstado' ORDER BY id DESC LIMIT 1";

    if ($conn->query($sql) === TRUE) {
        // Enviar una respuesta JSON
        echo json_encode(['success' => true]);
        exit;
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
} else {
    // Si no se recibe una solicitud POST, obtener el valor actual del switch
    $sql = "SELECT switch_estado FROM actuadorLuz ORDER BY id DESC LIMIT 1";
    $query = mysqli_query($conn, $sql);
    
    if ($query) {
        $row = mysqli_fetch_assoc($query);
        $switch_estado = $row['switch_estado'];
        
        // Retornar el estado del switch en formato JSON
        echo json_encode(['switch_estado' => $switch_estado]);
    } else {
        echo json_encode(['switch_estado' => 'off']); // Si no se puede obtener el valor, se establece por defecto como 'off'
    }
}

$conn->close();
?>
