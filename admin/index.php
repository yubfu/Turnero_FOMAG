<?php
include '../includes/config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $documento = $_POST['documento'];
    $password = $_POST['password'];

    $query = "SELECT * FROM administradores WHERE documento = '$documento'";
    $result = mysqli_query($conn, $query);
    $admin = mysqli_fetch_assoc($result);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Documento o contraseña incorrecta";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Administrador</title>
    <link rel="stylesheet" href="../css/Login_principal.css">
</head>
<body>
    <div class="login-container">
        <div class="logo-container">
            <!-- Aquí puedes añadir el logo -->
            <img src="../Assets/logo.png" alt="Logo" class="logo">
        </div>
        <form method="POST">
            <h2>Login Administrador</h2>
            <input type="text" name="documento" placeholder="Documento" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Iniciar Sesión</button>
            <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
        </form>

        <div class="link-buttons">
            <li><a href="../public/display_turns.php">Monitor de turnos</a></li>
            <li><a href="../module/login.php">Ingreso Funcionarios</a></li>
        </div>
    </div>
</body>
</html>
