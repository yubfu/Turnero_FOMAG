<?php
include '../includes/config.php';
include '../includes/functions.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $documento = $_POST['documento'];
    $password = $_POST['password'];

    $query = "SELECT * FROM funcionarios WHERE documento='$documento'";
    $result = mysqli_query($conn, $query);
    $funcionario = mysqli_fetch_assoc($result);

    if ($funcionario && password_verify($password, $funcionario['password'])) {
        $_SESSION['funcionario_id'] = $funcionario['id'];      
        header("Location: take_turn.php");
        exit();
    } else {
        $error = "Documento o contraseña incorrectos";
    }

     // Cerrar la conexión a la base de datos
     mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Funcionarios</title>
    <link rel="stylesheet" href="../css/login_styles.css">
</head>
<body>
    <div class="login-container">
        <div class="logo-container">
            <!-- Aquí puedes añadir el logo -->
            <a href="http://localhost/turnos/admin/index.php"><img src="../Assets/logo.png" alt="Logo" class="logo"></a>
        </div>
        <h2>Login Funcionarios</h2>
        <form method="POST">
            <input type="text" name="documento" placeholder="Documento" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Iniciar Sesión</button>
        </form>
        <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
    </div>
</body>
</html>
