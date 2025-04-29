<?php
session_start();
include 'db.php';

$id_usuario = $_SESSION['usuario_id'];
$stmt = $conn->prepare("SELECT * FROM historia_clinica WHERE id_usuario = ?");
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head><title>Historia Clínica</title></head>
<body>
<h2>Mi Historia Clínica</h2>
<ul>
<?php while ($row = $result->fetch_assoc()): ?>
    <li><?php echo $row['detalle']; ?></li>
<?php endwhile; ?>
</ul>
</body>
</html>
