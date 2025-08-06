<?php session_start(); ?>
<!doctype html>
<html lang="tr">

<head>
    <meta charset="utf-8" />
    <title>Giriş Seçimi | E-Mentor App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/app.min.css" rel="stylesheet">
</head>

<body>

<div class="d-flex min-vh-100">
    <div class="auth-bg flex-fill position-relative">
        <div class="bg-overlay"></div>
    </div>

    <div class="container position-absolute top-50 start-50 translate-middle">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg">
                    <?php if (isset($_SESSION['auth_error'])): ?>
                        <div class="alert alert-warning text-center mb-4" role="alert">
                            <?= $_SESSION['auth_error']; ?>
                        </div>
                        <?php unset($_SESSION['auth_error']); // Mesajı gösterdikten sonra temizle ?>
                    <?php endif; ?>
                    <div class="card-body text-center py-5">
                        <h2 class="fw-bold mb-3">E-Mentor'a Hoş Geldiniz</h2>
                        <p class="text-muted mb-4">Devam etmek için kullanıcı türünüzü seçin</p>
                        <div class="row g-5">
                            <div class="col-md-4">
                                <a href="giris-ogrenci.php" class="btn btn-primary fs-5 w-100 py-3">
                                    Öğrenci Girişi
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="giris-ogretmen.php" class="btn btn-success fs-5 w-100 py-3">
                                    Öğretmen Girişi
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="#" class="btn btn-secondary fs-5 w-100 py-3 disabled">
                                    Veli Girişi (Yakında)
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>