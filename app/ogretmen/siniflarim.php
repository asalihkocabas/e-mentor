<?php
session_start();
$_SESSION['user_role'] = 'teacher';
$page_title = "Sınıflarım | E-Mentor Öğretmen Paneli";
include '../partials/header.php';
include '../partials/sidebar.php';
?>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Sınıflarım</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="index.php">Ana Sayfa</a></li>
                                    <li class="breadcrumb-item active">Sınıflarım</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-3">
                                        <i class="bx bxs-school"></i>
                                    </span>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-muted fw-medium mb-2">Sınıf</p>
                                        <h4 class="mb-0">10-A Bilişim Teknolojileri</h4>
                                    </div>
                                </div>
                                <div class="mt-4 pt-2">
                                    <div class="d-flex justify-content-between">
                                        <p class="mb-0"><i class="bx bx-user-pin me-2"></i>Öğrenci Sayısı: <span class="fw-bold">28</span></p>
                                        <p class="mb-0"><i class="bx bx-line-chart me-2"></i>Ortalama: <span class="fw-bold text-success">82.5</span></p>
                                    </div>
                                    <a href="sinif-detay.php" class="btn btn-primary w-100 mt-3">Detayları Gör</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-success-subtle text-success rounded-circle fs-3">
                                        <i class="bx bxs-school"></i>
                                    </span>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="text-muted fw-medium mb-2">Sınıf</p>
                                        <h4 class="mb-0">11-C Fen Bilimleri</h4>
                                    </div>
                                </div>
                                <div class="mt-4 pt-2">
                                    <div class="d-flex justify-content-between">
                                        <p class="mb-0"><i class="bx bx-user-pin me-2"></i>Öğrenci Sayısı: <span class="fw-bold">32</span></p>
                                        <p class="mb-0"><i class="bx bx-line-chart me-2"></i>Ortalama: <span class="fw-bold text-danger">68.2</span></p>
                                    </div>
                                    <a href="sinif-detay.php" class="btn btn-primary w-100 mt-3">Detayları Gör</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include '../partials/footer.php'; ?>