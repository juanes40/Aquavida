
<?php
    // Incluir el archivo de conexión a la base de datos
    include("connection.php");
    $conn = connection();

    // Consultar los datos de la tabla "datos_sensores"
    $sql = "SELECT * FROM datos_sensores";
    $query = mysqli_query($conn, $sql);

    // Mostrar los datos en la tabla
    while ($row = mysqli_fetch_assoc($query)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['fecha_hora'] . "</td>";
        echo "<td>" . $row['ph_agua'] . "</td>";
        echo "<td>" . $row['nivel_agua'] . "</td>";
        echo "<td>" . $row['temperatura'] . "</td>";
        echo "<td>" . $row['ubicacion'] . "</td>";
        echo "</tr>";
    }

        mysqli_close($conn);
?>

