<?php

include("connection.php");
$conn = connection();

// Keep this API Key value to be compatible with the ESP32 code provided in the project page. 
// If you change this value, the ESP32 sketch needs to match
$api_key_value = "tPmAT5Ab3j7F9";

$api_key= $sensor1 = $location = $value1 =$sensor2 = $value2 = $sensor3 = $value3 = "";

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
        
        
        
        $sql = "INSERT INTO SensorData (sensor1, location, value1, sensor2, value2, sensor3, value3)
        VALUES ('" . $sensor1 . "', '" . $location . "', '" . $value1 . "','" . $sensor2 . "', '" . $value2 . "', '" . $sensor3 . "', '" . $value3 . "')";
        
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } 
        else {
            echo "Error: " . $sql . "<br>" . $conn->error;
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
