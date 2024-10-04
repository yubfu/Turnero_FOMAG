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
    <table id="user-list">
        <thead>
            <tr>
                <th>Documento</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <!-- Aquí se llenarán los usuarios dinámicamente -->
        </tbody>
    </table>
    <a href="dashboard.php">Volver al Panel de Control</a>

    <script>
        function fetchUsers(query = '') {
            fetch('fetch_users.php?query=' + query)
                .then(response => response.json())
                .then(data => {
                    const container = document.querySelector('#user-list tbody');
                    container.innerHTML = '';
                    data.forEach(user => {
                        const row = document.createElement('tr');
                        row.className = 'user-item';
                        row.innerHTML = `
                            <td>${user.documento}</td>
                            <td>${user.nombre}</td> 
                            <td>${user.correo}</td>
                            <td>${user.telefono}</td>
                            <td>${user.tiene_turno === '0' ? `<button onclick="assignTurn(${user.id})">Asignar Turno</button>` : `<span>Turno Asignado</span>`}</td>
                        `;
                        container.appendChild(row);
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
</body>
</html>




