<?php
    $page_title = "Ders Programım | E-Mentor Öğrenci Paneli";
    include '../partials/header.php';
    include '../partials/sidebar.php';
?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Ders Programım</h4>
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
                            <h5 class="text-success fw-bold">Beden Eğitimi</h5>
                            <p class="mb-0">10:40 - 11:20 arası</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card shadow-sm border-start border-warning border-4 h-100">
                        <div class="card-body">
                            <h6 class="text-muted mb-2">Sıradaki Ders</h6>
                            <h5 class="text-warning fw-bold">Fen Bilimleri</h5>
                            <p class="mb-0">11:30 - 12:10 arası</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-12 mb-3">
                    <div class="card shadow-sm border-start border-info border-4 h-100">
                        <div class="card-body">
                            <h6 class="text-muted mb-2">Günün Notu</h6>
                            <p class="mb-0">Bugün Beden Eğitimi dersi için spor kıyafetlerini getirmeyi unutma!</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4"><i class="bx bx-calendar-week me-2"></i>Haftalık Ders Programı</h4>
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
                                    <tr><td>09:00 - 09:40</td><td class="bg-light text-muted opacity-75">Türkçe</td><td class="bg-light text-muted opacity-75">Matematik</td><td>Fen Bilimleri</td><td>Sosyal Bilgiler</td><td>İngilizce</td></tr>
                                    <tr><td>09:50 - 10:30</td><td class="bg-light text-muted opacity-75">Türkçe</td><td class="bg-light text-muted opacity-75">Matematik</td><td>Fen Bilimleri</td><td>Sosyal Bilgiler</td><td>İngilizce</td></tr>
                                    <tr><td>10:40 - 11:20</td><td class="bg-light text-muted opacity-75">Din Kültürü</td><td class="bg-success-subtle fw-bold">Beden Eğitimi</td><td>Görsel Sanatlar</td><td>Müzik</td><td>Matematik</td></tr>
                                    <tr><td>11:30 - 12:10</td><td class="bg-light text-muted opacity-75">Bilişim Teknolojileri</td><td class="bg-warning-subtle">Fen Bilimleri</td><td>Türkçe</td><td>İngilizce</td><td>Sosyal Bilgiler</td></tr>
                                    <tr><td colspan="6" class="bg-light fw-bold">ÖĞLE ARASI</td></tr>
                                    <tr><td>12:40 - 13:20</td><td class="bg-light text-muted opacity-75">Matematik</td><td>Görsel Sanatlar</td><td>Türkçe</td><td>Fen Bilimleri</td><td>Beden Eğitimi</td></tr>
                                    <tr><td>13:30 - 14:10</td><td class="bg-light text-muted opacity-75">Sosyal Bilgiler</td><td>İngilizce</td><td>Din Kültürü</td><td>Türkçe</td><td>Fen Bilimleri</td></tr>
                                    <tr><td>14:20 - 15:00</td><td class="bg-light text-muted opacity-75">İngilizce</td><td>Matematik</td><td>Bilişim Teknolojileri</td><td>Beden Eğitimi</td><td>Türkçe</td></tr>
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