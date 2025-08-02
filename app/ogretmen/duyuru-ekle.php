<?php
session_start();
$_SESSION['user_role'] = 'teacher';
$page_title = "Yeni Duyuru Oluştur | E-Mentor Öğretmen Paneli";
include '../partials/header.php';
include '../partials/sidebar.php';
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
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="index.php">Ana Sayfa</a></li>
                                    <li class="breadcrumb-item"><a href="duyuru-yonetimi.php">Duyurular</a></li>
                                    <li class="breadcrumb-item active">Yeni Duyuru</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="announcement-title" class="form-label">Duyuru Başlığı</label>
                                    <input type="text" class="form-control" id="announcement-title" placeholder="Duyuru başlığını giriniz...">
                                </div>

                                <div>
                                    <label class="form-label">Duyuru İçeriği</label>
                                    <textarea id="announcement-editor"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Dosya Eki</h4>
                            </div>
                            <div class="card-body">
                                <form action="#" class="dropzone">
                                    <div class="fallback">
                                        <input name="file" type="file" multiple="multiple">
                                    </div>
                                    <div class="dz-message needsclick">
                                        <div class="mb-3"><i class="display-4 text-muted bx bx-cloud-upload"></i></div>
                                        <h5>Varsa duyuru ekini buraya sürükleyin veya seçin.</h5>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Yayınlama Ayarları</h4>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="announcement-category" class="form-label">Kategori</label>
                                    <select class="form-select" id="announcement-category">
                                        <option value="duyuru">Genel Duyuru</option>
                                        <option value="sinav">Sınav</option>
                                        <option value="odev">Ödev</option>
                                        <option value="toplanti">Toplantı</option>
                                        <option value="idari">İdari</option>
                                    </select>
                                </div>
                                <hr>
                                <div class="mb-3">
                                    <label class="form-label">Kimler Görebilir? (Hedef Kitle)</label>
                                    <select class="form-control" name="choices-target-audience" id="choices-target-audience" multiple>
                                        <optgroup label="Sınıflar">
                                            <option value="6A">6/A Sınıfı</option>
                                            <option value="6B">6/B Sınıfı</option>
                                            <option value="5A">5/A Sınıfı</option>
                                            <option value="5B">5/B Sınıfı</option>
                                        </optgroup>
                                        <optgroup label="Gruplar">
                                            <option value="ogretmenler">Tüm Öğretmenler</option>
                                            <option value="veliler">Tüm Veliler</option>
                                        </optgroup>
                                    </select>
                                </div>
                                <hr>
                                <div class="mb-3">
                                    <label for="publish-date" class="form-label">Yayınlanma Tarihi</label>
                                    <input type="text" class="form-control" id="publish-date" placeholder="Hemen yayınlanacak">
                                </div>
                                <div class="mb-3">
                                    <label for="end-date" class="form-label">Bitiş Tarihi (İsteğe Bağlı)</label>
                                    <input type="text" class="form-control" id="end-date" placeholder="Duyuru bu tarihte kalkar">
                                </div>
                            </div>
                            <div class="card-footer bg-transparent border-top">
                                <div class="d-grid">
                                    <button class="btn btn-primary"><i class="bx bx-send me-2"></i>Duyuruyu Yayınla</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <script src="../assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="../assets/libs/dropzone/min/dropzone.min.js"></script>
    <script src="../assets/libs/flatpickr/flatpickr.min.js"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/tr.js"></script>
    <script src="../assets/libs/tinymce/tinymce.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Choices.js
            new Choices('#choices-target-audience');

            // Flatpickr
            flatpickr('#publish-date', {
                enableTime: true,
                dateFormat: "d.m.Y H:i",
                locale: "tr"
            });
            flatpickr('#end-date', {
                enableTime: true,
                dateFormat: "d.m.Y H:i",
                locale: "tr"
            });

            // TinyMCE
            tinymce.init({
                selector: 'textarea#announcement-editor',
                height: 300,
                menubar: false,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                ],
                toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
            });
        });
    </script>

<?php
include '../partials/footer.php';
?>