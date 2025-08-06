<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// config/init.php'yi burada çağırmamıza gerek yok çünkü her sayfa onu header'dan önce çağırıyor.
// Ancak helpers.php'yi burada çağırmak güvenli olabilir.
if (file_exists(__DIR__ . '/../config/helpers.php')) {
    require_once __DIR__ . '/../config/helpers.php';
}


// --- GÜVENLİK KONTROLLERİ ---

// 1. Giriş yapılmış mı?
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    $_SESSION['auth_error'] = "Lütfen devam etmek için giriş yapın.";
    // Not: Bu header'dan önce hiçbir HTML veya echo olmamalıdır.
    header("Location: ../index.php");
    exit;
}

// 2. Doğru rolde mi?
$folder = basename(dirname($_SERVER['PHP_SELF'])); // 'ogrenci' veya 'ogretmen'
$user_role = $_SESSION['user_role'];

// Eğer bir öğrenci, öğretmen sayfasına girmeye çalışıyorsa...
if ($folder == 'ogretmen' && $user_role != 'teacher') {
    $_SESSION['auth_error'] = "Bu sayfaya erişim yetkiniz bulunmamaktadır.";
    header("Location: ../ogrenci/index.php"); // Onu öğrenci paneline yönlendir.
    exit;
}

// Eğer bir öğretmen, öğrenci sayfasına girmeye çalışıyorsa...
if ($folder == 'ogrenci' && $user_role != 'student') {
    $_SESSION['auth_error'] = "Bu sayfaya erişim yetkiniz bulunmamaktadır.";
    header("Location: ../ogretmen/index.php"); // Onu öğretmen paneline yönlendir.
    exit;
}

// Avatar için gerekli verileri al
$user_full_name = $_SESSION['full_name'] ?? 'Kullanıcı';
$avatar = get_avatar_data($user_full_name);
?>

<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8" />
    <title><?= $page_title ?? 'E-Mentor Sistemi' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/images/favicon.ico">
    <link rel="stylesheet" href="../assets/css/preloader.min.css" type="text/css" />
    <link href="../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
</head>
<body data-topbar="dark">
<div id="layout-wrapper">
    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <div class="navbar-brand-box">
                    <a href="index.php" class="logo logo-light">
                        <span class="logo-sm"><img src="../assets/images/logo-sm.svg" alt="" height="30"></span>
                        <span class="logo-lg"><img src="../assets/images/logo-sm.svg" alt="" height="24"> <span class="logo-txt">E-Mentor</span></span>
                    </a>
                </div>
                <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn"><i class="fa fa-fw fa-bars"></i></button>
            </div>
            <div class="d-flex">
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item bg-light-subtle border-start border-end" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm d-none d-xl-inline-block me-2">
                                <span class="avatar-title rounded-circle <?= $avatar['color_class'] ?> text-white">
                                    <?= $avatar['initials'] ?>
                                </span>
                            </div>
                            <span class="d-none d-xl-inline-block fw-medium"><?= htmlspecialchars($user_full_name); ?></span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </div>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="../islemler/cikis-yap.php"><i class="mdi mdi-logout font-size-16 align-middle me-1"></i>Güvenli Çıkış</a>
                    </div>
                </div>
            </div>
        </div>
    </header>