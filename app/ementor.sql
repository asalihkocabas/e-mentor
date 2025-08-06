-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3306
-- Üretim Zamanı: 07 Ağu 2025, 00:16:25
-- Sunucu sürümü: 10.11.11-MariaDB-cll-lve
-- PHP Sürümü: 8.3.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `cswebcom_ementor`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ai_interaction_logs`
--

CREATE TABLE `ai_interaction_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `prompt` text DEFAULT NULL,
  `response` text DEFAULT NULL,
  `context` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `creator_id` int(11) DEFAULT NULL,
  `school_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `publish_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `announcements`
--

INSERT INTO `announcements` (`id`, `creator_id`, `school_id`, `title`, `content`, `category`, `publish_date`, `end_date`) VALUES
(13, 1, 1, 'MATEMATİK', '<p>Matematik 1. yazılı sınavımız <strong data-start=\"915\" data-end=\"957\">12 Mart 2026 Perşembe, 3. ders saatine</strong> alınmıştır.</p>', 'Sınav', '2024-10-15 03:00:00', NULL),
(14, 1, 1, 'Kütüphane Haftası Etkinlik Programı', '<p>25&ndash;29 EKİM &ouml;ğle arası etkinlik; katıl, bonus kazan.</p>', 'İdari', '2024-10-15 03:00:00', NULL),
(15, 1, 1, 'Fen Bilimleri Ödev Teslimi', '<p>6. sınıf &ouml;devi son tarih 5 Kasım 23:59.</p>', 'Ödev', '2024-10-15 03:00:00', NULL),
(16, 1, 1, 'Yarıyıl Tatili', '<p>Bilgilendirme Tatil 26 Oca &ndash; 9 Şub olacaktır.</p>', 'İdari', '2024-10-15 03:00:00', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `announcement_targets`
--

CREATE TABLE `announcement_targets` (
  `announcement_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `announcement_targets`
--

INSERT INTO `announcement_targets` (`announcement_id`, `class_id`) VALUES
(1, 1),
(2, 1),
(2, 2),
(3, 1),
(3, 2),
(7, 1),
(7, 2);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` enum('izinli','izinsiz') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `grade_level` int(11) NOT NULL,
  `school_id` int(11) DEFAULT NULL,
  `homeroom_teacher_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `classes`
--

INSERT INTO `classes` (`id`, `name`, `grade_level`, `school_id`, `homeroom_teacher_id`) VALUES
(1, '6-A', 6, 1, 1),
(2, '6-B', 6, 1, 2);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `weekly_hours` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `courses`
--

INSERT INTO `courses` (`id`, `name`, `weekly_hours`) VALUES
(1, 'Türkçe', 6),
(2, 'Matematik', 5),
(3, 'Fen Bilimleri', 4);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `exams`
--

CREATE TABLE `exams` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `term` varchar(50) DEFAULT NULL,
  `exam_type` varchar(50) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `exam_date` datetime DEFAULT NULL,
  `creator_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `exams`
--

INSERT INTO `exams` (`id`, `name`, `term`, `exam_type`, `course_id`, `exam_date`, `creator_id`) VALUES
(14, 'Matematik 1. Dönem 1. Yazılı', '1. Dönem', '1. Yazılı', 2, '2024-10-15 03:00:00', 1),
(16, 'Matematik 1. Dönem Quiz', '1. Dönem', 'Quiz', 2, '2024-10-16 03:00:00', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `exam_classes`
--

CREATE TABLE `exam_classes` (
  `exam_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `exam_classes`
--

INSERT INTO `exam_classes` (`exam_id`, `class_id`) VALUES
(14, 1),
(14, 2),
(16, 1),
(16, 2);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `homework_assignments`
--

CREATE TABLE `homework_assignments` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `learning_outcome_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL DEFAULT 'AI Tarafından Oluşturulan Ödev',
  `content` text DEFAULT NULL,
  `assigned_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `due_date` datetime DEFAULT NULL,
  `submission_date` datetime DEFAULT NULL,
  `student_submission_text` text DEFAULT NULL,
  `student_submission_file_path` varchar(255) DEFAULT NULL,
  `status` enum('assigned','submitted','graded') DEFAULT 'assigned',
  `grade` varchar(50) DEFAULT NULL,
  `teacher_comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `learning_outcomes`
--

CREATE TABLE `learning_outcomes` (
  `id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `grade_level` int(11) DEFAULT NULL,
  `unit_name` varchar(255) DEFAULT NULL,
  `outcome_code` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `learning_outcomes`
--

INSERT INTO `learning_outcomes` (`id`, `course_id`, `grade_level`, `unit_name`, `outcome_code`, `description`, `start_date`, `end_date`) VALUES
(1, 3, 6, '1.ÜNİTE: GÜNEŞ SİSTEMİ VE\n TUTULMALAR', 'F.6.1.1.1.', 'Güneş sistemindeki gezegenleri birbirleri ile karşılaştırır.', '2024-09-09', '2024-09-13'),
(2, 3, 6, '1.ÜNİTE: GÜNEŞ SİSTEMİ VE\n TUTULMALAR', 'F.6.1.1.2.', 'Güneş sistemindeki gezegenleri, Güneş’e yakınlıklarına göre sıralayarak bir model oluşturur.', '2024-09-16', '2024-09-20'),
(3, 3, 6, '1.ÜNİTE: GÜNEŞ SİSTEMİ VE\n TUTULMALAR', 'F.6.1.2.1.', 'Güneş tutulmasının nasıl oluştuğunu tahmin eder.', '2024-09-16', '2024-09-20'),
(5, 3, 6, '1.ÜNİTE: GÜNEŞ SİSTEMİ VE\n TUTULMALAR', 'F.6.1.2.2.', 'Ay tutulmasının nasıl oluştuğunu tahmin eder.', '2024-09-23', '2024-09-27'),
(6, 3, 6, '1.ÜNİTE: GÜNEŞ SİSTEMİ VE\n TUTULMALAR\n\n2.ÜNİTE: VÜCUDUMUZDAKİ\n SİSTEMLER', 'F.6.1.2.3.', 'Güneş ve Ay tutulmasını temsil eden bir model oluşturur.', '2024-09-30', '2024-09-00'),
(7, 3, 6, '1.ÜNİTE: GÜNEŞ SİSTEMİ VE\n TUTULMALAR\n\n2.ÜNİTE: VÜCUDUMUZDAKİ\n SİSTEMLER', 'F.6.2.1.1.', 'Destek ve hareket sistemine ait yapıları örneklerle açıklar.', '2024-09-30', '2024-09-00'),
(8, 3, 6, '2.ÜNİTE: VÜCUDUMUZDAKİ\n SİSTEMLER', 'F.6.2.4.1.', 'Solunum sistemini oluşturan yapı ve organların görevlerini modeller kullanarak açıklar.', '2024-11-04', '2024-11-08'),
(9, 3, 6, '2.ÜNİTE: VÜCUDUMUZDAKİ\n SİSTEMLER', 'F.6.2.5.1.', 'Boşaltım sistemini oluşturan yapı ve organları model üzerinde göstererek görevlerini özetler.', '2024-11-04', '2024-11-08'),
(11, 3, 6, '2.ÜNİTE: VÜCUDUMUZDAKİ\n SİSTEMLER\n\n3.ÜNİTE: KUVVET VE HAREKET', 'F.6.3.1.1.', 'Bir cisme etki eden kuvvetin yönünü, doğrultusunu ve büyüklüğünü çizerek gösterir.', '2024-11-18', '2024-11-22'),
(12, 3, 6, '3.ÜNİTE: KUVVET VE HAREKET', 'F.6.3.1.2.', 'Bir cisme etki eden birden fazla kuvveti deneyerek gözlemler.', '2024-11-25', '2024-11-29'),
(13, 3, 6, '3.ÜNİTE: KUVVET VE HAREKET', 'F.6.3.1.3.', 'Dengelenmiş ve dengelenmemiş kuvvetleri, cisimlerin hareket durumlarını gözlemleyerek karşılaştırır.', '2024-12-02', '2024-12-06'),
(14, 3, 6, '3.ÜNİTE: KUVVET VE HAREKET', 'F.6.3.2.1.', 'Sürati tanımlar ve birimini ifade eder.', '2024-12-02', '2024-12-06'),
(15, 3, 6, '3.ÜNİTE: KUVVET VE HAREKET', 'F.6.3.2.2.', 'Yol, zaman ve sürat arasındaki ilişkiyi grafik üzerinde gösterir.', '2024-12-09', '2024-12-13'),
(16, 3, 6, '4.ÜNİTE: MADDE VE ISI', 'F.6.4.1.1.', 'Maddelerin; tanecikli, boşluklu ve hareketli yapıda olduğunu ifade eder.', '2024-12-16', '2024-12-20'),
(17, 3, 6, '4.ÜNİTE: MADDE VE ISI', 'F.6.4.1.2.', 'Hâl değişimine bağlı olarak maddenin tanecikleri arasındaki boşluk ve taneciklerin hareketliliğinin  değiştiğini deney yaparak karşılaştırır.', '2024-12-16', '2024-12-20'),
(19, 3, 6, '4.ÜNİTE: MADDE VE \nISI', 'F.6.4.2.2.', 'Tasarladığı deneyler sonucunda çeşitli maddelerin yoğunluklarını hesaplar.', '2024-12-30', '2024-12-00'),
(20, 3, 6, '4.ÜNİTE: MADDE VE \nISI', 'F.6.4.2.3.', 'Birbiri içinde çözünmeyen sıvıların yoğunluklarını deney yaparak karşılaştırır.', '2024-12-30', '2024-12-00'),
(21, 3, 6, '4.ÜNİTE: MADDE VE \nISI', 'F.6.4.2.4.', 'Suyun katı ve sıvı hâllerine ait yoğunlukları karşılaştırarak bu durumun canlılar için önemini tartışır.', '2025-01-06', '2025-01-10'),
(22, 3, 6, '4.ÜNİTE: MADDE VE \nISI', 'F.6.4.3.1.', 'Maddeleri, ısı iletimi bakımından sınıflandırır.', '2025-01-06', '2025-01-10'),
(23, 3, 6, '4.ÜNİTE: MADDE VE \nISI', 'F.6.4.3.2.', 'Binalarda kullanılan ısı yalıtım malzemelerinin seçilme ölçütlerini belirler.', '2025-01-13', '2025-01-17'),
(24, 3, 6, '4.ÜNİTE: MADDE VE \nISI', 'F.6.4.3.3.', 'Alternatif ısı yalıtım malzemeleri geliştirir.', '2025-01-13', '2025-01-17'),
(25, 3, 6, '4.ÜNİTE: MADDE VE \nISI', 'F.6.4.3.4.', 'Binalarda ısı yalıtımının önemini, aile ve ülke ekonomisi ve kaynakların etkili kullanımı bakımından tartışır.', '2025-02-03', '2025-02-07'),
(26, 3, 6, '4.ÜNİTE: MADDE VE \nISI', 'F.6.4.4.1.', 'Yakıtları, katı, sıvı ve gaz yakıtlar olarak sınıflandırıp yaygın şekilde kullanılan yakıtlara örnekler verir.', '2025-02-03', '2025-02-07'),
(27, 3, 6, '4.ÜNİTE:MADDE VE \nISI', 'F.6.4.4.2.', 'Farklı türdeki yakıtların ısı amaçlı kullanımının, insan ve çevre üzerine etkilerini tartışır.', '2025-02-10', '2025-02-14'),
(28, 3, 6, '4.ÜNİTE:MADDE VE \nISI', 'F.6.4.4.3.', 'Soba ve doğal gaz zehirlenmeleri ile ilgili alınması gereken tedbirleri araştırır ve rapor eder.', '2025-02-10', '2025-02-14'),
(29, 3, 6, '5.ÜNİTE: SES VE ÖZELLİKLERİ', 'F.6.5.1.1.', 'Sesin yayılabildiği ortamları tahmin eder ve tahminlerini test eder.', '2025-02-17', '2025-02-21'),
(30, 3, 6, '5.ÜNİTE: SES VE ÖZELLİKLERİ', 'F.6.5.2.1.', 'Ses kaynağının değişmesiyle seslerin farklı işitildiğini deneyerek keşfeder.', '2025-02-24', '2025-02-28'),
(31, 3, 6, '5.ÜNİTE: SES VE ÖZELLİKLERİ', 'F.6.5.2.2.', 'Sesin yayıldığı ortamın değişmesiyle farklı işitildiğini deneyerek keşfeder.', '2025-03-03', '2025-03-07'),
(32, 3, 6, '5.ÜNİTE: SES VE ÖZELLİKLERİ', 'F.6.5.3.1.', 'Sesin farklı ortamlardaki süratini karşılaştırır.', '2025-03-03', '2025-03-07'),
(34, 3, 6, '5.ÜNİTE: SES VE ÖZELLİKLERİ', 'F.6.5.4.1.', 'Sesin yansıma ve soğurulmasına örnekler verir.', '2025-03-10', '2025-03-14'),
(35, 3, 6, '5.ÜNİTE: SES VE ÖZELLİKLERİ', 'F.6.5.4.2.', 'Sesin yayılmasını önlemeye yönelik tahminlerde bulunur ve tahminlerini test eder.', '2025-03-17', '2025-03-21'),
(36, 3, 6, '5.ÜNİTE: SES VE ÖZELLİKLERİ', 'F.6.5.4.3.', 'Ses yalıtımının önemini açıklar.', '2025-03-17', '2025-03-21'),
(37, 3, 6, '5.ÜNİTE: SES VE ÖZELLİKLERİ', 'F.6.5.4.4.', 'Akustik uygulamalarına örnekler verir.', '2025-03-17', '2025-03-21'),
(38, 3, 6, '5.ÜNİTE: SES VE ÖZELLİKLERİ \n\n6. ÜNİTE: VÜCUDUMUZDAKİ\n SİSTEMLER VE SAĞLIĞI', 'F.6.5.4.5.', 'Sesin yalıtımı veya akustik uygulamalarına örnek teşkil edecek ortam tasarımı yapar.', '2025-03-24', '2025-03-28'),
(39, 3, 6, '5.ÜNİTE: SES VE ÖZELLİKLERİ \n\n6. ÜNİTE: VÜCUDUMUZDAKİ\n SİSTEMLER VE SAĞLIĞI', 'F.6.6.1.1.', 'Sinir sistemini, merkezî ve çevresel sinir sisteminin görevlerini model üzerinde açıklar.', '2025-03-24', '2025-03-28'),
(40, 3, 6, '7. ÜNİTE:\nELEKTRİĞİN İLETİMİ', 'F.6.7.1.1.', 'Tasarladığı elektrik devresini kullanarak maddeleri, elektriği iletme durumlarına göre sınıflandırır.', '2025-05-05', '2025-05-09'),
(41, 3, 6, '7. ÜNİTE:\nELEKTRİĞİN İLETİMİ', 'F.6.7.1.2.', 'Maddelerin elektriksel iletkenlik ve yalıtkanlık özelliklerinin günlük yaşamda hangi amaçlar için kullanıldığını', '2025-05-05', '2025-05-09'),
(42, 3, 6, '7. ÜNİTE:\nELEKTRİĞİN İLETİMİ', 'F.6.7.2.1.', 'Bir elektrik devresindeki ampulün parlaklığının bağlı olduğu değişkenleri tahmin eder ve tahminlerini', '2025-05-12', '2025-05-16'),
(43, 3, 6, '7. ÜNİTE:\nELEKTRİĞİN İLETİMİ', 'F.6.7.2.2.', 'Elektriksel direnci tanımlar.', '2025-05-19', '2025-05-23'),
(44, 3, 6, '7. ÜNİTE:\nELEKTRİĞİN İLETİMİ', 'F.6.7.2.3.', 'Ampulün içindeki telin bir direncinin olduğunu fark eder.', '2025-05-19', '2025-05-23'),
(45, 2, 6, 'M.6.1. SAYILAR VE İŞLEMLER', 'M.6.1.1.1.', 'Bir doğal sayının kendisiyle tekrarlı çarpımını üslü nicelik olarak ifade eder ve üslü niceliklerin değerini belirler.', '2024-09-09', '2024-09-13'),
(46, 2, 6, 'M.6.1. SAYILAR VE İŞLEMLER', 'M.6.1.1.2.', 'İşlem önceliğini dikkate alarak doğal sayılarla dört işlem yapar.', '2024-09-09', '2024-09-13'),
(47, 2, 6, 'M.6.1. SAYILAR VE İŞLEMLER', 'M.6.1.1.3.', 'Doğal sayılarda ortak çarpan parantezine alma ve dağılma özelliğini uygulamaya yönelik işlemler yapar.', '2024-09-16', '2024-09-20'),
(48, 2, 6, 'M.6.1. SAYILAR VE İŞLEMLER', 'M.6.1.1.4.', 'Doğal sayılarla dört işlem yapmayı gerektiren problemleri çözer.', '2024-09-23', '2024-09-27'),
(49, 2, 6, 'M.6.1. SAYILAR VE İŞLEMLER', 'M.6.1.2.1.', 'Doğal sayıların çarpanlarını ve katlarını belirler.', '2024-09-30', '2024-09-00'),
(50, 2, 6, 'M.6.1. SAYILAR VE İŞLEMLER', 'M.6.1.3.1.', 'Kümeler ile ilgili temel kavramları anlar.', '2024-11-04', '2024-11-08'),
(51, 2, 6, 'M.6.1. SAYILAR VE İŞLEMLER', 'M.6.1.4.1.', 'Tam sayıları tanır ve sayı doğrusunda gösterir.', '2024-11-18', '2024-11-22'),
(52, 2, 6, 'M.6.1. SAYILAR VE İŞLEMLER', 'M.6.1.4.2.', 'Tam sayıları karşılaştırır ve sıralar.', '2024-11-25', '2024-11-29'),
(53, 2, 6, 'M.6.1. SAYILAR VE İŞLEMLER', 'M.6.1.4.3.', 'Bir tam sayının mutlak değerini belirler ve anlamlandırır.', '2024-11-25', '2024-11-29'),
(54, 2, 6, 'M.6.1. SAYILAR VE İŞLEMLER', 'M.6.1.5.1.', 'Kesirleri karşılaştırır, sıralar ve sayı doğrusunda gösterir.', '2024-12-02', '2024-12-06'),
(55, 2, 6, 'M.6.1. SAYILAR VE İŞLEMLER', 'M.6.1.5.2.', 'Kesirlerle toplama ve çıkarma işlemlerini yapar', '2024-12-02', '2024-12-06'),
(57, 2, 6, 'M.6.1. SAYILAR VE İŞLEMLER', 'M.6.1.5.3.', 'Bir doğal sayı ile bir kesrin çarpma işlemini yapar ve anlamlandırır.', '2024-12-09', '2024-12-13'),
(58, 2, 6, 'M.6.1. SAYILAR VE İŞLEMLER', 'M.6.1.5.4.', 'İki kesrin çarpma işlemini yapar ve anlamlandırır.', '2024-12-09', '2024-12-13'),
(59, 2, 6, 'M.6.1. SAYILAR VE İŞLEMLER', 'M.6.1.5.5.', 'Bir doğal sayıyı bir kesre ve bir kesri bir doğal sayıya böler,bu işlemi anlamlandırır.                                         M.6.1.5.6. İki kesrin bölme işlemini yapar ve anlamlandırır.', '2024-12-16', '2024-12-20'),
(60, 2, 6, 'M.6.1. SAYILAR VE İŞLEMLER', 'M.6.1.5.7.', 'Kesirlerle yapılan işlemlerin sonucunu tahmin eder.', '2024-12-16', '2024-12-20'),
(61, 2, 6, 'M.6.1. SAYILAR VE İŞLEMLER', 'M.6.1.5.8.', 'Kesirlerle işlem yapmayı gerektiren problemleri çözer.', '2024-12-23', '2024-12-27'),
(62, 2, 6, 'M.6.1. SAYILAR VE İŞLEMLER', 'M.6.1.6.1.', 'Bölme işlemi ile kesir kavramını ilişkilendirir.', '2024-12-23', '2024-12-27'),
(63, 2, 6, 'M.6.1. SAYILAR VE İŞLEMLER', 'M.6.1.6.2.', 'Ondalık gösterimleri verilen sayıları çözümler.', '2024-12-30', '2024-12-00'),
(64, 2, 6, 'M.6.1. SAYILAR VE İŞLEMLER', 'M.6.1.6.3.', 'Ondalık gösterimleri verilen sayıları belirli bir basamağa kadar yuvarlar.', '2024-12-30', '2024-12-00'),
(65, 2, 6, 'M.6.1. SAYILAR VE İŞLEMLER', 'M.6.1.6.4.', 'Ondalık gösterimleri verilen sayılarla çarpma işlemi yapar.', '2025-01-06', '2025-01-10'),
(66, 2, 6, 'M.6.1. SAYILAR VE İŞLEMLER', 'M.6.1.6.5.', 'Ondalık gösterimleri verilen sayılarla bölme işlemi yapar.', '2025-01-06', '2025-01-10'),
(67, 2, 6, 'M.6.1. SAYILAR VE İŞLEMLER', 'M.6.1.6.6.', 'Ondalık gösterimleri verilen sayılarla; 10, 100 ve 1000 ile kısa yoldan çarpma ve bölme işlemlerini yapar.', '2025-01-13', '2025-01-17'),
(68, 2, 6, 'M.6.1. SAYILAR VE İŞLEMLER', 'M.6.1.6.7.', 'Sayıların ondalık gösterimleriyle yapılan işlemlerin sonucunu tahmin eder.', '2025-01-13', '2025-01-17'),
(69, 2, 6, 'M.6.1. SAYILAR VE İŞLEMLER', 'M.6.1.6.8.', 'Ondalık ifadelerle dört işlem yapmayı gerektiren problemleri çözer.', '2025-01-13', '2025-01-17'),
(71, 2, 6, 'M.6.1. SAYILAR VE İŞLEMLER', 'M.6.1.7.1.', 'Çoklukları karşılaştırmada oran kullanır ve oranı farklı biçimlerde gösterir.', '2025-02-03', '2025-02-07'),
(72, 2, 6, 'M.6.1. SAYILAR VE İŞLEMLER', 'M.6.1.7.2.', 'Bir bütünün iki parçaya ayrıldığı durumlarda iki parçanın birbirine veya her bir parçanın bütüne oranını belirler, problem durumlarında oranlardan biri verildiğinde diğerini bulur.', '2025-02-10', '2025-02-14'),
(73, 2, 6, 'M.6.1. SAYILAR VE İŞLEMLER', 'M.6.1.7.3.', 'Aynı veya farklı birimlerdeki iki çokluğun birbirine oranını belirler.', '2025-02-10', '2025-02-14'),
(75, 2, 6, 'M.6.1. SAYILAR VE İŞLEMLER\nM.6.2. CEBİR', 'M.6.2.1.1.', 'Sözel olarak verilen bir duruma uygun cebirsel ifade ve verilen bir cebirsel ifadeye uygun sözel bir durum yazar.', '2025-02-17', '2025-02-21'),
(76, 2, 6, 'M.6.2. CEBİR', 'M.6.2.1.2.', 'Cebirsel ifadenin değerini değişkenin alacağı farklı doğal sayı değerleri için hesaplar.', '2025-02-24', '2025-02-28'),
(77, 2, 6, 'M.6.2. CEBİR', 'M.6.2.1.3.', 'Basit cebirsel ifadelerin anlamını açıklar.', '2025-02-24', '2025-02-28'),
(79, 2, 6, 'M.6.2. CEBİR\nM.6.4. VERİ İŞLEME', 'M.6.4.1.1.', 'İki veri grubunu karşılaştırmayı gerektiren araştırma soruları oluşturur ve uygun verileri elde eder.', '2025-03-03', '2025-03-07'),
(80, 2, 6, 'M.6.2. CEBİR\nM.6.4. VERİ İŞLEME', 'M.6.4.1.2.', 'İki gruba ait verileri ikili sıklık tablosu ve sütun grafiği ile gösterir.', '2025-03-03', '2025-03-07'),
(82, 2, 6, 'M.6.4. VERİ İŞLEME', 'M.6.4.2.1.', 'Bir veri grubuna ait açıklığı hesaplar ve yorumlar.', '2025-03-10', '2025-03-14'),
(83, 2, 6, 'M.6.4. VERİ İŞLEME', 'M.6.4.2.2.', 'Bir veri grubuna ait aritmetik ortalamayı hesaplar ve yorumlar.', '2025-03-10', '2025-03-14'),
(84, 2, 6, 'M.6.4. VERİ İŞLEME\nM.6.3. GEOMETRİ VE ÖLÇME', 'M.6.4.2.3.', 'İki gruba ait verileri karşılaştırmada ve yorumlamada aritmetik ortalama ve açıklığı kullanır.', '2025-03-17', '2025-03-21'),
(85, 2, 6, 'M.6.4. VERİ İŞLEME\nM.6.3. GEOMETRİ VE ÖLÇME', 'M.6.3.1.1.', 'Açıyı, başlangıç noktaları aynı olan iki ışının oluşturduğunu bilir ve sembolle gösterir.', '2025-03-17', '2025-03-21'),
(86, 2, 6, 'M.6.3. GEOMETRİ VE ÖLÇME', 'M.6.3.1.2.', 'Bir açıya eş bir açı çizer.', '2025-03-24', '2025-03-28'),
(87, 2, 6, 'M.6.3. GEOMETRİ VE ÖLÇME', 'M.6.3.1.3.', 'Komşu, tümler, bütünler ve ters açıların özelliklerini keşfeder; ilgili problemleri çözer.', '2025-03-24', '2025-03-28'),
(88, 2, 6, 'M.6.3. GEOMETRİ VE ÖLÇME', 'M.6.3.3.2.', 'Bir çemberin uzunluğunun çapına oranının sabit bir değer olduğunu ölçme yaparak belirler.', '2025-05-05', '2025-05-09'),
(89, 2, 6, 'M.6.3. GEOMETRİ VE ÖLÇME', 'M.6.3.3.3.', 'Çapı veya yarıçapı verilen bir çemberin uzunluğunu hesaplamayı  gerektiren problemleri çözer.', '2025-05-12', '2025-05-16'),
(90, 2, 6, 'M.6.3. GEOMETRİ VE ÖLÇME', 'M.6.3.4.1.', 'Dikdörtgenler prizmasının içine boşluk kalmayacak biçimde yerleştirilen birimküp sayısının o cismin hacmi olduğunu anlar, verilen cismin hacmini birimküpleri sayarak hesaplar.', '2025-05-12', '2025-05-16'),
(92, 2, 6, 'M.6.3. GEOMETRİ VE ÖLÇME', 'M.6.3.4.2.', 'Verilen bir hacim ölçüsüne sahip farklı dikdörtgenler prizmalarını birimküplerle oluşturur, hacmin taban alanı ile yüksekliğin çarpımı olduğunu gerekçesiyle açıklar.', '2025-05-19', '2025-05-23'),
(93, 2, 6, 'M.6.3. GEOMETRİ VE ÖLÇME', 'M.6.3.4.3.', 'Standart hacim ölçme birimlerini tanır ve cm³, dm³, m³ birimleri arasında dönüşüm yapar.', '2025-05-26', '2025-05-30'),
(94, 2, 6, 'M.6.3. GEOMETRİ VE ÖLÇME', 'M.6.3.4.4.', 'Dikdörtgenler prizmasının hacim bağıntısını oluşturur, ilgili problemleri çözer.', '2025-05-26', '2025-05-30');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `library_content`
--

CREATE TABLE `library_content` (
  `id` int(11) NOT NULL,
  `uploader_id` int(11) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_type` enum('Kazanım Testi','Ders Kitabı','Çıkmış Soru') DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `parent_profiles`
--

CREATE TABLE `parent_profiles` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `parent_student_relationships`
--

CREATE TABLE `parent_student_relationships` (
  `parent_user_id` int(11) NOT NULL,
  `student_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) DEFAULT NULL,
  `type` enum('mcq','tf','open') NOT NULL,
  `question_text` text DEFAULT NULL,
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`options`)),
  `correct_answer` varchar(255) DEFAULT NULL,
  `points` int(11) DEFAULT NULL,
  `learning_outcome_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `questions`
--

INSERT INTO `questions` (`id`, `exam_id`, `type`, `question_text`, `options`, `correct_answer`, `points`, `learning_outcome_id`) VALUES
(17, 14, 'mcq', 'Aşağıdakilerden hangisi 3×3×3×3 işleminin üslü sayı gösterimidir?', '{\"A\":\"3^2\",\"B\":\"3^6\",\"C\":\"4^3\",\"D\":\"3^4\"}', 'D', 25, 45),
(18, 14, 'open', '5+2×(6−1)−3 işlemini işlem önceliğine göre hesaplayınız.', NULL, '12', 25, 46),
(19, 14, 'tf', '8×13=8×(10+3) ifadesi dağılma özelliğini doğru kullanmıştır.', NULL, 'D', 25, 47),
(20, 14, 'mcq', 'Aşağıdaki seçeneklerden hangisi 7×5+7×2 ifadesinin ortak çarpan parantezine alınmış hâlidir?', '{\"A\":\" 7 \\u00d7 ( 5 + 2 ) \",\"B\":\"9 \\u00d7 ( 5 + 2 )\",\"C\":\"7+(5\\u00d72)\",\"D\":\"(7+5)\\u00d72\"}', 'A', 25, 48),
(21, 16, 'open', 'Sayı doğrusunda –5 sayısı, –2 sayısının solunda mı sağında mı yer alır? Yazınız.', NULL, 'sol', 50, 51);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `schedule_periods`
--

CREATE TABLE `schedule_periods` (
  `id` int(11) NOT NULL,
  `period_number` int(11) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `schedule_periods`
--

INSERT INTO `schedule_periods` (`id`, `period_number`, `start_time`, `end_time`) VALUES
(1, 1, '09:00:00', '09:40:00'),
(2, 2, '09:50:00', '10:30:00'),
(3, 3, '10:40:00', '11:20:00'),
(4, 4, '11:30:00', '12:10:00'),
(5, 5, '12:40:00', '13:20:00'),
(6, 6, '13:30:00', '14:10:00'),
(7, 7, '14:20:00', '15:00:00');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `schools`
--

CREATE TABLE `schools` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `city` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `schools`
--

INSERT INTO `schools` (`id`, `name`, `city`) VALUES
(1, 'Atatürk Ortaokulu', 'Ankara');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `student_answers`
--

CREATE TABLE `student_answers` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `exam_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `selected_answer` varchar(255) DEFAULT NULL,
  `written_answer` text DEFAULT NULL,
  `is_correct` tinyint(1) DEFAULT NULL,
  `score_override` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `student_answers`
--

INSERT INTO `student_answers` (`id`, `student_id`, `exam_id`, `question_id`, `selected_answer`, `written_answer`, `is_correct`, `score_override`) VALUES
(51, 16, 5, 7, '', NULL, 0, NULL),
(52, 16, 5, 8, '', NULL, 0, NULL),
(53, 13, 5, 7, '', NULL, 0, NULL),
(54, 13, 5, 8, '', NULL, 0, NULL),
(55, 19, 5, 7, '', NULL, 0, NULL),
(56, 19, 5, 8, '', NULL, 0, NULL),
(57, 17, 5, 7, '', NULL, 0, NULL),
(58, 17, 5, 8, '', NULL, 0, NULL),
(59, 12, 5, 7, '', NULL, 0, NULL),
(60, 12, 5, 8, '', NULL, 0, NULL),
(61, 11, 11, 14, 'B', NULL, 0, NULL),
(62, 20, 11, 14, 'A', NULL, 1, NULL),
(63, 18, 11, 14, 'A', NULL, 1, NULL),
(64, 14, 11, 14, 'A', NULL, 1, NULL),
(65, 15, 11, 14, 'A', NULL, 1, NULL),
(66, 16, 11, 14, 'A', NULL, 1, NULL),
(67, 13, 11, 14, 'A', NULL, 1, NULL),
(68, 19, 11, 14, 'A', NULL, 1, NULL),
(69, 17, 11, 14, 'A', NULL, 1, NULL),
(70, 12, 11, 14, 'A', NULL, 1, NULL),
(71, 11, 13, 16, 'A', NULL, 0, NULL),
(72, 20, 13, 16, '', NULL, 0, NULL),
(73, 18, 13, 16, '', NULL, 0, NULL),
(74, 14, 13, 16, '', NULL, 0, NULL),
(75, 15, 13, 16, '', NULL, 0, NULL),
(76, 16, 13, 16, '', NULL, 0, NULL),
(77, 13, 13, 16, '', NULL, 0, NULL),
(78, 19, 13, 16, '', NULL, 0, NULL),
(79, 17, 13, 16, '', NULL, 0, NULL),
(80, 12, 13, 16, '', NULL, 0, NULL),
(81, 11, 14, 17, 'A', NULL, 0, NULL),
(82, 11, 14, 18, '', '12', 0, 25.00),
(83, 11, 14, 19, 'D', NULL, 1, NULL),
(84, 11, 14, 20, 'A', NULL, 1, NULL),
(85, 20, 14, 17, 'A', NULL, 0, NULL),
(86, 20, 14, 18, '', '12', 0, 25.00),
(87, 20, 14, 19, 'D', NULL, 1, NULL),
(88, 20, 14, 20, 'D', NULL, 0, NULL),
(89, 18, 14, 17, 'D', NULL, 1, NULL),
(90, 18, 14, 18, '', '14', 0, 0.00),
(91, 18, 14, 19, 'Y', NULL, 0, NULL),
(92, 18, 14, 20, 'A', NULL, 1, NULL),
(93, 14, 14, 17, 'D', NULL, 1, NULL),
(94, 14, 14, 18, '', '12', 0, 25.00),
(95, 14, 14, 19, 'Y', NULL, 0, NULL),
(96, 14, 14, 20, 'A', NULL, 1, NULL),
(97, 15, 14, 17, 'D', NULL, 1, NULL),
(98, 15, 14, 18, '', '12', 0, 25.00),
(99, 15, 14, 19, 'D', NULL, 1, NULL),
(100, 15, 14, 20, 'A', NULL, 1, NULL),
(101, 16, 14, 17, 'C', NULL, 0, NULL),
(102, 16, 14, 18, '', '12', 0, 25.00),
(103, 16, 14, 19, 'D', NULL, 1, NULL),
(104, 16, 14, 20, 'A', NULL, 1, NULL),
(105, 13, 14, 17, 'D', NULL, 1, NULL),
(106, 13, 14, 18, '', '13', 0, 0.00),
(107, 13, 14, 19, 'D', NULL, 1, NULL),
(108, 13, 14, 20, 'A', NULL, 1, NULL),
(109, 19, 14, 17, 'A', NULL, 0, NULL),
(110, 19, 14, 18, '', '12', 0, 25.00),
(111, 19, 14, 19, 'D', NULL, 1, NULL),
(112, 19, 14, 20, 'Y', NULL, 0, NULL),
(113, 17, 14, 17, 'B', NULL, 0, NULL),
(114, 17, 14, 18, '', '12', 0, 25.00),
(115, 17, 14, 19, 'D', NULL, 1, NULL),
(116, 17, 14, 20, 'Y', NULL, 0, NULL),
(117, 12, 14, 17, 'B', NULL, 0, NULL),
(118, 12, 14, 18, '', '12', 0, 25.00),
(119, 12, 14, 19, 'D', NULL, 1, NULL),
(120, 12, 14, 20, 'D', NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `student_exam_scores`
--

CREATE TABLE `student_exam_scores` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `exam_id` int(11) DEFAULT NULL,
  `score` decimal(5,2) DEFAULT NULL,
  `correct_count` int(11) DEFAULT NULL,
  `incorrect_count` int(11) DEFAULT NULL,
  `blank_count` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `student_exam_scores`
--

INSERT INTO `student_exam_scores` (`id`, `student_id`, `exam_id`, `score`, `correct_count`, `incorrect_count`, `blank_count`) VALUES
(51, 11, 14, 75.00, 2, 1, 0),
(52, 20, 14, 50.00, 1, 2, 0),
(53, 18, 14, 50.00, 2, 1, 0),
(54, 14, 14, 75.00, 2, 1, 0),
(55, 15, 14, 100.00, 3, 0, 0),
(56, 16, 14, 75.00, 2, 1, 0),
(57, 13, 14, 75.00, 3, 0, 0),
(58, 19, 14, 50.00, 1, 2, 0),
(59, 17, 14, 50.00, 1, 2, 0),
(60, 12, 14, 50.00, 1, 2, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `student_profiles`
--

CREATE TABLE `student_profiles` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `student_number` varchar(50) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `gpa` decimal(5,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `student_profiles`
--

INSERT INTO `student_profiles` (`user_id`, `full_name`, `student_number`, `class_id`, `gpa`) VALUES
(11, 'Ali Demir', '101', 1, 85.50),
(12, 'Zeynep Kaya', '102', 1, 95.00),
(13, 'Mustafa Çelik', '103', 1, 70.00),
(14, 'Elif Arslan', '104', 1, 100.00),
(15, 'Emir Aydın', '105', 1, 45.00),
(16, 'Fatma Doğan', '106', 1, 88.00),
(17, 'Yusuf Kılıç', '107', 1, 92.00),
(18, 'Ecrin Yıldız', '108', 1, 75.00),
(19, 'Ömer Aslan', '109', 1, 50.00),
(20, 'Defne Şahin', '110', 1, 65.00),
(21, 'Ahmet Kurt', '201', 2, 80.00),
(22, 'Asya Bulut', '202', 2, 90.00),
(23, 'Kerem Can', '203', 2, 76.00),
(24, 'İrem Güneş', '204', 2, 98.00),
(25, 'Mehmet Ali Polat', '205', 2, 60.00),
(26, 'Zümra Tekin', '206', 2, 82.00),
(27, 'Burak Koç', '207', 2, 79.00),
(28, 'Eslem Acar', '208', 2, 91.00),
(29, 'Eymen Özdemir', '209', 2, 58.00),
(30, 'Gökçe Aksoy', '210', 2, 72.00);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `system_settings`
--

CREATE TABLE `system_settings` (
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `system_settings`
--

INSERT INTO `system_settings` (`setting_key`, `setting_value`) VALUES
('gemini_api_key', 'AIzaSyDfHeFLY-3-q2sp-Bwzo0OXuQap-xJo7Z0'),
('gemini_model', 'gemini-2.0-flash');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `teacher_assignments`
--

CREATE TABLE `teacher_assignments` (
  `teacher_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `teacher_assignments`
--

INSERT INTO `teacher_assignments` (`teacher_id`, `class_id`, `course_id`) VALUES
(1, 1, 2),
(1, 2, 2),
(2, 1, 1),
(2, 1, 3),
(2, 2, 1),
(2, 2, 3);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `teacher_profiles`
--

CREATE TABLE `teacher_profiles` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `branch` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `teacher_profiles`
--

INSERT INTO `teacher_profiles` (`user_id`, `full_name`, `branch`) VALUES
(1, 'Ayşe Yılmaz', 'Matematik'),
(2, 'Mehmet Öztürk', 'Türkçe');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `tc_kimlik` varchar(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','teacher','parent','admin') NOT NULL,
  `school_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `tc_kimlik`, `password`, `role`, `school_id`) VALUES
(1, '11111111111', '$2y$10$/pr1ueUjBZls8ImbYECHPeEi3uSqKGnYHyb45XiPr16XreIlmLPFS', 'teacher', 1),
(2, '10000000002', '$2y$10$/pr1ueUjBZls8ImbYECHPeEi3uSqKGnYHyb45XiPr16XreIlmLPFS', 'teacher', 1),
(11, '20000000001', '$2y$10$/pr1ueUjBZls8ImbYECHPeEi3uSqKGnYHyb45XiPr16XreIlmLPFS', 'student', 1),
(12, '20000000002', '$2y$10$/pr1ueUjBZls8ImbYECHPeEi3uSqKGnYHyb45XiPr16XreIlmLPFS', 'student', 1),
(13, '20000000003', '$2y$10$/pr1ueUjBZls8ImbYECHPeEi3uSqKGnYHyb45XiPr16XreIlmLPFS', 'student', 1),
(14, '20000000004', '$2y$10$/pr1ueUjBZls8ImbYECHPeEi3uSqKGnYHyb45XiPr16XreIlmLPFS', 'student', 1),
(15, '20000000005', '$2y$10$/pr1ueUjBZls8ImbYECHPeEi3uSqKGnYHyb45XiPr16XreIlmLPFS', 'student', 1),
(16, '20000000006', '$2y$10$/pr1ueUjBZls8ImbYECHPeEi3uSqKGnYHyb45XiPr16XreIlmLPFS', 'student', 1),
(17, '20000000007', '$2y$10$/pr1ueUjBZls8ImbYECHPeEi3uSqKGnYHyb45XiPr16XreIlmLPFS', 'student', 1),
(18, '20000000008', '$2y$10$/pr1ueUjBZls8ImbYECHPeEi3uSqKGnYHyb45XiPr16XreIlmLPFS', 'student', 1),
(19, '20000000009', '$2y$10$/pr1ueUjBZls8ImbYECHPeEi3uSqKGnYHyb45XiPr16XreIlmLPFS', 'student', 1),
(20, '20000000010', '$2y$10$/pr1ueUjBZls8ImbYECHPeEi3uSqKGnYHyb45XiPr16XreIlmLPFS', 'student', 1),
(21, '30000000001', '$2y$10$/pr1ueUjBZls8ImbYECHPeEi3uSqKGnYHyb45XiPr16XreIlmLPFS', 'student', 1),
(22, '30000000002', '$2y$10$/pr1ueUjBZls8ImbYECHPeEi3uSqKGnYHyb45XiPr16XreIlmLPFS', 'student', 1),
(23, '30000000003', '$2y$10$/pr1ueUjBZls8ImbYECHPeEi3uSqKGnYHyb45XiPr16XreIlmLPFS', 'student', 1),
(24, '30000000004', '$2y$10$/pr1ueUjBZls8ImbYECHPeEi3uSqKGnYHyb45XiPr16XreIlmLPFS', 'student', 1),
(25, '30000000005', '$2y$10$/pr1ueUjBZls8ImbYECHPeEi3uSqKGnYHyb45XiPr16XreIlmLPFS', 'student', 1),
(26, '30000000006', '$2y$10$/pr1ueUjBZls8ImbYECHPeEi3uSqKGnYHyb45XiPr16XreIlmLPFS', 'student', 1),
(27, '30000000007', '$2y$10$/pr1ueUjBZls8ImbYECHPeEi3uSqKGnYHyb45XiPr16XreIlmLPFS', 'student', 1),
(28, '30000000008', '$2y$10$/pr1ueUjBZls8ImbYECHPeEi3uSqKGnYHyb45XiPr16XreIlmLPFS', 'student', 1),
(29, '30000000009', '$2y$10$/pr1ueUjBZls8ImbYECHPeEi3uSqKGnYHyb45XiPr16XreIlmLPFS', 'student', 1),
(30, '30000000010', '$2y$10$/pr1ueUjBZls8ImbYECHPeEi3uSqKGnYHyb45XiPr16XreIlmLPFS', 'student', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `weekly_schedules`
--

CREATE TABLE `weekly_schedules` (
  `id` int(11) NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `day_of_week` int(11) DEFAULT NULL COMMENT '1: Pazartesi...',
  `period` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `weekly_schedules`
--

INSERT INTO `weekly_schedules` (`id`, `class_id`, `course_id`, `day_of_week`, `period`) VALUES
(1, 1, 2, 1, 1),
(2, 1, 2, 1, 2),
(3, 2, 2, 2, 1),
(4, 2, 2, 2, 2),
(5, 1, 2, 3, 3),
(6, 1, 2, 3, 4),
(7, 2, 2, 4, 1),
(8, 2, 2, 4, 2),
(9, 1, 2, 5, 5),
(10, 1, 2, 5, 6),
(11, 1, 2, 1, 1),
(12, 1, 2, 1, 2),
(13, 2, 2, 2, 3),
(14, 2, 2, 2, 4),
(15, 1, 1, 3, 1),
(16, 1, 1, 3, 2),
(17, 2, 1, 4, 3),
(18, 2, 1, 4, 4);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `ai_interaction_logs`
--
ALTER TABLE `ai_interaction_logs`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `announcement_targets`
--
ALTER TABLE `announcement_targets`
  ADD PRIMARY KEY (`announcement_id`,`class_id`);

--
-- Tablo için indeksler `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `exam_classes`
--
ALTER TABLE `exam_classes`
  ADD PRIMARY KEY (`exam_id`,`class_id`);

--
-- Tablo için indeksler `homework_assignments`
--
ALTER TABLE `homework_assignments`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `learning_outcomes`
--
ALTER TABLE `learning_outcomes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `outcome_code` (`outcome_code`);

--
-- Tablo için indeksler `library_content`
--
ALTER TABLE `library_content`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `parent_profiles`
--
ALTER TABLE `parent_profiles`
  ADD PRIMARY KEY (`user_id`);

--
-- Tablo için indeksler `parent_student_relationships`
--
ALTER TABLE `parent_student_relationships`
  ADD PRIMARY KEY (`parent_user_id`,`student_user_id`);

--
-- Tablo için indeksler `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `schedule_periods`
--
ALTER TABLE `schedule_periods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `period_number` (`period_number`);

--
-- Tablo için indeksler `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `student_answers`
--
ALTER TABLE `student_answers`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `student_exam_scores`
--
ALTER TABLE `student_exam_scores`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `student_profiles`
--
ALTER TABLE `student_profiles`
  ADD PRIMARY KEY (`user_id`);

--
-- Tablo için indeksler `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`setting_key`);

--
-- Tablo için indeksler `teacher_assignments`
--
ALTER TABLE `teacher_assignments`
  ADD PRIMARY KEY (`teacher_id`,`class_id`,`course_id`);

--
-- Tablo için indeksler `teacher_profiles`
--
ALTER TABLE `teacher_profiles`
  ADD PRIMARY KEY (`user_id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tc_kimlik` (`tc_kimlik`);

--
-- Tablo için indeksler `weekly_schedules`
--
ALTER TABLE `weekly_schedules`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `ai_interaction_logs`
--
ALTER TABLE `ai_interaction_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Tablo için AUTO_INCREMENT değeri `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `exams`
--
ALTER TABLE `exams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Tablo için AUTO_INCREMENT değeri `homework_assignments`
--
ALTER TABLE `homework_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `learning_outcomes`
--
ALTER TABLE `learning_outcomes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- Tablo için AUTO_INCREMENT değeri `library_content`
--
ALTER TABLE `library_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Tablo için AUTO_INCREMENT değeri `schedule_periods`
--
ALTER TABLE `schedule_periods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `schools`
--
ALTER TABLE `schools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `student_answers`
--
ALTER TABLE `student_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- Tablo için AUTO_INCREMENT değeri `student_exam_scores`
--
ALTER TABLE `student_exam_scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Tablo için AUTO_INCREMENT değeri `weekly_schedules`
--
ALTER TABLE `weekly_schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
