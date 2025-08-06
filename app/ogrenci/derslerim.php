<?php
// Gerekli dosyaları ve session'ı başlat
include '../config/init.php';
$_SESSION['user_role'] = 'student';
$page_title = "Derslerim | E-Mentor Öğrenci Paneli";

include '../partials/header.php';
include '../partials/sidebar.php';

$student_id = $_SESSION['user_id'] ?? 2;
$simulated_date = date('Y-m-d', strtotime(SIMULATED_NOW));

// --- VERİTABANI SORGUSU (GÜNCELLENDİ) ---
$stmt = $pdo->prepare("
        SELECT 
            c.id as course_id,
            c.name as course_name,
            tp.full_name as teacher_name,
            -- O anki tarihe denk gelen kazanımın açıklamasını al
            (SELECT lo.description FROM learning_outcomes lo WHERE lo.course_id = c.id AND ? BETWEEN lo.start_date AND lo.end_date LIMIT 1) as weekly_topic,
            -- Öğrencinin o dersteki not ortalamasını anlık olarak hesapla
            (SELECT AVG(ses.score) FROM student_exam_scores ses JOIN exams e ON ses.exam_id = e.id WHERE ses.student_id = sp.user_id AND e.course_id = c.id) as average_score
        FROM student_profiles sp
        JOIN teacher_assignments ta ON sp.class_id = ta.class_id
        JOIN courses c ON ta.course_id = c.id
        JOIN teacher_profiles tp ON ta.teacher_id = tp.user_id
        WHERE sp.user_id = ?
        ORDER BY c.name
    ");
$stmt->execute([$simulated_date, $student_id]);
$dersler = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Derslere özel standart renkleri ve ikonları tanımlayan bir dizi
$ders_stilleri = [
    'Matematik' => ['color' => '#556ee6', 'icon' => 'bx-math'],
    'Fen Bilimleri' => ['color' => '#34c38f', 'icon' => 'bx-vial'],
    'Türkçe' => ['color' => '#f1b44c', 'icon' => 'bx-edit-alt'],
    'Sosyal Bilgiler' => ['color' => '#50a5f1', 'icon' => 'bx-globe'],
    'default' => ['color' => '#6c757d', 'icon' => 'bx-book']
];
?>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Derslerim</h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <?php if(empty($dersler)): ?>
                        <div class="col-12">
                            <div class="alert alert-info">Henüz size atanmış bir ders bulunmamaktadır.</div>
                        </div>
                    <?php else: ?>
                        <?php foreach($dersler as $ders):
                            // Dersin stilini belirle, eğer listede yoksa varsayılanı kullan
                            $style = $ders_stilleri[$ders['course_name']] ?? $ders_stilleri['default'];
                            ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="card border-0 shadow-sm position-relative">
                                    <span class="position-absolute top-0 start-0 w-100" style="height:4px; background-color: <?= $style['color'] ?>;"></span>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h4 class="fw-bold mb-1"><a href="ders-detay.php?course_id=<?= $ders['course_id'] ?>" class="text-dark text-decoration-none stretched-link"><?= htmlspecialchars($ders['course_name']) ?></a></h4>
                                                <small class="text-muted fs-6"><strong>Öğrt. <?= htmlspecialchars($ders['teacher_name']) ?></strong></small>
                                            </div>
                                            <div class="avatar-xs">
                                        <span class="avatar-title rounded bg-light text-secondary">
                                            <i class="bx <?= $style['icon'] ?> font-size-20"></i>
                                        </span>
                                            </div>
                                        </div>
                                        <div class="mt-4 small">
                                            <div class="text-muted fs-6">Bu Haftanın Konusu: <strong><?= htmlspecialchars($ders['weekly_topic'] ?? 'Belirlenmedi') ?></strong></div>
                                            <div class="mt-3 fs-6">Ders Ortalaman:
                                                <strong class="<?= ($ders['average_score'] >= 70) ? 'text-success' : 'text-danger' ?>">
                                                    <?= $ders['average_score'] ? number_format($ders['average_score'], 2) : 'N/A' ?>
                                                </strong>
                                            </div>
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

<?php
include '../partials/footer.php';
?>