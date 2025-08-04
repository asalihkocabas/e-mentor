<?php
include '../config/init.php';
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
                                <h4 class="card-title">Öğrenci Listesi (<?= count($students); ?> Öğrenci)</h4>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle table-nowrap">
                                        <thead class="table-light">
                                        <tr><th>Öğrenci No</th><th>Adı Soyadı</th><th>İşlemler</th></tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($students as $student): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($student['student_number']); ?></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <?= generate_avatar($student['full_name']); ?>
                                                        <a href="ogrenci-detay.php?student_id=<?= $student['user_id']; ?>" class="text-body fw-bold"><?= htmlspecialchars($student['full_name']); ?></a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="ogrenci-detay.php?student_id=<?= $student['user_id']; ?>" class="btn btn-primary btn-sm">Profilini Görüntüle</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
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