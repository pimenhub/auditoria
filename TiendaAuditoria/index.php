<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: productos.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
        .container { max-width: 400px; margin: auto; }
        a { display: block; margin: 10px 0; padding: 10px; text-decoration: none; color: white; border-radius: 5px; }
        .login { background: #007bff; }
        .register { background: #28a745; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Bienvenido a la Tienda</h2>
        <a href="login.php" class="login">Iniciar Sesión</a>
        <a href="register.php" class="register">Registrarse</a>
    </div>
</body>
</html>