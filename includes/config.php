<?php
$servername = "193.203.175.55";
$username = "u606328427_admin_fomag";
$password = "Fomag2024*";
$dbname = "u606328427_sistema_turnos";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
