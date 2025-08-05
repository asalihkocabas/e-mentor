<?php
// Gerekli dosyaları ve session'ı başlat
include '../config/init.php';
$_SESSION['user_role'] = 'teacher';
$page_title = "Ödev Takip Ekranı | E-Mentor Öğretmen Paneli";

include '../partials/header.php';
include '../partials/sidebar.php';

$teacher_id = $_SESSION['user_id'] ?? 1;

// Öğretmenin atadığı tüm ödevleri, öğrenci ve kazanım bilgileriyle birlikte çek
$stmt = $pdo->prepare("
        SELECT 
            h.id, 
            sp.full_name, 
            c.name as class_name,
            lo.outcome_code, 
            h.assigned_date, 
            h.due_date, 
            h.status
        FROM homework_assignments h
        JOIN student_profiles sp ON h.student_id = sp.user_id
        JOIN classes c ON sp.class_id = c.id
        JOIN learning_outcomes lo ON h.learning_outcome_id = lo.id
        WHERE h.teacher_id = ?
        ORDER BY h.due_date DESC
    ");
$stmt->execute([$teacher_id]);
$assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Atanan Ödevleri Takip Et</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="index.php">Ana Sayfa</a></li>
                                    <li class="breadcrumb-item active">Ödev Takibi</li>
                                </ol>
                            </div>
                        </div>
                    </div>
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
                                <h4 class="card-title">Atanan Ödevler</h4>
                                <p class="card-title-desc">Öğrencilere atadığınız tüm kişisel ödevlerin listesi.</p>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                        <tr>
                                            <th>Öğrenci</th>
                                            <th>Kazanım Kodu</th>
                                            <th>Son Teslim Tarihi</th>
                                            <th>Durum</th>
                                            <th class="text-center">İşlemler</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($assignments as $hw):
                                            // 1. Merkezi fonksiyondan avatar verilerini al
                                            $avatar = get_avatar_data($hw['full_name']);
                                            ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm me-2">
                                                        <span class="avatar-title rounded-circle <?= $avatar['color_class'] ?> text-white font-size-16">
                                                            <?= $avatar['initials'] ?>
                                                        </span>
                                                        </div>
                                                        <div>
                                                            <span class="fw-bold d-block"><?= htmlspecialchars($hw['full_name']) ?></span>
                                                            <small class="text-muted"><?= htmlspecialchars($hw['class_name']) ?></small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><?= htmlspecialchars($hw['outcome_code']) ?></td>
                                                <td><?= (new DateTime($hw['due_date']))->format('d.m.Y H:i') ?></td>
                                                <td>
                                                    <?php
                                                    $status_badge = '';
                                                    if ($hw['status'] == 'assigned') $status_badge = '<span class="badge bg-warning-subtle text-warning">Teslim Bekleniyor</span>';
                                                    elseif ($hw['status'] == 'submitted') $status_badge = '<span class="badge bg-info-subtle text-info">Teslim Edildi</span>';
                                                    else $status_badge = '<span class="badge bg-success-subtle text-success">Değerlendirildi</span>';
                                                    echo $status_badge;
                                                    ?>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-primary">Değerlendir</button>
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

<?php
include '../partials/footer.php';
?>