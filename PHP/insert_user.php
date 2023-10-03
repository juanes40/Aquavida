<?php
include("connection.php");
$conn = connection();

$id = $_POST['identificacion'];
$name = $_POST['nombres'];
$lastname = $_POST['apellidos'];
$username = $_POST['usuario'];
$password = $_POST['contraseña'];


$sql = "INSERT INTO users VALUES('$id','$name','$lastname','$username','$password')";
$query = mysqli_query($conn, $sql);

if($query){
    Header("Location: ../html/crearUsuario.html");
}else{

}

?>