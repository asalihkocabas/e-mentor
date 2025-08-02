<?php
$page_title = "Sınav Takvimi | E-Mentor Öğrenci Paneli";
include '../partials/header.php';
include '../partials/sidebar.php';
?>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Sınav Takvimi</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="index.php">Ana Sayfa</a></li>
                                    <li class="breadcrumb-item active">Sınav Takvimi</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="row justify-content-center">
                            <div class="col-xl-10">
                                <div class="timeline">
                                    <div class="timeline-container">
                                        <div class="timeline-launch">
                                            <div class="timeline-box">
                                                <div class="timeline-text">
                                                    <h3 class="font-size-18">Bugün - <span id="today-date"></span></h3>
                                                    <p class="text-muted mb-0">Sınavların yaklaşıyor, çalışmayı ihmal etme!</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="timeline-continue">
                                            <div class="row timeline-right">
                                                <div class="col-md-6"><div class="timeline-icon"><i class="bx bx-math text-primary h2 mb-0"></i></div></div>
                                                <div class="col-md-6">
                                                    <div class="timeline-box">
                                                        <div class="timeline-date bg-primary text-center rounded">
                                                            <h3 class="text-white mb-0">15</h3>
                                                            <p class="mb-0 text-white-50">Ağu</p>
                                                        </div>
                                                        <div class="event-content">
                                                            <div class="timeline-text">
                                                                <h3 class="font-size-18">Matematik</h3>
                                                                <p class="mb-0 mt-2 pt-1 text-muted">1. Dönem 2. Yazılı</p>
                                                                <button type="button" class="btn btn-primary btn-rounded waves-effect waves-light mt-4">AI ile Konu Tekrarı Yap</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row timeline-left">
                                                <div class="col-md-6">
                                                    <div class="timeline-box">
                                                        <div class="timeline-date bg-primary text-center rounded">
                                                            <h3 class="text-white mb-0">18</h3>
                                                            <p class="mb-0 text-white-50">Ağu</p>
                                                        </div>
                                                        <div class="event-content">
                                                            <div class="timeline-text">
                                                                <h3 class="font-size-18">Türkçe</h3>
                                                                <p class="mb-0 mt-2 pt-1 text-muted">1. Dönem 2. Yazılı</p>
                                                                <button type="button" class="btn btn-primary btn-rounded waves-effect waves-light mt-4">AI ile Konu Tekrarı Yap</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 d-md-block d-none"><div class="timeline-icon"><i class="bx bx-edit text-primary h2 mb-0"></i></div></div>
                                            </div>

                                            <div class="row timeline-right">
                                                <div class="col-md-6"><div class="timeline-icon"><i class="bx bx-vial text-primary h2 mb-0"></i></div></div>
                                                <div class="col-md-6">
                                                    <div class="timeline-box">
                                                        <div class="timeline-date bg-primary text-center rounded">
                                                            <h3 class="text-white mb-0">20</h3>
                                                            <p class="mb-0 text-white-50">Ağu</p>
                                                        </div>
                                                        <div class="event-content">
                                                            <div class="timeline-text">
                                                                <h3 class="font-size-18">Fen Bilimleri</h3>
                                                                <p class="mb-0 mt-2 pt-1 text-muted">1. Dönem 2. Yazılı</p>
                                                                <button type="button" class="btn btn-primary btn-rounded waves-effect waves-light mt-4">AI ile Konu Tekrarı Yap</button>
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
                    </div>
                </div>
            </div>
        </div>
        <script>
            // Sayfa yüklendiğinde bugünün tarihini ilgili alana yazdır
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('today-date').innerText = new Date().toLocaleDateString('tr-TR', { day: 'numeric', month: 'long', year: 'numeric' });
            });
        </script>
    </div>

<?php
include '../partials/footer.php';
?>