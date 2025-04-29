<?php
session_start();
include 'db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

$sql = "SELECT * FROM historia_clinica WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head><title>Historia Clínica</title></head>
<body>
<h2>🩺 Historia Clínica</h2>
<?php while ($row = $resultado->fetch_assoc()): ?>
    <div>
        <h4>Fecha: <?php echo $row['fecha']; ?></h4>
        <p><strong>Diagnóstico:</strong> <?php echo $row['diagnostico']; ?></p>
        <p><strong>Tratamiento:</strong> <?php echo $row['tratamiento']; ?></p>
    </div>
    <hr>
<?php endwhile; ?>
<a href="paci.php">⬅ Volver</a>
</body>
</html>
