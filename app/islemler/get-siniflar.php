<?php
require_once '../config/init.php';

$exam_id = $_POST['exam_id'] ?? 0;
$response = [];

if ($exam_id > 0) {
    // Veritabanından, gönderilen sınav ID'sine atanmış sınıfları çek
    $stmt = $pdo->prepare("
        SELECT c.id, c.name 
        FROM classes c
        JOIN exam_classes ec ON c.id = ec.class_id
        WHERE ec.exam_id = ?
        ORDER BY c.name
    ");
    $stmt->execute([$exam_id]);
    $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Sonucu JSON formatında geri döndür
header('Content-Type: application/json');
echo json_encode($response);
?>