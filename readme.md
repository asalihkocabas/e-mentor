# E-Mentor

**Gemini AI Destekli Kişiselleştirilmiş Eğitim ve Mentorluk Platformu**

[![PHP 8.2](https://img.shields.io/badge/PHP-8.2-777BB4?logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-4479A1?logo=mysql&logoColor=white)](https://www.mysql.com/)
[![Google Gemini](https://img.shields.io/badge/Google-Gemini_AI-4285F4?logo=google&logoColor=white)](https://ai.google.dev/)
[![Bootstrap 5](https://img.shields.io/badge/Bootstrap-5-7952B3?logo=bootstrap&logoColor=white)](https://getbootstrap.com/)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

## 🌐 Canlı Demo

**Projenin yeteneklerini canlı olarak deneyimlemek için aşağıdaki bağlantıya tıklayabilirsiniz:**

### **[➡️ Canlı Demoyu Görüntüle](https://endtag.cloud/e-mentor)**

---

## 🚀 Proje Hakkında

**E-Mentor**, **BTK Akademi Hackathon 2025** için geliştirilmiş, Google'ın gelişmiş **Gemini** yapay zeka servisleri ile güçlendirilmiş, yeni nesil bir eğitim ve mentorluk platformudur. Bu proje, PHP 8.2 ve MySQL'in sağlam temelleri üzerinde yükselirken, modern ve kullanıcı dostu arayüzünü Bootstrap 5 ile sunar.

Platformun en devrimci özelliği, öğrenci ve öğretmen arasındaki veri akışını yapay zeka ile anlamlandırarak, her öğrenci için **tamamen kişiselleştirilmiş bir öğrenme deneyimi** yaratmasıdır. "Sınavdaki yanlışlarıma göre bana özel bir çalışma notu hazırla" gibi bir komut, Gemini entegrasyonu sayesinde anında işlenerek, her öğrenciye kendi sanal mentorunu sunar.

## ✨ Öne Çıkan Özellikler

### 🤖 AI Destekli Kişiselleştirilmiş Öğrenme
- **Otomatik Zayıf Kazanım Tespiti:** Yapılan sınavlardaki yanlış cevapları analiz ederek, her öğrencinin hangi kazanımlarda eksik olduğunu otomatik olarak tespit eder.
- **Kişiye Özel Ödev Atama:** Öğretmen, tek tuşla, öğrencinin zayıf olduğu kazanıma özel olarak Gemini AI tarafından oluşturulmuş çalışma sorularını ödev olarak atayabilir.
- **Akıllı Sınav Analizi:** Öğrenci, sınav sonuçlarını incelerken, yanlış yaptığı soruların nedenlerini ve ilgili kazanımın özetini yapay zekadan anında öğrenebilir.
- **Dinamik Çalışma Rehberi:** Öğrenci, yaklaşan bir sınavı için ilgili tüm kazanımları kapsayan, yapay zeka tarafından oluşturulmuş özel bir "Hızlı Tekrar Notu" talep edebilir.

### 📊 Kapsamlı Yönetim ve Takip
- **Dinamik Ders Programı:** Öğrenci ve öğretmenler için, sistemin simüle edilmiş zamanına göre "mevcut ders", "sıradaki ders" ve "tamamlanmış dersler" gibi durumları gösteren akıllı ders programları.
- **Gelişmiş Sınav Oluşturucu:** Çoklu sınıf atama, farklı soru tipleri (`Çoktan Seçmeli`, `Doğru/Yanlış`, `Açık Uçlu`) ve 100 puan kontrolü gibi özelliklere sahip esnek sınav oluşturma modülü.
- **İçerik Kütüphanesi:** Öğretmenlerin ders materyallerini, kazanım testlerini ve çıkmış soruları sisteme yükleyip yönetebileceği merkezi bir kütüphane.

### ⚙️ Esnek ve Simüle Edilebilir Altyapı
- **Zaman Makinesi:** Tüm sistemin, sunum ve test amacıyla, belirlenmiş herhangi bir tarih ve saatte çalışmasını sağlayan simülasyon özelliği. Bu, dönemin başındaki, ortasındaki veya sonundaki senaryoları canlı olarak gösterebilmeyi sağlar.

## 🛠️ Kullanılan Teknolojiler

- **Backend:** PHP 8.2 (PDO ile), AJAX
- **Frontend:** HTML5, CSS3, JavaScript (jQuery), Bootstrap 5
- **AI Servisleri:** Google Gemini 1.5 Flash
- **Veritabanı:** MySQL / MariaDB
- **Sunucu:** Apache (XAMPP Ortamı)

## 🏁 Kurulum ve Başlangıç

Bu bölüm, projeyi yerel makinenizde kurmanız ve çalıştırmanız için gereken adımları içerir.

### Gereksinimler
- [XAMPP](https://www.apachefriends.org/tr/index.html) (PHP 8.1+ ve MySQL/MariaDB içeren)
- Bir metin/kod editörü (örn: VSCode, PhpStorm)
- Google AI Studio'dan alınmış bir **Gemini API Anahtarı**.

### 1. Proje Dosyalarının Kurulumu

1.  **Repo'yu Klonlayın veya İndirin:** Proje dosyalarını `xampp/htdocs/e-mentor` gibi bir klasöre yerleştirin. `app` klasörü bu dizinin içinde olmalıdır.
2.  **Web Sunucusunu Başlatın:** XAMPP Kontrol Paneli'nden Apache ve MySQL sunucularını başlatın.

### 2. Veritabanı Kurulumu

1.  **Veritabanını Oluşturun:** `http://localhost/phpmyadmin` adresine gidin.
2.  **SQL Kodunu Çalıştırın:** Proje ile birlikte sunulan `database_setup.sql` dosyasının içeriğini kopyalayıp, "SQL" sekmesine yapıştırın ve çalıştırın. Bu komut, `e_mentor` veritabanını, tüm tabloları ve demo verilerini oluşturacaktır.

### 3. Yapılandırma

1.  **Veritabanı Bağlantısı:** `app/config/database.php` dosyasını açın ve veritabanı kullanıcı adı (`DB_USER`) ve şifreniz (`DB_PASS`) ile güncelleyin (Genellikle `root` ve şifre boştur).
2.  **Gemini API Anahtarını Girin:** `phpMyAdmin`'de `system_settings` tablosunu açın. `setting_key`'i `gemini_api_key` olan satırı bulun ve `setting_value` sütununa kendi Google Gemini API anahtarınızı yapıştırın.

### 4. Başlangıç

-   Artık projeye `http://localhost/app/` adresinden erişebilirsiniz.
-   **Test Giriş Bilgileri (Şifre: 123456):**
    - **Öğretmen:** `11111111111`
    - **Öğrenci:** `20000000001`