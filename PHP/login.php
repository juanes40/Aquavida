<?php
include("connection.php");
$conn = connection();
include("cifrarDatos.php");

session_start();

// Obtiene los datos del formulario
$usuario = $_POST["usuario"];
$contraseña = $_POST["contraseña"];
$clave = 'clave';

// Consulta SQL para obtener todos los registros de usuarios y sus contraseñas cifradas
$sql = "SELECT username, password, identifier, id FROM users";
$result = $conn->query($sql);

$usuarioDescifrado = null;
while ($row = $result->fetch_assoc()) {
    $usuarioCifrado = $row['username'];
    $usuarioDescifrado = decryptData($usuarioCifrado, $clave);

    if ($usuarioDescifrado == $usuario) {
        break;  // Si se encuentra una coincidencia, sal del bucle
    }
}

if ($usuarioDescifrado != null) {
    // Ahora puedes proceder con la verificación de la contraseña
    $hashFromDatabase = $row['password'];
    $identifier = $row['identifier'];
    $id =$row['id'];

    if (password_verify($contraseña, $hashFromDatabase)) {
        $_SESSION['user_id'] = $row['id'];
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
