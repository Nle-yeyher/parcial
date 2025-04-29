<?php
session_start();
include 'db.php';

$resultado = $conn->query("SELECT * FROM usuario WHERE rol = 'paciente'");
?>
<!DOCTYPE html>
<html>
<head><title>Pacientes</title></head>
<body>
<h2>Lista de Pacientes</h2>
<ul>
<?php while ($row = $resultado->fetch_assoc()): ?>
    <li><?php echo $row['nombre']; ?> (<?php echo $row['correo']; ?>)</li>
<?php endwhile; ?>
</ul>
</body>
</html>
