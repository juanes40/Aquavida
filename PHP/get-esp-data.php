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

$api_key= $sensor1 = $location = $value1 =$sensor2 = $value2 = $sensor3 = $value3 = $tiempotemp = $tiemponivel = $tiempoph = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $api_key = test_input($_GET["api_key"]);
    if($api_key == $api_key_value) {
        $tiempotemp = test_input($_GET["tiempo1"]);
        $tiemponivel = test_input($_GET["tiempo2"]);
        $tiempoph = test_input($_GET["tiempo3"]);
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        
        $sql = "SELECT * FROM sensordata ORDER BY id DESC LIMIT 1";
        if ($result = $conn->query($sql)) {
            $row = mysqli_fetch_row($result);
            $var = $row[9] . "," . $row[10] . "," . $row[11];
            echo $var;
            //echo "tiempo";
        }
        else {
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
