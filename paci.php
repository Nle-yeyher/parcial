<?php
session_start();
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo'] !== 'Paciente') {
    header("Location: usu.php");
    exit();
}

include 'cone.php';
$id_paciente = $_SESSION['id_usuario'];

// Obtener datos del paciente
$sql = "SELECT * FROM pacientes WHERE id_paciente = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_paciente);
$stmt->execute();
$result = $stmt->get_result();
$paciente = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Paciente</title>
    <link rel="stylesheet" href="paci.css">
</head>
<body>
    <header class="navbar">
        <h1>Bienvenido, <?php echo htmlspecialchars($paciente['nombre']); ?> </h1>
    </header>
    <div class="container">
        <nav class="sidebar">
            <ul>
                <li><a href="medicamentos.php">💊 Mis Medicamentos</a></li>
                <li><a href="facturacion.php">📄 Facturación</a></li>
                <li><a href="historial.php">🩺 Historia Clínica</a></li>
                <li><a href="logout.php" class="logout">🚪 Cerrar Sesión</a></li>
            </ul>
        </nav>
        <main class="content">
            <h2>Información General</h2>
            <p><strong>Nombre:</strong> <?php echo htmlspecialchars($paciente['nombre']); ?></p>
            <p><strong>Correo:</strong> <?php echo htmlspecialchars($paciente['correo']); ?></p>
            <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($paciente['telefono']); ?></p>
        </main>
    </div>
</body>
</html>
