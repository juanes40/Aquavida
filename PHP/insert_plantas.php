<?php
include("connection.php");
$conn = connection();

// Obtener los valores del formulario de manera segura
$id = mysqli_real_escape_string($conn, $_POST['identificacion']);
$nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
$tipo = mysqli_real_escape_string($conn, $_POST['tipo']);
$user_id = mysqli_real_escape_string($conn, $_POST['user_id']);

// Verificar que el usuario con user_id exista en la tabla users
$checkUserQuery = "SELECT * FROM users WHERE id = '$user_id'";
$checkUserResult = mysqli_query($conn, $checkUserQuery);

if (mysqli_num_rows($checkUserResult) > 0) {
    // El usuario existe, proceder con la inserción en la tabla plantas
    $sql = "INSERT INTO plantas (id, nombre, tipo, user_id) VALUES ('$id', '$nombre', '$tipo', '$user_id')";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        Header("Location: ../html/crearPlantas.html");
    } else {
        // Manejar errores
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // El usuario con user_id no existe, manejar el error
    echo "Error: El usuario con ID $user_id no existe en la tabla users.";
}

// Cerrar la conexión
mysqli_close($conn);
?>
