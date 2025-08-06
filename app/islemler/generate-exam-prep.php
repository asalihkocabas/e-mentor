<?php
require_once '../config/init.php';

// API anahtarını ve modelini veritabanından çek
$stmt = $pdo->query("SELECT setting_key, setting_value FROM system_settings WHERE setting_key IN ('gemini_api_key', 'gemini_model')");
$settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
$apiKey = $settings['gemini_api_key'] ?? null;
$modelName = $settings['gemini_model'] ?? 'gemini-1.5-flash-latest';

$kazanimlar_str = $_POST['kazanimlar'] ?? '';
$response_data = ['success' => false, 'data' => ['oneriler' => ['Kazanım bilgisi bulunamadı.']]];

if (!$apiKey || $apiKey === "BURAYA_KENDI_GEMINI_API_ANAHTARINIZI_GIRIN") {
    $response_data['data']['oneriler'] = ['HATA: Gemini API anahtarı sistemde kayıtlı değil. Lütfen yönetici panelinden ekleyin.'];
} elseif (!empty($kazanimlar_str)) {

    $prompt = "Bir öğrenci için, aşağıdaki kazanımları temel alarak bir sınava hazırlık materyali oluştur. Cevabını MUTLAKA şu formatta bir JSON nesnesi olarak ver: {\"konular\": [\"kazanımların özetlendiği maddeler halinde bir liste\"], \"ornek_sorular\": [{\"soru\": \"çoktan seçmeli bir soru ve şıkları\", \"cevap\": \"doğru cevap şıkkı\"}, {\"soru\": \"başka bir çoktan seçmeli soru ve şıkları\", \"cevap\": \"doğru cevap şıkkı\"}], \"oneriler\": [\"bu konulara nasıl çalışılması gerektiğine dair 3 adet taktik\"]}. İşte kazanımlar: \n\n" . $kazanimlar_str;

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
        $response_data['data']['oneriler'] = ['API Bağlantı Hatası: ' . curl_error($ch)];
    } else {
        $result = json_decode($api_response, true);
        if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            $raw_text = $result['candidates'][0]['content']['parts'][0]['text'];
            $json_text = $raw_text;
            if (preg_match('/`+json\s*([\s\S]*?)\s*`+/', $raw_text, $matches)) {
                $json_text = $matches[1];
            }
            $json_data = json_decode($json_text, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($json_data)) {
                $response_data['success'] = true;
                $response_data['data'] = $json_data;
            } else {
                $response_data['data']['oneriler'] = ['Yapay zekadan yapısal bir cevap alınamadı. Ham Cevap: ' . htmlspecialchars($raw_text)];
            }
        } else {
            $error_message = $result['error']['message'] ?? 'Bilinmeyen bir API hatası oluştu. Lütfen API anahtarınızı ve Google Cloud projenizin durumunu kontrol edin.';
            $response_data['data']['oneriler'] = ['API Hatası: ' . htmlspecialchars($error_message)];
        }
    }
    curl_close($ch);
}

header('Content-Type: application/json');
echo json_encode($response_data);
?>