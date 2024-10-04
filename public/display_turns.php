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
    <link rel="stylesheet" href="../css/display_style.css">
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
                    for (let i = 0; i < 6; i++) {
                        if (i < currentInProcessTurns.length) {
                            let turno = currentInProcessTurns[i];
                            let row = `<tr>
                                <td>${turno.numero_turno}</td>
                                <td>${turno.usuario_nombre}</td>
                                <td>${turno.modulo_nombre ? turno.modulo_nombre : 'No asignado'}</td>
                                <td>${turno.estado}</td>
                            </tr>`;
                            tbodyInProcess.append(row);
                        } else {
                            // Rellenar con filas vacías si no hay suficientes turnos en proceso
                            let row = `<tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>`;
                            tbodyInProcess.append(row);
                        }
                    }

                    // Mostrar los turnos finalizados
                    finishedTurns.forEach(turno => {
                        let row = `<tr>
                            <td>${turno.numero_turno}</td>
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
            setInterval(fetchTurns, 15000); // Actualiza cada 10 segundos 
        });
    </script>
</head>
<body>
    <div class="container">
        <h2>Turnos en progreso</h2>
        <table>
            <thead>
                <tr>
                    <th>Turno No.</th>
                    <th>Usuario</th>
                    <th>Módulo</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody id="turnos-in-process-body">
                <!-- Turnos en proceso serán cargados aquí por AJAX -->
            </tbody>
        </table>
        
        <h2>Turnos Finalizados</h2>
        <table>
            <thead>
                <tr>
                    <th>Turno No.</th>
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
