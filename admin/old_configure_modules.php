<?php
include '../includes/config.php';
include '../includes/functions.php';
session_start();

redirectIfNotAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $funcionario_nombre = $_POST['nombre_funcionario'];
    $documento_funcionario = $_POST['documento_funcionario'];

    $query = "INSERT INTO modulos (nombre, nombre_funcionario, documento_funcionario) VALUES ('$nombre', '$funcionario_nombre', '$documento_funcionario')";
    mysqli_query($conn, $query);
}

$query = "SELECT * FROM modulos";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Configurar Módulos</title>
    <link rel="stylesheet" href="../css/module_confi_styles.css">
</head>
<body>
    <h2>Configurar Módulos</h2>
    <form method="POST">
        <input type="text" name="nombre" placeholder="Nombre del Módulo" required>
        <input type="text" name="nombre_funcionario" placeholder="Nombre del Funcionario" required>
        <input type="text" name="documento_funcionario" placeholder="Documento del Funcionario" required>
        <button type="submit">Agregar Módulo</button>
    </form>

    <h3>Módulos Actuales</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Módulo</th>
                <th>Nombre del Funcionario</th>
                <th>Documento del Funcionario</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['nombre_funcionario']; ?></td>
                <td><?php echo $row['documento_funcionario']; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="dashboard.php">Volver al Panel de Control</a>
</body>
</html>
