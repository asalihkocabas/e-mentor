<?php
require_once '../config/init.php';

$user_prompt = $_POST['prompt'] ?? '';
$response_data = ['success' => false, 'message' => 'Geçersiz istek.'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($user_prompt)) {

    // ----- GEMINI API Entegrasyonu -----
    $apiKey = "AIzaSyDfHeFLY-3-q2sp-Bwzo0OXuQap-xJo7Z0";

    // Öğretmene özel, daha bağlamsal bir prompt oluşturuyoruz.
    $prompt = "Bir öğretmenim ve E-Mentor adlı bir eğitim platformu kullanıyorum. Soruma bu bağlamda cevap ver: " . $user_prompt;

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
        $response_data['message'] = 'API bağlantı hatası: ' . curl_error($ch);
    } else {
        $result = json_decode($api_response, true);
        if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            $response_data['success'] = true;
            $response_data['message'] = $result['candidates'][0]['content']['parts'][0]['text'];
        } else {
            $response_data['message'] = 'API\'den geçerli bir yanıt alınamadı. Lütfen API anahtarınızı kontrol edin.';
        }
    }
    curl_close($ch);
    // ----- GEMINI API Entegrasyonu Sonu -----
}

header('Content-Type: application/json');
echo json_encode($response_data);
?>