<?php
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
    $sql = "INSERT INTO usuario (nombre, correo, contrasena) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nombre, $correo, $contrasena);
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
    input, button { margin: 10px; padding: 10px; width: 100%; }
    button { background-color: #28a745; color: white; border: none; cursor: pointer; }
</style>
<form method="POST">
    <input type="text" name="nombre" placeholder="Nombre" required>
    <input type="email" name="correo" placeholder="Correo" required>
    <input type="password" name="contrasena" placeholder="Contraseña" required>
    <button type="submit">Registrar</button>
</form>