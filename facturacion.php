<?php
session_start();
include 'db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

$sql = "SELECT * FROM facturas WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head><title>Facturación</title></head>
<body>
<h2>📄 Mis Facturas</h2>
<table border="1">
<tr><th>N° Factura</th><th>Fecha</th><th>Monto</th></tr>
<?php while ($row = $resultado->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['numero_factura']; ?></td>
        <td><?php echo $row['fecha']; ?></td>
        <td><?php echo $row['monto']; ?> COP</td>
    </tr>
<?php endwhile; ?>
</table>
<a href="paci.php">⬅ Volver</a>
</body>
</html>
