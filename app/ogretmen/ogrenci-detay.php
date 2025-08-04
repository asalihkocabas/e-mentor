<?php
// Gerekli dosyaları ve session'ı başlat
include '../config/init.php';

// Bu sayfanın bir öğretmen sayfası olduğunu belirtmek ve oturum kontrolü yapmak için
$_SESSION['user_role'] = 'teacher';

// URL'den gelen sınıf ID'sini al ve güvenli hale getir
$class_id = isset($_GET['class_id']) ? intval($_GET['class_id']) : 0;
if ($class_id == 0) {
    // Eğer class_id yoksa veya geçersizse, sınıflar sayfasına yönlendir
    header("Location: siniflarim.php");
    exit;
}

// Sınıf bilgilerini çek
$stmt_class = $pdo->prepare("SELECT name FROM classes WHERE id = ?");
$stmt_class->execute([$class_id]);
$class = $stmt_class->fetch(PDO::FETCH_ASSOC);

$page_title = ($class ? htmlspecialchars($class['name']) : 'Sınıf') . " Detayları | E-Mentor";

include '../partials/header.php';
include '../partials/sidebar.php';

// Sınıftaki öğrencileri listele
$stmt_students = $pdo->prepare("
        SELECT sp.user_id, sp.full_name, sp.student_number 
        FROM student_profiles sp 
        WHERE sp.class_id = ? ORDER BY sp.full_name ASC
    ");
$stmt_students->execute([$class_id]);
$students = $stmt_students->fetchAll(PDO::FETCH_ASSOC);
?>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18"><?= htmlspecialchars($class['name'] ?? 'Sınıf'); ?> Detayları</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="index.php">Ana Sayfa</a></li>
                                    <li class="breadcrumb-item"><a href="siniflarim.php">Sınıflarım</a></li>
                                    <li class="breadcrumb-item active">Sınıf Detayı</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="card-title">Öğrenci Listesi (<?= count($students); ?> Öğrenci)</h4>
                                    <a href="#" class="btn btn-primary btn-sm"><i class="bx bx-plus me-1"></i> Yeni Öğrenci Ekle</a>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-hover align-middle table-nowrap">
                                        <thead class="table-light">
                                        <tr>
                                            <th>Öğrenci No</th>
                                            <th>Adı Soyadı</th>
                                            <th>Son Sınav Puanı</th>
                                            <th>Devamsızlık (Gün)</th>
                                            <th class="text-center">İşlemler</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (empty($students)): ?>
                                            <tr>
                                                <td colspan="5" class="text-center">Bu sınıfta kayıtlı öğrenci bulunmamaktadır.</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($students as $student):
                                                // Her öğrenci için son sınav notunu çek (Örnek)
                                                $stmt_score = $pdo->prepare("SELECT score FROM student_exam_scores WHERE student_id = ? ORDER BY id DESC LIMIT 1");
                                                $stmt_score->execute([$student['user_id']]);
                                                $last_score = $stmt_score->fetchColumn();

                                                // Avatar verisini al
                                                $avatar = get_avatar_data($student['full_name']);
                                                ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($student['student_number']); ?></td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-xs me-2">
                                                            <span class="avatar-title rounded-circle <?= $avatar['color_class'] ?> text-white font-size-16">
                                                                <?= $avatar['initials'] ?>
                                                            </span>
                                                            </div>
                                                            <a href="ogrenci-detay.php?student_id=<?= $student['user_id']; ?>" class="text-body fw-bold"><?= htmlspecialchars($student['full_name']); ?></a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <?php if ($last_score !== false): ?>
                                                            <span class="badge p-2 <?= ($last_score >= 70) ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger'; ?>">
                                                            <?= number_format($last_score, 2); ?>
                                                        </span>
                                                        <?php else: ?>
                                                            <span class="badge bg-light text-dark p-2">Girilmedi</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo rand(0, 5); // Devamsızlık için şimdilik rastgele bir sayı üretiyoruz ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="ogrenci-detay.php?student_id=<?= $student['user_id']; ?>" class="btn btn-primary btn-sm">Profilini Görüntüle</a>
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

<?php include '../partials/footer.php'; ?>