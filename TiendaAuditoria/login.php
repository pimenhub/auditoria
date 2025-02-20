<?php
session_start();
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $sql = "SELECT id, contrasena FROM usuario WHERE correo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();
        if (password_verify($contrasena, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            header("Location: productos.php");
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }
    $stmt->close();
    $conn->close();
}
?>
<style>
    body { font-family: Arial, sans-serif; text-align: center; }
    form { display: inline-block; padding: 20px; border: 1px solid #ccc; border-radius: 5px; }
    input, button { margin: 10px; padding: 10px; width: 100%; }
    button { background-color: #007bff; color: white; border: none; cursor: pointer; }
</style>
<form method="POST">
    <input type="email" name="correo" placeholder="Correo" required>
    <input type="password" name="contrasena" placeholder="Contraseña" required>
    <button type="submit">Iniciar sesión</button>
</form>