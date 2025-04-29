<?php
session_start();
include 'db.php';

// Verifica si el usuario está logueado y tiene un id_medico en la sesión
if (isset($_SESSION['usuario_id']) && isset($_SESSION['rol']) && $_SESSION['rol'] == 'medico') {
    $id_medico = $_SESSION['usuario_id'];

    // Obtener datos del médico desde la base de datos
    $sql = "SELECT * FROM medicos WHERE id_medico = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_medico);
    $stmt->execute();
    $result = $stmt->get_result();
    $medico = $result->fetch_assoc();

    $stmt->close();
} else {
    // Si no está logueado o el rol no es médico
    echo "Acceso denegado.";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del Médico</title>
    <link rel="stylesheet" href="medi.css">
</head>
<body>
    <div class="navbar">Panel del Médico</div>
    <div class="container">
        <aside class="sidebar">
            <h3>Bienvenido</h3> <!-- Mostrar nombre del médico -->
            <ul>
                <li><a href="gestionar_pacientes.php">Gestionar Pacientes</a></li>
                <li><a href="citas.php">Gestionar Citas</a></li>
                <li><a href="gestionar_tratamientos.php">Gestionar Tratamientos</a></li>
                <li><a href="historia_clinica.php">Historia Clínica</a></li>
                <li><a href="medicamentos.php">Medicamentos</a></li>
                <li><a href="formulas_medicas.php">Fórmulas Médicas</a></li>
                <li><a href="logout.php" class="logout">Cerrar Sesión</a></li>
            </ul>
        </aside>
        <main class="content">
            <h2>Panel Principal</h2>
            <p>Seleccione una opción del menú lateral para gestionar pacientes, citas, tratamientos y más.</p>
        </main>
    </div>
</body>
</html>
