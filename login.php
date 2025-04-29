<?php
session_start();
include 'db.php'; // Asegúrate de tener db.php con la conexión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    $stmt = $conn->prepare("SELECT id, contraseña, rol, intentos_fallidos, bloqueado_hasta FROM usuario WHERE correo = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $row = $resultado->fetch_assoc();

        // Verificar si el usuario está temporalmente bloqueado
        if (!is_null($row['bloqueado_hasta']) && strtotime($row['bloqueado_hasta']) > time()) {
            echo "Este usuario está temporalmente bloqueado. Intenta nuevamente más tarde.";
            exit;
        }

        if (password_verify($contrasena, $row['contraseña'])) {
            // Éxito: reiniciar intentos
            $stmt = $conn->prepare("UPDATE usuario SET intentos_fallidos = 0, bloqueado_hasta = NULL WHERE correo = ?");
            $stmt->bind_param("s", $usuario);
            $stmt->execute();

            // Guardar sesión
            $_SESSION['usuario_id'] = $row['id'];
            $_SESSION['rol'] = $row['rol'];

            // Agrega un var_dump para depurar
            // var_dump($_SESSION['rol']); // Puedes descomentar esto para ver qué rol tiene el usuario

            // Redirigir según el rol
            switch ($row['rol']) {
                case 'admin':
                    header("Location: admin.php");
                    exit;
                case 'medico':
                    header("Location: medi.php");
                    exit;
                case 'paciente':
                    header("Location: paci.php");
                    exit;
                default:
                    echo "Rol no reconocido.";
            }
        } else {
            $intentos = $row['intentos_fallidos'] + 1;

            if ($intentos >= 3) {
                $bloqueo_hasta = date("Y-m-d H:i:s", strtotime("+2 minutes"));
                $stmt = $conn->prepare("UPDATE usuario SET intentos_fallidos = ?, bloqueado_hasta = ? WHERE correo = ?");
                $stmt->bind_param("iss", $intentos, $bloqueo_hasta, $usuario);
                $stmt->execute();
                echo "Demasiados intentos fallidos. Intenta nuevamente después de 2 minutos.";
            } else {
                $stmt = $conn->prepare("UPDATE usuario SET intentos_fallidos = ? WHERE correo = ?");
                $stmt->bind_param("is", $intentos, $usuario);
                $stmt->execute();
                echo "Usuario o contraseña incorrectos.";
            }
        }
    } else {
        echo "Usuario no encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="usu.css">
</head>
<body>
    <div class="wrapper">
        <h2>Iniciar sesión</h2>
        <form method="POST">
            <div class="input-group">
                <label for="usuario">Correo</label>
                <input type="text" class="form-control" id="usuario" name="usuario" required>
            </div>
            <div class="input-group">
                <label for="contrasena">Contraseña</label>
                <input type="password" class="form-control" id="contrasena" name="contrasena" required>
            </div>
            <div class="forgot-pass">
                <a href="#">¿Olvidó su contraseña?</a>
            </div>
            <button type="submit" class="btn">Iniciar sesión</button>
            <p>¿No tienes cuenta? <a href="registro.php">Registrarse</a></p>
        </form>
    </div>
</body>
</html>
