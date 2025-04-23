<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include('conexion.php');

// Mostrar citas pendientes
$sql = "SELECT * FROM citas WHERE Estado_Cita = 'Pendiente'";
$stmt = $pdo->query($sql);
$citas = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
</head>
<body>
    <h1>Bienvenido, Administrador</h1>
    <a href="logout.php">Cerrar sesión</a>
    
    <h2>Citas Pendientes</h2>
    <table>
        <thead>
            <tr>
                <th>ID Cita</th>
                <th>Paciente</th>
                <th>Médico</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($citas as $cita): ?>
            <tr>
                <td><?php echo $cita['ID_Cita']; ?></td>
                <td><?php echo $cita['ID_Paciente']; ?></td>
                <td><?php echo $cita['ID_Medico']; ?></td>
                <td><?php echo $cita['Fecha_Cita']; ?></td>
                <td><?php echo $cita['Hora_Cita']; ?></td>
                <td><?php echo $cita['Estado_Cita']; ?></td>
                <td>
                    <a href="confirmar_cita.php?id=<?php echo $cita['ID_Cita']; ?>">Confirmar</a> |
                    <a href="cancelar_cita.php?id=<?php echo $cita['ID_Cita']; ?>">Cancelar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
