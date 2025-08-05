<?php
include '../config/init.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $target_audience = $_POST['target_audience'] ?? [];
    $publish_date_str = $_POST['publish_date'];
    $end_date_str = $_POST['end_date'];
    $creator_id = $_SESSION['user_id'] ?? 1;
    $school_id = 1; // Şimdilik varsayılan okul ID'si

    // Tarih formatlarını MySQL'e uygun hale getir
    $publish_date = !empty($publish_date_str) ? DateTime::createFromFormat('d.m.Y H:i', $publish_date_str)->format('Y-m-d H:i:s') : date('Y-m-d H:i:s');
    $end_date = !empty($end_date_str) ? DateTime::createFromFormat('d.m.Y H:i', $end_date_str)->format('Y-m-d H:i:s') : null;

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("INSERT INTO announcements (creator_id, school_id, title, content, category, publish_date, end_date) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$creator_id, $school_id, $title, $content, $category, $publish_date, $end_date]);
        $announcement_id = $pdo->lastInsertId();

        // Hedef kitleyi işle
        if (!empty($target_audience)) {
            $stmt_target = $pdo->prepare("INSERT INTO announcement_targets (announcement_id, class_id) VALUES (?, ?)");
            foreach($target_audience as $target){
                if(strpos($target, 'class_') === 0){
                    $class_id = substr($target, 6);
                    $stmt_target->execute([$announcement_id, $class_id]);
                }
            }
        }

        $pdo->commit();
        $_SESSION['form_message'] = "Duyuru başarıyla oluşturuldu.";
        $_SESSION['form_message_type'] = "success";
        header("Location: ../ogretmen/duyuru-yonetimi.php");

    } catch (Exception $e) {
        $pdo->rollBack();
        $_SESSION['form_message'] = "Hata: " . $e->getMessage();
        $_SESSION['form_message_type'] = "danger";
        header("Location: ../ogretmen/duyuru-ekle.php");
    }
    exit();
}
?>