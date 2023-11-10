<?php

include("connection.php");
$conn = connection();

// Obtener datos del formulario
$idPlanta = $_POST["idUsuario"];
$nombre = $_POST["nombres"];
$tipo = $_POST["apellidos"];
$user_id = $_POST["id"];


//senstencia para eliminar usuario
$sql = "DELETE FROM users WHERE id = '$idUsuario'";
$query = mysqli_query($conn, $sql);

if ($query) {
    Header("Location: ../html/eliminarUsuario.html");
} else {
    echo "Error al actualizar los datos: " . $conn->error;
}

$conn->close();
?>