<?php
session_start();
$_SESSION['user_role'] = 'teacher';
$page_title = "Ana Sayfa | E-Mentor Öğretmen Paneli";
include '../partials/header.php';
include '../partials/sidebar.php';
?>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Hoş Geldiniz!</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item active">Ana Sayfa</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <span class="text-muted mb-3 lh-1 d-block">Toplam Öğrenci</span>
                                        <h4 class="mb-3"><span class="counter-value" data-target="120">0</span></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <span class="text-muted mb-3 lh-1 d-block">Genel Başarı Oranı</span>
                                        <h4 class="mb-3">%<span class="counter-value" data-target="75.5">0</span></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <span class="text-muted mb-3 lh-1 d-block">Aktif Ödev Sayısı</span>
                                        <h4 class="mb-3"><span class="counter-value" data-target="4">0</span></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card card-h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <span class="text-muted mb-3 lh-1 d-block">Bugünkü Ders Saati</span>
                                        <h4 class="mb-3"><span class="counter-value" data-target="6">0</span></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header align-items-center d-flex"><h4 class="card-title mb-0 flex-grow-1">En Başarılı Öğrencileriniz</h4></div>
                            <div class="card-body px-0" data-simplebar style="max-height: 386px;">
                                <div class="px-3">
                                    <div class="d-flex align-items-center pb-4">
                                        <div class="avatar-md me-4"><img src="../assets/images/users/avatar-2.jpg" class="img-fluid rounded-circle"></div>
                                        <div class="flex-grow-1">
                                            <h5 class="font-size-15 mb-1"><a href="" class="text-dark">Ayşe Yılmaz</a></h5>
                                            <span class="text-muted">10-A Sınıfı</span>
                                        </div>
                                        <div class="flex-shrink-0"><span class="badge rounded-pill bg-success-subtle text-success font-size-12 fw-medium">95.0</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header align-items-center d-flex"><h4 class="card-title mb-0 flex-grow-1">Desteğe İhtiyaç Duyanlar</h4></div>
                            <div class="card-body px-0" data-simplebar style="max-height: 386px;">
                                <div class="px-3">
                                    <div class="d-flex align-items-center pb-4">
                                        <div class="avatar-md me-4"><img src="../assets/images/users/avatar-3.jpg" class="img-fluid rounded-circle"></div>
                                        <div class="flex-grow-1">
                                            <h5 class="font-size-15 mb-1"><a href="" class="text-dark">Ali Veli</a></h5>
                                            <span class="text-muted">10-A Sınıfı</span>
                                        </div>
                                        <div class="flex-shrink-0"><span class="badge rounded-pill bg-danger-subtle text-danger font-size-12 fw-medium">55.0</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header"><h4 class="card-title mb-0">Yaklaşan Etkinlikler</h4></div>
                            <div class="card-body" data-simplebar style="max-height: 386px;">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3"><div class="avatar-xs"><span class="avatar-title rounded-circle bg-danger-subtle text-danger"><i class="bx bx-calendar-event"></i></span></div></div>
                                            <div class="flex-grow-1">
                                                <h6>10-A Matematik Sınavı</h6>
                                                <p class="text-muted mb-0">15 Ağustos 2025, 10:00</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="../assets/libs/apexcharts/apexcharts.min.js"></script>
    <script src="../assets/js/pages/dashboard.init.js"></script>

<?php
include '../partials/footer.php';
?>