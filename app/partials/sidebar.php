<?php
// Bu session değişkeni, kullanıcı giriş yaptığında oluşturulacak.
// Rol kontrolü için. Varsayılan olarak 'teacher' ayarladım.
$user_role = $_SESSION['user_role'] ?? 'teacher';

// Mevcut sayfanın adını ve bulunduğu klasörü alıyoruz.
$currentPage = basename($_SERVER['PHP_SELF']);
$folder = basename(dirname($_SERVER['PHP_SELF']));
?>
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">Menü</li>

                <?php if ($user_role == 'teacher'): ?>

                    <li class="<?= ($currentPage == 'index.php') ? 'mm-active' : ''; ?>">
                        <a href="index.php"><i data-feather="home"></i><span>Ana Sayfa</span></a>
                    </li>
                    <li class="menu-title" data-key="t-apps">Yönetim</li>

                    <li class="<?= in_array($currentPage, ['siniflarim.php', 'sinif-detay.php', 'ogrenci-detay.php']) ? 'mm-active' : ''; ?>">
                        <a href="siniflarim.php" class="has-arrow"><i data-feather="users"></i><span>Sınıflarım</span></a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="siniflarim.php">Sınıf Listesi</a></li>
                        </ul>
                    </li>

                    <li class="<?= in_array($currentPage, ['sinav-olustur.php', 'sonuc-girisi.php', 'raporlar.php']) ? 'mm-active' : ''; ?>">
                        <a href="javascript: void(0);" class="has-arrow"><i data-feather="clipboard"></i><span>Sınav İşlemleri</span></a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="sinav-olustur.php">Sınav Oluştur</a></li>
                            <li><a href="sonuc-girisi.php">Sonuç Girişi</a></li>
                            <li><a href="raporlar.php">Sınav Raporları</a></li>
                        </ul>
                    </li>

                    <li class="<?= in_array($currentPage, ['odev-ver.php', 'odev-takip.php']) ? 'mm-active' : ''; ?>">
                        <a href="javascript: void(0);" class="has-arrow"><i data-feather="trello"></i><span>Ödev İşlemleri</span></a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="odev-ver.php">Ödev Ata</a></li>
                            <li><a href="odev-takip.php">Ödev Takibi</a></li>
                        </ul>
                    </li>

                    <li class="<?= in_array($currentPage, ['duyuru-ekle.php', 'duyuru-yonetimi.php']) ? 'mm-active' : ''; ?>">
                        <a href="javascript: void(0);" class="has-arrow"><i data-feather="send"></i><span>Duyurular</span></a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="duyuru-ekle.php">Duyuru Ekle</a></li>
                            <li><a href="duyuru-yonetimi.php">Duyuru Yönetimi</a></li>
                        </ul>
                    </li>

                    <li class="<?= in_array($currentPage, ['dosya-yukle.php', 'icerik-kutuphanesi.php']) ? 'mm-active' : ''; ?>">
                        <a href="javascript: void(0);" class="has-arrow"><i data-feather="folder"></i><span>İçerik Yönetimi</span></a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="dosya-yukle.php">Dosya Yükle</a></li>
                            <li><a href="icerik-kutuphanesi.php">İçerik Kütüphanesi</a></li>
                        </ul>
                    </li>

                    <li class="menu-title" data-key="t-tools">Araçlar</li>
                    <li class="<?= ($currentPage == 'ders-programi.php') ? 'mm-active' : ''; ?>">
                        <a href="ders-programi.php"><i data-feather="calendar"></i><span>Ders Programı</span></a>
                    </li>
                    <li class="<?= ($currentPage == 'yardim.php') ? 'mm-active' : ''; ?>">
                        <a href="yardim.php"><i data-feather="help-circle"></i><span>Yardım & Destek</span></a>
                    </li>

                <?php elseif ($user_role == 'student'): ?>

                    <li class="<?= ($currentPage == 'index.php') ? 'mm-active' : ''; ?>"><a href="index.php"><i data-feather="home"></i><span>Ana Sayfa</span></a></li>
                    <li class="<?= in_array($currentPage, ['derslerim.php', 'ders-detay.php']) ? 'mm-active' : ''; ?>"><a href="derslerim.php"><i data-feather="book"></i><span>Derslerim</span></a></li>
                    <li class="<?= ($currentPage == 'odevlerim.php') ? 'mm-active' : ''; ?>"><a href="odevlerim.php"><i data-feather="trello"></i><span>Ödevlerim</span></a></li>
                    <li class="<?= ($currentPage == 'sinav-sonuclarim.php') ? 'mm-active' : ''; ?>"><a href="#"><i data-feather="award"></i><span>Sınav Sonuçlarım</span></a></li>
                    <li class="<?= ($currentPage == 'ders-programi.php') ? 'mm-active' : ''; ?>"><a href="ders-programi.php"><i data-feather="calendar"></i><span>Ders Programım</span></a></li>
                    <li class="<?= ($currentPage == 'sinav-takvimi.php') ? 'mm-active' : ''; ?>"><a href="sinav-takvimi.php"><i data-feather="clock"></i><span>Sınav Takvimi</span></a></li>
                    <li class="<?= ($currentPage == 'kutuphane.php') ? 'mm-active' : ''; ?>"><a href="kutuphane.php"><i data-feather="folder"></i><span>Kütüphane</span></a></li>
                    <li class="menu-title" data-key="t-support">Destek</li>
                    <li class="<?= ($currentPage == 'yardim.php') ? 'mm-active' : ''; ?>"><a href="yardim.php"><i data-feather="help-circle"></i><span>Yardım</span></a></li>

                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>