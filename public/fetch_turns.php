<?php
include '../includes/config.php';

$query = "SELECT u.*, (SELECT COUNT(*) FROM turnos t WHERE t.id_usuario = u.id AND t.estado = 'pendiente') AS tiene_turno FROM usuarios u";
if (isset($_GET['query']) && $_GET['query'] !== '') {
    $search = $_GET['query'];
    $query .= " WHERE documento LIKE '%$search%'";
}

$result = mysqli_query($conn, $query);
$users = [];

while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}

header('Content-Type: application/json');
echo json_encode($users);
mysqli_close($conn);
?>
