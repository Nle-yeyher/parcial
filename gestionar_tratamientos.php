<?php
session_start();
include 'db.php';

$resultado = $conn->query("SELECT * FROM tratamientos");
?>
<!DOCTYPE html>
<html>
<head><title>Tratamientos</title></head>
<body>
<h2>Tratamientos Registrados</h2>
<ul>
<?php while ($row = $resultado->fetch_assoc()): ?>
    <li><?php echo $row['descripcion']; ?></li>
<?php endwhile; ?>
</ul>
</body>
</html>
