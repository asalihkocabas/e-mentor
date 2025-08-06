<?php
include '../config/init.php';

// Formun POST metodu ile ve gerekli ID ile geldiğini kontrol et
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['announcement_id'])) {

    $announcement_id = intval($_POST['announcement_id']);
    $teacher_id = $_SESSION['user_id'] ?? 0;

    try {
        // Güvenlik: Sadece duyuruyu oluşturan öğretmenin silebildiğinden emin ol
        $stmt = $pdo->prepare("DELETE FROM announcements WHERE id = ? AND creator_id = ?");
        $stmt->execute([$announcement_id, $teacher_id]);

        // Eğer silme işlemi başarılı olduysa (etkilenen satır sayısı 1 ise)
        if ($stmt->rowCount() > 0) {
            $_SESSION['form_message'] = "Duyuru başarıyla silindi.";
            $_SESSION['form_message_type'] = "success";
        } else {
            $_SESSION['form_message'] = "Hata: Bu duyuruyu silme yetkiniz yok veya duyuru bulunamadı.";
            $_SESSION['form_message_type'] = "danger";
        }

    } catch (Exception $e) {
        $_SESSION['form_message'] = "Hata: Duyuru silinirken bir veritabanı hatası oluştu.";
        $_SESSION['form_message_type'] = "danger";
    }
}

// İşlem sonrası yönetim sayfasına geri dön
header("Location: ../ogretmen/duyuru-yonetimi.php");
exit();
?>