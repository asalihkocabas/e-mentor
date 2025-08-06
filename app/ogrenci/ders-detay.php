<?php
// Gerekli dosyaları ve session'ı başlat
include '../config/init.php';
$_SESSION['user_role'] = 'student';

$student_id = $_SESSION['user_id'] ?? 2;
$course_id = isset($_GET['course_id']) ? intval($_GET['course_id']) : 0;

if ($course_id == 0) {
    header("Location: derslerim.php");
    exit;
}

// --- VERİTABANI SORGULARI ---
$stmt_course = $pdo->prepare("SELECT c.name as course_name, tp.full_name as teacher_name FROM courses c LEFT JOIN teacher_assignments ta ON c.id = ta.course_id LEFT JOIN teacher_profiles tp ON ta.teacher_id = tp.user_id WHERE c.id = ? AND ta.class_id = (SELECT class_id FROM student_profiles WHERE user_id = ?) LIMIT 1");
$stmt_course->execute([$course_id, $student_id]);
$course = $stmt_course->fetch(PDO::FETCH_ASSOC);

$page_title = ($course ? $course['course_name'] : 'Ders') . " Detayı | E-Mentor";
include '../partials/header.php';
include '../partials/sidebar.php';

$stmt_student_avg = $pdo->prepare("SELECT AVG(score) FROM student_exam_scores ses JOIN exams e ON ses.exam_id = e.id WHERE ses.student_id = ? AND e.course_id = ?");
$stmt_student_avg->execute([$student_id, $course_id]);
$student_avg_score = $stmt_student_avg->fetchColumn();

$stmt_class_avg = $pdo->prepare("SELECT AVG(ses.score) FROM student_exam_scores ses JOIN exams e ON ses.exam_id = e.id JOIN student_profiles sp ON ses.student_id = sp.user_id WHERE e.course_id = ? AND sp.class_id = (SELECT class_id FROM student_profiles WHERE user_id = ?)");
$stmt_class_avg->execute([$course_id, $student_id]);
$class_avg_score = $stmt_class_avg->fetchColumn();

$stmt_topics = $pdo->prepare("SELECT * FROM learning_outcomes WHERE course_id = ? ORDER BY start_date ASC");
$stmt_topics->execute([$course_id]);
$topics = $stmt_topics->fetchAll(PDO::FETCH_ASSOC);

$stmt_exams = $pdo->prepare("SELECT e.id as exam_id, e.name as exam_name, e.exam_date, ses.score FROM student_exam_scores ses JOIN exams e ON ses.exam_id = e.id WHERE ses.student_id = ? AND e.course_id = ? ORDER BY e.exam_date DESC");
$stmt_exams->execute([$student_id, $course_id]);
$exam_scores = $stmt_exams->fetchAll(PDO::FETCH_ASSOC);

$simulated_date = new DateTime(SIMULATED_NOW);
?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row"><div class="col-12"><div class="page-title-box d-sm-flex align-items-center justify-content-between"><h4 class="mb-sm-0 font-size-18"><?= htmlspecialchars($course['course_name'] ?? 'Ders Detayı') ?></h4></div></div></div>

            <div class="row">
                <div class="col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Ders Bilgileri</h5>
                            <div class="d-flex align-items-center mb-3">
                                <?php $teacher_avatar = get_avatar_data($course['teacher_name'] ?? 'Öğretmen'); ?>
                                <div class="avatar-xs me-2"><span class="avatar-title rounded-circle <?= $teacher_avatar['color_class'] ?> text-white font-size-16"><?= $teacher_avatar['initials'] ?></span></div>
                                <strong><?= htmlspecialchars($course['teacher_name'] ?? 'Atanmamış') ?></strong>
                            </div>
                            <hr>
                            <p class="mb-1"><strong>Ders Ortalaman:</strong> <span class="fw-bold text-success"><?= ($student_avg_score) ? number_format($student_avg_score, 2) : 'N/A' ?></span></p>
                            <p class="mb-0"><strong>Sınıf Ortalaması:</strong> <span class="fw-bold text-info"><?= ($class_avg_score) ? number_format($class_avg_score, 2) : 'N/A' ?></span></p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-9">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                                <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#konular" role="tab">Konu Listesi</a></li>
                                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#sinavlar" role="tab">Sınav Sonuçları</a></li>
                            </ul>
                            <div class="tab-content p-3">
                                <div class="tab-pane active" id="konular" role="tabpanel">
                                    <div class="table-responsive" style="max-height: 300px;" data-simplebar>
                                        <table class="table table-nowrap align-middle table-hover">
                                            <tbody>
                                            <?php if(empty($topics)): ?>
                                                <tr><td>Bu ders için konu listesi bulunamadı.</td></tr>
                                            <?php else: ?>
                                                <?php foreach ($topics as $topic):
                                                    $topic_start = $topic['start_date'] ? new DateTime($topic['start_date']) : null;
                                                    $topic_end = $topic['end_date'] ? new DateTime($topic['end_date']) : null;
                                                    $status_badge = '';
                                                    if ($topic_start && $topic_end) {
                                                        if ($simulated_date >= $topic_start && $simulated_date <= $topic_end) { $status_badge = '<span class="badge bg-primary">Bu Haftanın Konusu</span>'; }
                                                        elseif ($simulated_date > $topic_end) { $status_badge = '<span class="badge bg-success-subtle text-success">Tamamlandı</span>'; }
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td style="width: 45px;"><div class="avatar-xs"><span class="avatar-title rounded-circle bg-primary-subtle text-primary"><i class="bx bx-book-content"></i></span></div></td>
                                                        <td><h5 class="font-size-14 mb-1"><?= htmlspecialchars($topic['unit_name']) ?></h5><p class="text-muted mb-0"><?= htmlspecialchars($topic['description']) ?></p></td>
                                                        <td><div><?= $status_badge ?></div></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="sinavlar" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0 align-middle">
                                            <thead class="table-light"><tr><th>Sınav</th><th>Tarih</th><th>Puan</th><th class="text-end">İşlemler</th></tr></thead>
                                            <tbody>
                                            <?php if(empty($exam_scores)): ?>
                                                <tr><td colspan="4" class="text-center">Bu derse ait sınav sonucunuz bulunmuyor.</td></tr>
                                            <?php else: ?>
                                                <?php foreach ($exam_scores as $exam): ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($exam['exam_name']) ?></td>
                                                        <td><?= (new DateTime($exam['exam_date']))->format('d.m.Y') ?></td>
                                                        <td><span class="fw-bold text-success"><?= number_format($exam['score'], 2) ?></span></td>
                                                        <td class="text-end">
                                                            <button type="button" class="btn btn-primary btn-sm view-details-btn" data-exam-id="<?= $exam['exam_id'] ?>" data-exam-name="<?= htmlspecialchars($exam['exam_name']) ?>">Detay</button>
                                                            <button type="button" class="btn btn-info btn-sm ai-analysis-btn" data-exam-id="<?= $exam['exam_id'] ?>" data-exam-name="<?= htmlspecialchars($exam['exam_name']) ?>"><i class="bx bxs-magic-wand"></i> AI Analiz</button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="soruDetayModal" tabindex="-1"><div class="modal-dialog modal-lg modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="soruDetayModalLabel">Sınav Analizi</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><div id="kazanim-analiz-body"></div></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button></div></div></div></div>
<div class="modal fade" id="soruInceleModal" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="soruInceleModalLabel">Soru Detayı</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body" id="soru-incele-body"></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#soruDetayModal">Geri</button></div></div></div></div>
<div class="modal fade" id="aiAnalysisModal" tabindex="-1"><div class="modal-dialog modal-lg modal-dialog-centered"><div class="modal-content"><div class="modal-header bg-info text-white"><h5 class="modal-title" id="aiAnalysisModalLabel">Yapay Zeka Sınav Analizi</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div><div class="modal-body" id="ai-analysis-body" style="max-height: 70vh; overflow-y: auto;"></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button></div></div></div></div>

<?php include '../partials/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
    $(document).ready(function() {
        const soruDetayModal = new bootstrap.Modal(document.getElementById('soruDetayModal'));
        const soruInceleModal = new bootstrap.Modal(document.getElementById('soruInceleModal'));
        const aiAnalysisModal = new bootstrap.Modal(document.getElementById('aiAnalysisModal'));
        let currentAjaxRequest = null;

        $('.view-details-btn').on('click', function() {
            const examId = $(this).data('exam-id');
            const examName = $(this).data('exam-name');
            $('#soruDetayModalLabel').text(examName + ': Soru ve Kazanım Analizi');
            $('#kazanim-analiz-body').html('<div class="text-center my-3"><div class="spinner-border"></div></div>');
            soruDetayModal.show();

            $.ajax({
                url: '../islemler/get-sinav-analizi.php', type: 'POST', data: { exam_id: examId }, dataType: 'json',
                success: function(response) {
                    let tableHtml = '<div class="table-responsive"><table class="table align-middle"><thead><tr><th>Soru</th><th>Kazanım</th><th class="text-center">Durumun</th><th class="text-center">İncele</th></tr></thead><tbody>';
                    if(!response || response.length === 0){
                        tableHtml += '<tr><td colspan="4" class="text-center">Bu sınav için detaylı analiz verisi bulunamadı.</td></tr>';
                    } else {
                        response.forEach((q, index) => {
                            const status = q.is_correct ? '<span class="badge bg-success-subtle text-success">Doğru</span>' : '<span class="badge bg-danger-subtle text-danger">Yanlış</span>';
                            tableHtml += `<tr><td>${index+1}</td><td><strong>${q.outcome_code}:</strong> ${q.outcome_description}</td><td class="text-center">${status}</td><td class="text-center"><button class="btn btn-sm btn-outline-primary view-question-btn" data-question-id="${q.question_id}">İncele</button></td></tr>`;
                        });
                    }
                    tableHtml += '</tbody></table></div>';
                    $('#kazanim-analiz-body').html(tableHtml);
                }
            });
        });

        $(document).on('click', '.view-question-btn', function() {
            const questionId = $(this).data('question-id');
            $('#soruInceleModalLabel').text(`Soru ${$(this).closest('tr').find('td:first').text()} Detayı`);
            $('#soru-incele-body').html('<div class="text-center my-3"><div class="spinner-border"></div></div>');
            soruDetayModal.hide();
            soruInceleModal.show();

            $.ajax({
                url: '../islemler/get-soru-detayi.php', type: 'POST', data: { question_id: questionId }, dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        const d = response.data;
                        const options = d.options || {};
                        let optionsHtml = '<div class="list-group">';
                        for (const key in options) {
                            const isCorrect = (key == d.correct_answer);
                            const isSelected = (key == d.selected_answer);
                            let itemClass = ''; let badgeHtml = '';

                            if (isCorrect) {
                                itemClass = 'list-group-item-success';
                                badgeHtml = '<span class="badge bg-success">Doğru Cevap</span>';
                            }
                            if (isSelected) {
                                itemClass = isCorrect ? 'list-group-item-success' : 'list-group-item-danger';
                                badgeHtml += (badgeHtml ? ' ' : '') + '<span class="badge bg-warning text-dark">Senin Cevabın</span>';
                            }
                            optionsHtml += `<div class="list-group-item d-flex justify-content-between align-items-center ${itemClass}"><span>${key}) ${options[key]}</span><div>${badgeHtml}</div></div>`;
                        }
                        optionsHtml += '</div>';
                        $('#soru-incele-body').html(`<h6 class="fw-bold">Soru Metni:</h6><p class="card-text p-3 bg-light rounded">${d.question_text}</p><h6 class="fw-bold mt-4">Seçenekler:</h6>${optionsHtml}`);
                    }
                }
            });
        });

        $('.ai-analysis-btn').on('click', function() {
            const examId = $(this).data('exam-id');
            const examName = $(this).data('exam-name');
            const aiAnalysisModal = new bootstrap.Modal(document.getElementById('aiAnalysisModal'));
            $('#aiAnalysisModalLabel').text(examName + ': Yapay Zeka Sınav Analizi');
            $('#ai-analysis-body').html('<div class="text-center my-3"><p>Yanlışların bulunuyor...</p><div class="spinner-border text-primary"></div></div>');
            aiAnalysisModal.show();

            $.ajax({
                url: '../islemler/get-yanlis-sorular.php',
                type: 'POST', data: { exam_id: examId }, dataType: 'json',
                success: function(yanlislar) {
                    if (yanlislar.length === 0) {
                        $('#ai-analysis-body').html('<div class="alert alert-success">Harika! Bu sınavda hiç yanlışın yok. Analiz edilecek bir hata bulunamadı.</div>');
                        return;
                    }

                    $('#ai-analysis-body').html('<div class="text-center my-3"><p>Yanlışların Gemini AI tarafından analiz ediliyor...</p><div class="spinner-border text-info"></div></div>');

                    $.ajax({
                        url: '../islemler/sinav-analiz-ai.php',
                        type: 'POST',
                        data: { yanlis_sorular: JSON.stringify(yanlislar) },
                        dataType: 'json',
                        timeout: 35000,
                        success: function(analiz) {
                            if (analiz.success) {
                                $('#ai-analysis-body').html(marked.parse(analiz.analysis));
                            } else {
                                $('#ai-analysis-body').html(`<div class="alert alert-danger p-3" style="white-space: pre-wrap;"><strong>Analiz Başarısız</strong><hr>${analiz.analysis}</div>`);
                            }
                        },
                        error: function(jqXHR, textStatus) {
                            let errorMsg = 'AI analizi alınırken bir sunucu hatası oluştu. Lütfen geliştirici konsolunu kontrol edin.';
                            if (textStatus === 'timeout') {
                                errorMsg = 'İstek zaman aşımına uğradı. Sunucu meşgul veya internet bağlantınız yavaş olabilir. Lütfen tekrar deneyin.';
                            }
                            $('#ai-analysis-body').html(`<div class="alert alert-danger">${errorMsg}</div>`);
                        }
                    });
                },
                error: function() { $('#ai-analysis-body').html('<div class="alert alert-danger">Yanlış soruların alınırken bir hata oluştu.</div>'); }
            });
        });
    });
</script>