
<?php
    // Incluir el archivo de conexión a la base de datos
    include("connection.php");
    $conn = connection();

    // Consultar los datos de la tabla "datos_sensores"
    $sql = "SELECT * FROM sensordata";
    $query = mysqli_query($conn, $sql);

    // Mostrar los datos en la tabla
    while ($row = mysqli_fetch_assoc($query)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['sensor1'] . "</td>";
        echo "<td>" . $row['location'] . "</td>";
        echo "<td>" . $row['value1'] . "</td>";
        echo "<td>" . $row['sensor2'] . "</td>";
        echo "<td>" . $row['value2'] . "</td>";
        echo "<td>" . $row['sensor3'] . "</td>";
        echo "<td>" . $row['value3'] . "</td>";
        echo "<td>" . $row['reading_time'] . "</td>";
        echo "</tr>";
    }

        mysqli_close($conn);
?>

