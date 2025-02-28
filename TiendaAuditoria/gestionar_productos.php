<?php
session_start();
include 'db.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Obtener el rol del usuario
$stmt = $conn->prepare("SELECT id_rol_fk FROM usuario WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$stmt->bind_result($rol);
$stmt->fetch();
$stmt->close();

// Verificar si es usuario app (rol 3)
if ($rol != 3) {
    header("Location: productos.php");
    exit();
}

// Procesar el registro de nuevo producto
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registrar_producto'])) {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    
    $stmt = $conn->prepare("INSERT INTO producto (nombre, precio) VALUES (?, ?)");
    $stmt->bind_param("sd", $nombre, $precio);
    
    if ($stmt->execute()) {
        $mensaje = "Producto registrado con éxito.";
        $tipo_mensaje = "success";
    } else {
        $mensaje = "Error al registrar el producto: " . $stmt->error;
        $tipo_mensaje = "danger";
    }
    $stmt->close();
}

// Obtener lista de productos
$result = $conn->query("SELECT * FROM producto ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
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
        .form-container {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="products-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Gestión de Productos</h2>
            <a href="logout.php" class="btn btn-outline-danger">
                <i class="bi bi-box-arrow-right"></i> Cerrar sesión
            </a>
        </div>

        <?php if (isset($mensaje)): ?>
            <div class="alert alert-<?= $tipo_mensaje ?> alert-dismissible fade show" role="alert">
                <?= $mensaje ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="form-container">
            <h4 class="mb-3">Registrar Nuevo Producto</h4>
            <form method="POST" class="row g-3">
                <div class="col-md-6">
                    <label for="nombre" class="form-label">Nombre del Producto</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="col-md-6">
                    <label for="precio" class="form-label">Precio</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" id="precio" name="precio" step="0.01" min="0" required>
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" name="registrar_producto" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Registrar Producto
                    </button>
                </div>
            </form>
        </div>

        <h4 class="mb-3">Lista de Productos</h4>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']); ?></td>
                            <td><?= htmlspecialchars($row['nombre']); ?></td>
                            <td>$<?= number_format($row['precio'], 2); ?></td>
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