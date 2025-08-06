<?php
// Gerekli dosyaları ve session'ı başlat
include '../config/init.php';
$_SESSION['user_role'] = 'teacher';
$page_title = "Ana Sayfa | E-Mentor Öğretmen Paneli";

include '../partials/header.php';
include '../partials/sidebar.php';

$teacher_id = $_SESSION['user_id'] ?? 1;
$school_id = 1; // Varsayılan okul ID'si

// --- VERİTABANI SORGULARI ---

// 1. Toplam Öğrenci Sayısı
$stmt_total_students = $pdo->prepare("SELECT COUNT(DISTINCT sp.user_id) FROM teacher_assignments ta JOIN student_profiles sp ON ta.class_id = sp.class_id WHERE ta.teacher_id = ?");
$stmt_total_students->execute([$teacher_id]);
$total_students = $stmt_total_students->fetchColumn() ?: 0;

// 2. Genel Başarı Oranı
$stmt_gpa_avg = $pdo->prepare("SELECT AVG(sp.gpa) FROM student_profiles sp WHERE sp.gpa > 0 AND sp.class_id IN (SELECT class_id FROM teacher_assignments WHERE teacher_id = ?)");
$stmt_gpa_avg->execute([$teacher_id]);
$overall_success_rate = $stmt_gpa_avg->fetchColumn() ?: 0;

// 3. En Başarılı 5 Öğrenci
$stmt_top_students = $pdo->prepare("SELECT sp.user_id, sp.full_name, c.name as class_name, c.id as class_id, sp.gpa FROM student_profiles sp JOIN classes c ON sp.class_id = c.id WHERE sp.class_id IN (SELECT class_id FROM teacher_assignments WHERE teacher_id = ?) ORDER BY sp.gpa DESC LIMIT 5");
$stmt_top_students->execute([$teacher_id]);
$top_students = $stmt_top_students->fetchAll(PDO::FETCH_ASSOC);

// 4. Desteğe İhtiyaç Duyan 5 Öğrenci
$stmt_needy_students = $pdo->prepare("SELECT sp.user_id, sp.full_name, c.name as class_name, c.id as class_id, sp.gpa FROM student_profiles sp JOIN classes c ON sp.class_id = c.id WHERE sp.gpa > 0 AND sp.class_id IN (SELECT class_id FROM teacher_assignments WHERE teacher_id = ?) ORDER BY sp.gpa ASC LIMIT 5");
$stmt_needy_students->execute([$teacher_id]);
$needy_students = $stmt_needy_students->fetchAll(PDO::FETCH_ASSOC);

// 5. Son Duyurular
$stmt_announcements = $pdo->prepare("SELECT * FROM announcements WHERE school_id = ? AND publish_date <= ? ORDER BY publish_date DESC LIMIT 5");
$stmt_announcements->execute([$school_id, SIMULATED_NOW]);
$announcements = $stmt_announcements->fetchAll(PDO::FETCH_ASSOC);
?>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Hoş Geldiniz, <?= htmlspecialchars($_SESSION['full_name'] ?? 'Öğretmen'); ?>!</h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-h-100">
                            <div class="card-body">
                                <span class="text-muted mb-3 lh-1 d-block">Toplam Öğrenci Sayınız</span>
                                <h2 class="mb-2"><span><?= $total_students; ?></span></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-h-100">
                            <div class="card-body">
                                <span class="text-muted mb-3 lh-1 d-block">Genel Başarı Oranı</span>
                                <h2 class="mb-2">%<span><?= number_format($overall_success_rate, 1); ?></span></h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header"><h4 class="card-title mb-0">En Başarılı Öğrencileriniz</h4></div>
                            <div class="card-body" data-simplebar style="max-height: 380px;">
                                <?php foreach($top_students as $student):
                                    $avatar = get_avatar_data($student['full_name']);
                                    ?>
                                    <div class="d-flex align-items-center pb-3">
                                        <div class="avatar-sm me-3">
                                            <span class="avatar-title rounded-circle <?= $avatar['color_class'] ?> text-white font-size-16"><?= $avatar['initials'] ?></span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h5 class="font-size-15 mb-1"><a href="ogrenci-detay.php?student_id=<?= $student['user_id']; ?>&class_id=<?= $student['class_id']; ?>" class="text-dark"><?= htmlspecialchars($student['full_name']); ?></a></h5>
                                            <span class="text-muted"><?= htmlspecialchars($student['class_name']); ?></span>
                                        </div>
                                        <div class="flex-shrink-0"><span class="badge rounded-pill bg-success-subtle text-success font-size-12 fw-medium"><?= number_format($student['gpa'], 1); ?></span></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header"><h4 class="card-title mb-0">Desteğe İhtiyaç Duyanlar</h4></div>
                            <div class="card-body" data-simplebar style="max-height: 380px;">
                                <?php foreach($needy_students as $student):
                                    $avatar = get_avatar_data($student['full_name']);
                                    ?>
                                    <div class="d-flex align-items-center pb-3">
                                        <div class="avatar-sm me-3">
                                            <span class="avatar-title rounded-circle <?= $avatar['color_class'] ?> text-white font-size-16"><?= $avatar['initials'] ?></span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h5 class="font-size-15 mb-1"><a href="ogrenci-detay.php?student_id=<?= $student['user_id']; ?>&class_id=<?= $student['class_id']; ?>" class="text-dark"><?= htmlspecialchars($student['full_name']); ?></a></h5>
                                            <span class="text-muted"><?= htmlspecialchars($student['class_name']); ?></span>
                                        </div>
                                        <div class="flex-shrink-0"><span class="badge rounded-pill bg-danger-subtle text-danger font-size-12 fw-medium"><?= number_format($student['gpa'], 1); ?></span></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header"><h4 class="card-title mb-0">Son Duyurular</h4></div>
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush" data-simplebar style="max-height: 800px;">
                                    <?php if(empty($announcements)): ?>
                                        <div class="p-3 text-center text-muted">Yayınlanmış bir duyuru bulunmuyor.</div>
                                    <?php else: ?>
                                        <?php foreach($announcements as $ann): ?>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                                            <span class="badge fs-6 bg-primary-subtle text-primary"><?= htmlspecialchars($ann['category']) ?></span>
                                                            <small class="text-muted"><?= (new DateTime($ann['publish_date']))->format('d.m.Y H:i') ?></small>
                                                        </div>
                                                        <h6 class="mb-1 text-dark"><?= htmlspecialchars($ann['title']) ?></h6>
                                                        <p class="text-muted mb-0 font-size-13 text-truncate"><?= htmlspecialchars(strip_tags($ann['content'])) ?></p>
                                                    </div>
                                                </div>
                                            </a>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent text-center">
                                <a href="duyuru-yonetimi.php" class="text-primary">Tüm Duyuruları Görüntüle</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

<?php
include '../partials/footer.php';
?>