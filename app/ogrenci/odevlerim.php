<?php
include '../config/init.php';
$_SESSION['user_role'] = 'student';
$page_title = "Ödevlerim | E-Mentor Öğrenci Paneli";

include '../partials/header.php';
include '../partials/sidebar.php';

$student_id = $_SESSION['user_id'] ?? 2;

// --- VERİTABANI SORGULARI ---
$stmt = $pdo->prepare("
        SELECT h.id, h.title, h.content, h.due_date, h.submission_date, h.status, h.grade, h.teacher_comment, c.name as course_name 
        FROM homework_assignments h
        JOIN learning_outcomes lo ON h.learning_outcome_id = lo.id
        JOIN courses c ON lo.course_id = c.id
        WHERE h.student_id = ? ORDER BY h.due_date DESC
    ");
$stmt->execute([$student_id]);
$all_assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Ödevleri durumlarına göre ayır
$yapilacaklar = array_filter($all_assignments, fn($a) => $a['status'] == 'assigned');
$teslim_edilenler = array_filter($all_assignments, fn($a) => $a['status'] == 'submitted');
$degerlendirilenler = array_filter($all_assignments, fn($a) => $a['status'] == 'graded');
?>

    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row"><div class="col-12"><div class="page-title-box d-sm-flex align-items-center justify-content-between"><h4 class="mb-sm-0 font-size-18">Ödevlerim</h4></div></div></div>

                <?php if (isset($_SESSION['form_message'])): ?>
                    <div class="alert alert-<?= $_SESSION['form_message_type']; ?> alert-dismissible fade show" role="alert">
                        <?= htmlspecialchars($_SESSION['form_message']); ?><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['form_message'], $_SESSION['form_message_type']); endif; ?>

                <div class="row g-3 mb-4">
                    <div class="col-md-4"><div class="card border-0 shadow-sm h-100"><div class="card-body d-flex align-items-center"><div class="avatar-lg bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-3"><i class="bx bx-task fs-2"></i></div><div><p class="mb-1 text-muted">Toplam Ödevim</p><h4 class="mb-0"><?= count($all_assignments) ?></h4></div></div></div></div>
                    <div class="col-md-4"><div class="card border-0 shadow-sm h-100"><div class="card-body d-flex align-items-center"><div class="avatar-lg bg-warning-subtle text-warning rounded-circle d-flex align-items-center justify-content-center me-3"><i class="bx bx-time-five fs-2"></i></div><div><p class="mb-1 text-muted">Yaklaşan Teslim</p><h4 class="mb-0"><?= count($yapilacaklar) ?></h4></div></div></div></div>
                    <div class="col-md-4"><div class="card border-0 shadow-sm h-100"><div class="card-body d-flex align-items-center"><div class="avatar-lg bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center me-3"><i class="bx bx-check-circle fs-2"></i></div><div><p class="mb-1 text-muted">Tamamladıklarım</p><h4 class="mb-0"><?= count($degerlendirilenler) ?></h4></div></div></div></div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card"><div class="card-body">
                                <ul class="nav nav-pills" role="tablist">
                                    <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-yapilacaklar">Yapılacaklar <span class="badge rounded-pill bg-warning ms-1"><?= count($yapilacaklar) ?></span></button></li>
                                    <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-teslim-edilenler">Teslim Ettiklerim <span class="badge rounded-pill bg-info ms-1"><?= count($teslim_edilenler) ?></span></button></li>
                                    <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-degerlendirilenler">Değerlendirilenler <span class="badge rounded-pill bg-success ms-1"><?= count($degerlendirilenler) ?></span></button></li>
                                </ul>
                            </div></div>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tab-yapilacaklar" role="tabpanel">
                                <div class="card"><div class="card-body"><div class="table-responsive">
                                            <table class="table align-middle table-nowrap mb-0">
                                                <thead class="table-light"><tr><th>Ödev Konusu</th><th>Ders</th><th>Son Teslim Tarihi</th><th class="text-center">İşlem</th></tr></thead>
                                                <tbody>
                                                <?php if(empty($yapilacaklar)): ?><tr><td colspan="4" class="text-center">Yapılacak ödeviniz bulunmuyor.</td></tr><?php else: ?>
                                                    <?php foreach($yapilacaklar as $hw): ?>
                                                        <tr>
                                                            <td><strong><?= htmlspecialchars($hw['title']) ?></strong></td>
                                                            <td><?= htmlspecialchars($hw['course_name']) ?></td>
                                                            <td><?= (new DateTime($hw['due_date']))->format('d.m.Y H:i') ?></td>
                                                            <td class="text-center"><button class="btn btn-sm btn-primary view-assignment-btn" data-id="<?= $hw['id'] ?>" data-content="<?= htmlspecialchars($hw['content']) ?>">Görüntüle ve Yap</button></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div></div></div>
                            </div>
                            <div class="tab-pane fade" id="tab-teslim-edilenler" role="tabpanel">
                                <div class="card"><div class="card-body"><div class="table-responsive">
                                            <table class="table align-middle table-nowrap mb-0">
                                                <thead class="table-light"><tr><th>Ödev Konusu</th><th>Ders</th><th>Teslim Tarihi</th><th>Durum</th></tr></thead>
                                                <tbody>
                                                <?php if(empty($teslim_edilenler)): ?><tr><td colspan="4" class="text-center">Teslim edilmiş ödeviniz bulunmuyor.</td></tr><?php else: ?>
                                                    <?php foreach($teslim_edilenler as $hw): ?>
                                                        <tr>
                                                            <td><strong><?= htmlspecialchars($hw['title']) ?></strong></td>
                                                            <td><?= htmlspecialchars($hw['course_name']) ?></td>
                                                            <td><?= (new DateTime($hw['submission_date']))->format('d.m.Y H:i') ?></td>
                                                            <td><span class="badge rounded-pill bg-info-subtle text-info">Değerlendirme Bekleniyor</span></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div></div></div>
                            </div>
                            <div class="tab-pane fade" id="tab-degerlendirilenler" role="tabpanel">
                                <div class="card"><div class="card-body"><div class="table-responsive">
                                            <table class="table align-middle table-nowrap mb-0">
                                                <thead class="table-light"><tr><th>Ödev Konusu</th><th>Ders</th><th>Sonuç</th><th>Öğretmen Yorumu</th></tr></thead>
                                                <tbody>
                                                <?php if(empty($degerlendirilenler)): ?><tr><td colspan="4" class="text-center">Değerlendirilen ödeviniz bulunmuyor.</td></tr><?php else: ?>
                                                    <?php foreach($degerlendirilenler as $hw): ?>
                                                        <tr>
                                                            <td><strong><?= htmlspecialchars($hw['title']) ?></strong></td>
                                                            <td><?= htmlspecialchars($hw['course_name']) ?></td>
                                                            <td><span class="badge bg-<?= $hw['grade'] == 'Başarılı' ? 'success' : 'danger' ?> font-size-13"><?= $hw['grade'] ?></span></td>
                                                            <td><span class="text-muted fst-italic">"<?= htmlspecialchars($hw['teacher_comment']) ?>"</span></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div></div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="odevModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Ödevi Görüntüle ve Teslim Et</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <form action="../islemler/odev-teslim-et.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="assignment_id" id="modal-assignment-id">
                        <h6>Öğretmenin Notu ve Sorular</h6>
                        <div id="modal-assignment-content" class="p-3 bg-light rounded border mb-4" style="white-space: pre-wrap; max-height: 200px; overflow-y: auto;"></div>
                        <h6>Cevabın</h6>
                        <textarea name="submission_text" class="form-control mb-3" rows="5" placeholder="Cevabını buraya yazabilirsin..."></textarea>
                        <label class="form-label">Veya dosya yükle:</label>
                        <input type="file" name="submission_file" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                        <button type="submit" class="btn btn-primary"><i class="bx bx-send me-1"></i> Ödevi Teslim Et</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const odevModal = new bootstrap.Modal(document.getElementById('odevModal'));
            $('.view-assignment-btn').on('click', function() {
                const assignmentId = $(this).data('id');
                const content = $(this).data('content');
                $('#modal-assignment-id').val(assignmentId);
                $('#modal-assignment-content').text(content);
                odevModal.show();
            });
        });
    </script>

<?php
include '../partials/footer.php';
?>