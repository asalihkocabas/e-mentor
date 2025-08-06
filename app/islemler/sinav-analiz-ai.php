<?php
require_once '../config/init.php';

// API anahtarını ve modelini veritabanından çek
$stmt = $pdo->query("SELECT setting_key, setting_value FROM system_settings WHERE setting_key IN ('gemini_api_key', 'gemini_model')");
$settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
$apiKey = $settings['gemini_api_key'] ?? null;
$modelName = $settings['gemini_model'] ?? 'gemini-1.5-flash-latest';

$yanlis_sorular_json = $_POST['yanlis_sorular'] ?? '[]';
$yanlis_sorular = json_decode($yanlis_sorular_json, true);
$response_data = ['success' => false, 'analysis' => 'Analiz edilecek veri bulunamadı.'];

if (!$apiKey || $apiKey === "BURAYA_KENDI_GEMINI_API_ANAHTARINIZI_GIRIN") {
    $response_data['analysis'] = 'HATA: Gemini API anahtarı sistemde kayıtlı değil.';
} elseif (!empty($yanlis_sorular)) {

    $prompt_context = "Sen 6. sınıf öğrencisine yardımcı olan bir E-Mentor öğretmenisin. Öğrencinin sınavda yaptığı hataları, onu kırmadan, teşvik edici ve basit bir dille analiz edeceksin. Her bir hata için, önce doğru cevabın neden doğru olduğunu kısaca açıkla, sonra da öğrencinin yaptığı hatanın muhtemel sebebini (dikkatsizlik, bilgi eksiği, çeldirici şıkka takılma vb.) nazikçe belirt. Cevabını Markdown formatında, her soru için başlıklar kullanarak düzenle.\n\nİşte öğrencinin yanlışları:\n\n";

    $soru_metinleri = "";
    foreach ($yanlis_sorular as $index => $soru) {
        $soru_metinleri .= "---\n\n";
        $soru_metinleri .= "**Soru " . ($index + 1) . ":** " . ($soru['question_text'] ?? 'Soru metni bulunamadı.') . "\n";

        // DÜZELTME: Şıkları prompt'a ekliyoruz
        $options = json_decode($soru['options'] ?? '{}', true);
        if(is_array($options)){
            foreach($options as $key => $value){
                $soru_metinleri .= "- " . $key . ") " . $value . "\n";
            }
        }

        $soru_metinleri .= "- **Doğru Cevap:** " . ($soru['correct_answer'] ?? 'N/A') . "\n";
        $soru_metinleri .= "- **Senin Cevabın:** " . ($soru['selected_answer'] ?? 'N/A') . "\n";
        $soru_metinleri .= "- **İlgili Kazanım:** " . ($soru['outcome_description'] ?? 'Belirtilmemiş') . "\n\n";
    }

    $final_prompt = $prompt_context . $soru_metinleri;

    $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/{$modelName}:generateContent?key=" . $apiKey;
    $data = ["contents" => [["parts" => [["text" => $final_prompt]]]]];
    $jsonData = json_encode($data);

    // cURL işlemleri... (değişiklik yok)
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $api_response = curl_exec($ch);

    if (curl_errno($ch)) {
        $response_data['analysis'] = 'API Bağlantı Hatası: ' . curl_error($ch);
    } else {
        $result = json_decode($api_response, true);
        if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            $response_data['success'] = true;
            $response_data['analysis'] = $result['candidates'][0]['content']['parts'][0]['text'];
        } else {
            $response_data['analysis'] = 'API\'den geçerli bir yanıt alınamadı. Hata: ' . ($result['error']['message'] ?? 'Bilinmeyen API hatası.');
        }
    }
    curl_close($ch);
}

header('Content-Type: application/json');
echo json_encode($response_data);
?>