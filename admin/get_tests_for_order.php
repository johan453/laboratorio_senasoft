<?php
include '../config/db_connection.php';

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    
    try {
        $stmt = $pdo->prepare("
            SELECT p.id, p.nombre
            FROM lab_p_pruebas p
            JOIN lab_m_orden_detalle od ON p.id = od.id_prueba
            WHERE od.id_orden = :order_id
            AND NOT EXISTS (
                SELECT 1 
                FROM lab_m_orden_resultados r 
                WHERE r.id_orden = od.id_orden AND r.id_prueba = od.id_prueba
            )
        ");
        $stmt->execute(['order_id' => $order_id]);
        $tests = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        header('Content-Type: application/json');
        echo json_encode($tests);
    } catch (PDOException $e) {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'No order ID provided']);
}