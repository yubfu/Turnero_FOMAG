<?php
include '../includes/config.php';
include '../includes/functions.php';
session_start();

redirectIfNotFuncionario();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['turno_id']) && !empty($_POST['turno_id'])) {
        $turno_id = $_POST['turno_id'];
        date_default_timezone_set('America/Bogota'); // Establecer la zona horaria a 'America/Bogota'
        $current_time = date('Y-m-d H:i:s');
        $current_date = date('Y-m-d');

        // Actualizar el estado del turno a 'finalizado' y registrar el fin
        $query = "UPDATE turnos SET estado='finalizado', fin='$current_time', fecha='$current_date' WHERE id='$turno_id'";
        if (mysqli_query($conn, $query)) {
            // Redirigir de vuelta a la página de tomar turnos
            header("Location: take_turn.php");
            exit();
        } else {
            echo "Error al finalizar el turno: " . mysqli_error($conn);
        }
    } else {
        echo "ID de turno no válido.";
    }
} else {
    echo "Solicitud inválida.";
}
mysqli_close($conn); // Asegúrate de cerrar la conexión aquí
?>


