<?php
// Gerekli dosyaları ve session'ı başlat
include '../config/init.php';
$_SESSION['user_role'] = 'teacher';
$page_title = "İçerik Kütüphanesi | E-Mentor Öğretmen Paneli";

include '../partials/header.php';
include '../partials/sidebar.php';

$teacher_id = $_SESSION['user_id'] ?? 1;

// --- VERİTABANI SORGULARI ---

// DÜZELTME 1: ID'leri isme dönüştürmek için ders ve sınıf listelerini alıyoruz
$stmt_courses = $pdo->query("SELECT id, name FROM courses");
$courses = $stmt_courses->fetchAll(PDO::FETCH_KEY_PAIR); // id => name formatında
$stmt_classes = $pdo->query("SELECT id, name FROM classes");
$classes = $stmt_classes->fetchAll(PDO::FETCH_KEY_PAIR); // id => name formatında

// Kütüphanedeki içerikleri çek
$stmt_content = $pdo->prepare("SELECT * FROM library_content WHERE uploader_id = ? ORDER BY upload_date DESC");
$stmt_content->execute([$teacher_id]);
$library_contents = $stmt_content->fetchAll(PDO::FETCH_ASSOC);
?>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12"><div class="page-title-box d-sm-flex align-items-center justify-content-between"><h4 class="mb-sm-0 font-size-18">İçerik Kütüphanesi</h4></div></div>
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
                                    <h4 class="card-title">Yüklenen İçerikler</h4>
                                    <a href="dosya-yukle.php" class="btn btn-primary"><i class="bx bx-plus me-1"></i> Yeni İçerik Yükle</a>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                        <tr><th>Dosya Adı</th><th>Tür</th><th>Detaylar</th><th>Yüklenme Tarihi</th><th class="text-center">İşlemler</th></tr>
                                        </thead>
                                        <tbody>
                                        <?php if (empty($library_contents)): ?>
                                            <tr><td colspan="5" class="text-center">Kütüphanede hiç içerik bulunmuyor.</td></tr>
                                        <?php else: ?>
                                            <?php foreach ($library_contents as $content):
                                                $metadata = json_decode($content['metadata'], true);
                                                ?>
                                                <tr>
                                                    <td><i class="bx bxs-file-pdf text-danger me-2"></i><strong><?= htmlspecialchars($content['file_name']) ?></strong></td>
                                                    <td><span class="badge bg-primary-subtle text-primary"><?= htmlspecialchars($content['file_type']) ?></span></td>
                                                    <td>
                                                        <?php
                                                        // DÜZELTME 2: Metaveriyi anlamlı isimlerle gösteriyoruz
                                                        if(is_array($metadata)) {
                                                            if(isset($metadata['course_id'])) echo "<span class='badge bg-light me-1'>Ders: " . htmlspecialchars($courses[$metadata['course_id']] ?? 'Bilinmiyor') . "</span>";
                                                            if(isset($metadata['class_id'])) echo "<span class='badge bg-light me-1'>Sınıf: " . htmlspecialchars($classes[$metadata['class_id']] ?? 'Bilinmiyor') . "</span>";
                                                            if(isset($metadata['exam_type'])) echo "<span class='badge bg-light me-1'>Sınav: " . htmlspecialchars($metadata['exam_type']) . "</span>";
                                                            if(isset($metadata['year'])) echo "<span class='badge bg-light me-1'>Yıl: " . htmlspecialchars($metadata['year']) . "</span>";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?= (new DateTime($content['upload_date']))->format('d.m.Y H:i') ?></td>
                                                    <td class="text-center">
                                                        <a href="<?= htmlspecialchars($content['file_path']) ?>" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="İndir" download><i class="bx bx-download"></i></a>
                                                        <form action="../islemler/icerik-sil.php" method="POST" class="d-inline" onsubmit="return confirm('Bu içeriği kalıcı olarak silmek istediğinizden emin misiniz?');">
                                                            <input type="hidden" name="content_id" value="<?= $content['id'] ?>">
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
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) { return new bootstrap.Tooltip(tooltipTriggerEl); });
        });
    </script>

<?php
include '../partials/footer.php';
?>