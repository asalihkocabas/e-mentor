<?php
include '../config/init.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $assignment_id = $_POST['assignment_id'] ?? 0;
    $grade = $_POST['grade_status'] ?? null;
    $comment = $_POST['teacher_comment'] ?? '';
    $teacher_id = $_SESSION['user_id'] ?? 0;

    if ($assignment_id > 0 && $grade) {
        try {
            // Güvenlik: Sadece ilgili öğretmenin değerlendirme yapabildiğinden emin ol
            $stmt = $pdo->prepare("
                UPDATE homework_assignments 
                SET status = 'graded', 
                    grade = ?,
                    teacher_comment = ?
                WHERE id = ? AND teacher_id = ?
            ");
            $stmt->execute([$grade, $comment, $assignment_id, $teacher_id]);

            if ($stmt->rowCount() > 0) {
                $_SESSION['form_message'] = "Ödev başarıyla değerlendirildi.";
                $_SESSION['form_message_type'] = "success";
            } else {
                $_SESSION['form_message'] = "Hata: Değerlendirme kaydedilemedi veya yetkiniz yok.";
                $_SESSION['form_message_type'] = "danger";
            }

        } catch (Exception $e) {
            $_SESSION['form_message'] = "Veritabanı hatası: " . $e->getMessage();
            $_SESSION['form_message_type'] = "danger";
        }
    } else {
        $_SESSION['form_message'] = "Hata: Eksik bilgi gönderildi.";
        $_SESSION['form_message_type'] = "danger";
    }
    header("Location: ../ogretmen/odev-takip.php");
    exit();
}
?>