<?php

// Conexión con la base de datos
include("connection.php");
$conn = connection();
include("cifrarDatos.php");

// Obtener datos del formulario
$idUsuario = $_POST["idUsuario"];
$nombres = $_POST["nombres"];
$apellidos = $_POST["apellidos"];
$identificacion = $_POST["id"];
$usuario = $_POST["usuario"];
$contraseña = $_POST["contraseña"];
$identificador = $_POST["identificador"]; 
$clave = 'clave';
// Hasheamos la contraseña usando password_hash
$hashedPassword = password_hash($contraseña, PASSWORD_DEFAULT);
$usuarioCifrado = encryptData($usuario,$clave);
//$identificacionCifrada = encryptData($identificacion,$clave);

// Actualizar datos en la base de datos
$sql = "UPDATE users SET name='$nombres', lastname='$apellidos', id='$identificacion', username='$usuarioCifrado', password='$hashedPassword', identifier='$identificador' WHERE id='$idUsuario'";
$query = mysqli_query($conn, $sql);

if ($query) {
    Header("Location: ../html/editarUsuario.html");
} else {
    echo "Error al actualizar los datos: " . mysqli_error($conn);
}


$conn->close();
?>
