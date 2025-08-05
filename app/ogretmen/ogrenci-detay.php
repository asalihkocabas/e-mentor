<?php
// Gerekli dosyaları ve session'ı başlat
include '../config/init.php';

// Bu sayfanın bir öğretmen sayfası olduğunu belirtmek ve oturum kontrolü yapmak için
$_SESSION['user_role'] = 'teacher';

// URL'den gelen öğrenci ID'sini al
$student_id = isset($_GET['student_id']) ? intval($_GET['student_id']) : 0;
if ($student_id == 0) {
    header("Location: siniflarim.php"); // ID yoksa sınıflara yönlendir
    exit;
}

// --- VERİTABANI SORGULARI ---

// 1. Öğrenci profil bilgilerini ve sınıfını çek
$stmt_student = $pdo->prepare("
        SELECT sp.full_name, sp.student_number, sp.gpa, c.name AS class_name, c.id AS class_id
        FROM student_profiles sp
        LEFT JOIN classes c ON sp.class_id = c.id
        WHERE sp.user_id = ?
    ");
$stmt_student->execute([$student_id]);
$student = $stmt_student->fetch(PDO::FETCH_ASSOC);

// Eğer öğrenci bulunamazsa hata göster
if (!$student) {
    $page_title = "Hata | E-Mentor";
    include '../partials/header.php';
    include '../partials/sidebar.php';
    echo "<div class='main-content'><div class='page-content'><div class='alert alert-danger'>Öğrenci bulunamadı.</div></div></div>";
    include '../partials/footer.php';
    exit;
}

// 2. Veli bilgilerini çek
$stmt_parent = $pdo->prepare("
        SELECT pp.full_name, pp.phone_number, pp.contact_email
        FROM parent_profiles pp
        JOIN parent_student_relationships psr ON pp.user_id = psr.parent_user_id
        WHERE psr.student_user_id = ? LIMIT 1
    ");
$stmt_parent->execute([$student_id]);
$parent = $stmt_parent->fetch(PDO::FETCH_ASSOC);

// 3. Devamsızlık verilerini çek
$stmt_attendance = $pdo->prepare("SELECT `date`, `status` FROM attendance WHERE student_id = ? ORDER BY `date` DESC");
$stmt_attendance->execute([$student_id]);
$attendance_records = $stmt_attendance->fetchAll(PDO::FETCH_ASSOC);

// 4. Sınav geçmişini çek (Örnek)
$stmt_exams = $pdo->prepare("
        SELECT e.name, ses.score 
        FROM student_exam_scores ses
        JOIN exams e ON ses.exam_id = e.id
        WHERE ses.student_id = ?
        ORDER BY e.exam_date DESC
    ");
$stmt_exams->execute([$student_id]);
$exam_history = $stmt_exams->fetchAll(PDO::FETCH_ASSOC);

$page_title = htmlspecialchars($student['full_name']) . " | Öğrenci Profili";
include '../partials/header.php';
include '../partials/sidebar.php';
?>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Öğrenci Profili</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="siniflarim.php">Sınıflarım</a></li>
                                    <li class="breadcrumb-item"><a href="sinif-detay.php?class_id=<?= $student['class_id']; ?>">Sınıf Detayı</a></li>
                                    <li class="breadcrumb-item active"><?= htmlspecialchars($student['full_name']); ?></li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center">
                                    <?php $avatar = get_avatar_data($student['full_name']); ?>
                                    <div class="avatar-lg">
                                    <span class="avatar-title rounded-circle <?= $avatar['color_class'] ?> text-white font-size-24">
                                        <?= $avatar['initials'] ?>
                                    </span>
                                    </div>
                                    <div class="mt-3 text-center">
                                        <h4 class="mb-1"><?= htmlspecialchars($student['full_name']); ?></h4>
                                        <p class="text-muted">Öğrenci No: <?= htmlspecialchars($student['student_number']); ?></p>
                                        <p class="text-muted mb-0">Sınıf: <?= htmlspecialchars($student['class_name']); ?></p>
                                    </div>
                                </div>
                                <hr class="my-4">
                                <div class="text-muted">
                                    <h5 class="font-size-16">Veli İletişim Bilgileri</h5>
                                    <?php if ($parent): ?>
                                        <p class="mb-1"><strong>Adı:</strong> <?= htmlspecialchars($parent['full_name']); ?></p>
                                        <p class="mb-1"><i class="bx bx-phone me-2"></i><?= htmlspecialchars($parent['phone_number']); ?></p>
                                        <p class="mb-0"><i class="bx bx-envelope me-2"></i><?= htmlspecialchars($parent['contact_email']); ?></p>
                                    <?php else: ?>
                                        <p>Veli bilgisi bulunamadı.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#overview" role="tab">Genel Bakış</a></li>
                                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#exam-results" role="tab">Sınav Sonuçları</a></li>
                                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#attendance" role="tab">Devamsızlık Kayıtları</a></li>
                                </ul>

                                <div class="tab-content p-3">
                                    <div class="tab-pane active" id="overview" role="tabpanel">
                                        <h5 class="font-size-16 mb-4">Performans Özeti</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="mb-2">Genel Başarı Ortalaması: <span class="fw-bold text-success"><?= number_format($student['gpa'], 2); ?></span></p>
                                                <div class="progress mb-4" style="height: 10px;">
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: <?= $student['gpa']; ?>%;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="exam-results" role="tabpanel">
                                        <h5 class="font-size-16 mb-3">Sınav Geçmişi</h5>
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead class="table-light"><tr><th>Sınav Adı</th><th>Puan</th></tr></thead>
                                                <tbody>
                                                <?php foreach($exam_history as $exam): ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($exam['name']); ?></td>
                                                        <td><span class="fw-bold text-success"><?= number_format($exam['score'], 2); ?></span></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="attendance" role="tabpanel">
                                        <h5 class="font-size-16 mb-3">Devamsızlık Listesi (Toplam: <?= count($attendance_records); ?> gün)</h5>
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead class="table-light"><tr><th>Tarih</th><th>Durum</th></tr></thead>
                                                <tbody>
                                                <?php foreach($attendance_records as $record): ?>
                                                    <tr>
                                                        <td><?= date('d.m.Y', strtotime($record['date'])); ?></td>
                                                        <td><span class="badge bg-<?= ($record['status'] == 'izinsiz') ? 'danger' : 'success'; ?>-subtle text-<?= ($record['status'] == 'izinsiz') ? 'danger' : 'success'; ?>"><?= ucfirst($record['status']); ?></span></td>
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
        </div>
    </div>

<?php include '../partials/footer.php'; ?>