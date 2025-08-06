<?php
// config/init.php dosyasını çağırarak session'ı başlatır ve veritabanına bağlanırız.
require_once '../config/init.php';

// Formun POST metodu ile gönderilip gönderilmediğini kontrol edelim.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Formdan gelen verileri temizleyerek alalım.
    $tc_kimlik = trim($_POST['tc_kimlik']);
    $password = trim($_POST['password']);
    $expected_role = trim($_POST['role']); // Formun ait olduğu rol (teacher veya student)

    // Başarısız giriş durumunda geri dönülecek varsayılan giriş sayfası.
    $login_page = ($expected_role == 'teacher') ? '../giris-ogretmen.php' : '../giris-ogrenci.php';

    // 1. ADIM: Kullanıcı veritabanında var mı? (Sadece T.C. ile kontrol)
    $stmt = $pdo->prepare("SELECT * FROM users WHERE tc_kimlik = ?");
    $stmt->execute([$tc_kimlik]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Eğer bu T.C. ile bir kullanıcı bulunamadıysa...
    if (!$user) {
        $_SESSION['login_error'] = "Bu T.C. Kimlik Numarası ile kayıtlı kullanıcı bulunamadı.";
        header("Location: " . $login_page);
        exit();
    }

    // 2. ADIM: Kullanıcının rolü, girmeye çalıştığı formla uyumlu mu?
    if ($user['role'] != $expected_role) {
        $_SESSION['login_error'] = "Hatalı giriş sayfası! Lütfen kendi rolünüze uygun sayfadan giriş yapın.";
        // Kullanıcıyı ait olduğu doğru giriş sayfasına yönlendir
        $correct_login_page = ($user['role'] == 'teacher') ? '../giris-ogretmen.php' : '../giris-ogrenci.php';
        header("Location: " . $correct_login_page);
        exit();
    }

    // 3. ADIM: Şifre doğru mu?
    if (password_verify($password, $user['password'])) {
        // --- GİRİŞ BAŞARILI ---

        // Rolüne göre profil tablosundan adını çekelim.
        $profile_table = ($user['role'] == 'teacher') ? 'teacher_profiles' : 'student_profiles';
        $stmt_profile = $pdo->prepare("SELECT full_name FROM $profile_table WHERE user_id = ?");
        $stmt_profile->execute([$user['id']]);
        $profile = $stmt_profile->fetch(PDO::FETCH_ASSOC);

        // Session değişkenlerini ayarlayalım.
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['full_name'] = $profile['full_name'] ?? 'Kullanıcı';
        $_SESSION['is_logged_in'] = true;

        // Rolüne göre doğru panele yönlendirelim.
        $dashboard_page = ($user['role'] == 'teacher') ? '../ogretmen/index.php' : '../ogrenci/index.php';
        header("Location: " . $dashboard_page);
        exit();

    } else {
        // --- GİRİŞ BAŞARISIZ (Şifre Yanlış) ---
        $_SESSION['login_error'] = "T.C. Kimlik Numarası veya şifre hatalı!";
        header("Location: " . $login_page);
        exit();
    }

} else {
    // Eğer sayfa POST metodu ile çağrılmadıysa, ana role seçim sayfasına yönlendir.
    header("Location: ../index.php");
    exit();
}
?>