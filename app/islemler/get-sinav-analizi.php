<?php
require_once '../config/init.php';

$exam_id = $_POST['exam_id'] ?? 0;
$student_id = $_SESSION['user_id'] ?? 0;
$response = [];

if ($exam_id > 0 && $student_id > 0) {
    $stmt = $pdo->prepare("
        SELECT 
            q.id as question_id,
            lo.outcome_code,
            lo.description as outcome_description,
            sa.is_correct
        FROM questions q
        LEFT JOIN student_answers sa ON q.id = sa.question_id AND sa.student_id = ?
        LEFT JOIN learning_outcomes lo ON q.learning_outcome_id = lo.id
        WHERE q.exam_id = ?
        ORDER BY q.id ASC
    ");
    $stmt->execute([$student_id, $exam_id]);
    $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

header('Content-Type: application/json');
echo json_encode($response);
?>