<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../includes/db.php';

// Faqat POST so'rovlarini qabul qilish
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Faqat POST so\'rovi qo\'llab-quvvatlanadi']);
    exit;
}

// JSON ma'lumotlarni o'qish
$input = json_decode(file_get_contents('php://input'), true);

$user_id = filter_var($input['user_id'] ?? 1, FILTER_VALIDATE_INT); // Sinov uchun default user_id = 1
$manga_id = filter_var($input['manga_id'] ?? null, FILTER_VALIDATE_INT);
$chapter_id = filter_var($input['chapter_id'] ?? null, FILTER_VALIDATE_INT);
$progress_percent = filter_var($input['progress_percent'] ?? 0, FILTER_VALIDATE_INT);

if (!$manga_id || !$chapter_id) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Manga ID yoki Chapter ID yetishmayapti']);
    exit;
}

try {
    // Bazaga saqlash yoki yangilash (Upsert)
    $stmt = $pdo->prepare("
        INSERT INTO reading_progress (user_id, manga_id, chapter_id, progress_percent, updated_at)
        VALUES (?, ?, ?, ?, NOW())
        ON DUPLICATE KEY UPDATE 
            chapter_id = VALUES(chapter_id),
            progress_percent = VALUES(progress_percent),
            updated_at = NOW()
    ");
    
    $stmt->execute([$user_id, $manga_id, $chapter_id, $progress_percent]);

    echo json_encode(['success' => true, 'message' => 'O\'qish jarayoni muvaffaqiyatli saqlandi']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Bazada xatolik: ' . $e->getMessage()]);
}