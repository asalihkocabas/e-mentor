<?php
require_once '../config/init.php';

// Filtreleme parametrelerini al
$type = $_POST['type'] ?? '';
$course_name = $_POST['course'] ?? '';
// Diğer filtreler (sınıf vb.) de buraya eklenebilir.

// Ana SQL sorgusunu oluştur
$sql = "SELECT lc.*, c.name as course_name, cl.name as class_name 
        FROM library_content lc
        LEFT JOIN courses c ON JSON_UNQUOTE(JSON_EXTRACT(lc.metadata, '$.course_id')) = c.id
        LEFT JOIN classes cl ON JSON_UNQUOTE(JSON_EXTRACT(lc.metadata, '$.class_id')) = cl.id
        WHERE 1=1";

$params = [];

if (!empty($type)) {
    $sql .= " AND lc.file_type = ?";
    $params[] = $type;
}
if (!empty($course_name)) {
    $sql .= " AND c.name = ?";
    $params[] = $course_name;
}
$sql .= " ORDER BY lc.upload_date DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$library_contents = $stmt->fetchAll(PDO::FETCH_ASSOC);

$output = '';
if (empty($library_contents)) {
    $output = '<div class="col-12"><div class="alert alert-warning text-center">Bu kriterlere uygun içerik bulunamadı.</div></div>';
} else {
    foreach ($library_contents as $content) {
        $metadata = json_decode($content['metadata'], true);
        $color = 'primary'; $icon = 'bx-file';
        if($content['file_type'] == 'Kazanım Testi') {$color = 'success'; $icon = 'bx-task';}
        if($content['file_type'] == 'Ders Kitabı') {$color = 'info'; $icon = 'bx-book-open';}
        if($content['file_type'] == 'Çıkmış Soru') {$color = 'warning'; $icon = 'bx-question-mark';}

        $output .= '
        <div class="col-md-6 col-xl-4">
            <div class="card book-card">
                <div class="book-cover bg-'.$color.' bg-gradient"><i class="bx '.$icon.'"></i></div>
                <div class="card-body d-flex flex-column">
                    <span class="badge bg-'.$color.'-subtle text-'.$color.' align-self-start">'.htmlspecialchars($content['file_type']).'</span>
                    <h5 class="font-size-16 my-2 flex-grow-1"><a href="#" class="text-dark">'.htmlspecialchars($content['file_name']).'</a></h5>
                    <div class="meta-badges">
                        <span class="badge bg-light me-1">'.htmlspecialchars($content['course_name'] ?? '').'</span>
                        <span class="badge bg-light me-1">'.htmlspecialchars($content['class_name'] ?? '').'</span>
                    </div>
                    <a href="'.htmlspecialchars($content['file_path']).'" class="btn btn-primary btn-sm w-100 mt-3" download><i class="bx bx-download me-1"></i> İndir</a>
                </div>
            </div>
        </div>';
    }
}
echo $output;
?>