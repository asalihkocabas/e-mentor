<?php
include '../config/init.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $exam_id = $_POST['exam_id'];
    $class_id = $_POST['class_id'];
    $answers = $_POST['answers'] ?? [];

    $stmt_q = $pdo->prepare("SELECT id, correct_answer, points, type FROM questions WHERE exam_id = ?");
    $stmt_q->execute([$exam_id]);
    $questions_raw = $stmt_q->fetchAll(PDO::FETCH_ASSOC);
    $questions = [];
    foreach($questions_raw as $q) { $questions[$q['id']] = $q; }

    try {
        $pdo->beginTransaction();

        foreach ($answers as $student_id => $student_answers) {
            $total_score = 0; $correct_count = 0; $incorrect_count = 0; $blank_count = 0;

            foreach ($student_answers as $question_id => $data) {
                if (!isset($questions[$question_id])) continue;
                $question_info = $questions[$question_id];
                $is_correct = 0; $score_override = null; $selected_answer = ''; $written_answer = null;

                if ($question_info['type'] == 'open') {
                    $written_answer = trim($data['written_answer'] ?? '');
                    $score_override = !empty($data['score']) ? floatval($data['score']) : 0;
                    $total_score += $score_override;
                } else {
                    $selected_answer = strtoupper(trim($data['answer'] ?? ''));
                    if (empty($selected_answer)) {
                        $blank_count++;
                        $is_correct = 0;
                    } elseif (trim($selected_answer) == trim($question_info['correct_answer'])) {
                        $is_correct = 1; $correct_count++; $total_score += $question_info['points'];
                    } else {
                        $incorrect_count++;
                        $is_correct = 0;
                    }
                }

                $stmt_ans = $pdo->prepare(
                    "INSERT INTO student_answers (student_id, exam_id, question_id, selected_answer, written_answer, is_correct, score_override) VALUES (?, ?, ?, ?, ?, ?, ?)"
                );
                $stmt_ans->execute([$student_id, $exam_id, $question_id, $selected_answer, $written_answer, $is_correct, $score_override]);
            }

            $stmt_score = $pdo->prepare(
                "INSERT INTO student_exam_scores (student_id, exam_id, score, correct_count, incorrect_count, blank_count) VALUES (?, ?, ?, ?, ?, ?)"
            );
            $stmt_score->execute([$student_id, $exam_id, $total_score, $correct_count, $incorrect_count, $blank_count]);
        }

        $pdo->commit();
        $_SESSION['form_message'] = "Sınav sonuçları başarıyla kaydedildi!";
        $_SESSION['form_message_type'] = "success";
        header("Location: ../ogretmen/raporlar.php");
        exit();

    } catch (Exception $e) {
        $pdo->rollBack();
        $_SESSION['form_message'] = "Hata: " . $e->getMessage();
        $_SESSION['form_message_type'] = "danger";
        header("Location: ../ogretmen/sonuc-girisi.php");
        exit();
    }
}
?>