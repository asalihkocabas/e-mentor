<?php
include '../config/init.php';
$_SESSION['user_role'] = 'teacher';
$page_title = "Yeni Sınav Oluştur | E-Mentor Öğretmen Paneli";

include '../partials/header.php';
include '../partials/sidebar.php';

$teacher_id = $_SESSION['user_id'] ?? 1;

// --- Veritabanından Gerekli Verileri Çekme ---
$stmt_classes = $pdo->prepare("SELECT DISTINCT c.id, c.name, c.grade_level FROM classes c JOIN teacher_assignments ta ON c.id = ta.class_id WHERE ta.teacher_id = ? ORDER BY c.name");
$stmt_classes->execute([$teacher_id]);
$teacher_classes = $stmt_classes->fetchAll(PDO::FETCH_ASSOC);

$stmt_courses = $pdo->prepare("SELECT DISTINCT co.id, co.name FROM courses co JOIN teacher_assignments ta ON co.id = ta.course_id WHERE ta.teacher_id = ? ORDER BY co.name");
$stmt_courses->execute([$teacher_id]);
$teacher_courses = $stmt_courses->fetchAll(PDO::FETCH_ASSOC);
?>

<link href="../assets/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../assets/libs/flatpickr/flatpickr.min.css">
<style>
    #questions-container:empty { min-height: 50px; }
    .main-content { padding-bottom: 120px; }
    .choices__list--dropdown, .dropdown-menu { z-index: 1060 !important; }
</style>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row"><div class="col-12"><div class="page-title-box d-sm-flex align-items-center justify-content-between"><h4 class="mb-sm-0 font-size-18">Yeni Sınav Oluştur</h4></div></div></div>

            <?php if (isset($_SESSION['form_message'])): ?>
                <div class="alert alert-<?= $_SESSION['form_message_type']; ?> alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($_SESSION['form_message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['form_message'], $_SESSION['form_message_type']); endif; ?>

            <form id="create-exam-form" action="../islemler/sinav-kaydet.php" method="POST">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Sınav Bilgileri</h4>
                                <div class="row">
                                    <div class="col-md-3 mb-3"><label class="form-label">Ders</label><select name="course_id" id="course-select" required><option value="">Seçiniz...</option><?php foreach($teacher_courses as $course): ?><option value="<?= $course['id'] ?>"><?= htmlspecialchars($course['name']) ?></option><?php endforeach; ?></select></div>
                                    <div class="col-md-3 mb-3"><label class="form-label">Sınıflar</label><select name="class_ids[]" id="class-select" multiple required><?php foreach($teacher_classes as $class): ?><option value="<?= $class['id'] ?>" data-grade="<?= $class['grade_level'] ?>"><?= htmlspecialchars($class['name']) ?></option><?php endforeach; ?></select></div>
                                    <div class="col-md-2 mb-3"><label class="form-label">Dönem</label><select class="form-control" name="exam_term"><option>1. Dönem</option><option>2. Dönem</option></select></div>
                                    <div class="col-md-2 mb-3"><label class="form-label">Sınav Türü</label><select class="form-control" name="exam_type"><option>1. Yazılı</option><option>2. Yazılı</option><option>Quiz</option></select></div>
                                    <div class="col-md-2 mb-3"><label class="form-label">Sınav Tarihi</label><input type="text" class="form-control" name="exam_date" id="exam-date" placeholder="Tarih seçin..." required></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="card-title mb-0">Sorular</h4>
                            <div class="btn-group">
                                <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-plus me-1"></i> Yeni Soru Ekle</button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#" id="add-mcq-btn">Çoktan Seçmeli</a>
                                    <a class="dropdown-item" href="#" id="add-tf-btn">Doğru / Yanlış</a>
                                    <a class="dropdown-item" href="#" id="add-open-btn">Açık Uçlu</a>
                                </div>
                            </div>
                        </div>
                        <div id="questions-container"></div>
                    </div>
                </div>

                <div class="sticky-bottom">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Toplam Puan: <span id="total-points" class="fw-bold text-danger">0</span> / 100</h5>
                            <button type="submit" class="btn btn-primary btn-lg"><i class="bx bx-save me-2"></i>Sınavı Kaydet</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <footer class="footer"><div class="container-fluid"><div class="row"><div class="col-sm-6"><script>document.write(new Date().getFullYear())</script> © E-Mentor.</div></div></div></footer>
</div>
</div>

<template id="mcq-template">
    <div class="card question-card" data-type="mcq">
        <div class="card-header bg-light d-flex justify-content-between align-items-center"><h5 class="mb-0">Soru</h5><button type="button" class="btn-close remove-question-btn"></button></div>
        <div class="card-body">
            <input type="hidden" name="questions[counter][type]" value="mcq">
            <div class="mb-3"><label class="form-label">Soru Metni</label><textarea class="form-control" rows="3" name="questions[counter][text]"></textarea></div>
            <div class="row">
                <div class="col-lg-7"><label class="form-label">Seçenekler</label><div class="options-container">
                        <div class="input-group mb-2"><div class="input-group-text"><input class="form-check-input" type="radio" name="questions[counter][correct]" value="A"></div><span class="input-group-text">A)</span><input type="text" class="form-control" name="questions[counter][options][A]"></div>
                        <div class="input-group mb-2"><div class="input-group-text"><input class="form-check-input" type="radio" name="questions[counter][correct]" value="B"></div><span class="input-group-text">B)</span><input type="text" class="form-control" name="questions[counter][options][B]"></div>
                    </div><button type="button" class="btn btn-sm btn-outline-secondary add-option-btn mt-2">Şık Ekle</button><button type="button" class="btn btn-sm btn-outline-danger remove-option-btn mt-2 ms-2">Şık Sil</button></div>
                <div class="col-lg-5"><div class="mb-3"><label class="form-label">Puan</label><input type="number" class="form-control question-points" name="questions[counter][points]" value="5"></div><div class="mb-3"><label class="form-label">Kazanım</label><select class="form-control question-objective" name="questions[counter][outcome_id]"><option value="">Önce Ders ve Sınıf Seçin</option></select></div></div>
            </div>
        </div>
    </div>
</template>
<template id="tf-template">
    <div class="card question-card" data-type="tf">
        <div class="card-header bg-light d-flex justify-content-between align-items-center"><h5 class="mb-0">Soru</h5><button type="button" class="btn-close remove-question-btn"></button></div>
        <div class="card-body">
            <input type="hidden" name="questions[counter][type]" value="tf">
            <div class="mb-3"><label class="form-label">Önerme / Soru Metni</label><textarea class="form-control" rows="2" name="questions[counter][text]"></textarea></div>
            <div class="row"><div class="col-lg-7"><label class="form-label">Doğru Cevap</label><div class="d-flex gap-3"><div class="form-check"><input class="form-check-input" type="radio" name="questions[counter][correct]" value="D" id="radio-d-counter"><label class="form-check-label" for="radio-d-counter">Doğru</label></div><div class="form-check"><input class="form-check-input" type="radio" name="questions[counter][correct]" value="Y" id="radio-y-counter"><label class="form-check-label" for="radio-y-counter">Yanlış</label></div></div></div>
                <div class="col-lg-5"><div class="mb-3"><label class="form-label">Puan</label><input type="number" class="form-control question-points" name="questions[counter][points]" value="5"></div><div class="mb-3"><label class="form-label">Kazanım</label><select class="form-control question-objective" name="questions[counter][outcome_id]"><option value="">Önce Ders ve Sınıf Seçin</option></select></div></div></div>
        </div>
    </div>
</template>
<template id="open-template">
    <div class="card question-card" data-type="open">
        <div class="card-header bg-light d-flex justify-content-between align-items-center"><h5 class="mb-0">Soru</h5><button type="button" class="btn-close remove-question-btn"></button></div>
        <div class="card-body">
            <input type="hidden" name="questions[counter][type]" value="open">
            <div class="mb-3"><label class="form-label">Açık Uçlu Soru</label><textarea class="form-control" rows="3" name="questions[counter][text]"></textarea></div>
            <div class="mb-3"><label class="form-label">Doğru Cevap (Anahtar Kelimeler)</label><textarea class="form-control" rows="2" name="questions[counter][correct]" placeholder="Değerlendirme için anahtar kelimeleri girin..."></textarea></div>
            <div class="row"><div class="col-lg-6"><div class="mb-3"><label class="form-label">Puan</label><input type="number" class="form-control question-points" name="questions[counter][points]" value="10"></div></div>
                <div class="col-lg-6"><div class="mb-3"><label class="form-label">Kazanım</label><select class="form-control question-objective" name="questions[counter][outcome_id]"><option value="">Önce Ders ve Sınıf Seçin</option></select></div></div></div>
        </div>
    </div>
</template>

<script src="../assets/libs/jquery/jquery.min.js"></script>
<script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../assets/libs/metismenu/metisMenu.min.js"></script>
<script src="../assets/libs/simplebar/simplebar.min.js"></script>
<script src="../assets/libs/node-waves/waves.min.js"></script>
<script src="../assets/libs/feather-icons/feather.min.js"></script>
<script src="../assets/libs/pace-js/pace.min.js"></script>
<script src="../assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/tr.js"></script>
<script src="../assets/libs/flatpickr/flatpickr.min.js"></script>
<script src="../assets/js/pages/form-exam-create.js"></script>
<script src="../assets/js/app.js"></script>

</body>
</html>