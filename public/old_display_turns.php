<?php
include '../includes/config.php';
include '../includes/functions.php';
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Display de Turnos</title>
    <link rel="stylesheet" href="/css/display_style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let previousInProcessTurns = [];

        function fetchTurns() {
            $.ajax({
                url: 'get_turns.php',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    let tbodyInProcess = $('#turnos-in-process-body');
                    let tbodyFinished = $('#turnos-finished-body');

                    tbodyInProcess.empty();
                    tbodyFinished.empty();

                    let currentInProcessTurns = data.in_process;
                    let finishedTurns = data.finished;

                    // Mostrar los turnos en proceso
                    currentInProcessTurns.forEach(turno => {
                        let row = `<tr>
                            <td>${turno.id}</td>
                            <td>${turno.usuario_nombre}</td>
                            <td>${turno.modulo_nombre ? turno.modulo_nombre : 'No asignado'}</td>
                            <td>${turno.estado}</td>
                        </tr>`;
                        tbodyInProcess.append(row);
                    });

                    // Mostrar los turnos finalizados
                    finishedTurns.forEach(turno => {
                        let row = `<tr>
                            <td>${turno.id}</td>
                            <td>${turno.usuario_nombre}</td>
                            <td>${turno.modulo_nombre ? turno.modulo_nombre : 'No asignado'}</td>
                            <td>${turno.estado}</td>
                        </tr>`;
                        tbodyFinished.append(row);
                    });

                    // Comparar turnos actuales con los anteriores
                    let newInProcessTurns = currentInProcessTurns.filter(turno => 
                        !previousInProcessTurns.some(prevTurno => prevTurno.id === turno.id)
                    );

                    // Reproducir el sonido si hay nuevos turnos en proceso
                    if (newInProcessTurns.length > 0) {
                        document.getElementById("turno-sound").play();
                    }

                    // Actualizar el estado de turnos anteriores
                    previousInProcessTurns = currentInProcessTurns;
                }
            });
        }

        $(document).ready(function() {
            fetchTurns();
            setInterval(fetchTurns, 6000); // Actualiza cada 6 segundos
        });
    </script>
</head>
<body>
    <div class="container">
        <h2>Turnos del Día</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Módulo</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody id="turnos-in-process-body">
                <!-- Turnos en proceso serán cargados aquí por AJAX -->
            </tbody>
        </table>
        
        <h2>Últimos 5 Turnos Finalizados</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Módulo</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody id="turnos-finished-body">
                <!-- Turnos finalizados serán cargados aquí por AJAX -->
            </tbody>
        </table>
    </div>
    
    <!-- Audio para el sonido de turno llamado -->
    <audio id="turno-sound" src="../tonos/tono.mp3" preload="auto"></audio>
</body>
</html>