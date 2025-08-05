<?php
require_once 'config/init.php';

echo "<pre style='font-family: monospace; font-size: 12px; white-space: pre-wrap; word-wrap: break-word;'>";

function importOutcomes(PDO $pdo, string $filePath, int $courseId, int $gradeLevel) {
    if (!file_exists($filePath)) {
        echo "<strong style='color:red;'>HATA: Dosya bulunamadı -> " . htmlspecialchars($filePath) . "</strong>\n";
        return;
    }

    $file = fopen($filePath, 'r');
    $line = 0;

    $currentMonth = '';
    $currentWeekStr = '';
    $aylar = ["EYLÜL" => "09", "EKİM" => "10", "KASIM" => "11", "ARALIK" => "12", "OCAK" => "01", "ŞUBAT" => "02", "MART" => "03", "NİSAN" => "04", "MAYIS" => "05", "HAZİRAN" => "06"];

    while (($row = fgetcsv($file, 0, ';')) !== FALSE) {
        $line++;
        if ($line <= 2 || empty(array_filter($row, 'trim'))) continue;

        $ayStr = !empty(trim($row[0] ?? '')) ? trim($row[0]) : $currentMonth;
        if (!empty(trim($row[0] ?? ''))) $currentMonth = $ayStr;

        $haftaStr = !empty(trim($row[1] ?? '')) ? trim($row[1]) : $currentWeekStr;
        if (!empty(trim($row[1] ?? ''))) $currentWeekStr = $haftaStr;

        $unite = trim($row[3] ?? '');
        $kazanimlarStr = trim($row[5] ?? ''); // Her iki dosya için de 5. sütun ana kazanım bilgisini içerir.

        if (empty($haftaStr) || empty($unite) || empty($kazanimlarStr)) continue;

        preg_match('/(\d+)-?(\d+)?\s+([a-zA-ZıİğĞüÜşŞöÖçÇ]+)/u', $haftaStr, $matches);
        if (count($matches) < 3) continue;

        $startDay = $matches[1];
        $endDay = $matches[2] ?? $startDay;
        $monthName = mb_strtoupper(trim($matches[3]), 'UTF-8');

        if (!isset($aylar[$monthName])) continue;

        $monthNumber = $aylar[$monthName];
        $year = (intval($monthNumber) >= 9) ? 2024 : 2025;

        $startDate = "$year-$monthNumber-" . str_pad($startDay, 2, '0', STR_PAD_LEFT);
        $endDate = "$year-$monthNumber-" . str_pad($endDay, 2, '0', STR_PAD_LEFT);

        $kazanimlar = preg_split('/\r\n|\r|\n/', $kazanimlarStr);

        foreach ($kazanimlar as $kazanim) {
            $kazanim = trim($kazanim);
            if (empty($kazanim)) continue;

            // Kazanım formatını yakala (Örn: F.6.1.1.1. Açıklama...)
            preg_match('/^([A-Z]\.\d\.\d\.\d\.\d\.)\s*(.*)$/u', $kazanim, $kazanimMatches);
            if (count($kazanimMatches) < 3) {
                echo "SATIR $line UYARI: Kazanım formatı tanınamadı -> " . htmlspecialchars($kazanim) . "\n";
                continue;
            }

            $outcomeCode = trim($kazanimMatches[1]);
            $description = trim($kazanimMatches[2]);

            try {
                $stmt = $pdo->prepare(
                    "INSERT INTO learning_outcomes (course_id, grade_level, unit_name, outcome_code, description, start_date, end_date) 
                     VALUES (?, ?, ?, ?, ?, ?, ?)"
                );
                $stmt->execute([$courseId, $gradeLevel, $unite, $outcomeCode, $description, $startDate, $endDate]);
                echo "<span style='color:green;'>EKLENDİ:</span> $outcomeCode - " . htmlspecialchars($description) . "\n";
            } catch (PDOException $e) {
                if ($e->errorInfo[1] == 1062) {
                    echo "<span style='color:orange;'>ZATEN MEVCUT:</span> $outcomeCode\n";
                } else {
                    echo "<strong style='color:red;'>VERİTABANI HATASI: " . $e->getMessage() . "</strong>\n";
                }
            }
        }
    }

    fclose($file);
    echo "\n<strong style='color:blue;'>" . htmlspecialchars($filePath) . " dosyası başarıyla işlendi.</strong>\n\n";
}

// --- İŞLEMİ BAŞLAT ---
echo "Kazanım aktarımı başlatılıyor...\n\n";
// Fen Bilimleri (courseId: 3) ve Matematik (courseId: 2) Kazanımlarını Aktar
importOutcomes($pdo, 'veri-aktarim/fen.csv', 3, 6);
importOutcomes($pdo, 'veri-aktarim/kazanimlar.xlsx - Matematik 6.csv', 2, 6);
echo "<strong style='color:blue; font-size: 16px;'>Tüm işlemler tamamlandı.</strong>";
echo "</pre>";
?>