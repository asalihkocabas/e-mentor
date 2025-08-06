<?php
// Gerekli dosyaları ve session'ı başlat
include '../config/init.php';
$_SESSION['user_role'] = 'teacher';
$page_title = "Sınav Raporları | E-Mentor Öğretmen Paneli";

include '../partials/header.php';
include '../partials/sidebar.php';

$teacher_id = $_SESSION['user_id'] ?? 1;

// --- VERİTABANI SORGULARI ---
$stmt = $pdo->prepare("
        SELECT 
            e.id, e.name, e.exam_date,
            (SELECT COUNT(*) FROM student_exam_scores WHERE exam_id = e.id) as submission_count
        FROM exams e
        WHERE e.creator_id = ?
        ORDER BY e.exam_date DESC
    ");
$stmt->execute([$teacher_id]);
$exams = $stmt->fetchAll(PDO::FETCH_ASSOC);

$now = new DateTime(SIMULATED_NOW);
?>

    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../assets/libs/flatpickr/flatpickr.min.css">

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Sınav Raporları</h4>
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
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="card-title">Oluşturulan Sınavlar</h4>
                                    <a href="sinav-olustur.php" class="btn btn-primary"><i class="bx bx-plus me-1"></i> Yeni Sınav Oluştur</a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                        <tr><th>Sınav Adı</th><th>Sınav Tarihi</th><th>Durum</th><th class="text-center">İşlemler</th></tr>
                                        </thead>
                                        <tbody>
                                        <?php if (empty($exams)): ?>
                                            <tr><td colspan="4" class="text-center">Henüz oluşturulmuş bir sınav bulunmuyor.</td></tr>
                                        <?php else: ?>
                                            <?php foreach ($exams as $exam):
                                                $exam_date = $exam['exam_date'] ? new DateTime($exam['exam_date']) : null;
                                                $status = '';
                                                $status_class = '';

                                                if (!$exam_date) { $status = 'Tarih Belirsiz'; $status_class = 'bg-secondary-subtle text-secondary'; }
                                                elseif ($now < $exam_date) { $status = 'Tarihi Bekleniyor'; $status_class = 'bg-warning-subtle text-warning'; }
                                                elseif ($exam['submission_count'] > 0) { $status = 'Tamamlandı'; $status_class = 'bg-success-subtle text-success'; }
                                                else { $status = 'Not Girişi Bekleniyor'; $status_class = 'bg-info-subtle text-info'; }
                                                ?>
                                                <tr>
                                                    <td><p class="fw-bold mb-0"><?= htmlspecialchars($exam['name']) ?></p></td>
                                                    <td><?= $exam_date ? $exam_date->format('d.m.Y, H:i') : '-'; ?></td>
                                                    <td><span class="badge font-size-12 p-2 <?= $status_class ?>"><?= $status ?></span></td>
                                                    <td class="text-center">
                                                        <?php if ($status == 'Tamamlandı'): ?>
                                                            <a href="#" class="btn btn-primary btn-md" data-bs-toggle="tooltip" title="Raporu Gör"><i class="bx bx-bar-chart-alt-2"></i></a>
                                                            <button class="btn btn-secondary btn-md" disabled data-bs-toggle="tooltip" title="Analiz (Yakında)"><i class="bx bx-analyse"></i></button>
                                                        <?php elseif ($status == 'Not Girişi Bekleniyor'): ?>
                                                            <a href="sonuc-girisi.php?exam_id=<?= $exam['id'] ?>" class="btn btn-success btn-md" data-bs-toggle="tooltip" title="Sonuç Gir"><i class="bx bx-edit"></i> Sonuç Gir</a>
                                                        <?php else: ?>
                                                            <button class="btn btn-info btn-md change-date-btn" data-exam-id="<?= $exam['id'] ?>" data-bs-toggle="tooltip" title="Tarihi Değiştir"><i class="bx bx-calendar"></i></button>
                                                            <form action="../islemler/sinav-sil.php" method="POST" class="d-inline" onsubmit="return confirm('Bu sınavı silmek istediğinizden emin misiniz?');">
                                                                <input type="hidden" name="exam_id" value="<?= $exam['id'] ?>">
                                                                <button type="submit" class="btn btn-danger btn-md" data-bs-toggle="tooltip" title="Sınavı İptal Et"><i class="bx bx-trash"></i></button>
                                                            </form>
                                                        <?php endif; ?>
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

    <div class="modal fade" id="changeDateModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Sınav Tarihini Güncelle</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <form action="../islemler/tarih-guncelle.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="exam_id" id="modal-exam-id">
                        <label for="new-exam-date" class="form-label">Yeni Sınav Tarihi ve Saati</label>
                        <input type="text" class="form-control" name="new_exam_date" id="new-exam-date" placeholder="Yeni tarihi seçin...">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                        <button type="submit" class="btn btn-primary">Kaydet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../assets/libs/flatpickr/flatpickr.min.js"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/tr.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            flatpickr("#new-exam-date", { enableTime: true, dateFormat: "d-m-Y H:i", locale: 'tr' });
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) { return new bootstrap.Tooltip(tooltipTriggerEl); });

            var changeDateModal = new bootstrap.Modal(document.getElementById('changeDateModal'));
            $('.change-date-btn').on('click', function() {
                var examId = $(this).data('exam-id');
                $('#modal-exam-id').val(examId);
                changeDateModal.show();
            });
        });
    </script>

<?php
include '../partials/footer.php';
?>