<?php
// Gerekli dosyaları ve session'ı başlat
include '../config/init.php';
$_SESSION['user_role'] = 'teacher';
$page_title = "Yeni İçerik Yükle | E-Mentor Öğretmen Paneli";

include '../partials/header.php';
include '../partials/sidebar.php';

$teacher_id = $_SESSION['user_id'] ?? 1;

// --- Formlar için gerekli verileri ve HTML seçeneklerini önceden hazırla ---

$stmt_courses = $pdo->prepare("SELECT id, name FROM courses ORDER BY name");
$stmt_courses->execute();
$course_options_html = '';
foreach($stmt_courses->fetchAll(PDO::FETCH_ASSOC) as $c) { $course_options_html .= "<option value='{$c['id']}'>" . htmlspecialchars($c['name']) . "</option>"; }

$stmt_classes = $pdo->prepare("SELECT id, name FROM classes ORDER BY name");
$stmt_classes->execute();
$class_options_html = '';
foreach($stmt_classes->fetchAll(PDO::FETCH_ASSOC) as $cl) { $class_options_html .= "<option value='{$cl['id']}'>" . htmlspecialchars($cl['name']) . "</option>"; }

$stmt_outcomes = $pdo->prepare("SELECT id, outcome_code, description FROM learning_outcomes ORDER BY outcome_code");
$stmt_outcomes->execute();
$outcome_options_html = '';
foreach($stmt_outcomes->fetchAll(PDO::FETCH_ASSOC) as $o) {
    $display_text = htmlspecialchars($o['outcome_code'] . " - " . $o['description']);
    $outcome_options_html .= "<option value='{$o['id']}'>{$display_text}</option>";
}
?>

<link href="../assets/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" type="text/css" />
<style>
    .choices__list--dropdown { z-index: 1060 !important; }
    .table-responsive { overflow: visible !important; }
</style>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12"><div class="page-title-box d-sm-flex align-items-center justify-content-between"><h4 class="mb-sm-0 font-size-18">Yeni İçerik Yükle</h4></div></div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Aşama 1: Yüklenecek Dosya Türünü Seçin</h4>
                            <select id="file-type-selector" class="form-select form-select-lg mb-3">
                                <option value="">Lütfen bir tür seçin...</option>
                                <option value="kazanim">Kazanım Testi</option>
                                <option value="kitap">Ders Kitabı</option>
                                <option value="soru">Çıkmış Soru</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div id="upload-form-container" style="display: none;">
                <form action="../islemler/icerik-kaydet.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="file_type" id="hidden-file-type">

                    <div class="card">
                        <div class="card-body text-center">
                            <h4 class="card-title">Aşama 2: Dosyaları Seçin</h4>
                            <label for="file-input" class="btn btn-primary btn-lg"><i class="bx bx-upload me-2"></i>Bilgisayardan Dosya Seç</label>
                            <input type="file" id="file-input" name="file_uploads[]" multiple class="d-none">
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header"><h4 class="card-title">Aşama 3: Dosya Bilgilerini Düzenleyin</h4></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead id="files-table-head" class="table-light"></thead>
                                    <tbody id="files-table-body"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success btn-lg"><i class="bx bx-library me-1"></i> Seçilenleri Kütüphaneye Ekle</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../partials/footer.php'; ?>
<script src="../assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelector = document.getElementById('file-type-selector');
        const formContainer = document.getElementById('upload-form-container');
        const fileInput = document.getElementById('file-input');
        const tableHead = document.getElementById('files-table-head');
        const tableBody = document.getElementById('files-table-body');
        const hiddenFileType = document.getElementById('hidden-file-type');

        const headers = {
            kazanim: '<tr><th>Dosya Adı</th><th>Ders</th><th>Sınıf</th><th>Kazanım</th></tr>',
            kitap: '<tr><th>Dosya Adı</th><th>Ders</th><th>Sınıf</th></tr>',
            soru: '<tr><th>Dosya Adı</th><th>Sınav Türü</th><th>Yıl</th><th>Alanı</th></tr>',
        };

        const courseOptions = '<?php echo addslashes($course_options_html); ?>';
        const classOptions = '<?php echo addslashes($class_options_html); ?>';
        const outcomeOptions = '<?php echo addslashes($outcome_options_html); ?>';

        typeSelector.addEventListener('change', function() {
            const type = this.value;
            tableBody.innerHTML = '';
            fileInput.value = '';

            // DÜZELTME: Backend'e gönderilecek değeri ENUM ile uyumlu hale getiriyoruz.
            if (type === 'kazanim') hiddenFileType.value = 'Kazanım Testi';
            else if (type === 'kitap') hiddenFileType.value = 'Ders Kitabı';
            else if (type === 'soru') hiddenFileType.value = 'Çıkmış Soru';

            if (type) {
                tableHead.innerHTML = headers[type];
                formContainer.style.display = 'block';
            } else {
                formContainer.style.display = 'none';
            }
        });

        fileInput.addEventListener('change', function() {
            tableBody.innerHTML = '';
            const type = typeSelector.value;
            const files = this.files;

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                let metaHtml = '';

                if (type === 'kazanim') {
                    metaHtml = `
                    <td><select name="files[${i}][course_id]">${courseOptions}</select></td>
                    <td><select name="files[${i}][class_id]">${classOptions}</select></td>
                    <td><select name="files[${i}][outcome_id]">${outcomeOptions}</select></td>
                `;
                } else if (type === 'kitap') {
                    metaHtml = `
                    <td><select name="files[${i}][course_id]">${courseOptions}</select></td>
                    <td><select name="files[${i}][class_id]">${classOptions}</select></td>
                `;
                } else if (type === 'soru') {
                    metaHtml = `
                    <td><select name="files[${i}][exam_type]"><option>LGS</option><option>YKS</option></select></td>
                    <td><input type="number" name="files[${i}][year]" class="form-control form-control-sm" value="2024"></td>
                    <td><select name="files[${i}][field]"><option>Sözel</option><option>Sayısal</option></select></td>
                `;
                }

                const newRowHTML = `<tr data-index="${i}"><td>${file.name}</td>${metaHtml}</tr>`;
                tableBody.insertAdjacentHTML('beforeend', newRowHTML);
                tableBody.querySelectorAll(`tr[data-index="${i}"] select`).forEach(selectEl => new Choices(selectEl, { searchResultLimit: 15, shouldSort: false }));
            }
        });
    });
</script>