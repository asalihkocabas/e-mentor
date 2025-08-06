<?php
require_once '../config/init.php';

$exam_id = $_POST['exam_id'] ?? 0;
$response = ['success' => false, 'kazanimlar' => []];

if ($exam_id > 0) {
    // Sadece kazanım açıklamalarını çekiyoruz
    $stmt = $pdo->prepare("
        SELECT DISTINCT lo.description 
        FROM learning_outcomes lo
        JOIN questions q ON lo.id = q.learning_outcome_id
        WHERE q.exam_id = ?
    ");
    $stmt->execute([$exam_id]);
    $response['kazanimlar'] = $stmt->fetchAll(PDO::FETCH_COLUMN);
    $response['success'] = true;
}

header('Content-Type: application/json');
echo json_encode($response);
?>