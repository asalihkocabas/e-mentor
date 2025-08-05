<?php
// Gerekli dosyaları ve session'ı başlat
include '../config/init.php';
$_SESSION['user_role'] = 'teacher';
$page_title = "Kişiye Özel Ödev Atama | E-Mentor Öğretmen Paneli";

include '../partials/header.php';
include '../partials/sidebar.php';

$teacher_id = $_SESSION['user_id'] ?? 1;

// Öğretmenin oluşturduğu ve sonuçları girilmiş sınavları çek
$stmt_exams = $pdo->prepare("SELECT DISTINCT e.id, e.name FROM exams e JOIN student_exam_scores ses ON e.id = ses.exam_id WHERE e.creator_id = ? ORDER BY e.name ASC");
$stmt_exams->execute([$teacher_id]);
$exams = $stmt_exams->fetchAll(PDO::FETCH_ASSOC);
?>

    <link href="../assets/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="../assets/libs/flatpickr/flatpickr.min.css">

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row"><div class="col-12"><div class="page-title-box d-sm-flex align-items-center justify-content-between"><h4 class="mb-sm-0 font-size-18">Kişiye Özel Ödev Atama</h4></div></div></div>
                <div id="form-notification" class="mb-3"></div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Adım 1: Analiz Yapılacak Sınavı ve Sınıfı Seçin</h4>
                                <form id="analysis-form" class="row gx-3 gy-2 align-items-end">
                                    <div class="col-md-5"><label for="exam-select">Sınav</label><select id="exam-select"><option value="">Seçiniz...</option><?php foreach($exams as $exam):?><option value="<?=$exam['id']?>"><?=$exam['name']?></option><?php endforeach;?></select></div>
                                    <div class="col-md-5"><label for="class-select">Sınıf</label><select id="class-select"><option value="">Önce Sınav Seçin...</option></select></div>
                                    <div class="col-md-2"><button type="submit" class="btn btn-primary w-100"><i class="bx bx-search-alt me-1"></i> Analiz Et</button></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header"><h4 class="card-title">Adım 2: Zayıf Kazanım Tespit Edilen Öğrenciler</h4></div>
                            <div class="card-body">
                                <div class="accordion" id="student-accordion-container">
                                    <div class="alert alert-info text-center">Lütfen analiz için bir sınav ve sınıf seçin.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="assignHwModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">✨ Yapay Zeka ile Ödev Oluştur</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <input type="hidden" id="modal-student-id">
                    <input type="hidden" id="modal-outcome-id">
                    <div class="mb-3"><strong>Kazanım:</strong> <span id="modal-outcome-text" class="text-primary"></span></div>
                    <p class="text-muted">Yapay zekadan bu kazanım için 5 adet soru oluşturmasını isteyin.</p>
                    <div class="text-center mb-3"><button type="button" id="generate-ai-content-btn" class="btn btn-info"><i class="bx bxs-magic-wand me-1"></i> 5 Adet Soru Oluştur</button></div>
                    <div id="ai-output-container" class="bg-light p-3 rounded" style="display:none;">
                        <label for="ai-content" class="form-label fw-bold">Oluşturulan İçerik (Düzenleyebilirsiniz):</label>
                        <textarea class="form-control" id="ai-content" rows="10"></textarea>
                    </div>
                    <hr class="my-4">
                    <div class="row">
                        <div class="col-md-6"><label for="due-date" class="form-label">Son Teslim Tarihi</label><input type="text" class="form-control" id="due-date" required></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                    <button type="button" id="save-assignment-btn" class="btn btn-primary"><i class="bx bx-send me-1"></i> Ödevi Ata</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/tr.js"></script>
    <script src="../assets/libs/flatpickr/flatpickr.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const examSelect = new Choices('#exam-select');
            const classSelect = new Choices('#class-select');
            flatpickr("#due-date", { enableTime: true, dateFormat: "d.m.Y H:i", locale: 'tr' });
            const assignHwModal = new bootstrap.Modal(document.getElementById('assignHwModal'));

            $('#exam-select').on('change', function() {
                const examId = this.value; classSelect.clearStore();
                if (!examId) { classSelect.setChoices([{ value: '', label: 'Önce Sınav Seçin...' }], 'value', 'label', true); return; }
                $.ajax({
                    url: '../islemler/get-siniflar.php', type: 'POST', data: { exam_id: examId }, dataType: 'json',
                    success: data => classSelect.setChoices([{ value: '', label: 'Sınıf Seçiniz...' }, ...data.map(c => ({ value: c.id, label: c.name }))], 'value', 'label', true)
                });
            });

            $('#analysis-form').on('submit', function(e) {
                e.preventDefault();
                const examId = examSelect.getValue(true);
                const classId = classSelect.getValue(true);
                if (examId && classId) {
                    $('#student-accordion-container').html('<p class="text-center my-3"><i class="bx bx-loader-alt bx-spin font-size-24"></i> Analiz ediliyor...</p>');
                    $.ajax({
                        url: '../islemler/get-zayif-kazanimlar.php', type: 'POST', data: { exam_id: examId, class_id: classId }, dataType: 'json',
                        success: function(data) {
                            let html = '';
                            if (!data.students || Object.keys(data.students).length === 0) {
                                html = '<div class="alert alert-success text-center">Harika! Bu sınıfta eksik kazanımı olan öğrenci bulunamadı.</div>';
                            } else {
                                html = '<div class="alert alert-info">Analiz tamamlandı. Aşağıda eksik kazanımı olan öğrenciler listelenmiştir.</div>';
                                $.each(data.students, function(studentId, studentData) {
                                    html += `<div class="accordion-item" id="student-item-${studentId}">
                                <h2 class="accordion-header"><button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-${studentId}">${studentData.full_name}</button></h2>
                                <div id="collapse-${studentId}" class="accordion-collapse collapse"><div class="accordion-body"><ul class="list-group list-group-flush">`;
                                    $.each(studentData.outcomes, function(i, outcome) {
                                        html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div><h6 class="mb-1">${outcome.code}</h6><p class="mb-0 text-muted">${outcome.description}</p></div>
                                    <button class="btn btn-primary btn-sm assign-btn" data-student-id="${studentId}" data-outcome-id="${outcome.id}" data-outcome-text="${outcome.description}">AI ile Ödev Oluştur</button>
                                </li>`;
                                    });
                                    html += `</ul></div></div></div>`;
                                });
                            }
                            $('#student-accordion-container').html(html);
                        }
                    });
                }
            });

            $(document).on('click', '.assign-btn', function() {
                $('#modal-student-id').val($(this).data('student-id'));
                $('#modal-outcome-id').val($(this).data('outcome-id'));
                $('#modal-outcome-text').text($(this).data('outcome-text'));
                $('#ai-output-container').hide();
                $('#ai-content').val('');
                assignHwModal.show();
            });

            $('#generate-ai-content-btn').on('click', function() {
                const btn = $(this);
                btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Oluşturuluyor...');
                $.ajax({
                    url: '../islemler/odev-olustur-ai.php', type: 'POST', data: { description: $('#modal-outcome-text').text() }, dataType: 'json',
                    success: function(data) {
                        if(data.success){
                            $('#ai-content').val(data.content);
                            $('#ai-output-container').slideDown();
                        } else {
                            alert('Hata: ' + data.content);
                        }
                    },
                    error: function(){ alert('AI içeriği oluşturulurken bir sunucu hatası oluştu.'); },
                    complete: function() { btn.prop('disabled', false).html('<i class="bx bxs-magic-wand me-1"></i> 5 Adet Soru Oluştur'); }
                });
            });

            $('#save-assignment-btn').on('click', function(){
                const btn = $(this);
                const assignmentData = {
                    student_id: $('#modal-student-id').val(),
                    outcome_id: $('#modal-outcome-id').val(),
                    ai_content: $('#ai-content').val(),
                    due_date: $('#due-date').val()
                };

                if(!assignmentData.student_id || !assignmentData.outcome_id || !assignmentData.ai_content || !assignmentData.due_date){
                    alert('Lütfen önce içerik oluşturun ve bir teslim tarihi seçin.');
                    return;
                }
                btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Atanıyor...');
                $.ajax({
                    url: '../islemler/odev-kaydet.php', type: 'POST', data: assignmentData, dataType: 'json',
                    success: function(response){
                        if(response.success){
                            assignHwModal.hide();
                            const studentId = assignmentData.student_id;
                            const studentItem = $(`#student-item-${studentId} .list-group-item button[data-outcome-id="${assignmentData.outcome_id}"]`).closest('li');
                            studentItem.fadeOut(400, function() { $(this).remove(); });

                            $('#form-notification').html(`<div class="alert alert-success alert-dismissible fade show" role="alert">${response.message}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>`);
                        } else {
                            alert('Hata: ' + response.message);
                        }
                    },
                    error: function(){ alert('Ödev atanırken bir sunucu hatası oluştu.'); },
                    complete: function() { btn.prop('disabled', false).html('<i class="bx bx-send me-1"></i> Ödevi Ata'); }
                });
            });
        });
    </script>

<?php
include '../partials/footer.php';
?>