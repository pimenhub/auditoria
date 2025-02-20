<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';
$result = $conn->query("SELECT * FROM producto");
?>
<a href="logout.php">Cerrar sesión</a>
<style>
    body { font-family: Arial, sans-serif; text-align: center; }
    table { width: 50%; margin: auto; border-collapse: collapse; }
    th, td { padding: 10px; border: 1px solid #ccc; }
    th { background-color: #f8f8f8; }
</style>
<table>
    <tr><th>Nombre</th><th>Precio</th></tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= htmlspecialchars($row['nombre']); ?></td>
            <td>$<?= number_format($row['precio'], 2); ?></td>
        </tr>
    <?php } ?>
</table>
<?php $conn->close(); ?>