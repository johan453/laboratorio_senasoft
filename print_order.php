<?php
session_start();
include 'config/db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$orderId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Obtener los detalles de la orden y el nombre del usuario
$query = "SELECT o.*, 
                 CONCAT(p.nombre1, ' ', p.nombre2, ' ', p.apellido1, ' ', p.apellido2) AS nombre_usuario 
          FROM lab_m_orden o 
          JOIN fac_m_tarjetero t ON o.id_historia = t.id 
          JOIN gen_m_persona p ON t.id_persona = p.id 
          WHERE o.id = :order_id AND t.id_persona = :user_id";

$stmt = $pdo->prepare($query);
$stmt->execute([':order_id' => $orderId, ':user_id' => $_SESSION['user_id']]);
$order = $stmt->fetch();

if (!$order) {
    die('Orden no encontrada.');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Orden</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .print-container {
            margin: 20px;
        }
    </style>
</head>
<body>
    <div class="print-container">
        <h2 class="text-center text-primary">Detalles de la Orden</h2>
        <p><strong>Fecha:</strong> <?php echo htmlspecialchars($order['fecha']); ?></p>
        <p><strong>Código del documento:</strong> <?php echo htmlspecialchars($order['id_documento']); ?></p>
        <p><strong>Número de orden:</strong> <?php echo htmlspecialchars($order['orden']); ?></p>
        <p><strong>Nombre del usuario:</strong> <?php echo htmlspecialchars($order['nombre_usuario']); ?></p>
        <!-- Agrega más detalles según sea necesario -->
        <button class="btn btn-primary" onclick="window.print()">Imprimir</button>
    </div>
</body>
</html>