<?php
include("connection.php");
$conn = connection();
include("cifrarDatos.php");

$id = $_POST['identificacion'];
$name = $_POST['nombres'];
$lastname = $_POST['apellidos'];
$username = $_POST['usuario'];
$password = $_POST['contraseña'];
$identifier = $_POST['identificador'];
$clave = 'clave';

// Hasheamos la contraseña usando password_hash
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
$usuarioCifrado = encryptData($username,$clave);
//$idcifrada = encryptData($id,$clave);

// Utiliza el hash de la contraseña en lugar de la contraseña en el SQL
$sql = "INSERT INTO users (id, name, lastname, username, password, identifier) VALUES ('$id', '$name', '$lastname', '$usuarioCifrado', '$hashedPassword', '$identifier')";
$query = mysqli_query($conn, $sql);

if ($query) {
    Header("Location: ../html/crearUsuario.html");
} else {
    // Manejar errores
    echo "Error: " . mysqli_error($conn);
}
?>

