<?php
require_once '../config/init.php';

$exam_id = $_POST['exam_id'] ?? 0;
$class_id = $_POST['class_id'] ?? 0;
$response = ['students' => []];

if ($exam_id > 0 && $class_id > 0) {
    $stmt = $pdo->prepare("
        SELECT 
            sp.user_id, 
            sp.full_name, 
            lo.id as outcome_id,
            lo.outcome_code, 
            lo.description
        FROM student_answers sa
        JOIN student_profiles sp ON sa.student_id = sp.user_id
        JOIN questions q ON sa.question_id = q.id
        JOIN learning_outcomes lo ON q.learning_outcome_id = lo.id
        WHERE sa.exam_id = ? 
          AND sp.class_id = ? 
          AND sa.is_correct = 0
        GROUP BY sp.user_id, lo.id
        ORDER BY sp.full_name, lo.outcome_code
    ");
    $stmt->execute([$exam_id, $class_id]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Veriyi öğrenci bazında grupla
    foreach ($results as $row) {
        $response['students'][$row['user_id']]['full_name'] = $row['full_name'];
        $response['students'][$row['user_id']]['outcomes'][] = [
            'id' => $row['outcome_id'],
            'code' => $row['outcome_code'],
            'description' => $row['description']
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?>