<?php
session_start();
include('conexion.php');

if (isset($_POST['login'])) {
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuario WHERE correo = :correo";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':correo', $correo);
    $stmt->execute();
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($password, $usuario['contraseña'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['rol'] = $usuario['rol'];
        if ($usuario['rol'] == 'admin') {
            header("Location: admin.php");
        } elseif ($usuario['rol'] == 'medico') {
            header("Location: medi.php");
        } elseif ($usuario['rol'] == 'paciente') {
            header("Location: paci.php");
        }
    } else {
        $error = "Correo o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="usu.css">
</head>
<body>
    <form method="POST">
        <h2>Iniciar sesión</h2>
        <?php if (isset($error)) echo "<p>$error</p>"; ?>
        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" required><br>
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required><br>
        <button type="submit" name="login">Iniciar sesión</button>
    </form>
    <p>¿No tienes una cuenta? <a href="registro_usuario.php"><button>Registrarse</button></a></p>
</body>
</html>
