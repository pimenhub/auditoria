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
    <title>Tecno-Son Impresión Completa</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #2f3640;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        .welcome-container {
            background: white;
            padding: 3rem;
            border-radius: 15px;
            box-shadow: 0 0 25px rgba(0,0,0,0.2);
            max-width: 500px;
            width: 90%;
            text-align: center;
        }
        .logo-container {
            margin-bottom: 2rem;
            max-width: 100%;
            height: auto;
        }
        .logo-container img {
            max-width: 100%;
            height: auto;
            margin-bottom: 1.5rem;
        }
        .btn {
            padding: 12px 24px;
            font-size: 1.1rem;
            border-radius: 8px;
            width: 100%;
            margin: 10px 0;
            transition: all 0.3s ease;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .btn-primary {
            background-color: #00a8ff;
            border-color: #00a8ff;
        }
        .btn-primary:hover {
            background-color: #0097e6;
            border-color: #0097e6;
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <div class="logo-container">
            <img src="logo.jpeg" alt="Tecno-Son Impresión Completa" class="img-fluid">
        </div>
        <div class="d-grid">
            <a href="login.php" class="btn btn-primary">
                Iniciar Sesión
            </a>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>