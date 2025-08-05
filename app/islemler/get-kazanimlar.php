<?php
// Bu dosya, AJAX isteklerine JSON formatında cevap verir.

require_once '../config/init.php';

// Formdan AJAX ile gönderilen verileri al
$course_id = $_POST['course_id'] ?? 0;
$grade_level = $_POST['grade_level'] ?? 0;

// Gerekli parametreler geldiyse işlem yap
if ($course_id > 0 && $grade_level > 0) {
    try {
        $stmt = $pdo->prepare(
            "SELECT id, outcome_code, description 
             FROM learning_outcomes 
             WHERE course_id = ? AND grade_level = ?
             ORDER BY outcome_code"
        );
        $stmt->execute([$course_id, $grade_level]);
        $outcomes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Veriyi JSON formatında JavaScript'e geri gönder
        header('Content-Type: application/json');
        echo json_encode($outcomes);

    } catch (PDOException $e) {
        // Hata durumunda boş bir JSON dizisi gönder
        header('Content-Type: application/json');
        http_response_code(500); // Sunucu hatası kodu
        echo json_encode([]);
    }
} else {
    // Gerekli parametreler gelmediyse boş bir JSON dizisi gönder
    header('Content-Type: application/json');
    echo json_encode([]);
}
?>