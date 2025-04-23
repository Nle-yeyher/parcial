<?php
session_start();

// Verificar si el usuario ha iniciado sesión y es Médico
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo'] !== 'Medico') {
    header("Location: usu.php");
    exit();
}

include 'cone.php';
$id_medico = $_SESSION['id_usuario'];

// Obtener datos del médico
$sql = "SELECT * FROM medicos WHERE id_medico = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_medico);
$stmt->execute();
$result = $stmt->get_result();
$medico = $result->fetch_assoc();

$stmt->close();
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
            <h3>Bienvenido, Dr. <?php echo htmlspecialchars($medico['nombre'] . " " . $medico['apellido']); ?></h3>
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
