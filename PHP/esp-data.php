<!DOCTYPE html>
<html><body>
<?php
/*
  Rui Santos
  Complete project details at https://RandomNerdTutorials.com/esp32-esp8266-mysql-database-php/
  
  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files.
  
  The above copyright notice and this permission notice shall be included in all
  copies or substantial portions of the Software.
*/

$servername = "localhost";

// REPLACE with your Database name
$dbname = "practica1";
// REPLACE with Database user
$username = "juanes";
// REPLACE with Database user password
$password = "";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT id, sensor1, location, value1, sensor2, value2, reading_time, alarma, tiempo FROM sensordata ORDER BY id DESC";

echo '<table cellspacing="5" cellpadding="5">
      <tr> 
        <td>ID</td> 
        <td>Sensor 1</td> 
        <td>Location</td> 
        <td>Temperatura</td> 
        <td>Sensor 2</td>
        <td>Nivel agua</td>
        <td>Timestamp</td> 
        <td>Alarma</td>
      </tr>
      <br>
      <a href="/Practica1DHT11/practica1paraSISEs/Alarma.php">Alarma</a>
      
      ';
 
if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $row_id = $row["id"];
        $row_sensor1 = $row["sensor1"];
        $row_location = $row["location"];
        $row_value1 = $row["value1"];
        $row_sensor2 = $row["sensor2"];
        $row_value2 = $row["value2"]; 
        $row_reading_time = $row["reading_time"];
        $row_alarma = $row["alarma"];
        $row_tiempo = $row["tiempo"];
        // Uncomment to set timezone to - 1 hour (you can change 1 to any number)
        //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time - 1 hours"));
      
        // Uncomment to set timezone to + 4 hours (you can change 4 to any number)
        //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time + 4 hours"));
      
        echo '
              <tr> 
                <td>' . $row_id . '</td> 
                <td>' . $row_sensor1 . '</td> 
                <td>' . $row_location . '</td> 
                <td>' . $row_value1 . '</td> 
                <td>' . $row_sensor2 . '</td> 
                <td>' . $row_value2 . '</td>
                <td>' . $row_reading_time . '</td> 
                <td>' . $row_alarma . '</td>
              </tr>';
    }
    $result->free();
}

$conn->close();
?> 
</table>
</body>
</html>
