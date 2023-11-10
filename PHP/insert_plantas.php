<?php
include("connection.php");
$conn = connection();

$id = $_POST['identificacion'];
$nombre = $_POST['nombre'];
$tipo = $_POST['tipo'];
$user_id = $_POST['usuario'];



$sql = "INSERT INTO users (id, nombre, tipo, username, user_id) VALUES ('$id', '$nombre', '$tipo', '$user_id')";
$query = mysqli_query($conn, $sql);

if ($query) {
    Header("Location: ../html/crearPlantas.html");
} else {
    // Manejar errores
    echo "Error: " . mysqli_error($conn);
}
?>