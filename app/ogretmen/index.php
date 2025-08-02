<?php
    // Bu sayfanın bir öğretmen sayfası olduğunu belirtmek için session'ı ayarlıyoruz.
    // Gerçek projede bu, giriş işlemi sırasında otomatik olarak yapılacak.
    session_start();
    $_SESSION['user_role'] = 'teacher';

    $page_title = "Ana Sayfa | E-Mentor Öğretmen Paneli";

    // Header, sidebar gibi ortak alanları çağırıyoruz.
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
                <div class="col-xl-5">
                    <div class="card">
                        <div class="card-header"><h4 class="card-title mb-0">En Başarılı Öğrenciler</h4></div>
                        <div class="card-body px-0" data-simplebar style="max-height: 300px;">
                            <div class="px-3">
                                <div class="d-flex align-items-center pb-4">
                                    <div class="avatar-md me-4"><img src="../assets/images/users/avatar-2.jpg" class="img-fluid rounded-circle"></div>
                                    <div class="flex-grow-1">
                                        <h5 class="font-size-15 mb-1"><a href="" class="text-dark">Ayşe Yılmaz</a></h5>
                                        <span class="text-muted">10-A Sınıfı</span>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <span class="badge rounded-pill bg-success-subtle text-success font-size-12 fw-medium">95.0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header"><h4 class="card-title mb-0">Desteğe İhtiyaç Duyanlar</h4></div>
                        <div class="card-body px-0" data-simplebar style="max-height: 300px;">
                            <div class="px-3">
                                <div class="d-flex align-items-center pb-4">
                                    <div class="avatar-md me-4"><img src="../assets/images/users/avatar-3.jpg" class="img-fluid rounded-circle"></div>
                                    <div class="flex-grow-1">
                                        <h5 class="font-size-15 mb-1"><a href="" class="text-dark">Ali Veli</a></h5>
                                        <span class="text-muted">10-A Sınıfı</span>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <span class="badge rounded-pill bg-danger-subtle text-danger font-size-12 fw-medium">55.0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-7">
                    <div class="card">
                        <div class="card-header"><h4 class="card-title mb-0">Yaklaşan Etkinlikler</h4></div>
                        <div class="card-body" data-simplebar style="max-height: 245px;">
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
                                <li class="list-group-item">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3"><div class="avatar-xs"><span class="avatar-title rounded-circle bg-warning-subtle text-warning"><i class="bx bxs-user-detail"></i></span></div></div>
                                        <div class="flex-grow-1">
                                            <h6>Genel Veli Toplantısı</h6>
                                            <p class="text-muted mb-0">25 Ağustos 2025, 18:00</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header"><h4 class="card-title mb-0">Son Duyurular</h4></div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush" data-simplebar style="max-height: 290px;">
                                <a href="#" class="list-group-item list-group-item-action border-0 py-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="badge fs-6 bg-warning bg-opacity-10 text-warning">İdari</span>
                                        <small class="text-muted">1 gün önce</small>
                                    </div>
                                    <h6 class="mb-1">Veli Toplantısı Hakkında</h6>
                                    <small class="text-muted">25 Ağustos 2025 tarihinde yapılacak olan veli toplantısı...</small>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action border-0 py-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="badge fs-6 bg-danger bg-opacity-10 text-danger">Sınav</span>
                                        <small class="text-muted">3 gün önce</small>
                                    </div>
                                    <h6 class="mb-1">Matematik Sınavı Tarihleri</h6>
                                    <small class="text-muted">1. dönem 2. matematik sınavı 15 Ağustos tarihinde...</small>
                                </a>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent text-center">
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