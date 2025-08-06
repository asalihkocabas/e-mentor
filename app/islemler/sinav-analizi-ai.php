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
} elseif (json_last_error() !== JSON_ERROR_NONE) {
    $response_data['analysis'] = 'HATA: Sunucuya gönderilen veride format sorunu var.';
} elseif (!empty($yanlis_sorular)) {

    $prompt_context = "Sen 6. sınıf öğrencisine yardımcı olan bir E-Mentor öğretmenisin. Öğrencinin sınavda yaptığı hataları, onu kırmadan, teşvik edici ve basit bir dille analiz edeceksin. Her bir hata için, önce doğru cevabın neden doğru olduğunu kısaca açıkla, sonra da öğrencinin yaptığı hatanın muhtemel sebebini (dikkatsizlik, bilgi eksiği vb.) nazikçe belirt. Cevabını Markdown formatında, her soru için başlıklar kullanarak düzenle.\n\nİşte öğrencinin yanlışları:\n\n";

    $soru_metinleri = "";
    foreach ($yanlis_sorular as $index => $soru) {
        $soru_metinleri .= "---\n\n";
        $soru_metinleri .= "**Soru " . ($index + 1) . ":** " . ($soru['question_text'] ?? 'Soru metni bulunamadı.') . "\n";
        $soru_metinleri .= "- **Doğru Cevap:** " . ($soru['correct_answer'] ?? 'N/A') . "\n";
        $soru_metinleri .= "- **Senin Cevabın:** " . ($soru['selected_answer'] ?? 'N/A') . "\n";
        $soru_metinleri .= "- **İlgili Kazanım:** " . ($soru['outcome_description'] ?? 'Belirtilmemiş') . "\n\n";
    }

    $final_prompt = $prompt_context . $soru_metinleri;

    $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/{$modelName}:generateContent?key=" . $apiKey;
    $data = ["contents" => [["parts" => [["text" => $final_prompt]]]]];
    $jsonData = json_encode($data);

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); // 10 saniye bağlantı zaman aşımı
    curl_setopt($ch, CURLOPT_TIMEOUT, 30); // 30 saniye toplam zaman aşımı