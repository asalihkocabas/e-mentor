<?php
require_once '../config/init.php';

// API anahtarını ve modelini veritabanından çek
$stmt = $pdo->query("SELECT setting_key, setting_value FROM system_settings WHERE setting_key IN ('gemini_api_key', 'gemini_model')");
$settings = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
$apiKey = $settings['gemini_api_key'] ?? null;
$modelName = $settings['gemini_model'] ?? 'gemini-1.5-flash-latest'; // Varsayılan model

$user_prompt = $_POST['prompt'] ?? '';
$user_role = $_SESSION['user_role'] ?? 'student';
$response_data = ['success' => false, 'message' => 'Geçersiz istek.'];

if (!$apiKey) {
    $response_data['message'] = 'HATA: Gemini API anahtarı sistemde kayıtlı değil.';
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($user_prompt)) {

    $context = ($user_role == 'teacher')
        ? "Bir öğretmenim ve E-Mentor adlı bir eğitim platformu kullanıyorum. Soruma bu bağlamda cevap ver: "
        : "Bir 6. sınıf öğrencisiyim. Soruma bu bağlamda, anlayabileceğim bir dille cevap ver: ";

    $prompt = $context . $user_prompt;

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
        $response_data['message'] = 'API bağlantı hatası: ' . curl_error($ch);
    } else {
        $result = json_decode($api_response, true);
        if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            $response_data['success'] = true;
            $response_data['message'] = $result['candidates'][0]['content']['parts'][0]['text'];
        } else {
            $response_data['message'] = 'API\'den geçerli bir yanıt alınamadı. Hata: ' . ($result['error']['message'] ?? 'Bilinmeyen hata');
        }
    }
    curl_close($ch);
}

header('Content-Type: application/json');
echo json_encode($response_data);
?>