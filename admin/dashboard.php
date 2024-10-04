<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control</title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
    <!-- Contenedor del botón de logout -->
    <div class="logout-container">
        <form method="POST" action="logout.php">
            <button type="submit" class="logout-button">Cerrar sección</button>
        </form>
    </div>
    
    <h2>Panel de Control</h2>
    <nav>
        <ul class="menu-grid">
            <li>
                <div class="menu-item">
                    <img src="../Assets/Registro.jpg" alt="Registrar Usuario">
                    <a href="register_user.php">Registrar Usuario</a>
                </div>
            </li>
            <li>
                <div class="menu-item">
                    <img src="../Assets/turno2.jpg" alt="Asignar Turno">
                    <a href="assign_turn.php">Asignar Turno</a>
                </div>
            </li>
            <li>
                <div class="menu-item">
                    <img src="../Assets/modulo.jpg" alt="Configurar Módulos">
                    <a href="configure_modules.php">Configurar Módulos</a>
                </div>
            </li>
            <li>
                <div class="menu-item">
                    <img src="../Assets/funcionarios.jpg" alt="Registrar Funcionario">
                    <a href="register_funcionario.php">Registrar Funcionario</a>
                </div>
            </li>
            <li>
                <div class="menu-item">
                    <img src="../Assets/visualizador.jpg" alt="Visualizar Turnos">
                    <a href="../public/display_turns.php" target = "_blank">Visualizar Turnos</a>
                </div>
            </li>
            <li>
                <div class="menu-item">
                    <img src="../Assets/visualizador.jpg" alt="Visualizar Turnos">
                    <form method="POST" action="reset_turn_counter.php">
                    <button type="submit" class="restart" >Reiniciar Contador de Turnos</button>
                    </form>
                </div>
            </li>

        </ul>
    </nav>
</body>
</html>
