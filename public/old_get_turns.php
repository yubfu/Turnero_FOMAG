<?php
include '../includes/config.php';
session_start();

$query = "SELECT t.id, u.nombre AS usuario_nombre, m.nombre AS modulo_nombre, t.estado 
          FROM turnos t 
          JOIN usuarios u ON t.id_usuario = u.id 
          LEFT JOIN modulos m ON t.id_modulo = m.id 
          WHERE t.estado = 'en proceso'"; // Solo los turnos en proceso
$result = mysqli_query($conn, $query);

$turnos = [];
while ($row = mysqli_fetch_assoc($result)) {
    $turnos[] = $row;
}

header('Content-Type: application/json');
echo json_encode($turnos);
?>

// otra logica ///

<?php
include '../includes/config.php';
session_start();

$query_in_process = "SELECT t.id, u.nombre AS usuario_nombre, m.nombre AS modulo_nombre, t.estado 
          FROM turnos t 
          JOIN usuarios u ON t.id_usuario = u.id 
          LEFT JOIN modulos m ON t.id_modulo = m.id_funcionario
          WHERE t.estado = 'en proceso'";

$query_finished = "SELECT t.id, u.nombre AS usuario_nombre, m.nombre AS modulo_nombre, t.estado 
          FROM turnos t 
          JOIN usuarios u ON t.id_usuario = u.id 
          LEFT JOIN modulos m ON t.id_modulo = m.id_funcionario
          WHERE t.estado = 'finalizado'
          ORDER BY t.fin DESC 
          LIMIT 5"; // Limitar a los últimos 5 turnos finalizados

$result_in_process = mysqli_query($conn, $query_in_process);
$result_finished = mysqli_query($conn, $query_finished);

$turnos_in_process = [];
$turnos_finished = [];

while ($row = mysqli_fetch_assoc($result_in_process)) {
    $turnos_in_process[] = $row;
}

while ($row = mysqli_fetch_assoc($result_finished)) {
    $turnos_finished[] = $row;
}



$response = [
    'in_process' => $turnos_in_process,
    'finished' => $turnos_finished
];

header('Content-Type: application/json');
echo json_encode($response);

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>
