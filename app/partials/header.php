<?php
// Oturum yönetimi burada başlayacak
// session_start();
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
                    <a href="../index.php" class="logo logo-light">
                        <span class="logo-sm"><img src="../assets/images/logo-sm.svg" alt="" height="30"></span>
                        <span class="logo-lg"><img src="../assets/images/logo-sm.svg" alt="" height="24"> <span class="logo-txt">E-Mentor</span></span>
                    </a>
                </div>
                <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn"><i class="fa fa-fw fa-bars"></i></button>
            </div>
            <div class="d-flex">
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item bg-light-subtle border-start border-end" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle header-profile-user" src="https://fotograf.sabis.sakarya.edu.tr/Fotograf/196f69e4eed68a3717e67cc6db180f6d" alt="Header Avatar">
                        <span class="d-none d-xl-inline-block ms-1 fw-medium">Kaan Buğra</span>
                        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#"><i class="mdi mdi-face-profile font-size-16 align-middle me-1"></i> Profil</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../cıkıs-yap.html"><i class="mdi mdi-logout font-size-16 align-middle me-1"></i> Çıkış</a>
                    </div>
                </div>
            </div>
        </div>
    </header>