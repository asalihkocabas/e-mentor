<?php
require_once '../config/init.php';

$exam_id = $_POST['exam_id'] ?? 0;
$student_id = $_SESSION['user_id'] ?? 0;
$response = [];

if ($exam_id > 0 && $student_id > 0) {
    // Sadece yanlış cevaplanan soruları, detaylarıyla birlikte çek
    $stmt = $pdo->prepare("
        SELECT 
            q.question_text,
            q.options,
            q.correct_answer,
            sa.selected_answer,
            lo.description as outcome_description
        FROM student_answers sa
        JOIN questions q ON sa.question_id = q.id
        LEFT JOIN learning_outcomes lo ON q.learning_outcome_id = lo.id
        WHERE sa.exam_id = ? AND sa.student_id = ? AND sa.is_correct = 0
    ");
    $stmt->execute([$exam_id, $student_id]);
    $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

header('Content-Type: application/json');
echo json_encode($response);
?>