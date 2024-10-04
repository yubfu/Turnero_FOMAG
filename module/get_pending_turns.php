<?php
include '../includes/config.php';
include '../includes/functions.php';
session_start();

redirectIfNotFuncionario();

$funcionario_id = $_SESSION['funcionario_id'];

// Obtener los turnos pendientes y los turnos en proceso que fueron aceptados por el funcionario actual
$query_turnos = "SELECT * FROM turnos WHERE (estado = 'pendiente') OR (estado = 'en proceso' AND id_modulo = '$funcionario_id') ORDER BY id ASC";
$result_turnos = mysqli_query($conn, $query_turnos);

$turnos = [];

while ($row = mysqli_fetch_assoc($result_turnos)) {
    // Obtener los datos del usuario
    $query_usuario = "SELECT * FROM usuarios WHERE id='" . $row['id_usuario'] . "'";
    $result_usuario = mysqli_query($conn, $query_usuario);
    $usuario = mysqli_fetch_assoc($result_usuario);
    
    $turnos[] = [
        'id' => $row['id'],
        'nombre' => $usuario['nombre'],
        'documento' => $usuario['documento'],
        'estado' => $row['estado']
    ];
}

echo json_encode($turnos);
mysqli_close($conn); // Cierra la conexión aquí
?>

