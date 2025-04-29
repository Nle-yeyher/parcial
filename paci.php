<?php
session_start();
include 'db.php';

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
        <h1>Bienvenido</h1>
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
            <h2>Panel Principal</h2>
            <p>Seleccione una opción del menú lateral para gestionar sus medicamentos, facturación y ver su historia clínica.</p>
            <p>Si necesita ayuda, no dude en contactar a su médico.</p>
            <p>Recuerde que su salud es lo más importante.</p>
        </main>
    </div>
</body>
</html>
