<?php
include '../config/init.php';
$_SESSION['user_role'] = 'student';
$page_title = "Ders Programım | E-Mentor Öğrenci Paneli";

include '../partials/header.php';
include '../partials/sidebar.php';

$student_id = $_SESSION['user_id'] ?? 2;

// --- VERİTABANI SORGULARI ---
$simulated_time = new DateTime(SIMULATED_NOW);
$current_day = $simulated_time->format('N');
$current_time = $simulated_time->format('H:i:s');

$stmt_class = $pdo->prepare("SELECT class_id FROM student_profiles WHERE user_id = ?");
$stmt_class->execute([$student_id]);
$class_id = $stmt_class->fetchColumn();

$stmt_periods = $pdo->query("SELECT period_number, start_time, end_time FROM schedule_periods ORDER BY period_number");
$periods = $stmt_periods->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);

$stmt_schedule = $pdo->prepare("SELECT ws.day_of_week, ws.period, co.name as course_name FROM weekly_schedules ws JOIN courses co ON ws.course_id = co.id WHERE ws.class_id = ?");
$stmt_schedule->execute([$class_id]);
$schedule_data = $stmt_schedule->fetchAll(PDO::FETCH_ASSOC);

$schedule = [];
foreach($schedule_data as $lesson) {
    $schedule[$lesson['day_of_week']][$lesson['period']] = $lesson['course_name'];
}

$current_lesson = null;
$next_lesson = null;
if(isset($schedule[$current_day])) {
    foreach($periods as $period_num => $times) {
        $start_time = $times[0]['start_time']; $end_time = $times[0]['end_time'];
        if ($current_time >= $start_time && $current_time <= $end_time && isset($schedule[$current_day][$period_num])) {
            $current_lesson = ['name' => $schedule[$current_day][$period_num], 'time' => date('H:i', strtotime($start_time)) . ' - ' . date('H:i', strtotime($end_time))];
        }
        if ($current_time < $start_time && isset($schedule[$current_day][$period_num]) && $next_lesson === null) {
            $next_lesson = ['name' => $schedule[$current_day][$period_num], 'time' => date('H:i', strtotime($start_time)) . ' - ' . date('H:i', strtotime($end_time))];
        }
    }
}
?>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row"><div class="col-12"><div class="page-title-box d-sm-flex align-items-center justify-content-between"><h4 class="mb-sm-0 font-size-18">Ders Programım</h4></div></div></div>

                <div class="row">
                    <div class="col-xl-6 col-md-6 mb-3">
                        <div class="card shadow-sm border-start border-success border-4 h-100">
                            <div class="card-body">
                                <h6 class="text-muted mb-2">Şu Anki Ders</h6>
                                <?php if ($current_lesson): ?>
                                    <h5 class="text-success fw-bold"><?= htmlspecialchars($current_lesson['name']) ?></h5>
                                    <p class="mb-0"><?= $current_lesson['time'] ?> arası</p>
                                <?php else: ?>
                                    <h5 class="text-muted fw-bold">Boş Ders</h5>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 mb-3">
                        <div class="card shadow-sm border-start border-warning border-4 h-100">
                            <div class="card-body">
                                <h6 class="text-muted mb-2">Sıradaki Ders</h6>
                                <?php if ($next_lesson): ?>
                                    <h5 class="text-warning fw-bold"><?= htmlspecialchars($next_lesson['name']) ?></h5>
                                    <p class="mb-0"><?= $next_lesson['time'] ?> arası</p>
                                <?php else: ?>
                                    <h5 class="text-muted fw-bold">Ders Yok</h5>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4"><i class="bx bx-calendar-week me-2"></i>Haftalık Ders Programı</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center align-middle">
                                        <thead class="table-light"><tr><th style="width: 120px;">Saat</th><th>Pazartesi</th><th>Salı</th><th>Çarşamba</th><th>Perşembe</th><th>Cuma</th></tr></thead>
                                        <tbody>
                                        <?php foreach ($periods as $period_num => $times):
                                            $start_time = $times[0]['start_time']; $end_time = $times[0]['end_time'];
                                            ?>
                                            <tr>
                                                <td><?= date('H:i', strtotime($start_time)) . ' - ' . date('H:i', strtotime($end_time)) ?></td>
                                                <?php for ($day = 1; $day <= 5; $day++):
                                                    $lesson_text = $schedule[$day][$period_num] ?? 'Boş';
                                                    $cell_class = '';
                                                    if ($day < $current_day) { $cell_class = 'bg-light text-muted opacity-75'; }
                                                    elseif ($day == $current_day) {
                                                        if ($current_time >= $start_time && $current_time <= $end_time) { $cell_class = 'bg-success-subtle fw-bold'; }
                                                        elseif ($current_time < $start_time && $next_lesson && $next_lesson['time'] == date('H:i', strtotime($start_time)) . ' - ' . date('H:i', strtotime($end_time))) { $cell_class = 'bg-warning-subtle'; }
                                                        elseif ($current_time > $end_time) { $cell_class = 'bg-light text-muted opacity-75'; }
                                                    }
                                                    ?>
                                                    <td class="<?= $cell_class ?>"><?= htmlspecialchars($lesson_text) ?></td>
                                                <?php endfor; ?>
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