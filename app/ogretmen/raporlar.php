<?php
session_start();
$_SESSION['user_role'] = 'teacher';
$page_title = "Sınav Raporları | E-Mentor Öğretmen Paneli";
include '../partials/header.php';
include '../partials/sidebar.php';
?>

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
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                        <tr><th>Sınav Adı</th><th>Tarih</th><th>Durum</th><th class="text-center">İşlemler</th></tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>9. Sınıf - Matematik - 1. Dönem 1. Sınav</td>
                                            <td>01.10.2024, 10:00</td>
                                            <td><span class="badge font-size-12 p-2 bg-success-subtle text-success">Tamamlandı</span></td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary btn-sm"><i class="bx bx-bar-chart-alt-2"></i></button>
                                                <button type="button" class="btn btn-info btn-sm"><i class="bx bx-key"></i></button>
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
    </div>

<?php include '../partials/footer.php'; ?>