<?php
$page_title = "Ödevlerim | E-Mentor Öğrenci Paneli";
include '../partials/header.php';
include '../partials/sidebar.php';
?>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Ödevlerim</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="index.php">Ana Sayfa</a></li>
                                    <li class="breadcrumb-item active">Ödevlerim</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100"><div class="card-body d-flex align-items-center">
                                <div class="avatar-lg bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-3"><i class="bx bx-task fs-2"></i></div>
                                <div><p class="mb-1 text-muted">Toplam Ödevim</p><h4 class="mb-0">12</h4></div>
                            </div></div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100"><div class="card-body d-flex align-items-center">
                                <div class="avatar-lg bg-warning-subtle text-warning rounded-circle d-flex align-items-center justify-content-center me-3"><i class="bx bx-time-five fs-2"></i></div>
                                <div><p class="mb-1 text-muted">Yaklaşan Teslim</p><h4 class="mb-0">3</h4></div>
                            </div></div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100"><div class="card-body d-flex align-items-center">
                                <div class="avatar-lg bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center me-3"><i class="bx bx-check-circle fs-2"></i></div>
                                <div><p class="mb-1 text-muted">Tamamladıklarım</p><h4 class="mb-0">9</h4></div>
                            </div></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <ul class="nav nav-pills" role="tablist">
                                    <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-yapilacaklar" type="button">Yapılacaklar</button></li>
                                    <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-teslim-edilenler" type="button">Teslim Ettiklerim</button></li>
                                    <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-degerlendirilenler" type="button">Değerlendirilenler</button></li>
                                </ul>
                            </div>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tab-yapilacaklar" role="tabpanel">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table align-middle table-nowrap mb-0">
                                                <thead class="table-light"><tr><th>Ödev Konusu</th><th>Ders</th><th>Son Teslim Tarihi</th><th>Durum</th><th class="text-center">İşlem</th></tr></thead>
                                                <tbody>
                                                <tr>
                                                    <td><strong>Üslü Sayılar Çalışma Notu</strong></td>
                                                    <td>Matematik</td>
                                                    <td>15.08.2025 <span class="badge bg-warning-subtle text-warning ms-1">2 gün kaldı</span></td>
                                                    <td><span class="badge rounded-pill bg-secondary-subtle text-secondary">Bekleniyor</span></td>
                                                    <td class="text-center"><a href="#" class="btn btn-sm btn-primary">Ödevi Görüntüle ve Yap</a></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab-teslim-edilenler" role="tabpanel">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table align-middle table-nowrap mb-0">
                                                <thead class="table-light"><tr><th>Ödev Konusu</th><th>Ders</th><th>Teslim Edilen Tarih</th><th>Durum</th></tr></thead>
                                                <tbody>
                                                <tr>
                                                    <td><strong>Köklü Sayılar Testi</strong></td>
                                                    <td>Matematik</td>
                                                    <td>01.08.2025</td>
                                                    <td><span class="badge rounded-pill bg-info-subtle text-info">Öğretmen Değerlendirmesi Bekleniyor</span></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab-degerlendirilenler" role="tabpanel">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table align-middle table-nowrap mb-0">
                                                <thead class="table-light"><tr><th>Ödev Konusu</th><th>Ders</th><th>Puan</th><th>Öğretmen Yorumu</th><th class="text-center">İşlem</th></tr></thead>
                                                <tbody>
                                                <tr>
                                                    <td><strong>Fotosentez Sunumu</strong></td>
                                                    <td>Fen Bilimleri</td>
                                                    <td><span class="badge bg-success font-size-13">Başarılı</span></td>
                                                    <td><span class="text-muted fst-italic">"Sunumun harikaydı, tebrikler!"</span></td>
                                                    <td class="text-center"><a href="#" class="btn btn-sm btn-light">Sonucu Gör</a></td>
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
        </div>
    </div>

<?php
include '../partials/footer.php';
?>