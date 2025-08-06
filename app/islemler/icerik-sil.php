<?php
include '../config/init.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['content_id'])) {
    $content_id = intval($_POST['content_id']);
    $teacher_id = $_SESSION['user_id'] ?? 0;

    try {
        // Not: Gerçek bir sistemde, sunucudan dosyayı silmek için unlink($file_path) komutu da eklenmelidir.
        $stmt = $pdo->prepare("DELETE FROM library_content WHERE id = ? AND uploader_id = ?");
        $stmt->execute([$content_id, $teacher_id]);

        if ($stmt->rowCount() > 0) {
            $_SESSION['form_message'] = "İçerik başarıyla silindi.";
            $_SESSION['form_message_type'] = "success";
        } else {
            $_SESSION['form_message'] = "Hata: İçerik silinemedi veya yetkiniz yok.";
            $_SESSION['form_message_type'] = "danger";
        }
    } catch (Exception $e) {
        $_SESSION['form_message'] = "Veritabanı hatası: " . $e->getMessage();
        $_SESSION['form_message_type'] = "danger";
    }
}
header("Location: ../ogretmen/icerik-kutuphanesi.php");
exit();
?>