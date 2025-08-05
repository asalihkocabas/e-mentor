<?php
include '../config/init.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['exam_id'])) {
    $exam_id = intval($_POST['exam_id']);

    try {
        $stmt = $pdo->prepare("DELETE FROM exams WHERE id = ? AND creator_id = ?");
        $stmt->execute([$exam_id, $_SESSION['user_id']]);

        $_SESSION['form_message'] = "Sınav başarıyla silindi.";
        $_SESSION['form_message_type'] = "success";
    } catch (Exception $e) {
        $_SESSION['form_message'] = "Hata: Sınav silinemedi. " . $e->getMessage();
        $_SESSION['form_message_type'] = "danger";
    }
}
header("Location: ../ogretmen/raporlar.php");
exit();
?>