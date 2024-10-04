<?php
include '../includes/config.php';
include '../includes/functions.php';
session_start();
redirectIfNotAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $documento = $_POST['documento'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $query = "INSERT INTO funcionarios (nombre, documento, password) VALUES ('$nombre', '$documento', '$password')";
        if (mysqli_query($conn, $query)) {
            $success = "Funcionario registrado exitosamente";
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() === 1062) { // Código de error MySQL para entrada duplicada
            // Verificar qué campo causó el duplicado
            if (strpos($e->getMessage(), 'documento') !== false) {
                $error = "El documento ya está registrado. Por favor, use un documento diferente.";
            } else {
                $error = "Error al registrar funcionario: " . $e->getMessage();
            }
        } else {
            $error = "Error al registrar funcionario: " . $e->getMessage();
        }
    }

    mysqli_close($conn); // Cerrar la conexión a la base de datos
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Funcionario</title>
    <link rel="stylesheet" href="../css/R_funcionario.css">
</head>
<body>
    <div class="container">
    <h2>Registrar Funcionario</h2>
    <form method="POST">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="text" name="documento" placeholder="Documento" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Registrar</button>
    </form>
    <a href="dashboard.php">Volver al Panel de Control</a>
    <?php if (isset($success)) { echo "<p>$success</p>"; } ?>
    <?php if (isset($error)) { echo "<p>$error</p>"; } ?>

    </div> 
</body>
</html>
