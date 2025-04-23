<?php
session_start();
include 'conexion.php';

// Solo permitir acceso a admin
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    echo "Acceso denegado.";
    exit();
}

// Registrar una nueva sede si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'];
    $ubicacion = $_POST['ubicacion'];
    $admin = $_POST['admin'];
    $foto = $_FILES['foto'];

    // Guardar la imagen en una carpeta local
    $foto_nombre = time() . "_" . basename($foto["name"]);
    $ruta_destino = "fotos_cedes/" . $foto_nombre;
    move_uploaded_file($foto["tmp_name"], $ruta_destino);

    // Insertar en la base de datos
    $stmt = $conn->prepare("INSERT INTO cedes (nombre, admin, ubicacion, foto) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $admin, $ubicacion, $foto_nombre);
    $stmt->execute();
    echo "<p>Cede registrada exitosamente.</p>";
}

// Mostrar todas las cedes
$cedes = $conn->query("SELECT * FROM cedes");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Cedes</title>
</head>
<body>
    <h2>Registrar Nueva Cede</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Nombre:</label>
        <input type="text" name="nombre" required><br><br>

        <label>Admin Responsable:</label>
        <input type="text" name="admin" required><br><br>

        <label>Ubicación (coordenadas):</label>
        <input type="text" name="ubicacion" placeholder="Latitud, Longitud" required><br><br>

        <label>Foto:</label>
        <input type="file" name="foto" accept="image/*" required><br><br>

        <input type="submit" value="Registrar Cede">
    </form>

    <h2>Cedes Registradas</h2>
    <table border="1">
        <tr>
            <th>Nombre</th>
            <th>Admin</th>
            <th>Ubicación</th>
            <th>Foto</th>
        </tr>
        <?php while ($fila = $cedes->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($fila['nombre']) ?></td>
                <td><?= htmlspecialchars($fila['admin']) ?></td>
                <td><?= htmlspecialchars($fila['ubicacion']) ?></td>
                <td><img src="fotos_cedes/<?= $fila['foto'] ?>" width="100" height="70"></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <br>
    <a href="bienvenida.php">Volver al panel</a>
</body>
</html>
