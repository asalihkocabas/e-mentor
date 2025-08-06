<?php
require_once '../config/init.php';

$question_id = $_POST['question_id'] ?? 0;
$student_id = $_SESSION['user_id'] ?? 0;
$response = ['success' => false];

if ($question_id > 0 && $student_id > 0) {
    $stmt = $pdo->prepare("
        SELECT 
            q.question_text,
            q.options,
            q.correct_answer,
            sa.selected_answer
        FROM questions q
        LEFT JOIN student_answers sa ON q.id = sa.question_id AND sa.student_id = ?
        WHERE q.id = ?
    ");
    $stmt->execute([$student_id, $question_id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data) {
        $response = [
            'success' => true,
            'data' => [
                'question_text' => $data['question_text'],
                'options' => json_decode($data['options'], true),
                'correct_answer' => trim($data['correct_answer']),
                'selected_answer' => trim($data['selected_answer'])
            ]
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?>