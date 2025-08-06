<?php
require_once '../config/init.php';

// API anahtarını ve modelini veritabanından çek
$stmt = $pdo->query("SELECT setting_key, setting_value FROM system_settings WHERE setting_key IN ('gemini_api_key', 'gemini_model')");
$settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
$apiKey = $settings['gemini_api_key'] ?? null;
$modelName = $settings['gemini_model'] ?? 'gemini-1.5-flash-latest';

$outcome_description = $_POST['description'] ?? '';
$response_data = ['success' => false, 'content' => 'Kazanım açıklaması bulunamadı.'];

if (!$apiKey) {
    $response_data['content'] = 'HATA: Gemini API anahtarı sistemde kayıtlı değil.';
} elseif (!empty($outcome_description)) {

    $prompt = "Bir 6. sınıf öğrencisi için, '" . addslashes($outcome_description) . "' kazanımını pekiştirecek 5 adet çoktan seçmeli (4 şıklı) soru ve cevabını oluştur. Soruları ve şıkları listele. Cevap anahtarını en sona 'Cevap Anahtarı: 1-A, 2-C...' şeklinde ekle.";

    $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/{$modelName}:generateContent?key=" . $apiKey;
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
            $response_data['content'] = 'API\'den geçerli bir yanıt alınamadı. Hata: ' . ($result['error']['message'] ?? 'Bilinmeyen hata');
        }
    }
    curl_close($ch);
}

header('Content-Type: application/json');
echo json_encode($response_data);
?>