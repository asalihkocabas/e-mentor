<?php
include '../config/init.php';

$response = ['success' => false, 'message' => 'Geçersiz istek.'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'] ?? null;
    $outcome_id = $_POST['outcome_id'] ?? null;
    $ai_content = $_POST['ai_content'] ?? null;
    $due_date_str = $_POST['due_date'] ?? null;
    $teacher_id = $_SESSION['user_id'] ?? 1;

    $date = DateTime::createFromFormat('d.m.Y H:i', $due_date_str);
    $due_date_mysql = $date ? $date->format('Y-m-d H:i:s') : null;

    if ($student_id && $outcome_id && $ai_content && $due_date_mysql) {
        try {
            $stmt = $pdo->prepare(
                "INSERT INTO homework_assignments (teacher_id, student_id, learning_outcome_id, content, due_date, status) 
                 VALUES (?, ?, ?, ?, ?, ?)"
            );
            $stmt->execute([$teacher_id, $student_id, $outcome_id, $ai_content, $due_date_mysql, 'assigned']);

            $response = ['success' => true, 'message' => 'Ödev başarıyla atandı!'];
        } catch (Exception $e) {
            $response['message'] = "Veritabanı hatası: " . $e->getMessage();
        }
    } else {
        $response['message'] = "Eksik bilgi gönderildi. Lütfen tüm alanları doldurun.";
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?>