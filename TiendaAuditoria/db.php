<?php
$host = "192.168.0.20";
$user = "dba";
$pass = "Admin.*";
$dbname = "DB_Tienda";
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>