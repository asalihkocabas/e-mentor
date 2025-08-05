<?php
include '../config/init.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['exam_id'], $_POST['new_exam_date'])) {
    $exam_id = intval($_POST['exam_id']);
    $new_date_str = $_POST['new_exam_date'];

    // Tarih formatını MySQL'e uygun hale getir
    $date = DateTime::createFromFormat('d-m-Y H:i', $new_date_str);
    $exam_date_mysql = $date ? $date->format('Y-m-d H:i:s') : null;

    if ($exam_date_mysql) {
        try {
            $stmt = $pdo->prepare("UPDATE exams SET exam_date = ? WHERE id = ? AND creator_id = ?");
            $stmt->execute([$exam_date_mysql, $exam_id, $_SESSION['user_id']]);

            $_SESSION['form_message'] = "Sınav tarihi başarıyla güncellendi.";
            $_SESSION['form_message_type'] = "success";
        } catch (Exception $e) {
            $_SESSION['form_message'] = "Hata: Tarih güncellenemedi.";
            $_SESSION['form_message_type'] = "danger";
        }
    } else {
        $_SESSION['form_message'] = "Hata: Geçersiz tarih formatı.";
        $_SESSION['form_message_type'] = "danger";
    }
}
header("Location: ../ogretmen/raporlar.php");
exit();
?>