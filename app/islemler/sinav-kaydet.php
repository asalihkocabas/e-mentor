<?php
// Gerekli dosyaları ve session'ı başlat
include '../config/init.php';

// Formun POST metodu ile gönderilip gönderilmediğini kontrol et
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- FORM VERİLERİNİ ALMA ---
    $course_id = $_POST['course_id'];
    $class_ids = $_POST['class_ids'] ?? [];
    $term = $_POST['exam_term'];
    $exam_type = $_POST['exam_type'];
    $creator_id = $_SESSION['user_id'] ?? 1;

    // Türkçe tarih formatını (d-m-Y H:i) MySQL formatına (Y-m-d H:i:s) çevir
    $exam_date_str = $_POST['exam_date'];
    $date = DateTime::createFromFormat('d-m-Y H:i', $exam_date_str);
    $exam_date_mysql = $date ? $date->format('Y-m-d H:i:s') : null;

    // Sınavın standart adını oluşturalım
    $stmt_course = $pdo->prepare("SELECT name FROM courses WHERE id = ?");
    $stmt_course->execute([$course_id]);
    $course_name = $stmt_course->fetchColumn();
    $exam_name = $course_name . " " . $term . " " . $exam_type;

    try {
        $pdo->beginTransaction();

        // 1. Adım: Yeni sınavı `exams` tablosuna ekle
        $stmt_exam = $pdo->prepare(
            "INSERT INTO exams (name, term, exam_type, course_id, creator_id, exam_date) VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt_exam->execute([$exam_name, $term, $exam_type, $course_id, $creator_id, $exam_date_mysql]);
        $exam_id = $pdo->lastInsertId();

        // 2. Adım: Sınavın hangi sınıflara atandığını `exam_classes` tablosuna ekle
        $stmt_exam_class = $pdo->prepare("INSERT INTO exam_classes (exam_id, class_id) VALUES (?, ?)");
        foreach ($class_ids as $class_id) {
            $stmt_exam_class->execute([$exam_id, $class_id]);
        }

        // 3. Adım: Soruları `questions` tablosuna ekle
        if (isset($_POST['questions']) && is_array($_POST['questions'])) {
            $stmt_question = $pdo->prepare(
                "INSERT INTO questions (exam_id, type, question_text, options, correct_answer, points, learning_outcome_id) 
                 VALUES (:exam_id, :type, :text, :options, :correct, :points, :outcome_id)"
            );

            foreach ($_POST['questions'] as $q_data) {
                $stmt_question->execute([
                    ':exam_id' => $exam_id,
                    ':type' => $q_data['type'],
                    ':text' => $q_data['text'],
                    ':options' => isset($q_data['options']) ? json_encode($q_data['options']) : null,
                    ':correct' => $q_data['correct'] ?? null,
                    ':points' => $q_data['points'],
                    ':outcome_id' => $q_data['outcome_id']
                ]);
            }
        }

        $pdo->commit();

        $_SESSION['form_message'] = "Sınav başarıyla oluşturuldu!";
        $_SESSION['form_message_type'] = "success";
        header("Location: ../ogretmen/raporlar.php");
        exit();

    } catch (Exception $e) {
        $pdo->rollBack();
        $_SESSION['form_message'] = "Hata: " . $e->getMessage();
        $_SESSION['form_message_type'] = "danger";
        header("Location: ../ogretmen/sinav-olustur.php");
        exit();
    }
}
?>