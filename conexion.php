<?php
$host = 'localhost'; // Cambia si es necesario
$dbname = 'hospital';
$username = 'root'; // Cambia con el nombre de usuario de tu base de datos
$password = ''; // Cambia con tu contraseña de base de datos

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
