<?php
// Gerekli dosyaları ve session'ı başlat
include '../config/init.php';
$_SESSION['user_role'] = 'student';
$page_title = "Kütüphane | E-Mentor Öğrenci Paneli";

include '../partials/header.php';
include '../partials/sidebar.php';

// Filtreleme için dersleri çek
$stmt_courses = $pdo->query("SELECT id, name FROM courses ORDER BY name");
$courses = $stmt_courses->fetchAll(PDO::FETCH_ASSOC);
?>

<style>
    /* Kitaplık Kartı Stilleri */
    .book-card { transition: all .2s ease-in-out; border: 1px solid #e0e0e0; }
    .book-card:hover { transform: translateY(-5px); box-shadow: 0 .5rem 1.5rem rgba(0,0,0,.1); }
    .book-cover { height: 200px; display: flex; align-items: center; justify-content: center; font-size: 4rem; color: white; }
    .book-card .card-body { min-height: 160px; }
</style>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row"><div class="col-12"><div class="page-title-box d-sm-flex align-items-center justify-content-between"><h4 class="mb-sm-0 font-size-18">Kütüphane</h4></div></div></div>

            <div class="row">
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Filtrele</h4>
                            <form id="filter-form">
                                <div class="mb-3">
                                    <label class="form-label">İçerik Türü</label>
                                    <select class="form-select" name="type">
                                        <option value="">Tümü</option>
                                        <option>Kazanım Testi</option>
                                        <option>Ders Kitabı</option>
                                        <option>Çıkmış Soru</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Ders</label>
                                    <select class="form-select" name="course">
                                        <option value="">Tümü</option>
                                        <?php foreach($courses as $course): ?>
                                            <option><?= htmlspecialchars($course['name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="button" id="filter-btn" class="btn btn-primary">Filtreyi Uygula</button>
                                    <button type="button" id="clear-filter-btn" class="btn btn-secondary">Filtreleri Temizle</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div id="library-content-area" class="row">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../partials/footer.php'; ?>
<script>
    $(document).ready(function() {
        // Sayfa ilk yüklendiğinde tüm içeriği yükle
        loadLibraryContent();

        $('#filter-btn').on('click', function() {
            loadLibraryContent();
        });

        $('#clear-filter-btn').on('click', function() {
            // Formu sıfırla ve içeriği yeniden yükle
            $('#filter-form')[0].reset();
            loadLibraryContent();
        });

        function loadLibraryContent() {
            const formData = $('#filter-form').serialize();
            const contentArea = $('#library-content-area');

            contentArea.html('<div class="col-12 text-center my-5"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">İçerikler yükleniyor...</p></div>');

            $.ajax({
                url: '../islemler/filtrele-kutuphane.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    contentArea.html(response);
                },
                error: function() {
                    contentArea.html('<div class="col-12"><div class="alert alert-danger">İçerikler yüklenirken bir hata oluştu.</div></div>');
                }
            });
        }
    });
</script>