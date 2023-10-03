<?php
// Realiza la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "aqua_vida";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("La conexión a la base de datos falló: " . $conn->connect_error);
}

// Obtén el ID del usuario enviado desde el formulario
if(isset($_POST["idUsuario"])) {
    $idUsuario = $_POST["idUsuario"];
    
    // Realiza la consulta SQL para obtener los datos del usuario
    $sql = "SELECT id, name, lastname, username, password FROM users WHERE id = $idUsuario";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // El usuario fue encontrado, obtén los datos
        $row = $result->fetch_assoc();
        $nombres = $row["name"];
        $apellidos = $row["lastname"];
        $id = $row["id"];
        $usuario = $row["username"];
        $contraseña = $row["password"];
        
        // Crea un arreglo asociativo con los datos del usuario
        $usuarioEncontrado = array(
            "nombres" => $nombres,
            "apellidos" => $apellidos,
            "id" => $id,
            "usuario" => $usuario,
            "contraseña" => $contraseña
        );

        // Devuelve los datos en formato JSON
        echo json_encode($usuarioEncontrado);
    } else {
        // El usuario no fue encontrado
        echo "Usuario no encontrado";
    }
} else {
    echo "ID del usuario no proporcionado";
}

// Cierra la conexión a la base de datos
$conn->close();
?>
