<?php
include 'db.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $rol = $_POST['rol'];

    // Verifica si el usuario ya existe
    $stmt = $conn->prepare("SELECT id FROM usuario WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $mensaje = "Este correo ya está registrado.";
    } else {
        // Encriptar la contraseña
        $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

        // Insertar nuevo usuario
        $stmt = $conn->prepare("INSERT INTO usuario (nombre, correo, contraseña, rol) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre, $correo, $contrasena_hash, $rol);

        if ($stmt->execute()) {
            // Si el rol es medico, insertar en la tabla medicos
            if ($rol == 'medico') {
                $stmt = $conn->prepare("INSERT INTO medicos (nombre, email) VALUES (?, ?)");
                $stmt->bind_param("ss", $nombre, $correo);
                $stmt->execute();
            } elseif ($rol == 'paciente') {
                // Si el rol es paciente, insertar en la tabla pacientes
                $stmt = $conn->prepare("INSERT INTO pacientes (nombre, email) VALUES (?, ?)");
                $stmt->bind_param("ss", $nombre, $correo);
                $stmt->execute();
            }

            // Mostrar mensaje de éxito y redirigir a login
            $mensaje = "Usuario registrado exitosamente.";
            header("Location: login.php"); // Redirige al login
            exit();
        } else {
            $mensaje = "Error al registrar usuario.";
        }
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="style.css"> <!-- Puedes usar otro CSS si prefieres -->
</head>
<body>
    <div class="container">
        <h2>Registro de Usuario</h2>
        <form method="POST">
            <label for="nombre">Nombre:</label><br>
            <input type="text" name="nombre" required><br><br>

            <label for="correo">Correo:</label><br>
            <input type="email" name="correo" required><br><br>

            <label for="contrasena">Contraseña:</label><br>
            <input type="password" name="contrasena" required><br><br>

            <label for="rol">Rol:</label><br>
            <select name="rol" required>
                <option value="admin">Admin</option>
                <option value="medico">Médico</option>
                <option value="paciente">Paciente</option>
            </select><br><br>

            <button type="submit">Registrar</button>
        </form>
        <p>¿Ya tienes una cuenta? <a href="login.php">Iniciar sesión</a></p>
        <p><?php echo $mensaje; ?></p>
    </div>
</body>
</html>
