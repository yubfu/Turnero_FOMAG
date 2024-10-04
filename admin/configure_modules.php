<?php
include '../includes/config.php';
include '../includes/functions.php';
session_start();

redirectIfNotAdmin();

// Obtener lista de funcionarios desde la base de datos
$funcionarios_query = "SELECT id, nombre FROM funcionarios";
$funcionarios_result = mysqli_query($conn, $funcionarios_query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_modulo = $_POST['nombre'];
    $id_funcionario = $_POST['id_funcionario'];

    // Insertar el nuevo módulo con el ID del funcionario
    $query = "INSERT INTO modulos (nombre, id_funcionario) VALUES ('$nombre_modulo', '$id_funcionario')";
    mysqli_query($conn, $query);
}

// Obtener lista de módulos existentes con los datos de los funcionarios
$query = "SELECT m.id, m.nombre, f.nombre AS nombre_funcionario
          FROM modulos m
          LEFT JOIN funcionarios f ON m.id_funcionario = f.id";
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
        <select name="id_funcionario" required>
            <option value="">Seleccione un Funcionario</option>
            <?php while ($funcionario = mysqli_fetch_assoc($funcionarios_result)): ?>
                <option value="<?php echo $funcionario['id']; ?>"><?php echo $funcionario['nombre']; ?></option>
            <?php endwhile; ?>
        </select>
        <button type="submit">Agregar Módulo</button>
    </form>

    <h3>Módulos Actuales</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Módulo</th>
                <th>Nombre del Funcionario</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['nombre_funcionario'] ? $row['nombre_funcionario'] : 'No asignado'; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="dashboard.php">Volver al Panel de Control</a>
</body>
</html>
