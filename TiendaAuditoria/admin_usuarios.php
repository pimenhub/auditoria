<?php
session_start();
include 'db.php';

// Verificar si el usuario está logueado y es administrador
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

// Verificar si es administrador (rol 1)
if ($rol != 1) {
    header("Location: productos.php");
    exit();
}

// Procesar eliminación de usuario
if (isset($_POST['eliminar_usuario'])) {
    $id_eliminar = $_POST['eliminar_usuario'];
    $stmt = $conn->prepare("DELETE FROM usuario WHERE id = ? AND id != ?");
    $stmt->bind_param("ii", $id_eliminar, $_SESSION['user_id']);
    $stmt->execute();
    $stmt->close();
}

// Procesar actualización de rol
if (isset($_POST['actualizar_rol'])) {
    $id_usuario = $_POST['id_usuario'];
    $nuevo_rol = $_POST['nuevo_rol'];
    $stmt = $conn->prepare("UPDATE usuario SET id_rol_fk = ? WHERE id = ? AND id != ?");
    $stmt->bind_param("iii", $nuevo_rol, $id_usuario, $_SESSION['user_id']);
    $stmt->execute();
    $stmt->close();
}

// Obtener lista de usuarios
$result = $conn->query("SELECT u.id, u.nombre, u.correo, u.id_rol_fk, 
                       CASE 
                           WHEN u.id_rol_fk = 1 THEN 'Administrador'
                           WHEN u.id_rol_fk = 2 THEN 'Consulta'
                           WHEN u.id_rol_fk = 3 THEN 'Usuario App'
                       END as rol_nombre
                       FROM usuario u 
                       WHERE u.id != " . $_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Usuarios</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 2rem;
        }
        .admin-container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            margin: auto;
            max-width: 1000px;
        }
        .actions {
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Administración de Usuarios</h2>
            <div>
                <a href="register.php" class="btn btn-success me-2">
                    <i class="bi bi-person-plus"></i> Nuevo Usuario
                </a>
                <a href="productos.php" class="btn btn-primary me-2">
                    <i class="bi bi-box"></i> Productos
                </a>
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
                        <th>Correo</th>
                        <th>Rol Actual</th>
                        <th>Cambiar Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nombre']); ?></td>
                            <td><?= htmlspecialchars($row['correo']); ?></td>
                            <td><?= htmlspecialchars($row['rol_nombre']); ?></td>
                            <td>
                                <form method="POST" class="d-flex" style="gap: 10px;">
                                    <input type="hidden" name="id_usuario" value="<?= $row['id']; ?>">
                                    <select name="nuevo_rol" class="form-select form-select-sm" style="width: auto;">
                                        <option value="1" <?= $row['id_rol_fk'] == 1 ? 'selected' : ''; ?>>Administrador</option>
                                        <option value="2" <?= $row['id_rol_fk'] == 2 ? 'selected' : ''; ?>>Consulta</option>
                                        <option value="3" <?= $row['id_rol_fk'] == 3 ? 'selected' : ''; ?>>Usuario App</option>
                                    </select>
                                    <button type="submit" name="actualizar_rol" class="btn btn-primary btn-sm">
                                        <i class="bi bi-check"></i>
                                    </button>
                                </form>
                            </td>
                            <td class="actions">
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="eliminar_usuario" value="<?= $row['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" 
                                            onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?')">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
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