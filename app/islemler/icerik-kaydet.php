<?php
include '../config/init.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $file_type = $_POST['file_type'] ?? '';
    $files_meta = $_POST['files'] ?? [];
    $uploaded_files = $_FILES['file_uploads'] ?? [];
    $uploader_id = $_SESSION['user_id'] ?? 1;

    $upload_dir = '../uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    try {
        $pdo->beginTransaction();
        $stmt = $pdo->prepare(
            "INSERT INTO library_content (uploader_id, file_name, file_path, file_type, metadata) 
             VALUES (?, ?, ?, ?, ?)"
        );

        // Dosyaları sunucuya yükle
        foreach ($uploaded_files['name'] as $index => $fileName) {
            $tempName = $uploaded_files['tmp_name'][$index];
            $newFileName = time() . '_' . basename($fileName);
            $targetPath = $upload_dir . $newFileName;

            if (move_uploaded_file($tempName, $targetPath)) {
                // Yükleme başarılıysa, metaverilerle birlikte veritabanına kaydet
                $metadata = json_encode($files_meta[$index]);
                $stmt->execute([$uploader_id, $fileName, $targetPath, $file_type, $metadata]);
            }
        }

        $pdo->commit();
        $_SESSION['form_message'] = "Dosyalar başarıyla kütüphaneye eklendi.";
        $_SESSION['form_message_type'] = "success";
        header("Location: ../ogretmen/icerik-kutuphanesi.php");
        exit();

    } catch (Exception $e) {
        $pdo->rollBack();
        $_SESSION['form_message'] = "Hata: " . $e->getMessage();
        $_SESSION['form_message_type'] = "danger";
        header("Location: ../ogretmen/dosya-yukle.php");
        exit();
    }
}
?>