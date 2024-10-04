<?php
include '../includes/config.php';
include '../includes/functions.php';
session_start();

redirectIfNotFuncionario();
// Establecer la zona horaria a 'America/Bogota'
date_default_timezone_set('America/Bogota');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['turno_id']) && !empty($_POST['turno_id'])) {
        $turno_id = $_POST['turno_id'];
        date_default_timezone_set('America/Bogota'); // Establecer la zona horaria a 'America/Bogota'
        $current_time = date('Y-m-d H:i:s');

        // Actualizar el estado del turno a 'en_proceso' y registrar el inicio
        $query = "UPDATE turnos SET estado='en proceso', inicio='$current_time', id_modulo='{$_SESSION['funcionario_id']}' WHERE id='$turno_id'";
        if (mysqli_query($conn, $query)) {
            // Redirigir de vuelta a la página de tomar turnos
            header("Location: take_turn.php");
            exit();
        } else {
            echo "Error al iniciar el turno: " . mysqli_error($conn);
        }
    } else {
        echo "ID de turno no válido.";
    }
} else {
    echo "Solicitud inválida.";
}
// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>













