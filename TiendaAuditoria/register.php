<?php
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
    $id_rol_fk = $_POST['id_rol_fk'];
    
    $sql = "INSERT INTO usuario (nombre, correo, contrasena, id_rol_fk) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        $error = "Error en la consulta SQL: " . $conn->error;
    } else {
        $stmt->bind_param("sssi", $nombre, $correo, $contrasena, $id_rol_fk);
        
        if ($stmt->execute()) {
            header("Location: index.php");
            $_SESSION['mensaje'] = "Usuario registrado con éxito.";
            exit();
        } else {
            $error = "Error al registrar el usuario: " . $stmt->error;
        }
        
        $stmt->close();
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .register-container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 90%;
        }
        .form-control, .form-select {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2 class="text-center mb-4">Registro</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <input type="text" class="form-control" name="nombre" placeholder="Nombre" required>
            </div>
            <div class="mb-3">
                <input type="email" class="form-control" name="correo" placeholder="Correo" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" name="contrasena" placeholder="Contraseña" required>
            </div>
            <div class="mb-3">
                <select class="form-select" name="id_rol_fk" required>
                    <option value="" disabled selected>Selecciona un rol</option>
                    <option value="1">Admin</option>
                    <option value="2">Consulta</option>
                    <option value="3">Usuario App</option>
                </select>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-success">Registrar</button>
                <a href="index.php" class="btn btn-outline-secondary">Volver al inicio</a>
            </div>
        </form>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
