<?php
session_start();
$_SESSION['user_role'] = 'teacher';
$page_title = "Sınıf Detayları | E-Mentor Öğretmen Paneli";
include '../partials/header.php';
include '../partials/sidebar.php';
?>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">10-A Sınıf Detayları</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="index.php">Ana Sayfa</a></li>
                                    <li class="breadcrumb-item"><a href="siniflarim.php">Sınıflarım</a></li>
                                    <li class="breadcrumb-item active">Sınıf Detayı</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Öğrenci Listesi</h4>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle table-nowrap">
                                        <thead class="table-light">
                                        <tr><th>Öğrenci No</th><th>Adı Soyadı</th><th>Son Sınav Puanı</th><th>Devamsızlık (Gün)</th><th class="text-center">İşlemler</th></tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>101</td>
                                            <td><img src="../assets/images/users/avatar-2.jpg" alt="" class="avatar-xs rounded-circle me-2"> <a href="#" class="text-body fw-bold">Ayşe Yılmaz</a></td>
                                            <td><span class="badge bg-success-subtle text-success p-2">95.00</span></td>
                                            <td>2</td>
                                            <td class="text-center"><a href="#" class="btn btn-primary btn-sm">Detay</a></td>
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
    </div>

<?php include '../partials/footer.php'; ?>