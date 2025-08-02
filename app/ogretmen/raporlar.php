<?php
session_start();
$_SESSION['user_role'] = 'teacher';
$page_title = "Sınav Raporları | E-Mentor Öğretmen Paneli";
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
                            <h4 class="mb-sm-0 font-size-18">Sınav Raporları</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="index.php">Ana Sayfa</a></li>
                                    <li class="breadcrumb-item active">Sınav Raporları</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-5">
                                        <label for="search-exam" class="form-label">Sınav Ara</label>
                                        <input type="text" id="search-exam" class="form-control" placeholder="Sınav adı, sınıf veya ders girin...">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="filter-status" class="form-label">Duruma Göre Filtrele</label>
                                        <select class="form-control" name="filter-status" id="filter-status">
                                            <option value="">Tümü</option>
                                            <option value="bekleniyor">Tarihi Bekleniyor</option>
                                            <option value="not_girisi">Not Girişi Bekleniyor</option>
                                            <option value="tamamlandi">Tamamlandı</option>
                                            <option value="iptal">Geçti / İptal</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                        <tr>
                                            <th>Sınav Adı</th>
                                            <th>Sınav Tarihi</th>
                                            <th>Durum</th>
                                            <th class="text-center">İşlemler</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><p class="fw-bold mb-0">9. Sınıf - Matematik - 1. Dönem 1. Sınav</p><span class="text-muted">ID: #SINAV001</span></td>
                                            <td>01.10.2024, 10:00</td>
                                            <td><span class="badge font-size-12 p-2 bg-success-subtle text-success">Tamamlandı</span></td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" title="Detaylı Raporu Görüntüle"><i class="bx bx-bar-chart-alt-2"></i></button>
                                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#answerKeyModal" data-bs-toggle="tooltip" title="Cevap Anahtarını Görüntüle"><i class="bx bx-key"></i></button>
                                                <button type="button" class="btn btn-light btn-sm" data-bs-toggle="tooltip" title="Sonuçları Düzenle"><i class="bx bx-pencil"></i></button>
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

        <div class="modal fade" id="answerKeyModal" tabindex="-1" aria-labelledby="answerKeyModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="answerKeyModalLabel">Cevap Anahtarı: 9. Sınıf - Matematik</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">Soru 1<span class="badge bg-primary rounded-pill">C</span></li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">Soru 2<span class="badge bg-primary rounded-pill">B</span></li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">Soru 3<span class="badge bg-primary rounded-pill">A</span></li>
                        </ul>
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
            new Choices('#filter-status');
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>

<?php
include '../partials/footer.php';
?>