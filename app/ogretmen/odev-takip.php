<?php
session_start();
$_SESSION['user_role'] = 'teacher';
$page_title = "Ödev Takip Ekranı | E-Mentor Öğretmen Paneli";
include '../partials/header.php';
include '../partials/sidebar.php';
?>

    <link href="../assets/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" type="text/css" />

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Ödev Takip Ekranı</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="index.php">Ana Sayfa</a></li>
                                    <li class="breadcrumb-item active">Ödev Takibi</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row gx-3 gy-2 align-items-end">
                                    <div class="col-sm-3">
                                        <label class="form-label">Sınıf</label>
                                        <select class="form-control" id="filter-class">
                                            <option value="">Tüm Sınıflar</option>
                                            <option value="9A">9-A</option>
                                            <option value="10B">10-B</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label">Öğrenci</label>
                                        <select class="form-control" id="filter-student">
                                            <option value="">Tüm Öğrenciler</option>
                                            <option value="ayse">Ayşe Yılmaz</option>
                                            <option value="ali">Ali Veli</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="form-label">Durum</label>
                                        <select class="form-control" id="filter-status">
                                            <option value="">Tümü</option>
                                            <option value="bekleniyor">Teslim Bekleniyor</option>
                                            <option value="teslim_edildi">Teslim Edildi</option>
                                            <option value="degerlendirildi">Değerlendirildi</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary w-100"><i class="bx bx-filter-alt me-1"></i> Filtrele</button>
                                    </div>
                                </div>
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
                                        <tr>
                                            <th>Öğrenci</th>
                                            <th>Ödev İçeriği (Kazanım)</th>
                                            <th>Atanma Tarihi</th>
                                            <th>Teslim Tarihi</th>
                                            <th>Durum</th>
                                            <th class="text-center">İşlemler</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><img src="../assets/images/users/avatar-2.jpg" alt="" class="avatar-xs rounded-circle me-2"><span class="fw-bold">Ayşe Yılmaz</span> <small class="text-muted">(10-A)</small></td>
                                            <td><p class="mb-0 fw-medium">M.9.1.2.1</p><small class="text-muted">Üslü ifadeleri içeren denklemleri çözer.</small></td>
                                            <td>02.08.2025</td>
                                            <td>05.08.2025</td>
                                            <td><span class="badge bg-info-subtle text-info">Teslim Edildi</span></td>
                                            <td class="text-center"><button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#gradeHwModal"><i class="bx bx-edit me-1"></i>Değerlendir</button></td>
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

        <div class="modal fade" id="gradeHwModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ödev Değerlendirme: <span class="text-primary">Ayşe Yılmaz</span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h6>Ödev Bilgileri</h6>
                        <p class="text-muted mb-1"><strong>Kazanım:</strong> M.9.1.2.1 - Üslü ifadeleri içeren denklemleri çözer.</p>
                        <p class="text-muted"><strong>Teslim Tarihi:</strong> 05.08.2025</p>
                        <hr>
                        <h6>Öğrencinin Çalışması</h6>
                        <div class="student-work bg-light p-3 rounded mb-4">
                            <h6 class="text-primary">Yapay Zeka Tarafından Oluşturulan Çalışma Notu</h6>
                            <p><strong>Üslü İfadeler:</strong> Bir sayının kendisi ile tekrarlı çarpımının kısa bir şekilde gösterilmesidir...</p>
                            <p><em>(Öğrenci bu metni okudu ve anladığını belirtti.)</em></p>
                        </div>
                        <hr>
                        <h6>Değerlendirme</h6>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Sonuç</label>
                                <div class="d-flex flex-wrap gap-3">
                                    <div class="form-check"><input class="form-check-input" type="radio" name="grade-status" id="grade-success" checked><label class="form-check-label" for="grade-success">Başarılı / Tamamlandı</label></div>
                                    <div class="form-check"><input class="form-check-input" type="radio" name="grade-status" id="grade-fail"><label class="form-check-label" for="grade-fail">Tekrar Gerekli</label></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="teacher-comment" class="form-label">Öğretmen Yorumu</label>
                                <textarea class="form-control" id="teacher-comment" rows="3" placeholder="Öğrenciye geri bildirim ve yorumlarınızı yazın..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                        <button type="button" class="btn btn-primary"><i class="bx bx-check-double me-1"></i> Değerlendirmeyi Kaydet</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new Choices('#filter-class');
            new Choices('#filter-student');
            new Choices('#filter-status');
        });
    </script>

<?php
include '../partials/footer.php';
?>