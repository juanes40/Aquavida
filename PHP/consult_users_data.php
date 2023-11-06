<?php
include("connection.php");
$conn = connection();
include("cifrarDatos.php");
$clave = 'clave';

// Obtén el ID del usuario enviado desde el formulario
if (isset($_POST["idUsuario"])) {
    $idUsuario = $_POST["idUsuario"];

    // Realiza la consulta SQL para obtener los datos del usuario
    $sql = "SELECT id, name, lastname, username, password, identifier FROM users WHERE id = $idUsuario";
    $result = $conn->query($sql);

    if ($result) {
        $usuarioEncontrado = $result->fetch_assoc();

        if ($usuarioEncontrado) {
            // El usuario fue encontrado, obtén los datos
            $nombres = $usuarioEncontrado["name"];
            $apellidos = $usuarioEncontrado["lastname"];
            $id = $usuarioEncontrado["id"];
            $usuario = $usuarioEncontrado["username"];
            $contraseña = $usuarioEncontrado["password"];
            $identificador = $usuarioEncontrado["identifier"];

            $usuarioDescifrado = decryptData($usuario,$clave);
            // Crea un arreglo asociativo con los datos del usuario
            $usuarioEncontrado = array(
                "nombres" => $nombres,
                "apellidos" => $apellidos,
                "id" => $id,
                "usuario" => $usuarioDescifrado,
                "identificador" => $identificador,
            );

            // Devuelve los datos en formato JSON
            echo json_encode($usuarioEncontrado);
        } else {
            // El usuario no fue encontrado
            $respuestaError = array(
                "error" => "Usuario no encontrado"
            );
            echo json_encode($respuestaError);
        }
    } else {
        // Error en la consulta SQL
        $respuestaError = array(
            "error" => "Error en la consulta SQL"
        );
        echo json_encode($respuestaError);
    }
} else {
    echo "ID del usuario no proporcionado";
}

// Cierra la conexión a la base de datos
$conn->close();
?>

