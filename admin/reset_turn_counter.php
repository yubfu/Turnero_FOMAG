<?php
include '../includes/config.php';
include '../includes/functions.php';
session_start();

redirectIfNotAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Reiniciar el contador a 0
    $query = "UPDATE turno_contador SET contador = 0 WHERE id = 1";
    
    if (mysqli_query($conn, $query)) {
        // Mostrar mensaje de alerta y redirigir al dashboard
        echo "<script>alert('El contador de turnos se ha reiniciado exitosamente.'); window.location.href = 'dashboard.php';</script>";
    } else {
        // Mostrar mensaje de error si algo falla
        echo "<script>alert('Error al reiniciar el contador de turnos: " . mysqli_error($conn) . "'); window.location.href = 'dashboard.php';</script>";
    }
}
?>
