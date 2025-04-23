<?php
include 'conexion.php'; // Asegúrate de tener este archivo de conexión.

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recibir los datos del formulario
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $clave = password_hash($_POST['clave'], PASSWORD_DEFAULT); // Encriptar la contraseña
    $rol = $_POST['rol'];

    // Preparar la consulta SQL usando PDO
    $stmt = $conn->prepare("INSERT INTO usuario (nombre, correo, clave, rol) VALUES (:nombre, :correo, :clave, :rol)");

    // Vincular los parámetros
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':clave', $clave);
    $stmt->bindParam(':rol', $rol);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Usuario registrado exitosamente. <a href='form_login.html'>Iniciar sesión</a>";
    } else {
        echo "Error al registrar usuario: " . $stmt->errorInfo()[2]; // Muestra un error más detallado si hay algún problema
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="container">
        <h2>Registro de Usuario</h2>
        <form action="registro_usuario.php" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required>

            <label for="correo">Correo:</label>
            <input type="email" name="correo" required>

            <label for="clave">Contraseña:</label>
            <input type="password" name="clave" required>

            <label for="rol">Rol:</label>
            <select name="rol" required>
                <option value="admin">Administrador</option>
                <option value="medico">Médico</option>
                <option value="paciente">Paciente</option>
            </select>

            <input type="submit" value="Registrar">
        </form>

        <p class="login-link">¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>
    </div>
</body>
</html>
