<?php
require_once '../config/init.php';

$outcome_description = $_POST['description'] ?? '';
$response_data = ['success' => false, 'content' => 'Kazanım açıklaması bulunamadı.'];

if (!empty($outcome_description)) {

    // ----- GEMINI API Entegrasyonu -----
    // Lütfen 'system_settings' tablosundan veya doğrudan buraya API anahtarınızı girin.
    $apiKey = "AIzaSyDfHeFLY-3-q2sp-Bwzo0OXuQap-xJo7Z0";

    // Gemini için otomatik prompt oluşturma
    $prompt = "Bir 6. sınıf öğrencisi için, '" . addslashes($outcome_description) . "' kazanımını pekiştirecek 5 adet çoktan seçmeli (4 şıklı) soru ve cevabını oluştur. Soruları ve şıkları listele. Cevap anahtarını en sona 'Cevap Anahtarı: 1-A, 2-C...' şeklinde ekle.";

    $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . $apiKey;
    $data = ["contents" => [["parts" => [["text" => $prompt]]]]];
    $jsonData = json_encode($data);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $api_response = curl_exec($ch);

    if (curl_errno($ch)) {
        $response_data['content'] = 'API bağlantı hatası: ' . curl_error($ch);
    } else {
        $result = json_decode($api_response, true);
        if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            $response_data['success'] = true;
            $response_data['content'] = $result['candidates'][0]['content']['parts'][0]['text'];
        } else {
            $response_data['content'] = 'API\'den geçerli bir yanıt alınamadı. Lütfen API anahtarınızı kontrol edin. Hata: ' . ($result['error']['message'] ?? 'Bilinmeyen hata');
        }
    }
    curl_close($ch);
}

header('Content-Type: application/json');
echo json_encode($response_data);
?>