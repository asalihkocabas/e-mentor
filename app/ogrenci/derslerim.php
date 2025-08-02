<?php
$page_title = "Derslerim | E-Mentor Öğrenci Paneli";
include '../partials/header.php';
include '../partials/sidebar.php';
?>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Derslerim</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="index.php">Ana Sayfa</a></li>
                                    <li class="breadcrumb-item active">Derslerim</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row gx-3 gy-2 align-items-end">
                                    <div class="col-sm-6">
                                        <label for="search-course" class="form-label">Ders Ara</label>
                                        <input type="text" id="search-course" class="form-control" placeholder="Ders adı veya öğretmen adıyla ara...">
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label">Dönem</label>
                                        <select class="form-select">
                                            <option>Tüm Dönemler</option>
                                            <option>1. Dönem</option>
                                            <option>2. Dönem</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary w-100"><i class="bx bx-search-alt me-1"></i> Filtrele</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-lg-4">
                        <div class="card border-0 shadow-sm position-relative">
                            <span class="position-absolute top-0 start-0 w-100" style="height:4px;background:#556ee6;"></span>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h4 class="fw-bold mb-1"><a href="ders-detay.php" class="text-dark text-decoration-none stretched-link">MATEMATİK</a></h4>
                                        <small class="text-muted fs-6"><strong>Öğrt. Ahmet Salih KOCABAŞ</strong></small>
                                    </div>
                                    <span class="badge bg-danger rounded-pill">2</span>
                                </div>
                                <div class="mt-3 small">
                                    <div class="text-muted fs-6">Bu Hafta: <strong>Üslü Sayılar</strong></div>
                                    <div class="progress mt-2" style="height:6px;"><div class="progress-bar bg-primary" style="width:40%"></div></div>
                                    <div class="d-flex justify-content-between mt-2 fs-6"><span>İlerleme</span><span>%40</span></div>
                                    <div class="mt-2 fs-6">Ortalama: <strong class="text-success">87.5</strong></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="card border-0 shadow-sm position-relative">
                            <span class="position-absolute top-0 start-0 w-100" style="height:4px;background:#34c38f;"></span>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h4 class="fw-bold mb-1"><a href="ders-detay.php" class="text-dark text-decoration-none stretched-link">FEN BİLİMLERİ</a></h4>
                                        <small class="text-muted fs-6"><strong>Öğrt. Zeynep GÜLER</strong></small>
                                    </div>
                                </div>
                                <div class="mt-3 small">
                                    <div class="text-muted fs-6">Bu Hafta: <strong>Hücre ve Bölünmeler</strong></div>
                                    <div class="progress mt-2" style="height:6px;"><div class="progress-bar bg-success" style="width:65%"></div></div>
                                    <div class="d-flex justify-content-between mt-2 fs-6"><span>İlerleme</span><span>%65</span></div>
                                    <div class="mt-2 fs-6">Ortalama: <strong class="text-primary">82.0</strong></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <div class="card border-0 shadow-sm position-relative">
                            <span class="position-absolute top-0 start-0 w-100" style="height:4px;background:#f1b44c;"></span>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h4 class="fw-bold mb-1"><a href="ders-detay.php" class="text-dark text-decoration-none stretched-link">SOSYAL BİLGİLER</a></h4>
                                        <small class="text-muted fs-6"><strong>Öğrt. Fatma KAYA</strong></small>
                                    </div>
                                    <span class="badge bg-danger rounded-pill">1</span>
                                </div>
                                <div class="mt-3 small">
                                    <div class="text-muted fs-6">Bu Hafta: <strong>Milli Mücadele</strong></div>
                                    <div class="progress mt-2" style="height:6px;"><div class="progress-bar bg-warning" style="width:78%"></div></div>
                                    <div class="d-flex justify-content-between mt-2 fs-6"><span>İlerleme</span><span>%78</span></div>
                                    <div class="mt-2 fs-6">Ortalama: <strong class="text-danger">68.7</strong></div>
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