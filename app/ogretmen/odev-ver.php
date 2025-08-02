<?php
session_start();
$_SESSION['user_role'] = 'teacher';
$page_title = "Yapay Zeka Destekli Ödev Atama | E-Mentor Öğretmen Paneli";
include '../partials/header.php';
include '../partials/sidebar.php';
?>

    <link href="../assets/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="../assets/libs/flatpickr/flatpickr.min.css">

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Yapay Zeka Destekli Ödev Atama</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="index.php">Ana Sayfa</a></li>
                                    <li class="breadcrumb-item active">Ödev Ata</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Adım 1: Analiz Yapılacak Sınavı Seçin</h4>
                                <p class="card-title-desc">Öğrenci eksikliklerini belirlemek için bir sınav seçin.</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <select class="form-control" name="choices-exam-select" id="choices-exam-select">
                                            <option value="">Sınav seçiniz...</option>
                                            <option value="1">9. Sınıf - Matematik - 1. Dönem 1. Sınav</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <button class="btn btn-primary"><i class="bx bx-search-alt me-1"></i> Analiz Et ve Öğrencileri Listele</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Adım 2: Öğrenci Analizi ve Ödev Atama</h4>
                                <p class="card-title-desc">Her öğrencinin eksik olduğu kazanımları görüntüleyin ve yapay zeka ile ödev oluşturun.</p>
                            </div>
                            <div class="card-body">
                                <div class="accordion" id="studentAccordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                                <img src="../assets/images/users/avatar-2.jpg" alt="" class="avatar-xs rounded-circle me-2">
                                                Ayşe Yılmaz - <span class="text-danger ms-1">3 Zayıf Kazanım Tespit Edildi</span>
                                                <span class="ms-auto badge bg-warning">Sınav Notu: 65</span>
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#studentAccordion">
                                            <div class="accordion-body">
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h6 class="mb-1">M.9.1.2.1</h6>
                                                            <p class="mb-0 text-muted">Üslü ifadeleri içeren denklemleri çözer.</p>
                                                        </div>
                                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#assignHwModal"><i class="bx bxs-magic-wand me-1"></i> AI ile Ödev Oluştur</button>
                                                    </li>
                                                </ul>
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

        <div class="modal fade" id="assignHwModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">✨ Yapay Zeka ile Ödev Oluştur: <span class="text-primary">M.9.1.2.1</span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted">İstediğiniz içerik türünü seçip "Oluştur" butonuna basın. Oluşturulan içeriği doğrudan öğrenciye atayabilirsiniz.</p>
                        <div class="row align-items-end">
                            <div class="col-md-8">
                                <label class="form-label">İçerik Türü</label>
                                <div class="d-flex flex-wrap gap-3">
                                    <div class="form-check"><input class="form-check-input" type="radio" name="ai-content-type" id="ai-study-note" checked><label class="form-check-label" for="ai-study-note">Çalışma Notu</label></div>
                                    <div class="form-check"><input class="form-check-input" type="radio" name="ai-content-type" id="ai-questions"><label class="form-check-label" for="ai-questions">Örnek Soru</label></div>
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                <button type="button" class="btn btn-info"><i class="bx bxs-magic-wand me-1"></i> Oluştur</button>
                            </div>
                        </div>
                        <div class="ai-output-container bg-light p-3 rounded mt-3">
                            <h6 class="text-primary">Yapay Zeka Çıktısı:</h6>
                            <p class="font-size-13 text-muted mb-2"><i>(Örnek Çalışma Notu)</i></p>
                            <p><strong>Üslü İfadeler:</strong> Bir sayının kendisi ile tekrarlı çarpımının kısa bir şekilde gösterilmesidir...</p>
                        </div>
                        <hr class="my-4">
                        <div class="row">
                            <div class="col-md-6"><label for="due-date" class="form-label">Son Teslim Tarihi</label><input type="text" class="form-control" id="due-date" placeholder="Tarih seçin..."></div>
                            <div class="col-md-12 mt-3"><label for="teacher-note" class="form-label">Öğretmen Notu (İsteğe Bağlı)</label><textarea class="form-control" id="teacher-note" rows="2" placeholder="Öğrenciye özel bir not ekleyebilirsiniz..."></textarea></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                        <button type="button" class="btn btn-primary"><i class="bx bx-send me-1"></i> Oluşturulan Ödevi Ata</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="../assets/libs/flatpickr/flatpickr.min.js"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/tr.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new Choices('#choices-exam-select');
            flatpickr('#due-date', {
                enableTime: true,
                dateFormat: "d.m.Y H:i",
                locale: "tr"
            });
        });
    </script>

<?php
include '../partials/footer.php';
?>