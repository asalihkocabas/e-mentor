<?php
require_once '../config/init.php';

$kazanimlar_str = $_POST['kazanimlar'] ?? '';
$response_data = ['success' => false, 'notes' => 'Kazanım bilgisi bulunamadı.'];

if (!empty($kazanimlar_str)) {
    $apiKey = "AIzaSyDfHeFLY-3-q2sp-Bwzo0OXuQap-xJo7Z0";
    $prompt = "Bir 6. sınıf öğrencisi için, aşağıdaki kazanımları kapsayan kısa ve anlaşılır bir çalışma notu hazırla:\n\n" . $kazanimlar_str;

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

    if (!curl_errno($ch)) {
        $result = json_decode($api_response, true);
        if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            $response_data['success'] = true;
            $response_data['notes'] = $result['candidates'][0]['content']['parts'][0]['text'];
        } else {
            $response_data['notes'] = 'API\'den geçerli bir yanıt alınamadı.';
        }
    }
    curl_close($ch);
}

header('Content-Type: application/json');
echo json_encode($response_data);
?>