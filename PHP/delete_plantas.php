<?php

include("connection.php");
$conn = connection();

// Obtener datos del formulario
$idPlanta = $_POST["idPlanta"];
$nombre = $_POST["nombre"];
$tipo = $_POST["tipo"];
$user_id = $_POST["user_id"];


//senstencia para eliminar usuario
$sql = "DELETE FROM plantas WHERE id = '$idPlanta'";
$query = mysqli_query($conn, $sql);

if ($query) {
    Header("Location: ../html/eliminarPlantas.html");
} else {
    echo "Error al actualizar los datos: " . $conn->error;
}

$conn->close();
?>