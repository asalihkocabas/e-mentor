<?php
session_start();
$_SESSION['user_role'] = 'teacher';
$page_title = "Aşamalı Sonuç Girişi | E-Mentor Öğretmen Paneli";
include '../partials/header.php';
include '../partials/sidebar.php';
?>

    <link href="../assets/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" type="text/css" />
    <style>
        .table th, .table td { padding: 0.6rem; vertical-align: middle; }
        .answer-input { width: 65px; text-align: center; text-transform: uppercase; }
    </style>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Aşamalı Sonuç Girişi</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="index.php">Ana Sayfa</a></li>
                                    <li class="breadcrumb-item active">Sonuç Girişi</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="choices-exam-select" class="form-label">Öncelikle Sonuçları Girilecek Sınavı Seçiniz</label>
                                    <select class="form-control" name="choices-exam-select" id="choices-exam-select">
                                        <option value="">Sınav seçiniz...</option>
                                        <option value="exam1">9. Sınıf - Matematik - 1. Dönem 1. Sınav (5 Soru)</option>
                                        <option value="exam2">10. Sınıf - Fizik - 1. Dönem 2. Sınav (10 Soru)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Aşama 1: Öğrenci Cevapları Girişi</h4>
                                <p class="card-title-desc">Her öğrencinin işaretlediği şıkkı giriniz. (A, B, C, D veya BOŞ)</p>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center">
                                        <thead class="table-light">
                                        <tr><th>Öğrenci No</th><th class="text-start">Adı Soyadı</th><th>S-1</th><th>S-2</th><th>S-3</th><th>S-4</th><th>S-5</th></tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>256</td><td class="text-start">Ahmet Yılmaz</td>
                                            <td><input type="text" class="form-control form-control-sm answer-input"></td>
                                            <td><input type="text" class="form-control form-control-sm answer-input"></td>
                                            <td><input type="text" class="form-control form-control-sm answer-input"></td>
                                            <td><input type="text" class="form-control form-control-sm answer-input"></td>
                                            <td><input type="text" class="form-control form-control-sm answer-input"></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="button" class="btn btn-primary">Sonuçları Hesapla ve Görüntüle</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Aşama 2: Sınav Sonuçları</h4>
                                <p class="card-title-desc">Hesaplama sonrası gösterilecek sonuç tablosu.</p>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped text-center">
                                        <thead class="table-light">
                                        <tr><th>Öğrenci No</th><th class="text-start">Adı Soyadı</th><th>Doğru Sayısı</th><th>Yanlış Sayısı</th><th>Boş Sayısı</th><th>Toplam Puan</th></tr>
                                        </thead>
                                        <tbody>
                                        <tr><td>256</td><td class="text-start">Ahmet Yılmaz</td><td class="text-success fw-bold">4</td><td class="text-danger fw-bold">1</td><td class="text-muted fw-bold">0</td><td class="text-primary fw-bold">75.00</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="button" class="btn btn-success"><i class="bx bx-save me-1"></i> Sonuçları Onayla ve Kaydet</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Choices('#choices-exam-select');
        });
    </script>

<?php
include '../partials/footer.php';
?>