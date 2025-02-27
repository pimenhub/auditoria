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
        die("Error en la consulta SQL: " . $conn->error);
    }
    
    $stmt->bind_param("sssi", $nombre, $correo, $contrasena, $id_rol_fk);
    
    if ($stmt->execute()) {
        echo "<script>alert('Usuario registrado con éxito.'); window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Error al registrar el usuario: " . $stmt->error . "'); window.location.href = 'index.php';</script>";
    }
    
    $stmt->close();
    $conn->close();
}
?>

<style>
    body { font-family: Arial, sans-serif; text-align: center; }
    form { display: inline-block; padding: 20px; border: 1px solid #ccc; border-radius: 5px; }
    input, select, button { margin: 10px; padding: 10px; width: 100%; }
    button { background-color: #28a745; color: white; border: none; cursor: pointer; }
</style>

<form method="POST">
    <input type="text" name="nombre" placeholder="Nombre" required>
    <input type="email" name="correo" placeholder="Correo" required>
    <input type="password" name="contrasena" placeholder="Contraseña" required>
    <select name="id_rol_fk" required>
        <option value="1">Admin</option>
        <option value="2">Consulta</option>
        <option value="3">Usuario App</option>
    </select>
    <button type="submit">Registrar</button>
</form>
