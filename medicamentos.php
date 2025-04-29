<?php
session_start();
include 'db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

$sql = "SELECT * FROM medicamentos WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head><title>Mis Medicamentos</title></head>
<body>
<h2>💊 Mis Medicamentos</h2>
<ul>
<?php while ($row = $resultado->fetch_assoc()): ?>
    <li><?php echo $row['nombre_medicamento']; ?> - <?php echo $row['dosis']; ?></li>
<?php endwhile; ?>
</ul>
<a href="paci.php">⬅ Volver</a>
</body>
</html>
