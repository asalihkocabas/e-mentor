<?php
    session_start();
    $_SESSION['user_role'] = 'teacher';
    $page_title = "Toplu Dosya Yükleme | E-Mentor Öğretmen Paneli";
    include '../partials/header.php';
    include '../partials/sidebar.php';
?>

<link href="../assets/libs/dropzone/min/dropzone.min.css" rel="stylesheet" type="text/css" />
<link href="../assets/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" type="text/css" />

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Toplu Dosya Yükleme</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="index.php">Ana Sayfa</a></li>
                                <li class="breadcrumb-item active">Dosya Yükleme</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Aşama 1: Yüklenecek Dosya Türünü Seçin</h4>
                            <p class="card-title-desc">Yükleyeceğiniz dosya türüne göre ilgili alanlar aşağıda belirecektir.</p>
                            <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#kazanim-tab" role="tab">
                                        <span class="d-block d-sm-none"><i class="bx bx-task font-size-18"></i></span>
                                        <span class="d-none d-sm-block"><i class="bx bx-task me-2"></i> Kazanım Testleri</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#kitap-tab" role="tab">
                                        <span class="d-block d-sm-none"><i class="bx bx-book-open font-size-18"></i></span>
                                        <span class="d-none d-sm-block"><i class="bx bx-book-open me-2"></i> Ders Kitapları</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#soru-tab" role="tab">
                                        <span class="d-block d-sm-none"><i class="bx bx-question-mark font-size-18"></i></span>
                                        <span class="d-none d-sm-block"><i class="bx bx-question-mark me-2"></i> Çıkmış Sorular</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-content pt-4">
                <div class="tab-pane active" id="kazanim-tab" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Aşama 2: Kazanım Testlerini Yükleyin</h4>
                            <p class="card-title-desc">Dosyaları sürükleyip bırakın ve ardından listeden her dosya için ilgili ders ve kazanımı seçin.</p>
                        </div>
                        <div class="card-body">
                            <form action="#" class="dropzone mb-4">
                                <div class="fallback">
                                    <input name="file" type="file" multiple="multiple">
                                </div>
                                <div class="dz-message needsclick">
                                    <div class="mb-3"><i class="display-4 text-muted bx bx-cloud-upload"></i></div>
                                    <h5>Dosyaları buraya sürükleyin veya yüklemek için tıklayın.</h5>
                                </div>
                            </form>
                            <h5 class="font-size-16 mt-4">Aşama 3: Yüklenecek Dosyaları Düzenleyin</h5>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                </table>
                            </div>
                            <div class="text-center mt-4">
                                <button type="button" class="btn btn-primary"><i class="bx bx-upload me-1"></i> Tümünü Yükle</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="kitap-tab" role="tabpanel">
                </div>
                <div class="tab-pane" id="soru-tab" role="tabpanel">
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../assets/libs/dropzone/min/dropzone.min.js"></script>
<script src="../assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>

<?php
    include '../partials/footer.php';
?>