<?php
include '../includes/config.php';
include '../includes/functions.php';
session_start();
redirectIfNotAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $documento = $_POST['documento'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];

    try {
        $query = "INSERT INTO usuarios (nombre, documento, correo, telefono) VALUES ('$nombre', '$documento', '$correo', '$telefono')";
        if (mysqli_query($conn, $query)) {
            $success = "Usuario registrado exitosamente";
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() === 1062) { // Código de error MySQL para entrada duplicada
            // Verificar qué campo causó el duplicado
            if (strpos($e->getMessage(), 'correo') !== false) {
                $error = "El correo ya está registrado. Por favor, use un correo diferente.";
            } elseif (strpos($e->getMessage(), 'documento') !== false) {
                $error = "El documento ya está registrado. Por favor, use un documento diferente.";
            } else {
                $error = "Error al registrar usuario: " . $e->getMessage();
            }
        } else {
            $error = "Error al registrar usuario: " . $e->getMessage();
        }
    }
}


mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Usuario</title>
    <link rel="stylesheet" href="../css/R_user.css">
</head>
<body>
    <div class="container">
    <h2>Registrar Usuario</h2>
    <form method="POST">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="text" name="documento" placeholder="Documento" required>
        <input type="email" name="correo" placeholder="Correo" required>
        <input type="text" name="telefono" placeholder="Teléfono" required>
        <button type="submit">Registrar</button>
    </form>
    <a href="dashboard.php">Volver al Panel de Control</a>
    <?php if (isset($success)) { echo "<p>$success</p>"; } ?>
    <?php if (isset($error)) { echo "<p>$error</p>"; } ?>

    </div>
 
</body>
</html>
