<?php session_start(); // Hata mesajını alabilmek için session'ı başlat ?>
<!doctype html>
<html lang="tr">

<head>

    <meta charset="utf-8" />
    <title>Öğretmen Girişi | E-Mentor Sistemi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="E-Mentor Sistemi Öğretmen Giriş Sayfası" name="description" />
    <meta content="Themesbrand" name="author" />
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <link rel="stylesheet" href="assets/css/preloader.min.css" type="text/css" />

    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body>

<div class="auth-page">
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-xxl-4 col-lg-5 col-md-6">
                <div class="auth-full-page-content d-flex p-sm-5 p-4">
                    <div class="w-100">
                        <div class="d-flex flex-column h-100">
                            <div class="mb-4 mb-md-5 text-center">
                                <a href="ogretmen/index.php" class="d-block auth-logo">
                                    <img src="assets/images/logo-sm.svg" alt="" height="28"> <span class="logo-txt">E-Mentor</span>
                                </a>
                            </div>
                            <div class="auth-content my-auto">
                                <div class="text-center">
                                    <h5 class="mb-0">Tekrar Hoş Geldiniz!</h5>
                                    <p class="text-muted mt-2">Öğretmen paneline devam etmek için oturum açın.</p>
                                </div>
                                <form class="mt-4 pt-2" action="islemler/giris-yap.php" method="POST">

                                    <?php if (isset($_SESSION['login_error'])): ?>
                                        <div class="alert alert-danger text-center mb-4" role="alert">
                                            <?= $_SESSION['login_error']; ?>
                                        </div>
                                        <?php unset($_SESSION['login_error']); // Mesajı gösterdikten sonra temizle ?>
                                    <?php endif; ?>

                                    <div class="form-floating form-floating-custom mb-4">
                                        <input type="text" class="form-control" name="tc_kimlik" placeholder="T.C. Kimlik No" required>
                                        <label>T.C. Kimlik Numarası</label>
                                    </div>
                                    <div class="form-floating form-floating-custom mb-4 auth-pass-inputgroup">
                                        <input type="password" class="form-control pe-5" name="password" placeholder="Şifrenizi Girin" required>
                                        <label>Parola</label>
                                    </div>
                                    <input type="hidden" name="role" value="teacher">
                                    <div class="mb-3">
                                        <button class="btn btn-primary w-100" type="submit">Giriş Yap</button>
                                    </div>
                                </form>
                            </div>
                            <div class="mt-4 mt-md-5 text-center">
                                <p class="mb-0">© <script>document.write(new Date().getFullYear())</script> E-Mentor.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-8 col-lg-7 col-md-6">
                <div class="auth-bg pt-md-5 p-4 d-flex">
                    <div class="bg-overlay"></div>
                    <div class="w-100">
                        <div class="d-flex h-100 flex-column justify-content-center">
                            <div class="p-4">
                                <div class="row justify-content-center">
                                    <div class="col-lg-7">
                                        <div class="text-center">
                                            <h4 class="mb-3 text-white">"Bir çocuğa öğretilen her şey, onun keşfedeceği bir şeyden çalınmıştır."</h4>
                                            <p class="text-white-50 mb-0">Jean Piaget</p>
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

<script src="assets/libs/jquery/jquery.min.js"></script>
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/libs/feather-icons/feather.min.js"></script>
<script src="assets/libs/pace-js/pace.min.js"></script>
<script src="assets/js/pages/pass-addon.init.js"></script>
<script src="assets/js/pages/feather-icon.init.js"></script>
</body>

</html>