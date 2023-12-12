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

$api_key = $switch_estado ="";
//echo $_SERVER["REQUEST_METHOD"];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = test_input($_POST["api_key"]);
    if($api_key == $api_key_value) {
        $switch_estado = test_input($_POST["switch_estado"]);
        
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        

        $sql1 = "INSERT INTO actuadorLuz (switch_estado)
        VALUES ('$switch_estado')";
        
        if ($conn->query($sql1) === TRUE) {
            echo "New record created luz";
        } 
        else {
            echo "Error: " . $sql1 . "<br>" . $conn->error;
        }
        $conn->close();
    }
    else {
        echo "Wrong API Key provided.";
    }

}
else {
    echo "No data posted with HTTP POST.";
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}