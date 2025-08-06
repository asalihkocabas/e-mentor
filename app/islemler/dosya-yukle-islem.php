<?php
include '../config/init.php';

// Yüklemeler için bir klasör olduğundan emin ol
$upload_dir = '../uploads/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if (!empty($_FILES)) {
    $tempFile = $_FILES['file']['tmp_name'];
    $fileName = time() . '-' . $_FILES['file']['name']; // Çakışmaları önlemek için dosya adının başına zaman damgası ekle
    $targetFile =  $upload_dir . $fileName;

    if (move_uploaded_file($tempFile, $targetFile)) {
        // Başarılı olursa, dosya adını ve yolunu JSON olarak geri döndür
        echo json_encode(['success' => true, 'fileName' => $fileName, 'filePath' => $targetFile]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Dosya yüklenemedi.']);
    }
}
?>