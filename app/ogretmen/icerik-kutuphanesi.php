<?php
session_start();
$_SESSION['user_role'] = 'teacher';
$page_title = "İçerik Kütüphanesi | E-Mentor Öğretmen Paneli";
include '../partials/header.php';
include '../partials/sidebar.php';
?>

    <link href="../assets/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" type="text/css" />

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">İçerik Kütüphanesi</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="index.php">Ana Sayfa</a></li>
                                    <li class="breadcrumb-item active">İçerik Kütüphanesi</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row gx-3 gy-2 align-items-end">
                                    <div class="col-sm-4">
                                        <label for="search-content" class="form-label">İçerik Ara</label>
                                        <input type="text" id="search-content" class="form-control" placeholder="Dosya adında ara...">
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="form-label">İçerik Türü</label>
                                        <select class="form-control" id="filter-type">
                                            <option value="">Tümü</option>
                                            <option value="test">Kazanım Testi</option>
                                            <option value="kitap">Ders Kitabı</option>
                                            <option value="soru">Çıkmış Soru</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="form-label">Ders</label>
                                        <select class="form-control" id="filter-course">
                                            <option value="">Tümü</option>
                                            <option value="matematik">Matematik</option>
                                            <option value="fizik">Fizik</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="form-label">Sınıf</label>
                                        <select class="form-control" id="filter-class">
                                            <option value="">Tümü</option>
                                            <option value="9">9. Sınıf</option>
                                            <option value="10">10. Sınıf</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <a href="dosya-yukle.php" class="btn btn-primary w-100"><i class="bx bx-plus me-1"></i> Yeni İçerik Ekle</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                        <tr>
                                            <th>Dosya Adı</th>
                                            <th>Tür</th>
                                            <th>Ders / Sınav</th>
                                            <th>Sınıf / Yıl</th>
                                            <th>Kazanım / Alan</th>
                                            <th>Yüklenme Tarihi</th>
                                            <th class="text-center">İşlemler</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><i class="bx bxs-file-pdf text-danger me-2"></i><strong>matematik-test-1.pdf</strong></td>
                                            <td><span class="badge bg-primary-subtle text-primary"><i class="bx bx-task me-1"></i>Kazanım Testi</span></td>
                                            <td>Matematik</td>
                                            <td>9. Sınıf</td>
                                            <td>M.9.1.1.1</td>
                                            <td>01.08.2025</td>
                                            <td class="text-center">
                                                <a href="#" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="İndir"><i class="bx bx-download"></i></a>
                                                <a href="#" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="Düzenle"><i class="bx bx-pencil"></i></a>
                                                <a href="#" class="btn btn-sm btn-light" data-bs-toggle="tooltip" title="Sil"><i class="bx bx-trash"></i></a>
                                            </td>
                                        </tr>
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

    <script src="../assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new Choices('#filter-type');
            new Choices('#filter-course');
            new Choices('#filter-class');

            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>

<?php
include '../partials/footer.php';
?>