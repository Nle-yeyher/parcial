<?php
session_start();
include 'cone.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_cita = $_POST['id_cita'] ?? null;
    $id_paciente = $_POST['id_paciente'];
    $id_medico = $_POST['id_medico'];
    $fecha_hora = $_POST['fecha_hora'];
    $motivo = $_POST['motivo'];
    $estado = $_POST['estado'];

    if ($id_cita) {
        $sql = "UPDATE citas SET id_paciente=?, id_medico=?, fecha_hora=?, motivo=?, estado=? WHERE id_cita=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisssi", $id_paciente, $id_medico, $fecha_hora, $motivo, $estado, $id_cita);
    } else {
        $sql = "INSERT INTO citas (id_paciente, id_medico, fecha_hora, motivo, estado) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisss", $id_paciente, $id_medico, $fecha_hora, $motivo, $estado);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Cita guardada exitosamente'); window.location.href='citas.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
}

if (isset($_GET['delete'])) {
    $id_cita = $_GET['delete'];
    $sql = "DELETE FROM citas WHERE id_cita=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_cita);
    $stmt->execute();
    echo "<script>alert('Cita eliminada'); window.location.href='citas.php';</script>";
}

$result = $conn->query("SELECT * FROM citas");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Citas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Gestión de Citas Médicas</h2>
    <form action="citas.php" method="POST">
        <input type="hidden" name="id_cita" id="id_cita">
        <label>ID Paciente:</label>
        <input type="text" name="id_paciente" required>
        
        <label>ID Médico:</label>
        <input type="text" name="id_medico" required>
        
        <label>Fecha y Hora:</label>
        <input type="datetime-local" name="fecha_hora" required>
        
        <label>Motivo:</label>
        <input type="text" name="motivo" required>
        
        <label>Estado:</label>
        <select name="estado">
            <option value="Pendiente">Pendiente</option>
            <option value="Confirmada">Confirmada</option>
            <option value="Cancelada">Cancelada</option>
        </select>
        
        <button type="submit">Guardar Cita</button>
    </form>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id_cita']; ?></td>
            <td><?php echo $row['id_paciente']; ?></td>
            <td><?php echo $row['id_medico']; ?></td>
            <td><?php echo $row['fecha_hora']; ?></td>
            <td><?php echo $row['motivo']; ?></td>
            <td><?php echo $row['estado']; ?></td>
            <td>
                <a href="citas.php?delete=<?php echo $row['id_cita']; ?>" onclick="return confirm('¿Eliminar cita?');">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
