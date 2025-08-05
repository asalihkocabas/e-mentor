<?php
include '../config/init.php';
$_SESSION['user_role'] = 'teacher';
$page_title = "Duyuru Yönetimi | E-Mentor Öğretmen Paneli";

include '../partials/header.php';
include '../partials/sidebar.php';

$teacher_id = $_SESSION['user_id'] ?? 1;

// Öğretmenin oluşturduğu tüm duyuruları çek
$stmt = $pdo->prepare("SELECT * FROM announcements WHERE creator_id = ? ORDER BY publish_date DESC");
$stmt->execute([$teacher_id]);
$announcements = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Simüle edilen şu anki zaman
$now = new DateTime(SIMULATED_NOW);
?>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Duyuru Yönetimi</h4>
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
                                    <h4 class="card-title">Oluşturulan Duyurular</h4>
                                    <a href="duyuru-ekle.php" class="btn btn-primary"><i class="bx bx-plus me-1"></i> Yeni Duyuru Ekle</a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                        <tr><th>Başlık</th><th>Kategori</th><th>Yayın Tarihi</th><th>Durum</th><th class="text-center">İşlemler</th></tr>
                                        </thead>
                                        <tbody>
                                        <?php if(empty($announcements)): ?>
                                            <tr><td colspan="5" class="text-center">Henüz oluşturulmuş bir duyuru yok.</td></tr>
                                        <?php else: ?>
                                            <?php foreach ($announcements as $ann):
                                                $publish_date = new DateTime($ann['publish_date']);
                                                $end_date = $ann['end_date'] ? new DateTime($ann['end_date']) : null;
                                                $status = '';
                                                $status_class = '';

                                                if ($now < $publish_date) {
                                                    $status = 'Zamanlanmış';
                                                    $status_class = 'bg-info-subtle text-info';
                                                } elseif ($end_date && $now > $end_date) {
                                                    $status = 'Arşivlendi';
                                                    $status_class = 'bg-secondary-subtle text-secondary';
                                                } else {
                                                    $status = 'Yayında';
                                                    $status_class = 'bg-success-subtle text-success';
                                                }
                                                ?>
                                                <tr>
                                                    <td><strong><?= htmlspecialchars($ann['title']) ?></strong></td>
                                                    <td><span class="badge bg-primary-subtle text-primary"><?= htmlspecialchars($ann['category']) ?></span></td>
                                                    <td><?= $publish_date->format('d.m.Y H:i') ?></td>
                                                    <td><span class="badge p-2 <?= $status_class ?>"><?= $status ?></span></td>
                                                    <td class="text-center">
                                                        <form action="../islemler/duyuru-sil.php" method="POST" class="d-inline" onsubmit="return confirm('Bu duyuruyu kalıcı olarak silmek istediğinizden emin misiniz?');">
                                                            <input type="hidden" name="announcement_id" value="<?= $ann['id'] ?>">
                                                            <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Sil"><i class="bx bx-trash"></i></button>
                                                        </form>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Bootstrap Tooltip'leri etkinleştir
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>

<?php
include '../partials/footer.php';
?>