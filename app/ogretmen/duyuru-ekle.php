<?php
// Gerekli dosyaları ve session'ı başlat
include '../config/init.php';
$_SESSION['user_role'] = 'teacher';
$page_title = "Yeni Duyuru Oluştur | E-Mentor Öğretmen Paneli";

include '../partials/header.php';
include '../partials/sidebar.php';

$teacher_id = $_SESSION['user_id'] ?? 1;

// Öğretmenin sorumlu olduğu sınıfları çek
$stmt_classes = $pdo->prepare("SELECT DISTINCT c.id, c.name FROM classes c JOIN teacher_assignments ta ON c.id = ta.class_id WHERE ta.teacher_id = ? ORDER BY c.name");
$stmt_classes->execute([$teacher_id]);
$teacher_classes = $stmt_classes->fetchAll(PDO::FETCH_ASSOC);
?>

    <link href="../assets/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/libs/dropzone/min/dropzone.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="../assets/libs/flatpickr/flatpickr.min.css">

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Yeni Duyuru Oluştur</h4>
                        </div>
                    </div>
                </div>

                <form action="../islemler/duyuru-kaydet.php" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="announcement-title" class="form-label">Duyuru Başlığı</label>
                                        <input type="text" class="form-control" id="announcement-title" name="title" placeholder="Duyuru başlığını giriniz..." required>
                                    </div>
                                    <div>
                                        <label class="form-label">Duyuru İçeriği</label>
                                        <textarea id="announcement-editor" name="content"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header"><h4 class="card-title mb-0">Yayınlama Ayarları</h4></div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="announcement-category" class="form-label">Kategori</label>
                                        <select class="form-select" name="category" id="announcement-category">
                                            <option value="Genel">Genel Duyuru</option>
                                            <option value="Sınav">Sınav</option>
                                            <option value="Ödev">Ödev</option>
                                            <option value="Toplantı">Toplantı</option>
                                            <option value="İdari">İdari</option>
                                        </select>
                                    </div>
                                    <hr>
                                    <div class="mb-3">
                                        <label class="form-label">Hedef Kitle</label>
                                        <select class="form-control" name="target_audience[]" id="choices-target-audience" multiple>
                                            <optgroup label="Gruplar">
                                                <option value="group_all_students">Tüm Öğrencilerim</option>
                                                <option value="group_teachers">Tüm Öğretmenler</option>
                                            </optgroup>
                                            <optgroup label="Sınıflar">
                                                <?php foreach($teacher_classes as $class): ?>
                                                    <option value="class_<?= $class['id'] ?>"><?= htmlspecialchars($class['name']) ?></option>
                                                <?php endforeach; ?>
                                            </optgroup>
                                        </select>
                                    </div>
                                    <hr>
                                    <div class="mb-3">
                                        <label for="publish-date" class="form-label">Yayınlanma Tarihi</label>
                                        <input type="text" class="form-control" name="publish_date" id="publish-date" placeholder="Hemen yayınlanacak">
                                    </div>
                                    <div class="mb-3">
                                        <label for="end-date" class="form-label">Bitiş Tarihi (İsteğe Bağlı)</label>
                                        <input type="text" class="form-control" name="end_date" id="end-date" placeholder="Duyuru bu tarihte kalkar">
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-top">
                                    <div class="d-grid"><button type="submit" class="btn btn-primary"><i class="bx bx-send me-2"></i>Duyuruyu Yayınla</button></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="../assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/tr.js"></script>
    <script src="../assets/libs/flatpickr/flatpickr.min.js"></script>
    <script src="../assets/libs/tinymce/tinymce.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new Choices('#choices-target-audience');
            flatpickr('#publish-date', { enableTime: true, dateFormat: "d.m.Y H:i", locale: "tr" });
            flatpickr('#end-date', { enableTime: true, dateFormat: "d.m.Y H:i", locale: "tr" });
            tinymce.init({
                selector: 'textarea#announcement-editor', height: 300, menubar: false,
                plugins: ['advlist autolink lists link'],
                toolbar: 'undo redo | bold italic | bullist numlist'
            });
        });
    </script>

<?php
include '../partials/footer.php';
?>