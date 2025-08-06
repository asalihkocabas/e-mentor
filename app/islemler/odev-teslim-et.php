<?php
include '../config/init.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $assignment_id = $_POST['assignment_id'] ?? 0;
    $submission_text = $_POST['submission_text'] ?? null;
    $student_id = $_SESSION['user_id'] ?? 0;

    // Dosya yükleme işlemi (varsa)
    $file_path = null;
    if (isset($_FILES['submission_file']) && $_FILES['submission_file']['error'] == 0) {
        $upload_dir = '../uploads/submissions/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $fileName = time() . '_' . basename($_FILES['submission_file']['name']);
        $targetFile = $upload_dir . $fileName;
        if (move_uploaded_file($_FILES['submission_file']['tmp_name'], $targetFile)) {
            $file_path = $targetFile;
        }
    }

    if ($assignment_id > 0 && $student_id > 0) {
        try {
            $stmt = $pdo->prepare("
                UPDATE homework_assignments 
                SET status = 'submitted', 
                    submission_date = NOW(),
                    student_submission_text = ?,
                    student_submission_file_path = ?
                WHERE id = ? AND student_id = ?
            ");
            $stmt->execute([$submission_text, $file_path, $assignment_id, $student_id]);

            $_SESSION['form_message'] = "Ödevin başarıyla teslim edildi.";
            $_SESSION['form_message_type'] = "success";

        } catch (Exception $e) {
            $_SESSION['form_message'] = "Hata: " . $e->getMessage();
            $_SESSION['form_message_type'] = "danger";
        }
    }
    header("Location: ../ogrenci/odevlerim.php");
    exit();
}
?>