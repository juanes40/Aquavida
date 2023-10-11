<?php
include("connection.php");
$conn = connection();

// Obtiene los datos del formulario
$usuario = $_POST["usuario"];
$contraseña = $_POST["contraseña"];

// Consulta SQL para obtener el hash de la contraseña almacenada en la base de datos
$sql = "SELECT password FROM users WHERE username='$usuario'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $hashFromDatabase = $row['password'];

    // Verifica si la contraseña proporcionada coincide con el hash almacenado
    if (password_verify($contraseña, $hashFromDatabase)) {
        // Inicio de sesión exitoso, redirige al usuario a la página de inicio
        header("Location: ../HTML/adminInicial.html");
    } else {
        echo "<script>alert('Usuario o contraseña inválidos. Por favor, inténtelo de nuevo.');</script>";
        echo "<script>window.location.href='../HTML/login.html';</script>";
    }
} else {
    echo "<script>alert('Usuario o contraseña inválidos. Por favor, inténtelo de nuevo.');</script>";
    echo "<script>window.location.href='../HTML/login.html';</script>";
}

// Cierra la conexión a la base de datos
$conn->close();
?>
