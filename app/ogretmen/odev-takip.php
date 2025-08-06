<?php
// Gerekli dosyaları ve session'ı başlat
include '../config/init.php';
$_SESSION['user_role'] = 'teacher';
$page_title = "Ödev Takip Ekranı | E-Mentor Öğretmen Paneli";

include '../partials/header.php';
include '../partials/sidebar.php';

$teacher_id = $_SESSION['user_id'] ?? 1;

// Sorguyu, modal için gerekli tüm bilgileri (ödev içeriği, öğrenci teslimleri) alacak şekilde güncelle
$stmt = $pdo->prepare("
        SELECT 
            h.id, h.title, h.due_date, h.status, h.content, 
            h.student_submission_text, h.student_submission_file_path,
            sp.full_name, c.name as class_name
        FROM homework_assignments h
        JOIN student_profiles sp ON h.student_id = sp.user_id
        JOIN classes c ON sp.class_id = c.id
        WHERE h.teacher_id = ? ORDER BY h.due_date DESC
    ");
$stmt->execute([$teacher_id]);
$assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row"><div class="col-12"><div class="page-title-box d-sm-flex align-items-center justify-content-between"><h4 class="mb-sm-0 font-size-18">Atanan Ödevleri Takip Et</h4></div></div></div>

            <?php if (isset($_SESSION['form_message'])): ?>
                <div class="alert alert-<?= $_SESSION['form_message_type']; ?> alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($_SESSION['form_message']); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php unset($_SESSION['form_message'], $_SESSION['form_message_type']); endif; ?>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Atanan Ödevler</h4>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                    <tr><th>Öğrenci</th><th>Ödev Konusu</th><th>Son Teslim Tarihi</th><th>Durum</th><th class="text-center">İşlemler</th></tr>
                                    </thead>
                                    <tbody>
                                    <?php if(empty($assignments)): ?>
                                        <tr><td colspan="5" class="text-center">Henüz atanmış bir ödev bulunmuyor.</td></tr>
                                    <?php else: ?>
                                        <?php foreach ($assignments as $hw):
                                            $avatar = get_avatar_data($hw['full_name']);
                                            ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm me-2">
                                                            <span class="avatar-title rounded-circle <?= $avatar['color_class'] ?> text-white font-size-16">
                                                                <?= $avatar['initials'] ?>
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span class="fw-bold d-block"><?= htmlspecialchars($hw['full_name']) ?></span>
                                                            <small class="text-muted"><?= htmlspecialchars($hw['class_name']) ?></small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><?= htmlspecialchars($hw['title']) ?></td>
                                                <td><?= (new DateTime($hw['due_date']))->format('d.m.Y H:i') ?></td>
                                                <td>
                                                    <?php
                                                    $status_badge = '';
                                                    if ($hw['status'] == 'assigned') $status_badge = '<span class="badge bg-warning-subtle text-warning">Teslim Bekleniyor</span>';
                                                    elseif ($hw['status'] == 'submitted') $status_badge = '<span class="badge bg-info-subtle text-info">Teslim Edildi</span>';
                                                    else $status_badge = '<span class="badge bg-success-subtle text-success">Değerlendirildi</span>';
                                                    echo $status_badge;
                                                    ?>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-primary grade-btn"
                                                            data-id="<?= $hw['id'] ?>"
                                                            data-student-name="<?= htmlspecialchars($hw['full_name']) ?>"
                                                            data-submission-text="<?= htmlspecialchars($hw['student_submission_text'] ?? 'Metin gönderilmedi.') ?>"
                                                            data-submission-file="<?= htmlspecialchars($hw['student_submission_file_path'] ?? '') ?>"
                                                        <?= ($hw['status'] == 'assigned') ? 'disabled' : '' ?>>
                                                        Değerlendir
                                                    </button>
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

<div class="modal fade" id="gradeModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ödev Değerlendirme: <span id="modal-student-name" class="text-primary"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="../islemler/odev-degerlendir.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="assignment_id" id="modal-assignment-id">
                    <h6>Öğrencinin Teslimi</h6>
                    <div class="p-3 bg-light rounded border mb-4">
                        <strong>Metin Cevabı:</strong>
                        <p id="modal-submission-text" class="text-muted" style="white-space: pre-wrap;"></p>
                        <strong>Dosya:</strong>
                        <div id="modal-submission-file"></div>
                    </div>
                    <hr>
                    <h6>Değerlendirme</h6>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Sonuç</label>
                            <div class="d-flex flex-wrap gap-3">
                                <div class="form-check"><input class="form-check-input" type="radio" name="grade_status" id="grade-success" value="Başarılı" checked><label class="form-check-label" for="grade-success">Başarılı / Tamamlandı</label></div>
                                <div class="form-check"><input class="form-check-input" type="radio" name="grade_status" id="grade-fail" value="Tekrar Gerekli"><label class="form-check-label" for="grade-fail">Tekrar Gerekli</label></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="teacher-comment" class="form-label">Öğretmen Yorumu</label>
                            <textarea class="form-control" name="teacher_comment" rows="3" placeholder="Öğrenciye geri bildirim ve yorumlarınızı yazın..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary"><i class="bx bx-check-double me-1"></i> Değerlendirmeyi Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../partials/footer.php'; ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const gradeModal = new bootstrap.Modal(document.getElementById('gradeModal'));

        // Olay dinleyicisini dinamik olarak eklenen elemanlar için de çalışacak şekilde `.on()` ile tanımlıyoruz.
        $(document).on('click', '.grade-btn', function() {
            if($(this).is(':disabled')) return;

            $('#modal-assignment-id').val($(this).data('id'));
            $('#modal-student-name').text($(this).data('student-name'));
            $('#modal-submission-text').text($(this).data('submission-text'));

            const filePath = $(this).data('submission-file');
            if (filePath) {
                const fileName = filePath.split('/').pop();
                $('#modal-submission-file').html(`<a href="${filePath}" target="_blank">${fileName} <i class="bx bx-link-external"></i></a>`);
            } else {
                $('#modal-submission-file').text('Dosya gönderilmedi.');
            }
            gradeModal.show();
        });
    });
</script>