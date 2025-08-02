<?php
$page_title = "Ders Detayı: Matematik | E-Mentor Sistemi";
include '../partials/header.php';
include '../partials/sidebar.php';
?>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Ders Detayı: Matematik</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="derslerim.php">Derslerim</a></li>
                                    <li class="breadcrumb-item active">Matematik</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-h-100"><div class="card-body"><div class="d-flex align-items-center"><div class="flex-grow-1"><span class="text-muted mb-3 lh-1 d-block">Genel Not Ortalaması</span><h4 class="mb-3"><span class="counter-value" data-target="87.5">0</span></h4></div></div></div></div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-h-100"><div class="card-body"><div class="d-flex align-items-center"><div class="flex-grow-1"><span class="text-muted mb-3 lh-1 d-block">Konu İlerlemesi</span><h4 class="mb-3">%<span class="counter-value" data-target="40">0</span></h4></div></div></div></div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-h-100"><div class="card-body"><div class="d-flex align-items-center"><div class="flex-grow-1"><span class="text-muted mb-3 lh-1 d-block">Yaklaşan Sınav</span><h4 class="mb-3">1</h4></div></div></div></div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-h-100"><div class="card-body"><div class="d-flex align-items-center"><div class="flex-grow-1"><span class="text-muted mb-3 lh-1 d-block">Öğretmen</span><h5 class="mb-3 pt-1">Ahmet S. KOCABAŞ</h5></div></div></div></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-transparent border-bottom"><h5 class="mb-0">Ders Not Bilgileri</h5></div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0 align-middle">
                                        <thead class="table-light"><tr><th>Çalışma</th><th>Not</th><th>Durum</th><th class="text-end">Detay</th></tr></thead>
                                        <tbody>
                                        <tr>
                                            <td>Sınav 1</td>
                                            <td>90</td>
                                            <td><div class="progress" style="height: 6px;"><div class="progress-bar bg-success" style="width: 90%;"></div></div></td>
                                            <td class="text-end">
                                                <div class="btn-group" style="position: static;">
                                                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Detay <i class="mdi mdi-chevron-down"></i></button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#soruDetayModal">Soru/Kazanım Detay</a></li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li><a class="dropdown-item" href="#">AI Destek</a></li>
                                                    </ul>
                                                </div>
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

        <div class="modal fade" id="soruDetayModal" tabindex="-1" aria-labelledby="soruDetayModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="soruDetayModalLabel">Sınav 1: Soru ve Kazanım Analizi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted">Bu sınavdaki performansını soru bazında inceleyebilirsin.</p>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-light">
                                <tr><th>Soru</th><th>Kazanım</th><th class="text-center">Puan</th><th class="text-center">Durumun</th><th class="text-center">İncele</th></tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><strong>M.9.1.1.1:</strong> Sayı kümelerini birbirleriyle ilişkilendirir.</td>
                                    <td class="text-center">10 / 10</td>
                                    <td class="text-center"><span class="badge bg-success-subtle text-success"><i class="bx bx-check-circle me-1"></i>Doğru</span></td>
                                    <td class="text-center"><button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#soruInceleModal">İncele</button></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td><strong>M.9.1.2.1:</strong> Üslü ifadeleri içeren denklemleri çözer.</td>
                                    <td class="text-center">0 / 10</td>
                                    <td class="text-center"><span class="badge bg-danger-subtle text-danger"><i class="bx bx-x-circle me-1"></i>Yanlış</span></td>
                                    <td class="text-center"><button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#soruInceleModal">İncele</button></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="soruInceleModal" tabindex="-1" aria-labelledby="soruInceleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="soruInceleModalLabel">Soru 2: Detaylı Analiz</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h6 class="fw-bold">Soru Metni:</h6>
                        <p class="card-text p-3 bg-light rounded">(-8) - (-5) işleminin sonucu kaçtır?</p>
                        <h6 class="fw-bold mt-4">Seçenekler:</h6>
                        <div class="list-group">
                            <div class="list-group-item list-group-item-danger d-flex justify-content-between align-items-center">A) -13<span class="badge bg-danger"><i class="bx bx-x me-1"></i>Senin Cevabın</span></div>
                            <div class="list-group-item list-group-item-success d-flex justify-content-between align-items-center">B) -3<span class="badge bg-success"><i class="bx bx-check me-1"></i>Doğru Cevap</span></div>
                            <div class="list-group-item">C) 3</div>
                            <div class="list-group-item">D) 13</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#soruDetayModal">Geri</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
include '../partials/footer.php';
?>