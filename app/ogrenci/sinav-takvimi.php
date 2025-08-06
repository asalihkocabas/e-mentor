<?php
// Gerekli dosyaları ve session'ı başlat
include '../config/init.php';
$_SESSION['user_role'] = 'student';
$page_title = "Sınav Takvimi | E-Mentor Öğrenci Paneli";

include '../partials/header.php';
include '../partials/sidebar.php';

$student_id = $_SESSION['user_id'] ?? 2;

// Öğrencinin sınıfını bul
$stmt_class = $pdo->prepare("SELECT class_id FROM student_profiles WHERE user_id = ?");
$stmt_class->execute([$student_id]);
$class_id = $stmt_class->fetchColumn();

// Sınıfa atanmış TÜM GELECEKTEKİ sınavları çek
$stmt_exams = $pdo->prepare("
        SELECT e.id, e.name as exam_name, e.exam_date, c.name as course_name
        FROM exams e
        JOIN exam_classes ec ON e.id = ec.exam_id
        JOIN courses c ON e.course_id = c.id
        WHERE ec.class_id = ? AND e.exam_date >= ?
        ORDER BY e.exam_date ASC
    ");
$stmt_exams->execute([$class_id, SIMULATED_NOW]);
$upcoming_exams = $stmt_exams->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12"><div class="page-title-box d-sm-flex align-items-center justify-content-between"><h4 class="mb-sm-0 font-size-18">Sınav Takvimi</h4></div></div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="row justify-content-center">
                        <div class="col-xl-10">
                            <div class="timeline">
                                <div class="timeline-container">
                                    <div class="timeline-launch">
                                        <div class="timeline-box">
                                            <div class="timeline-text">
                                                <h3 class="font-size-18">Bugün - <span id="today-date"></span></h3>
                                                <p class="text-muted mb-0">Sınavların yaklaşıyor, çalışmayı ihmal etme!</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="timeline-continue">
                                        <?php if(empty($upcoming_exams)): ?>
                                            <p class="text-center my-5">Yaklaşan bir sınavınız bulunmuyor.</p>
                                        <?php else: ?>
                                            <?php
                                            $icon_map = [ 'Matematik' => 'bx-math', 'Türkçe' => 'bx-edit-alt', 'Fen Bilimleri' => 'bx-vial' ];
                                            foreach($upcoming_exams as $index => $exam):
                                                $exam_date = new DateTime($exam['exam_date']);
                                                $alignment_class = ($index % 2 == 0) ? 'timeline-right' : 'timeline-left';
                                                $icon = $icon_map[$exam['course_name']] ?? 'bx-calendar-event';
                                                $icon_html = '<div class="col-md-6 d-none d-md-block"><div class="timeline-icon"><i class="bx '.$icon.' text-primary h2 mb-0"></i></div></div>';
                                                ?>
                                                <div class="row <?= $alignment_class ?>">
                                                    <?php if($alignment_class == 'timeline-right') echo $icon_html; ?>
                                                    <div class="col-md-6">
                                                        <div class="timeline-box">
                                                            <div class="timeline-date bg-primary text-center rounded"><h3 class="text-white mb-0"><?= $exam_date->format('d') ?></h3><p class="mb-0 text-white-50"><?= mb_substr($exam_date->format('F'), 0, 3) ?></p></div>
                                                            <div class="event-content"><div class="timeline-text">
                                                                    <h3 class="font-size-18"><?= htmlspecialchars($exam['course_name']) ?></h3>
                                                                    <p class="mb-0 mt-2 pt-1 text-muted"><?= htmlspecialchars($exam['exam_name']) ?></p>
                                                                    <button type="button" class="btn btn-primary btn-rounded waves-effect waves-light mt-4 ai-help-btn" data-exam-id="<?= $exam['id'] ?>">GeminiAI'dan Yardım İste</button>
                                                                </div></div>
                                                        </div>
                                                    </div>
                                                    <?php if($alignment_class == 'timeline-left') echo $icon_html; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
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

<div class="modal fade" id="aiHelpModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white"><h5 class="modal-title"><i class="bx bx-brain me-2"></i> Gemini AI - Sınav Hazırlık Rehberi</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>
            <div class="modal-body py-4" style="max-height: 70vh; overflow-y: auto;"><div id="ai-modal-content"></div></div>
            <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal" id="ai-modal-close-btn"><i class="bx bx-x me-1"></i> Kapat</button></div>
        </div>
    </div>
</div>

<?php include '../partials/footer.php'; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // HATA DÜZELTMESİ: Önce elementin varlığını kontrol et
        const todayDateEl = document.getElementById('today-date');
        if(todayDateEl) {
            todayDateEl.innerText = new Date().toLocaleDateString('tr-TR', { day: 'numeric', month: 'long', year: 'numeric' });
        }

        const aiHelpModalEl = document.getElementById('aiHelpModal');
        const aiHelpModal = new bootstrap.Modal(aiHelpModalEl);
        const aiModalContent = document.getElementById('ai-modal-content');
        let currentAjaxRequest = null;

        $('.ai-help-btn').on('click', function(){
            const examId = $(this).data('exam-id');
            aiModalContent.innerHTML = '<div class="text-center my-5"><div class="spinner-border text-primary"></div><p class="mt-2">Kazanımlar bulunuyor...</p></div>';
            aiHelpModal.show();

            if(currentAjaxRequest) { currentAjaxRequest.abort(); }

            currentAjaxRequest = $.ajax({
                url: '../islemler/get-kazanimlar-by-exam.php', type: 'POST', data: { exam_id: examId }, dataType: 'json',
                success: function(kazanimResponse) {
                    if (kazanimResponse.success && kazanimResponse.kazanimlar.length > 0) {
                        aiModalContent.innerHTML = '<div class="text-center my-5"><div class="spinner-border text-info"></div><p class="mt-2">Gemini AI hazırlık rehberi oluşturuyor...</p></div>';

                        currentAjaxRequest = $.ajax({
                            url: '../islemler/generate-exam-prep.php', type: 'POST', data: { kazanimlar: kazanimResponse.kazanimlar.join('\n') }, dataType: 'json',
                            timeout: 30000,
                            success: function(prepResponse){
                                if(prepResponse.success && prepResponse.data){
                                    let html = '';
                                    if(prepResponse.data.konular && prepResponse.data.konular.length > 0) {
                                        html += `<div class="mb-4"><h5><i class="bx bx-list-ul me-2 text-primary"></i>Sınav Konuları</h5><ul class="list-group list-group-flush">`;
                                        (prepResponse.data.konular || []).forEach(item => { html += `<li class="list-group-item"><i class="bx bx-check-circle text-success me-2"></i>${item}</li>`; });
                                        html += `</ul></div><hr>`;
                                    }
                                    if(prepResponse.data.ornek_sorular && prepResponse.data.ornek_sorular.length > 0) {
                                        html += `<div class="mb-4"><h5><i class="bx bx-question-mark me-2 text-primary"></i>Örnek Sorular</h5>`;
                                        (prepResponse.data.ornek_sorular || []).forEach((item, index) => {
                                            html += `<div class="p-3 border rounded mb-2"><strong>${index + 1}. Soru:</strong> ${item.soru}<br><strong>Cevap:</strong> <span class="text-success fw-bold">${item.cevap}</span></div>`;
                                        });
                                        html += `</div><hr>`;
                                    }
                                    html += `<div class="mb-3"><h5><i class="bx bx-bulb me-2 text-primary"></i>Çalışma Taktikleri</h5><ul class="list-group list-group-flush">`;
                                    (prepResponse.data.oneriler || []).forEach(item => { html += `<li class="list-group-item"><i class="bx bx-lightbulb text-warning me-2"></i>${item}</li>`; });
                                    html += `</ul></div>`;
                                    aiModalContent.innerHTML = html;
                                } else {
                                    const errorMessage = (prepResponse.data && prepResponse.data.oneriler) ? prepResponse.data.oneriler.join('<br>') : 'Bilinmeyen bir hata oluştu.';
                                    aiModalContent.innerHTML = `<div class="alert alert-danger">${errorMessage}</div>`;
                                }
                            }
                        });
                    } else {
                        aiModalContent.innerHTML = '<div class="alert alert-warning">Bu sınava ait kazanım bilgisi bulunamadı.</div>';
                    }
                }
            });
        });

        aiHelpModalEl.addEventListener('hide.bs.modal', function () {
            if (currentAjaxRequest) {
                currentAjaxRequest.abort();
            }
        });
    });
</script>