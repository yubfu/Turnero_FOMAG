<?php
include '../includes/config.php';
include '../includes/functions.php';
session_start();

redirectIfNotFuncionario();

// Establecer la zona horaria a 'America/Bogota'
date_default_timezone_set('America/Bogota');

$funcionario_id = $_SESSION['funcionario_id'];

// Obtener los datos del funcionario conectado
$query_funcionario = "SELECT * FROM funcionarios WHERE id='$funcionario_id'";
$result_funcionario = mysqli_query($conn, $query_funcionario);
$funcionario = mysqli_fetch_assoc($result_funcionario);

// Obtener el nombre del módulo del funcionario
$query_modulo = "SELECT * FROM modulos WHERE id_funcionario='$funcionario_id'";
$result_modulo = mysqli_query($conn, $query_modulo);
$modulo = mysqli_fetch_assoc($result_modulo);

// Contar los turnos pendientes y en proceso
$query_turnos_pendientes = "SELECT COUNT(*) AS total_pendientes FROM turnos WHERE estado='pendiente'";
$result_turnos_pendientes = mysqli_query($conn, $query_turnos_pendientes);
$turnos_pendientes = mysqli_fetch_assoc($result_turnos_pendientes)['total_pendientes'];

$query_turno_en_proceso = "SELECT COUNT(*) AS en_proceso FROM turnos WHERE estado='en proceso' AND id_modulo='$funcionario_id'";
$result_turno_en_proceso = mysqli_query($conn, $query_turno_en_proceso);
$turno_en_proceso = mysqli_fetch_assoc($result_turno_en_proceso)['en_proceso'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tomar Turnos</title>
    <link rel="stylesheet" href="../css/take_style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  
</head>
<body>
    <button class="logout-btn" onclick="window.location.href='logout.php'">Cerrar Sesión</button>
    <h2>Tomar Turnos</h2>

    <!-- Información del Funcionario y Módulo -->
    <div class="funcionario-info">
        <p><strong>Nombre del Funcionario:</strong> <?php echo htmlspecialchars($funcionario['nombre']); ?></p>
        <p><strong>Documento:</strong> <?php echo htmlspecialchars($funcionario['documento']); ?></p>
        <p><strong>Nombre del Módulo:</strong> <?php echo htmlspecialchars($modulo['nombre']); ?></p>
    </div>

    <!-- Contador de Turnos Pendientes -->
    <div class="contador-pendientes">
        <p><strong>Total de Turnos Pendientes:</strong> <span id="total_pendientes"><?php echo $turnos_pendientes; ?></span></p>
    </div>

    <!-- Tabla de Turnos Pendientes -->
    <h3>Turnos Pendientes y en Proceso</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Usuario</th>
                <th>Documento del Usuario</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody id="turnos_pendientes">
            <!-- Turnos pendientes serán cargados aquí por AJAX -->
        </tbody>
    </table>

    <script>
        function fetchPendingTurns() {
            $.ajax({
                url: 'get_pending_turns.php',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    var turnosHTML = '';
                    data.forEach(function(turno) {
                        turnosHTML += '<tr>';
                        turnosHTML += '<td>' + turno.id + '</td>';
                        turnosHTML += '<td>' + turno.nombre + '</td>';
                        turnosHTML += '<td>' + turno.documento + '</td>';
                        turnosHTML += '<td>' + turno.estado + '</td>';
                        if (turno.estado === 'pendiente') {
                            if (<?php echo $turno_en_proceso; ?> == 0) { // Solo mostrar turnos pendientes si no hay turnos en proceso
                                turnosHTML += '<td><form method="POST" action="start_turn.php">';
                                turnosHTML += '<input type="hidden" name="turno_id" value="' + turno.id + '">';
                                turnosHTML += '<button type="submit">Iniciar Turno</button>';
                                turnosHTML += '</form></td>';
                            } else {
                                turnosHTML += '<td>Turno por asignar</td>';
                            }
                        } else if (turno.estado === 'en proceso') {
                            turnosHTML += '<td><form method="POST" action="finalize_turn.php">';
                            turnosHTML += '<input type="hidden" name="turno_id" value="' + turno.id + '">';
                            turnosHTML += '<button type="submit">Finalizar Turno</button>';
                            turnosHTML += '</form></td>';
                        }
                        turnosHTML += '</tr>';
                    });
                    $('#turnos_pendientes').html(turnosHTML);
                    $('#total_pendientes').text(data.filter(turno => turno.estado === 'pendiente').length);
                }
            });
        }

        $(document).ready(function() {
            fetchPendingTurns();
            setInterval(fetchPendingTurns, 20000); // Actualizar cada 20 segundos
        });
    </script>
</body>
</html>

