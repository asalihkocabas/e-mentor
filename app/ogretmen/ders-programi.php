<?php
    // Bu sayfanın bir öğretmen sayfası olduğunu belirtmek için session'ı ayarlıyoruz.
    session_start();
    $_SESSION['user_role'] = 'teacher';

    $page_title = "Ders Programı | E-Mentor Öğretmen Paneli";

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
                        <h4 class="mb-sm-0 font-size-18">Ders Programı</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="index.php">Ana Sayfa</a></li>
                                <li class="breadcrumb-item active">Ders Programı</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card shadow-sm border-start border-success border-4 h-100">
                        <div class="card-body">
                            <h6 class="text-muted mb-2">Şu anki Ders</h6>
                            <h5 class="text-success fw-bold">Matematik (10-A)</h5>
                            <p class="mb-0">09:00 - 09:40 arası</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card shadow-sm border-start border-warning border-4 h-100">
                        <div class="card-body">
                            <h6 class="text-muted mb-2">Sıradaki Ders</h6>
                            <h5 class="text-warning fw-bold">Matematik (10-A)</h5>
                            <p class="mb-0">09:50 - 10:30 arası</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-md-12 mb-3">
                    <div class="card shadow-sm border-start border-info border-4 h-100">
                        <div class="card-body">
                            <h6 class="text-muted mb-2">Günün Notu</h6>
                            <p class="mb-0">10-A sınıfının matematik sınavı haftaya bugün. Öğrencilere hatırlatma yapmayı unutma!</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4"><i class="bx bx-calendar-week me-2"></i>Haftalık Ders Programı - Matematik</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered text-center align-middle">
                                    <thead class="table-light">
                                    <tr>
                                        <th style="width: 120px;">Saat</th>
                                        <th>Pazartesi</th>
                                        <th>Salı</th>
                                        <th>Çarşamba</th>
                                        <th>Perşembe</th>
                                        <th>Cuma</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr><td>09:00 - 09:40</td><td class="bg-success-subtle">Matematik (10-A)</td><td>Matematik (10-B)</td><td>Matematik (10-C)</td><td>Matematik (9-C)</td><td>Matematik (10-A)</td></tr>
                                    <tr><td>09:50 - 10:30</td><td class="bg-success-subtle">Matematik (10-A)</td><td>Matematik (10-B)</td><td>Matematik (10-C)</td><td>Matematik (9-C)</td><td>Matematik (10-A)</td></tr>
                                    <tr><td>10:40 - 11:20</td><td>Boş</td><td>Matematik (10-C)</td><td>Boş</td><td>Matematik (10-B)</td><td>Matematik (9-C)</td></tr>
                                    <tr><td>11:30 - 12:10</td><td>Matematik (9-C)</td><td>Boş</td><td>Matematik (10-A)</td><td>Matematik (10-B)</td><td>Boş</td></tr>
                                    <tr><td colspan="6" class="bg-light fw-bold">ÖĞLE ARASI</td></tr>
                                    <tr><td>12:40 - 13:20</td><td>Matematik (10-B)</td><td>Boş</td><td>Matematik (10-B)</td><td>Zümre Toplantısı</td><td>Boş</td></tr>
                                    <tr><td>13:30 - 14:10</td><td>Matematik (10-B)</td><td>Matematik (10-A)</td><td>Matematik (10-A)</td><td>Boş</td><td>Matematik (10-C)</td></tr>
                                    <tr><td>14:20 - 15:00</td><td>Boş</td><td>Matematik (10-A)</td><td>Boş</td><td>Boş</td><td>Matematik (10-C)</td></tr>
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

<?php
    include '../partials/footer.php';
?>