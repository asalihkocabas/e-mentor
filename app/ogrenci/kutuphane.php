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
                                        <p class="flex-grow-1 mb-3">Oran-orantı konusundaki temel kavramları tanımlar.</p>
                                        <a href="#" class="btn btn-outline-primary w-100 mt-auto">Teste Başla</a>
                                    </div></div>
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