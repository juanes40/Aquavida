<?php

$servername = "localhost";

// REPLACE with your Database name
$dbname = "aqua_vida";
// REPLACE with Database user
$username = "juanes";
// REPLACE with Database user password
$password = "";

// Keep this API Key value to be compatible with the ESP32 code provided in the project page. 
// If you change this value, the ESP32 sketch needs to match
$api_key_value = "tPmAT5Ab3j7F9";

$api_key = $switch_estado = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $api_key = test_input($_GET["api_key"]);
    if($api_key == $api_key_value) {
        $switch_estado = test_input($_GET["estadoLuz"]);
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        
        
            $sql_actuador = "SELECT * FROM actuadorluz ORDER BY id DESC LIMIT 1";
            if ($result_actuador = $conn->query($sql_actuador)) {
                $row_actuador = mysqli_fetch_row($result_actuador);
        
                // Concatenar datos de ambas tablas
                $var = $row_actuador[1];
                echo $var;
            } else {
                echo false;
            }
        
    
        $conn->close();
    }
    else {
        echo "Wrong API Key provided.";
    }

}
else {
    echo "No data get with HTTP GET.";
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}