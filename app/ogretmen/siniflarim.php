<?php
// Gerekli dosyaları ve session'ı başlat
include '../config/init.php';

// Bu sayfanın bir öğretmen sayfası olduğunu belirtmek ve oturum kontrolü yapmak için
$_SESSION['user_role'] = 'teacher';
$page_title = "Sınıflarım | E-Mentor Öğretmen Paneli";

// Header'ı çağır (içinde oturum kontrolü var)
include '../partials/header.php';
include '../partials/sidebar.php';

// Giriş yapmış öğretmenin ID'sini al
$teacher_id = $_SESSION['user_id'];

// --- VERİTABANI SORGULARI ---

// Öğretmenin ders verdiği tüm sınıfları ve bu sınıfların detaylarını çekmek için kapsamlı bir sorgu
$stmt = $pdo->prepare("
        SELECT 
            c.id AS class_id, 
            c.name AS class_name, 
            c.grade_level,
            -- Bu sınıftaki öğrenci sayısını say
            (SELECT COUNT(*) FROM student_profiles WHERE class_id = c.id) AS student_count,
            -- Bu sınıftaki öğrencilerin GPA ortalamasını al
            (SELECT AVG(gpa) FROM student_profiles WHERE class_id = c.id) AS class_average,
            -- Bu öğretmen bu sınıfın rehber öğretmeni mi kontrol et
            (c.homeroom_teacher_id = ?) AS is_homeroom_teacher
        FROM classes c
        -- Öğretmenin ders ataması olan sınıfları seç
        WHERE c.id IN (SELECT DISTINCT class_id FROM teacher_assignments WHERE teacher_id = ?)
        ORDER BY c.grade_level, c.name
    ");
$stmt->execute([$teacher_id, $teacher_id]);
$classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Sınıflarım</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="index.php">Ana Sayfa</a></li>
                                    <li class="breadcrumb-item active">Sınıflarım</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <?php if (empty($classes)): ?>
                        <div class="col-12">
                            <div class="alert alert-info">Henüz sorumlu olduğunuz bir sınıf bulunmamaktadır.</div>
                        </div>
                    <?php else: ?>
                        <?php foreach ($classes as $class): ?>
                            <div class="col-md-6 col-xl-4">
                                <div class="card <?= $class['is_homeroom_teacher'] ? 'border border-success' : '' ?>">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="avatar-md flex-shrink-0">
                                                <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-2"><i class="bx bxs-school"></i></span>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <p class="text-muted fw-medium mb-1"><?= htmlspecialchars($class['grade_level']); ?>. Sınıf</p>
                                                <h4 class="mb-0"><?= htmlspecialchars($class['class_name']); ?></h4>
                                            </div>
                                            <?php if ($class['is_homeroom_teacher']): ?>
                                                <div class="flex-shrink-0">
                                                    <span class="badge  fs-6 bg-success">Rehber Sınıfınız</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="mt-4 pt-2 border-top">
                                            <div class="d-flex justify-content-between">
                                                <p class="mb-0"><i class="bx bx-user-pin me-2"></i>Öğrenci Sayısı: <span class="fw-bold"><?= $class['student_count']; ?></span></p>
                                                <p class="mb-0"><i class="bx bx-line-chart me-2"></i>Ortalama:
                                                    <span class="fw-bold <?= ($class['class_average'] >= 70) ? 'text-success' : 'text-danger'; ?>">
                                                    <?= number_format($class['class_average'], 2); ?>
                                                </span>
                                                </p>
                                            </div>
                                            <a href="sinif-detay.php?class_id=<?= $class['class_id']; ?>" class="btn btn-primary w-100 mt-3">Detayları Gör</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

<?php include '../partials/footer.php'; ?>