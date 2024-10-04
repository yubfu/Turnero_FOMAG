<?php
include '../includes/config.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $documento_funcionario = $_POST['documento_funcionario'];

    $query = "SELECT * FROM modulos WHERE documento_funcionario = '$documento_funcionario'";
    $result = mysqli_query($conn, $query);
    $modulo = mysqli_fetch_assoc($result);

    if ($modulo) {
        $_SESSION['modulo_id'] = $modulo['id'];
        header("Location: take_turn.php");
        exit;
    } else {
        $error = "Documento incorrecto";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Módulo</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <form method="POST">
        <h2>Login Módulo</h2>
        <input type="text" name="documento_funcionario" placeholder="Documento" required>
        <button type="submit">Iniciar Sesión</button>
        <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
    </form>
</body>
</html>
