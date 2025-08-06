<?php
// Sayfa ilk yüklendiğinde veya form gönderildiğinde çalışacak değişkenleri tanımlayalım.
$prompt = 'Sen şuan php ortamında çalışıp çalışmadığını test ediyoruz';
$ai_response = '';
$error = '';

// Form gönderilmiş mi diye kontrol et
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // GÜVENLİK NOTU: Gerçek bir projede API anahtarınızı doğrudan koda yazmak yerine, sunucu ortam değişkenlerinden okumak daha güvenlidir.
    // Hackathon için bu yöntem yeterlidir.
    $apiKey = "AIzaSyDfHeFLY-3-q2sp-Bwzo0OXuQap-xJo7Z0"; // <-- API ANAHTARINIZI BU SATIRA YAPIŞTIRIN

    // Formdan gelen prompt'u al
    $prompt = $_POST['prompt'] ?? '';

    if (!empty($prompt) && !empty($apiKey)) {

        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . $apiKey;

        // Gemini API'sinin istediği JSON formatı
        $data = [
            "contents" => [
                [
                    "parts" => [
                        [
                            "text" => $prompt
                        ]
                    ]
                ]
            ]
        ];

        $jsonData = json_encode($data);

        // PHP cURL ile API'ye POST isteği gönderme
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $error = 'cURL Hatası: ' . curl_error($ch);
        } else {
            $result = json_decode($response, true);

            // API'den gelen cevabı güvenli bir şekilde alalım
            if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                $ai_response = $result['candidates'][0]['content']['parts'][0]['text'];
            } else {
                // API'den bir hata mesajı gelmiş olabilir, bunu gösterelim
                $error = 'API Hatası: ' . ($result['error']['message'] ?? 'Bilinmeyen bir hata oluştu.');
            }
        }

        curl_close($ch);
    }
}
?>

<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8" />
    <title>Gemini API Test Sayfası</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-4">
                <img src="assets/images/logo-sm.svg" height="32" class="me-2">
                <span class="logo-txt h4 align-middle">Gemini API - PHP Test</span>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Yapay Zekaya Soru Sor</h4>
                    <p class="card-title-desc">Aşağıdaki kutuya bir soru veya komut yazarak Gemini API'yi test edebilirsiniz.</p>

                    <form action="gemini-test.php" method="POST">
                        <div class="mb-3">
                            <label for="prompt" class="form-label">Sorunuz veya İsteğiniz:</label>
                            <textarea class="form-control" id="prompt" name="prompt" rows="4" required><?= htmlspecialchars($prompt) ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Cevap Oluştur</button>
                    </form>
                </div>
            </div>

            <?php if (!empty($ai_response) || !empty($error)): ?>
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Sonuç</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger">
                                <strong>Hata:</strong> <?= htmlspecialchars($error) ?>
                            </div>
                        <?php else: ?>
                            <div class="mb-3">
                                <h6 class="text-muted">Sizin Sorunuz:</h6>
                                <p class="p-3 bg-light rounded"><?= htmlspecialchars($prompt) ?></p>
                            </div>
                            <div>
                                <h6 class="text-primary">Gemini'nin Cevabı:</h6>
                                <div class="p-3 bg-primary-subtle text-primary rounded"><?= nl2br(htmlspecialchars($ai_response)) ?></div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
</body>
</html>