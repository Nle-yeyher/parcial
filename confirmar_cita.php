<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include('conexion.php');

if (isset($_GET['id'])) {
    $id_cita = $_GET['id'];

    $sql = "UPDATE citas SET Estado_Cita = 'Confirmada' WHERE ID_Cita = :id_cita";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_cita', $id_cita);
    $stmt->execute();

    header("Location: admin.php");
}
?>
