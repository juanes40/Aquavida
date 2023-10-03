<?php

include("connection.php");
$con = connection();

$id = $_POST['identificacion'];
$name = $_POST['nombres'];
$lastname = $_POST['apellidos'];
$username = $_POST['usuario'];
$password = $_POST['contraseña'];

$sql="UPDATE users VALUES('$id','$name','$lastname','$username','$password')";
$query = mysqli_query($con, $sql);

if($query){
    Header("Location: ../html/editarUsuario.html");;
}else{

}

?>