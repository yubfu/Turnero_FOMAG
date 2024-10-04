<?php
include '../includes/config.php';
include '../includes/functions.php';
session_start();

// Destruir todas las sesiones y redirigir al usuario
session_unset();
session_destroy();

header("Location: login.php"); // Redirige al login o a la página que prefieras
exit();
?>
