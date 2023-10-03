<?php

//conexión con la bd
include("connection.php");
$conn = connection();

// Obtener datos del formulario
$idUsuario = $_POST["idUsuario"];
$nombres = $_POST["nombres"];
$apellidos = $_POST["apellidos"];
$identificacion = $_POST["id"];
$usuario = $_POST["usuario"];
$contraseña = $_POST["contraseña"];

// Actualizar datos en la base de datos 
$sql = "UPDATE users SET name='$nombres', lastname='$apellidos', id='$identificacion', username='$usuario', password='$contraseña' WHERE id='$idUsuario'";
$query = mysqli_query($conn, $sql);

if ($query) {
    Header("Location: ../html/editarUsuario.html");
} else {
    echo "Error al actualizar los datos: " . $conn->error;
}

$conn->close();
?>
