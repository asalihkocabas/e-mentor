<?php
// Gerekli dosyaları ve session'ı başlat
include '../config/init.php';

// Bu sayfanın bir öğretmen sayfası olduğunu belirtmek ve oturum kontrolü yapmak için
$_SESSION['user_role'] = 'teacher';
$page_title = "Ana Sayfa | E-Mentor Öğretmen Paneli";

// Header'ı çağır (içinde oturum kontrolü var)
include '../partials/header.php';
include '../partials/sidebar.php';

// Giriş yapmış öğretmenin ID'sini al
$teacher_id = $_SESSION['user_id'];

// --- VERİTABANI SORGULARI ---

// 1. Toplam Öğrenci Sayısı
$stmt_total_students = $pdo->prepare("
        SELECT COUNT(DISTINCT sp.user_id) FROM teacher_assignments ta
        JOIN student_profiles sp ON ta.class_id = sp.class_id
        WHERE ta.teacher_id = ?
    ");
$stmt_total_students->execute([$teacher_id]);
$total_students = $stmt_total_students->fetchColumn() ?: 0;

// 2. Genel Başarı Oranı (Tüm öğrencilerinin GPA ortalaması)
$stmt_gpa_avg = $pdo->prepare("
        SELECT AVG(sp.gpa) FROM student_profiles sp
        WHERE sp.class_id IN (SELECT class_id FROM teacher_assignments WHERE teacher_id = ?)
    ");
$stmt_gpa_avg->execute([$teacher_id]);
$overall_success_rate = $stmt_gpa_avg->fetchColumn() ?: 0;

// 3. Aktif Ödev Sayısı (Şimdilik statik, ödev tablosu dolunca dinamikleşecek)
$active_homeworks = 4;

// 4. Bugünkü Ders Saati
$simulated_date = new DateTime(SIMULATED_NOW);
$day_of_week = $simulated_date->format('N'); // 1: Pazartesi, ..., 7: Pazar
$stmt_lessons = $pdo->prepare("
        SELECT COUNT(ws.id) FROM weekly_schedules ws
        JOIN teacher_assignments ta ON ws.class_id = ta.class_id AND ws.course_id = ta.course_id
        WHERE ta.teacher_id = ? AND ws.day_of_week = ?
    ");
$stmt_lessons->execute([$teacher_id, $day_of_week]);
$today_lessons = $stmt_lessons->fetchColumn() ?: 0;

// 5. En Başarılı 5 Öğrenci (GPA'ye göre)
$stmt_top_students = $pdo->prepare("
        SELECT sp.full_name, c.name as class_name, sp.gpa FROM student_profiles AS sp
        JOIN classes AS c ON sp.class_id = c.id
        WHERE sp.class_id IN (SELECT class_id FROM teacher_assignments WHERE teacher_id = ?)
        ORDER BY sp.gpa DESC LIMIT 5
    ");
$stmt_top_students->execute([$teacher_id]);
$top_students = $stmt_top_students->fetchAll(PDO::FETCH_ASSOC);

// 6. Desteğe İhtiyaç Duyan 5 Öğrenci (GPA'ye göre)
$stmt_needy_students = $pdo->prepare("
        SELECT sp.full_name, c.name as class_name, sp.gpa FROM student_profiles AS sp
        JOIN classes AS c ON sp.class_id = c.id
        WHERE sp.class_id IN (SELECT class_id FROM teacher_assignments WHERE teacher_id = ?)
        ORDER BY sp.gpa ASC LIMIT 5
    ");
$stmt_needy_students->execute([$teacher_id]);
$needy_students = $stmt_needy_students->fetchAll(PDO::FETCH_ASSOC);
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
                    <div class="col-xl-3 col-md-6"><div class="card card-h-100"><div class="card-body"><span class="text-muted mb-3 lh-1 d-block">Toplam Öğrenci</span><h4 class="mb-3"><span><?= $total_students; ?></span></h4></div></div></div>
                    <div class="col-xl-3 col-md-6"><div class="card card-h-100"><div class="card-body"><span class="text-muted mb-3 lh-1 d-block">Genel Başarı Oranı</span><h4 class="mb-3">%<span><?= number_format($overall_success_rate, 1); ?></span></h4></div></div></div>
                    <div class="col-xl-3 col-md-6"><div class="card card-h-100"><div class="card-body"><span class="text-muted mb-3 lh-1 d-block">Aktif Ödev Sayısı</span><h4 class="mb-3"><span><?= $active_homeworks; ?></span></h4></div></div></div>
                    <div class="col-xl-3 col-md-6"><div class="card card-h-100"><div class="card-body"><span class="text-muted mb-3 lh-1 d-block">Bugünkü Ders Saati</span><h4 class="mb-3"><span><?= $today_lessons; ?></span></h4></div></div></div>
                </div>

                <div class="row">
                    <div class="col-xl-5">
                        <div class="card">
                            <div class="card-header"><h4 class="card-title mb-0">En Başarılı Öğrenciler</h4></div>
                            <div class="card-body px-0" data-simplebar style="max-height: 300px;">
                                <div class="px-3">
                                    <?php foreach($top_students as $student): ?>
                                        <div class="d-flex align-items-center pb-4">
                                            <div class="avatar-md me-4"><img src="../assets/images/users/avatar-2.jpg" class="img-fluid rounded-circle"></div>
                                            <div class="flex-grow-1">
                                                <h5 class="font-size-15 mb-1"><a href="#" class="text-dark"><?= htmlspecialchars($student['full_name']); ?></a></h5>
                                                <span class="text-muted"><?= htmlspecialchars($student['class_name']); ?></span>
                                            </div>
                                            <div class="flex-shrink-0"><span class="badge rounded-pill bg-success-subtle text-success font-size-12 fw-medium"><?= number_format($student['gpa'], 1); ?></span></div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header"><h4 class="card-title mb-0">Desteğe İhtiyaç Duyanlar</h4></div>
                            <div class="card-body px-0" data-simplebar style="max-height: 300px;">
                                <div class="px-3">
                                    <?php foreach($needy_students as $student): ?>
                                        <div class="d-flex align-items-center pb-4">
                                            <div class="avatar-md me-4"><img src="../assets/images/users/avatar-3.jpg" class="img-fluid rounded-circle"></div>
                                            <div class="flex-grow-1">
                                                <h5 class="font-size-15 mb-1"><a href="#" class="text-dark"><?= htmlspecialchars($student['full_name']); ?></a></h5>
                                                <span class="text-muted"><?= htmlspecialchars($student['class_name']); ?></span>
                                            </div>
                                            <div class="flex-shrink-0"><span class="badge rounded-pill bg-danger-subtle text-danger font-size-12 fw-medium"><?= number_format($student['gpa'], 1); ?></span></div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-7">
                        <div class="card">
                            <div class="card-header"><h4 class="card-title mb-0">Yaklaşan Etkinlikler</h4></div>
                            <div class="card-body" data-simplebar style="max-height: 245px;">
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header"><h4 class="card-title mb-0">Son Duyurular</h4></div>
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush" data-simplebar style="max-height: 290px;">
                                </div>
                            </div>
                            <div class="card-footer bg-transparent text-center">
                                <a href="#" class="text-primary">Tüm Duyuruları Görüntüle</a>
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