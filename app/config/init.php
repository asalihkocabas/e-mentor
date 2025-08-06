<?php

// Oturum (session) başlatılmamışsa başlat
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);


// ===================================================================
// SİSTEM ZAMANI AYARI
// ===================================================================

// Sunucunun saat dilimini Türkiye olarak ayarla (hataları önler)
date_default_timezone_set('Europe/Istanbul');

// Sistemin "şu an" olarak kabul edeceği zamanı Türkiye saatine göre dinamik olarak tanımla
define('SIMULATED_NOW', date('Y-m-d H:i:s'));

// Not: Eğer gelecekte tekrar belirli bir tarihi simüle etmek isterseniz,
// yukarıdaki satırı yorum satırı yapıp (# ile başına işaret koyup)
// altındaki satırı aktif hale getirmeniz a.
//define('SIMULATED_NOW', '2025-8-6 10:15:00');


// Veritabanı bağlantısını ve yardımcı fonksiyonları dahil et
require_once 'database.php';
require_once 'helpers.php';

?>