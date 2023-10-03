<?php
// Conexión a la base de datos (reemplaza los datos con los tuyos)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aqua_vida";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error en la conexión a la base de datos: " . $conn->connect_error);
}

// Obtener datos del formulario
$idUsuario = $_POST["idUsuario"];
$nombres = $_POST["nombres"];
$apellidos = $_POST["apellidos"];
$identificacion = $_POST["identificacion"];
$usuario = $_POST["usuario"];
$contraseña = $_POST["contraseña"];

// Actualizar datos en la base de datos (esto es solo un ejemplo, debes ajustarlo según tu estructura de base de datos)
$sql = "UPDATE users SET nombres='$nombres', apellidos='$apellidos', identificacion='$identificacion', usuario='$usuario', contraseña='$contraseña' WHERE id='$idUsuario'";

if ($conn->query($sql) === TRUE) {
    echo "Los datos se actualizaron correctamente.";
} else {
    echo "Error al actualizar los datos: " . $conn->error;
}

$conn->close();
?>
