<?php
include("connection.php");
$conn = connection();

// Obtiene los datos del formulario
$usuario = $_POST["usuario"];
$contraseña = $_POST["contraseña"];

// Consulta SQL para obtener el hash de la contraseña y el valor de "identifier" almacenado en la base de datos
$sql = "SELECT password, identifier FROM users WHERE username='$usuario'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $hashFromDatabase = $row['password'];
    $identifier = $row['identifier'];

    // Verifica si la contraseña proporcionada coincide con el hash almacenado
    if (password_verify($contraseña, $hashFromDatabase)) {
        // Comprueba el valor de "identifier" y redirige al usuario según su valor
        if ($identifier == 0) {
            header("Location: ../HTML/adminInicial.html");
        } elseif ($identifier == 1) {
            header("Location: ../HTML/usuarioFull.html");
        } else {
            // Valor de "identifier" no reconocido, puedes manejarlo de otra manera si es necesario
            echo "<script>alert('Valor de identifier no reconocido.');</script>";
            echo "<script>window.location.href='../HTML/login.html';</script>";
        }
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

