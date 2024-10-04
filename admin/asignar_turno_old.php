<?php
include '../includes/config.php';
include '../includes/functions.php';
session_start();
redirectIfNotAdmin();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Turno</title>
    <link rel="stylesheet" href="../css/turnos_styles.css">
    
  
</head>
<body>
    <h2>Asignar Turno</h2>
    <input type="text" id="search-input" placeholder="Buscar por documento...">
    <div id="user-list"  class="user-list"  ></div>
    <a href="dashboard.php">Volver al Panel de Control</a>
</body>
<script>
        function fetchUsers(query = '') {
            fetch('fetch_users.php?query=' + query)
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('user-list');
                    container.innerHTML = '';
                    data.forEach(user => {
                        const div = document.createElement('div');
                        div.className = 'user-item';
                        div.innerHTML = `
                            <span>${user.nombre} - ${user.documento} - ${user.correo} - ${user.telefono}</span>
                            ${user.tiene_turno === '0' ? `<button onclick="assignTurn(${user.id})">Asignar Turno</button>` : `<span>Turno Asignado</span>`}
                        `;
                        container.appendChild(div);
                    });
                })
                .catch(error => console.error('Error:', error));
        }

        function assignTurn(userId) {
            fetch('assign_turn_action.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id_usuario: userId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    fetchUsers();
                } else {
                    alert('Error al asignar turno: ' + data.error);
                }
            })
            .catch(error => console.error('Error:', error));
        }

        document.addEventListener('DOMContentLoaded', () => {
            fetchUsers();

            const searchInput = document.getElementById('search-input');
            searchInput.addEventListener('input', () => {
                fetchUsers(searchInput.value);
            });
        });
    </script>

</html>



