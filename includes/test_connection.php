<?php
require '../includes/config.php';

?>
<!DOCTYPE html>
<html>
<head>
    <title>Prueba de Conexión</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <?php
    // Este mensaje se mostrará solo si la conexión fue exitosa
    if (!$conn->connect_error) {
        echo "<p>Conexión exitosa a la base de datos.</p>";
        
        // Realizar una consulta para obtener los administradores
        $sql = "SELECT * FROM administradores";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<h2>Administradores registrados:</h2>";
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>Nombre</th><th>Email</th><th>password</th></tr>";
            
            // Mostrar los datos de cada fila
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["id"]. "</td><td>" . $row["nombre"]. "</td><td>" . $row["correo"]. "</td><td>". $row["password"]. "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "No hay administradores registrados.";
        }
    } else {
        echo "Error de conexión a la base de datos: " . $conn->connect_error;
    }
    ?>
</body>
</html>
