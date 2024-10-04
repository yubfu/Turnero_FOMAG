<?php
include '../includes/config.php';
include '../includes/functions.php';
session_start();
redirectIfNotAdmin();

$data = json_decode(file_get_contents('php://input'), true);
$id_usuario = $data['id_usuario'];

if ($id_usuario) {
    $numero_turno = getNextTurnNumber();
    $query = "INSERT INTO turnos (id_usuario, numero_turno, estado) VALUES ('$id_usuario', '$numero_turno', 'pendiente')";
    if (mysqli_query($conn, $query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'No se proporcionó un ID de usuario']);
}
mysqli_close($conn);
?>
