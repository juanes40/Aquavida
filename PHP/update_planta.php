<?php

// Conexión con la base de datos
include("connection.php");
$conn = connection();

// Obtener datos del formulario
$idPlanta = $_POST["idPlanta"];
$nombre = $_POST["nombre"];
$tipo = $_POST["tipo"];
$user_id = $_POST["user_id"];


// Actualizar datos en la base de datos
$sql = "UPDATE users SET name='$nombre', tipo='$tipo', user_id='$user_id' WHERE id='$idPlanta'";
$query = mysqli_query($conn, $sql);

if ($query) {
    Header("Location: ../html/editarPlanta.html");
} else {
    echo "Error al actualizar los datos: " . mysqli_error($conn);
}


$conn->close();
?>