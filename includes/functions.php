<?php
date_default_timezone_set('America/Bogota');


function isAdminLoggedIn() {
    return isset($_SESSION['admin_id']);
}

function redirectIfNotAdmin() {
    if (!isAdminLoggedIn()) {
        header("Location: ../admin/index.php");
        exit;
    }
}

function isModuleLoggedIn() {
    return isset($_SESSION['modulo_id']);
}

function redirectIfNotModule() {
    if (!isModuleLoggedIn()) {
        header("Location: ../module/index.php");
        exit;
    }
}

/*
function getNextTurnNumber() {
    global $conn;
    $today = date('Y-m-d');
    $query = "SELECT COUNT(*) as count FROM turnos WHERE DATE(fecha) = '$today'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['count'] + 1;
}
    */

function getNextTurnNumber() {
    global $conn;
    
    // Obtener el valor actual del contador
    $query = "SELECT contador FROM turno_contador WHERE id = 1"; 
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    
    // Incrementar el contador
    $nuevo_contador = $row['contador'] + 1;
    
    // Actualizar el contador en la base de datos
    $update_query = "UPDATE turno_contador SET contador = '$nuevo_contador' WHERE id = 1";
     mysqli_query($conn, $update_query);
    
    return $nuevo_contador;
    }

function redirectIfNotFuncionario() {
    if (!isset($_SESSION['funcionario_id'])) {
        header("Location: login.php");
        exit();
    }
}

?>

