<?php
session_start();
$_SESSION['user_role'] = 'teacher';
$page_title = "Duyuru Yönetimi | E-Mentor Öğretmen Paneli";
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
                            <h4 class="mb-sm-0 font-size-18">Duyuru Yönetimi</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="index.php">Ana Sayfa</a></li>
                                    <li class="breadcrumb-item active">Duyurular</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-end">
                                    <div class="col-md-4">
                                        <label for="search-announcement" class="form-label">Duyuru Ara</label>
                                        <input type="text" id="search-announcement" class="form-control" placeholder="Başlıkta ara...">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="filter-category" class="form-label">Kategori</label>
                                        <select class="form-control" id="filter-category">
                                            <option value="">Tümü</option>
                                            <option value="sinav">Sınav</option>
                                            <option value="odev">Ödev</option>
                                            <option value="toplanti">Toplantı</option>
                                            <option value="idari">İdari</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="filter-status" class="form-label">Durum</label>
                                        <select class="form-control" id="filter-status">
                                            <option value="">Tümü</option>
                                            <option value="yayinda">Yayında</option>
                                            <option value="taslak">Taslak</option>
                                            <option value="zamanlanmis">Zamanlanmış</option>
                                            <option value="arsivlenmis">Arşivlenmiş</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="duyuru-ekle.php" class="btn btn-primary w-100"><i class="bx bx-plus me-1"></i> Yeni Duyuru</a>
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
                                            <th>Başlık</th>
                                            <th>Kategori</th>
                                            <th>Hedef Kitle</th>
                                            <th>Yayın Tarihi</th>
                                            <th>Bitiş Tarihi</th>
                                            <th>Durum</th>
                                            <th class="text-center">İşlemler</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><strong>Matematik Sınavı Tarihleri</strong></td>
                                            <td><span class="badge bg-danger-subtle text-danger">Sınav</span></td>
                                            <td>6/A, 6/B</td>
                                            <td>01.08.2025 10:00</td>
                                            <td>15.08.2025 17:00</td>
                                            <td><span class="badge bg-success-subtle text-success">Yayında</span></td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#viewAnnouncementModal"><i class="bx bx-show-alt"></i></button>
                                                <button class="btn btn-sm btn-light"><i class="bx bx-pencil"></i></button>
                                                <button class="btn btn-sm btn-light"><i class="bx bx-archive-in"></i></button>
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

        <div class="modal fade" id="viewAnnouncementModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Duyuru Detayı</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h6><strong>Başlık:</strong> Matematik Sınavı Tarihleri</h6>
                        <hr>
                        <p><strong>İçerik:</strong><br>Sevgili öğrenciler, 1. dönem 1. matematik sınavı 15 Ağustos 2025 Cuma günü 3. ders saatinde yapılacaktır. Konular: Üslü sayılar ve köklü ifadeler.</p>
                        <hr>
                        <p><strong>Kategori:</strong> <span class="badge bg-danger-subtle text-danger">Sınav</span></p>
                        <p><strong>Hedef Kitle:</strong> 6/A, 6/B</p>
                        <p><strong>Ekli Dosya:</strong> <a href="#">sinav_konulari.pdf <i class="bx bx-download"></i></a></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new Choices('#filter-category');
            new Choices('#filter-status');
        });
    </script>

<?php
include '../partials/footer.php';
?>