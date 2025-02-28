<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';

// Obtener el rol del usuario
$stmt = $conn->prepare("SELECT id_rol_fk FROM usuario WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$stmt->bind_result($rol_usuario);
$stmt->fetch();
$stmt->close();

$result = $conn->query("SELECT * FROM producto");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 2rem;
        }
        .products-container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            margin: auto;
            max-width: 800px;
        }
    </style>
</head>
<body>
    <div class="products-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Lista de Productos</h2>
            <div>
                <?php if ($rol_usuario == 1): ?>
                <a href="admin_usuarios.php" class="btn btn-primary me-2">
                    <i class="bi bi-people"></i> Administrar Usuarios
                </a>
                <?php endif; ?>
                <?php if ($rol_usuario == 3): ?>
                <a href="gestionar_productos.php" class="btn btn-success me-2">
                    <i class="bi bi-box-seam"></i> Gestionar Productos
                </a>
                <?php endif; ?>
                <a href="logout.php" class="btn btn-outline-danger">
                    <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                </a>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nombre']); ?></td>
                            <td>Q.<?= number_format($row['precio'], 2); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>