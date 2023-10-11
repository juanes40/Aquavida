<?php
include("connection.php");
$conn = connection();

// Obtiene los datos del formulario
$usuario = $_POST["usuario"];
$contraseña = $_POST["contraseña"];

// Consulta SQL para verificar el usuario y la contraseña
$sql = "SELECT * FROM users WHERE username='$usuario' AND password='$contraseña'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    // Inicio de sesión exitoso, redirige al usuario a la página de inicio
    header("Location: ../HTML/adminInicial.html");
} else {
    echo "<script>alert('Usuario o contraseña inválidos. Por favor, inténtelo de nuevo.');</script>";
    echo "<script>window.location.href='../HTML/login.html';</script>";
}

// Cierra la conexión a la base de datos
$conn->close();
?>
