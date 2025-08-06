<?php
// Gerekli dosyaları ve session'ı başlat
include '../config/init.php';
$_SESSION['user_role'] = 'student'; // Bu sayfanın rolünü öğrenci olarak ayarla
$page_title = "Ana Sayfa | E-Mentor Öğrenci Paneli";

// Header'ı çağır (içinde oturum ve yetki kontrolü var)
include '../partials/header.php';
include '../partials/sidebar.php';

// Giriş yapmış öğrencinin ID'sini session'dan al
$student_id = $_SESSION['user_id'] ?? 2; // Test için varsayılan öğrenci ID'si 2 (Kaan Buğra Taş)

// --- VERİTABANI SORGULARI ---

// 1. Öğrenci Profil Bilgilerini Çek
$stmt_student = $pdo->prepare("
        SELECT sp.full_name, sp.student_number, sp.gpa, c.name AS class_name, c.id AS class_id, tp.full_name AS teacher_name
        FROM student_profiles sp
        LEFT JOIN classes c ON sp.class_id = c.id
        LEFT JOIN teacher_profiles tp ON c.homeroom_teacher_id = tp.user_id
        WHERE sp.user_id = ?
    ");
$stmt_student->execute([$student_id]);
$student = $stmt_student->fetch(PDO::FETCH_ASSOC);

// 2. Devamsızlık Sayısını Çek
$stmt_attendance = $pdo->prepare("SELECT COUNT(*) FROM attendance WHERE student_id = ? AND status = 'izinsiz'");
$stmt_attendance->execute([$student_id]);
$attendance_count = $stmt_attendance->fetchColumn() ?: 0;

// 3. Sınıf Ortalamasını Çek
$class_avg_gpa = 0;
if ($student && $student['class_id']) {
    $stmt_class_avg = $pdo->prepare("SELECT AVG(gpa) FROM student_profiles WHERE class_id = ? AND gpa > 0");
    $stmt_class_avg->execute([$student['class_id']]);
    $class_avg_gpa = $stmt_class_avg->fetchColumn() ?: 0;
}

// 4. Duyuruları Çek (Öğrencinin sınıfına veya herkese gönderilenler)
$stmt_announcements = $pdo->prepare("
        SELECT a.* FROM announcements a
        LEFT JOIN announcement_targets at ON a.id = at.announcement_id
        WHERE a.publish_date <= ? AND (at.class_id = ? OR at.class_id IS NULL)
        ORDER BY a.publish_date DESC
        LIMIT 5
    ");
$stmt_announcements->execute([SIMULATED_NOW, $student['class_id'] ?? 0]);
$announcements = $stmt_announcements->fetchAll(PDO::FETCH_ASSOC);

?>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Hoş Geldin, <?= htmlspecialchars($student['full_name'] ?? 'Öğrenci'); ?>!</h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-4">
                        <div class="card mb-4">
                            <div class="card-body text-center">
                                <?php $avatar = get_avatar_data($student['full_name']); ?>
                                <div class="avatar-lg mx-auto mb-3">
                                <span class="avatar-title rounded-circle <?= $avatar['color_class'] ?> text-white font-size-24">
                                    <?= $avatar['initials'] ?>
                                </span>
                                </div>
                                <h5 class="mb-1"><?= htmlspecialchars($student['full_name']); ?></h5>
                                <p class="text-muted"><?= htmlspecialchars($student['class_name']); ?></p>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between"><span>Numara:</span> <strong><?= htmlspecialchars($student['student_number']); ?></strong></li>
                                <li class="list-group-item d-flex justify-content-between"><span>Rehber Öğretmen:</span> <strong><?= htmlspecialchars($student['teacher_name']); ?></strong></li>
                            </ul>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#tab1" role="tab">Devamsızlık</a></li>
                                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab2" role="tab">Ortalama</a></li>
                                </ul>
                                <div class="tab-content mt-3">
                                    <div class="tab-pane active" id="tab1" role="tabpanel"><div class="row g-3"><div class="col-6"><div class="p-3 border rounded text-center">Özürsüz<br><span class="badge rounded-pill bg-danger font-size-15 mt-1"><?= $attendance_count; ?> gün</span></div></div><div class="col-6"><div class="p-3 border rounded text-center">Kalan Hak<br><span class="badge rounded-pill bg-success font-size-15 mt-1"><?= 20 - $attendance_count; ?> gün</span></div></div></div></div>
                                    <div class="tab-pane" id="tab2" role="tabpanel"><div class="row g-3"><div class="col-6"><div class="p-3 border rounded text-center">Benim Ort.<br><span class="badge rounded-pill bg-success font-size-15 mt-1"><?= number_format($student['gpa'], 2); ?></span></div></div><div class="col-6"><div class="p-3 border rounded text-center">Sınıf Ort.<br><span class="badge rounded-pill bg-info font-size-15 mt-1"><?= number_format($class_avg_gpa, 2); ?></span></div></div></div></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-header"><h4 class="card-title mb-0">Son Duyurular</h4></div>
                            <div class="card-body pt-2" data-simplebar style="max-height: 540px;">
                                <ul class="list-group list-group-flush">
                                    <?php if(empty($announcements)): ?>
                                        <li class="list-group-item border-0"><div class="p-3 text-center text-muted">Yayınlanmış bir duyuru bulunmuyor.</div></li>
                                    <?php else: ?>
                                        <?php foreach($announcements as $ann):
                                            $icon = 'bx-megaphone';
                                            $color = 'primary';
                                            if ($ann['category'] == 'Sınav') { $icon = 'bx-calendar-event'; $color = 'danger'; }
                                            elseif ($ann['category'] == 'İdari') { $icon = 'bx-buildings'; $color = 'warning'; }
                                            elseif ($ann['category'] == 'Ödev') { $icon = 'bx-pencil'; $color = 'info'; }
                                            ?>
                                            <li class="list-group-item border-0">
                                                <a href="#" class="text-body d-flex align-items-start">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar-sm">
                                                        <span class="avatar-title rounded-circle bg-<?= $color ?>-subtle text-<?= $color ?>">
                                                            <i class="bx <?= $icon ?>"></i>
                                                        </span>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h6 class="mb-1 text-dark"><?= htmlspecialchars($ann['title']) ?></h6>
                                                            <small class="text-muted"><?= (new DateTime($ann['publish_date']))->format('d.m.Y') ?></small>
                                                        </div>
                                                        <p class="text-muted mb-0 font-size-13 text-truncate-2"><?= htmlspecialchars(strip_tags($ann['content'])) ?></p>
                                                    </div>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>
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