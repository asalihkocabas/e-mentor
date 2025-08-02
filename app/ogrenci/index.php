<?php
$page_title = "Ana Sayfa | E-Mentor Öğrenci Paneli";
include '../partials/header.php';
include '../partials/sidebar.php';
?>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Hoş Geldin, Kaan!</h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-4">
                        <div class="card mb-4">
                            <div class="card-body text-center">
                                <img src="https://fotograf.sabis.sakarya.edu.tr/Fotograf/196f69e4eed68a3717e67cc6db180f6d" class="rounded-circle mb-3" width="120" height="120" alt="Profil Fotoğrafı">
                                <h5 class="mb-1">KAAN BUĞRA TAŞ</h5>
                                <p class="text-muted">6/A Sınıfı</p>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between"><span>Okul:</span> <strong>Atatürk Ortaokulu</strong></li>
                                <li class="list-group-item d-flex justify-content-between"><span>Numara:</span> <strong>1234</strong></li>
                                <li class="list-group-item d-flex justify-content-between"><span>Rehber Öğretmen:</span> <strong>Zeynep Güler</strong></li>
                            </ul>
                        </div>

                        <div class="card mb-4">
                            <div class="card-body">
                                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#tab1" role="tab">Devamsızlık</a></li>
                                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab2" role="tab">Ortalama</a></li>
                                </ul>
                                <div class="tab-content mt-3">
                                    <div class="tab-pane active" id="tab1" role="tabpanel">
                                        <div class="row g-3">
                                            <div class="col-6"><div class="p-3 border rounded text-center">Kullanılan<br><span class="badge rounded-pill bg-danger font-size-15 mt-1">3,5</span></div></div>
                                            <div class="col-6"><div class="p-3 border rounded text-center">Kalan<br><span class="badge rounded-pill bg-success font-size-15 mt-1">26,5</span></div></div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab2" role="tabpanel">
                                        <div class="row g-3">
                                            <div class="col-6"><div class="p-3 border rounded text-center">Benim Ort.<br><span class="badge rounded-pill bg-success font-size-15 mt-1">87,5</span></div></div>
                                            <div class="col-6"><div class="p-3 border rounded text-center">Sınıf Ort.<br><span class="badge rounded-pill bg-info font-size-15 mt-1">75,25</span></div></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header"><h4 class="card-title mb-0">Ders Başarı Durumu</h4></div>
                            <div class="card-body" data-simplebar style="max-height: 250px;">
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between"><span>Matematik</span><span class="text-success fw-bold">95.00</span></div>
                                    <div class="progress mt-1" style="height: 6px;"><div class="progress-bar bg-success" style="width: 95%;"></div></div>
                                </div>
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between"><span>Fen Bilimleri</span><span class="text-primary fw-bold">82.50</span></div>
                                    <div class="progress mt-1" style="height: 6px;"><div class="progress-bar bg-primary" style="width: 82.5%;"></div></div>
                                </div>
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between"><span>Sosyal Bilgiler</span><span class="text-warning fw-bold">78.00</span></div>
                                    <div class="progress mt-1" style="height: 6px;"><div class="progress-bar bg-warning" style="width: 78%;"></div></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-header bg-white border-bottom-0 py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Duyurular</h5>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-primary active">Hepsi</button>
                                        <button type="button" class="btn btn-outline-secondary">Okul</button>
                                        <button type="button" class="btn btn-outline-secondary">Ders</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush" data-simplebar style="max-height: 700px;">
                                    <a href="#" class="list-group-item list-group-item-action border-0 py-3">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="badge fs-6 bg-primary bg-opacity-10 text-primary">Matematik</span>
                                            <small class="text-muted">11 Temmuz, 22:12</small>
                                        </div>
                                        <small class="text-muted fs-5">Matematik ödevinizi 5 Mayıs Çarşamba gününe kadar teslim ediniz.</small>
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action border-0 py-3">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="badge fs-6 bg-primary bg-opacity-10 text-primary">Fen Bilimleri</span>
                                            <small class="text-muted">9 Temmuz, 17:38</small>
                                        </div>
                                        <small class="text-muted fs-5">Fen Bilimleri laboratuvar gezisi 12 Mayıs Pazartesi günü gerçekleştirilecektir.</small>
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action border-0 py-3">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="badge fs-6 bg-warning bg-opacity-10 text-warning">İdare</span>
                                            <small class="text-muted">7 Temmuz, 20:14</small>
                                        </div>
                                        <small class="text-muted fs-5">Okul bahçesinde 15 Mayıs Çarşamba bahar şenliği düzenlenecektir.</small>
                                    </a>
                                </div>
                            </div>
                            <div class="card-footer bg-white border-top-0 py-3 text-center">
                                <a href="#" class="text-primary">Tüm Duyuruları Görüntüle</a>
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