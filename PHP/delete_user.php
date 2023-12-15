<?php
include("connection.php");
$conn = connection();

// Obtener el ID del usuario a eliminar
$idUsuario = $_POST["idUsuario"];

// Eliminar las plantas asociadas al usuario
$sqlDeletePlants = "DELETE FROM plantas WHERE user_id = '$idUsuario'";
$queryDeletePlants = mysqli_query($conn, $sqlDeletePlants);

if (!$queryDeletePlants) {
    echo "Error al eliminar las plantas asociadas al usuario: " . $conn->error;
    exit; // Detener la ejecución si hay un error al eliminar las plantas
}

// Eliminar al usuario
$sqlDeleteUser = "DELETE FROM users WHERE id = '$idUsuario'";
$queryDeleteUser = mysqli_query($conn, $sqlDeleteUser);

if ($queryDeleteUser) {
    // Redireccionar o proporcionar algún mensaje de éxito
    Header("Location: ../html/eliminarUsuario.html");
} else {
    echo "Error al eliminar el usuario: " . $conn->error;
}

$conn->close();
?>
