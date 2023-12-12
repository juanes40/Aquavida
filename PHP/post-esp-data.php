<?php

$servername = "localhost";

// REPLACE with your Database name
$dbname = "aqua_vida";
// REPLACE with Database user
$username = "juanes";
// REPLACE with Database user password
$password = "";

$email_address = "juanesbale53@gmail.com";
// Keep this API Key value to be compatible with the ESP32 code provided in the project page. 
// If you change this value, the ESP32 sketch needs to match
$api_key_value = "tPmAT5Ab3j7F9";

$api_key= $sensor1 = $location = $value1 =$sensor2 = $value2 = $sensor3 = $value3 = $tiempotemp = $tiemponivel = $tiempoph ="";
//echo $_SERVER["REQUEST_METHOD"];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = test_input($_POST["api_key"]);
    if($api_key == $api_key_value) {
        $sensor1 = test_input($_POST["sensor1"]);
        $location = test_input($_POST["location"]);
        $value1 = test_input($_POST["value1"]);
        $sensor2 = test_input($_POST["sensor2"]);
        $value2 = test_input($_POST["value2"]);
        $sensor3 = test_input($_POST["sensor3"]);
        $value3 = test_input($_POST["value3"]);
        $tiempotemp = test_input($_POST["tiempotemp"]);
        $tiemponivel = test_input($_POST["tiemponivel"]);
        $tiempoph = test_input($_POST["tiempoph"]);
        
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        
        $sql = "INSERT INTO SensorData (sensor1, location, value1, sensor2, value2, sensor3, value3, tiempotemp, tiemponivel, tiempoph)
        VALUES ('$sensor1', '$location', '$value1', '$sensor2', '$value2', '$sensor3', '$value3', '$tiempotemp', '$tiemponivel', '$tiempoph')";

        //echo $sql;
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } 
        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }


        $email_msg = "Temperatura:" . $value1;
        $email_msg = wordwrap($email_msg, 70);
        if($value1 > 20.0){
            mail($email_address, "[NEW] ¡ALERTA! temperatura excedida", $email_msg);
            echo "Email sent";
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
