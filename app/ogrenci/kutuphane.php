<?php
$page_title = "Kütüphane | E-Mentor Öğrenci Paneli";
include '../partials/header.php';
include '../partials/sidebar.php';
?>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Kütüphane</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="index.php">Ana Sayfa</a></li>
                                    <li class="breadcrumb-item active">Kütüphane</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4 g-3">
                    <div class="col-md-4">
                        <a href="#tab-kazanimlar" class="text-decoration-none" data-bs-toggle="pill" role="tab">
                            <div class="card h-100 shadow-sm border-0 hover-shadow">
                                <div class="card-body text-center">
                                    <div class="avatar-xl mx-auto mb-3"><span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-1"><i class="bx bx-task"></i></span></div>
                                    <h5 class="fw-bold text-dark mb-1">Kazanım Testleri</h5>
                                    <p class="text-muted mb-0">Konu eksiklerini kapat</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="#tab-cikmislar" class="text-decoration-none" data-bs-toggle="pill" role="tab">
                            <div class="card h-100 shadow-sm border-0 hover-shadow">
                                <div class="card-body text-center">
                                    <div class="avatar-xl mx-auto mb-3"><span class="avatar-title bg-warning-subtle text-warning rounded-circle fs-1"><i class="bx bx-question-mark"></i></span></div>
                                    <h5 class="fw-bold text-dark mb-1">Çıkmış Sorular</h5>
                                    <p class="text-muted mb-0">Sınavlara hazırlık yap</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="#tab-materyaller" class="text-decoration-none" data-bs-toggle="pill" role="tab">
                            <div class="card h-100 shadow-sm border-0 hover-shadow">
                                <div class="card-body text-center">
                                    <div class="avatar-xl mx-auto mb-3"><span class="avatar-title bg-success-subtle text-success rounded-circle fs-1"><i class="bx bx-book-open"></i></span></div>
                                    <h5 class="fw-bold text-dark mb-1">Ders Kitapları</h5>
                                    <p class="text-muted mb-0">Kaynaklarını incele</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <ul class="nav nav-pills nav-justified mb-3" role="tablist">
                    <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-kazanimlar" type="button">Kazanım Testleri</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-cikmislar" type="button">Çıkmış Sorular</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-materyaller" type="button">Ders Kitapları</button></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-kazanimlar" role="tabpanel">
                        <div class="row g-3">
                            <div class="col-lg-4 col-md-6">
                                <div class="card border-0 shadow-sm h-100"><div class="card-body d-flex flex-column">
                                        <h6 class="fw-bold text-primary mb-2">Matematik • 7. Sınıf</h6>
                                        <p class="flex-grow-1 mb-3">Oran-orantı konusundaki temel kavramları tanımlar ve günlük hayatta kullanır.</p>
                                        <a href="#" class="btn btn-outline-primary w-100 mt-auto">Teste Başla</a>
                                    </div></div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-cikmislar" role="tabpanel">
                        <div class="row g-3">
                            <div class="col-lg-3 col-sm-6">
                                <div class="card border-0 shadow-sm h-100 text-center"><div class="card-body d-flex flex-column">
                                        <div class="avatar-lg mx-auto mb-3"><span class="avatar-title bg-danger text-white rounded-circle fs-4">2024</span></div>
                                        <h6 class="fw-bold mb-2">LGS Matematik</h6>
                                        <p class="text-muted small flex-grow-1">Tamamı çözümlü PDF</p>
                                        <a href="#" class="btn btn-danger btn-sm mt-auto">İndir</a>
                                    </div></div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-materyaller" role="tabpanel">
                        <div class="row g-3">
                            <div class="col-lg-4 col-md-6">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="bg-primary-subtle d-flex align-items-center justify-content-center" style="height:180px;"><i class="bx bxs-file-pdf fs-1 text-primary"></i></div>
                                    <div class="card-body d-flex flex-column">
                                        <h6 class="fw-bold mb-2">Matematik • Çarpanlar ve Katlar Ders Notu</h6>
                                        <p class="text-muted flex-grow-1">Özet konu anlatımı + örnek sorular (PDF • 6 sayfa)</p>
                                        <a href="#" class="btn btn-outline-primary w-100 mt-auto" download>İndir</a>
                                    </div>
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