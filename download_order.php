<?php
session_start();
require_once('config/db_connection.php');

// Asegúrate de tener FPDF en la ruta correcta
require_once('fpdf/fpdf.php'); 

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$orderId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Obtener los detalles de la orden
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

// Crear un nuevo PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Detalles de la Orden', 0, 1, 'C');

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Fecha: ' . htmlspecialchars($order['fecha']), 0, 1);
$pdf->Cell(0, 10, 'Código del documento: ' . htmlspecialchars($order['id_documento']), 0, 1);
$pdf->Cell(0, 10, 'Número de orden: ' . htmlspecialchars($order['orden']), 0, 1);
$pdf->Cell(0, 10, 'Nombre del usuario: ' . htmlspecialchars($order['nombre_usuario']), 0, 1);

// Cerrar y crear el archivo PDF
$pdf->Output('orden_' . $orderId . '.pdf', 'D');
?>