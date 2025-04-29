<?php
session_start();
include 'db.php';

$id_usuario = $_SESSION['usuario_id'];
$stmt = $conn->prepare("SELECT * FROM formulas_medicas WHERE id_usuario = ?");
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head><title>Fórmulas Médicas</title></head>
<body>
<h2>Mis Fórmulas Médicas</h2>
<ul>
<?php while ($row = $result->fetch_assoc()): ?>
    <li><?php echo $row['descripcion']; ?></li>
<?php endwhile; ?>
</ul>
</body>
</html>
