<?php
// Gerekli dosyaları ve session'ı başlat
include '../config/init.php';
$_SESSION['user_role'] = 'teacher';
$page_title = "Sınav Sonuç Girişi | E-Mentor Öğretmen Paneli";

include '../partials/header.php';
include '../partials/sidebar.php';

$teacher_id = $_SESSION['user_id'] ?? 1;

// Öğretmenin oluşturduğu sınavları çek
$stmt_exams = $pdo->prepare("SELECT id, name FROM exams WHERE creator_id = ? ORDER BY exam_date DESC");
$stmt_exams->execute([$teacher_id]);
$exams = $stmt_exams->fetchAll(PDO::FETCH_ASSOC);
?>

    <link href="../assets/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" type="text/css" />
    <style>
        .answer-cell { min-width: 100px; }
    </style>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Sınav Sonuç Girişi</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="index.php">Ana Sayfa</a></li>
                                    <li class="breadcrumb-item active">Sonuç Girişi</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (isset($_SESSION['form_message'])): ?>
                    <div class="alert alert-<?= $_SESSION['form_message_type']; ?> alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($_SESSION['form_message']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['form_message'], $_SESSION['form_message_type']); endif; ?>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Adım 1: Sınav ve Sınıf Seçimi</h4>
                                <p class="card-title-desc">Sonuçlarını girmek istediğiniz sınavı ve sınıfı seçin.</p>
                                <form id="selection-form">
                                    <div class="row">
                                        <div class="col-md-5 mb-3">
                                            <label for="exam-select" class="form-label">Sınav</label>
                                            <select id="exam-select" name="exam_id">
                                                <option value="">Sınav Seçiniz...</option>
                                                <?php foreach ($exams as $exam): ?>
                                                    <option value="<?= $exam['id'] ?>"><?= htmlspecialchars($exam['name']) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-5 mb-3">
                                            <label for="class-select" class="form-label">Sınıf</label>
                                            <select id="class-select" name="class_id">
                                                <option value="">Önce Sınav Seçiniz...</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 align-self-end">
                                            <button type="submit" class="btn btn-primary w-100">Öğrencileri Getir</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <form action="../islemler/sonuc-kaydet.php" method="POST">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Adım 2: Öğrenci Cevapları</h4>
                                    <p class="card-title-desc">Her öğrencinin cevaplarını ilgili alana giriniz.</p>
                                    <div id="results-table-container" class="table-responsive mt-3">
                                        <div class="alert alert-info text-center">Lütfen yukarıdan bir sınav ve sınıf seçin.</div>
                                    </div>
                                    <div id="save-button-container" class="d-flex justify-content-end mt-4" style="display: none!important;">
                                        <button type="submit" class="btn btn-success btn-lg"><i class="bx bx-save me-2"></i>Tüm Sonuçları Kaydet</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const examSelectEl = document.getElementById('exam-select');
            const classSelectEl = document.getElementById('class-select');
            const examSelect = new Choices(examSelectEl);
            const classSelect = new Choices(classSelectEl);
            const tableContainer = document.getElementById('results-table-container');
            const saveButtonContainer = document.getElementById('save-button-container');

            examSelectEl.addEventListener('change', function() {
                const examId = this.value;
                classSelect.clearStore();
                classSelect.clearInput();
                if (!examId) {
                    classSelect.setChoices([{ value: '', label: 'Önce Sınav Seçiniz...' }], 'value', 'label', true);
                    return;
                }

                $.ajax({
                    url: '../islemler/get-siniflar.php',
                    type: 'POST',
                    data: { exam_id: examId },
                    dataType: 'json',
                    success: function(data) {
                        if(data.length > 0) {
                            const choices = data.map(cls => ({ value: cls.id, label: cls.name }));
                            classSelect.setChoices([{ value: '', label: 'Sınıf Seçiniz...' }, ...choices], 'value', 'label', true);
                        } else {
                            classSelect.setChoices([{ value: '', label: 'Bu sınava sınıf atanmamış' }], 'value', 'label', true);
                        }
                    }
                });
            });

            document.getElementById('selection-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const examId = examSelect.getValue(true);
                const classId = classSelect.getValue(true);

                if (examId && classId) {
                    $(tableContainer).html('<p class="text-center my-3"><i class="bx bx-loader-alt bx-spin font-size-24"></i> Yükleniyor...</p>');
                    $.ajax({
                        url: '../islemler/get-sonuc-tablosu.php',
                        type: 'POST',
                        data: { exam_id: examId, class_id: classId },
                        success: function(response) {
                            $(tableContainer).html(response);
                            $(saveButtonContainer).css('display', 'flex'); // jQuery ile göster
                        },
                        error: function() {
                            $(tableContainer).html('<div class="alert alert-danger">Tablo yüklenirken bir hata oluştu. Lütfen tekrar deneyin.</div>');
                            $(saveButtonContainer).hide();
                        }
                    });
                }
            });

            // Anlık Puan Hesaplama ve Görsel Geri Bildirim
            $(document).on('input', '.answer-input, .answer-score', function() {
                const row = $(this).closest('.student-row');
                const questions = row.closest('table').data('questions');

                // Görsel Geri Bildirim (Çoktan seçmeli ve D/Y için)
                if ($(this).hasClass('answer-input')) {
                    const questionId = Object.keys(questions)[$(this).closest('td').index() - 1];
                    const correctAnswer = questions[questionId].correct_answer;
                    const enteredAnswer = $(this).val().toUpperCase();

                    $(this).removeClass('is-valid is-invalid');
                    if (enteredAnswer) {
                        if (enteredAnswer === correctAnswer) {
                            $(this).addClass('is-valid');
                        } else if (enteredAnswer !== 'E') { // E Boş demek, yanlış değil
                            $(this).addClass('is-invalid');
                        }
                    }
                }

                // Toplam Puanı Hesapla
                let totalScore = 0;
                row.find('.answer-cell').each(function(index) {
                    const questionId = Object.keys(questions)[index];
                    const questionInfo = questions[questionId];

                    if (questionInfo.type === 'open') {
                        const scoreInput = $(this).find('.answer-score');
                        totalScore += parseFloat(scoreInput.val()) || 0;
                    } else {
                        const answerInput = $(this).find('.answer-input');
                        if (answerInput.val().toUpperCase() === questionInfo.correct_answer) {
                            totalScore += parseFloat(questionInfo.points);
                        }
                    }
                });

                row.find('.total-score-cell').text(totalScore.toFixed(2));
            });
        });
    </script>

<?php
include '../partials/footer.php';
?>