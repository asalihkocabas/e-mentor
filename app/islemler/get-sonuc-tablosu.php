<?php
require_once '../config/init.php';

$exam_id = $_POST['exam_id'] ?? 0;
$class_id = $_POST['class_id'] ?? 0;

if ($exam_id > 0 && $class_id > 0) {
    // Sınavdaki soruları ve puanlarını çek
    $stmt_q = $pdo->prepare("SELECT id, type, correct_answer, points FROM questions WHERE exam_id = ? ORDER BY id ASC");
    $stmt_q->execute([$exam_id]);
    $questions = $stmt_q->fetchAll(PDO::FETCH_ASSOC);

    // Sınıftaki öğrencileri çek
    $stmt_s = $pdo->prepare("SELECT user_id, full_name FROM student_profiles WHERE class_id = ? ORDER BY full_name ASC");
    $stmt_s->execute([$class_id]);
    $students = $stmt_s->fetchAll(PDO::FETCH_ASSOC);

    if (empty($questions) || empty($students)) {
        echo '<div class="alert alert-warning">Bu sınavda soru veya bu sınıfta öğrenci bulunmuyor.</div>';
        exit;
    }

    // JS'nin puan hesaplaması için soru verilerini hazırla
    $questions_json = json_encode(array_column($questions, null, 'id'));

    // HTML Tablosunu oluştur
    $html = '<input type="hidden" name="exam_id" value="'.$exam_id.'">';
    $html .= '<input type="hidden" name="class_id" value="'.$class_id.'">';
    $html .= "<table class='table table-bordered align-middle text-center' data-questions='".htmlspecialchars($questions_json, ENT_QUOTES, 'UTF-8')."'>";
    $html .= '<thead class="table-light"><tr><th class="text-start">Öğrenci Adı</th>';
    foreach ($questions as $index => $q) {
        $html .= '<th>S-' . ($index + 1) . ' (' . ($q['points'] ?? 0) . 'p)</th>';
    }
    $html .= '<th>Toplam Puan</th></tr></thead>';

    // Cevap Anahtarı Satırı
    $html .= '<tbody><tr class="table-info"><td class="text-start fw-bold">CEVAP ANAHTARI</td>';
    foreach ($questions as $q) {
        $html .= '<td class="fw-bold">' . htmlspecialchars($q['correct_answer'] ?? '-') . '</td>';
    }
    $html .= '<td></td></tr>';

    // Öğrenci Satırları
    foreach ($students as $student) {
        $html .= '<tr class="student-row" data-student-id="'.$student['user_id'].'">';
        $html .= '<td class="text-start">' . htmlspecialchars($student['full_name']) . '</td>';
        foreach ($questions as $q) {
            $input_name_prefix = "answers[{$student['user_id']}][{$q['id']}]";
            $html .= '<td class="answer-cell">';
            if ($q['type'] == 'mcq' || $q['type'] == 'tf') {
                $html .= "<input type='text' class='form-control form-control-sm answer-input' name='{$input_name_prefix}[answer]' maxlength='1' style='text-transform:uppercase;'>";
            } else { // open
                $html .= "<textarea class='form-control form-control-sm mb-1' name='{$input_name_prefix}[written_answer]' placeholder='Cevap' rows='2'></textarea>";
                $html .= "<input type='number' class='form-control form-control-sm answer-score' name='{$input_name_prefix}[score]' placeholder='Puan' min='0' max='".($q['points'] ?? 0)."'>";
            }
            $html .= '</td>';
        }
        $html .= '<td class="fw-bold total-score-cell">0</td>';
        $html .= '</tr>';
    }

    $html .= '</tbody></table>';
    echo $html;
}
?>