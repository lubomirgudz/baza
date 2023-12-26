<?php
// submit_review.php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $db = new PDO('sqlite:path_to_your_database/reviews.db'); // Змініть шлях до вашої бази даних
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Отримання даних з POST запиту
        $author = $_POST['author'] ?? '';
        $content = $_POST['content'] ?? '';

        // Перевірка на порожні поля
        if (empty($author) || empty($content)) {
            throw new Exception("All fields are required.");
        }

        // Запис відгуків у базу даних
        $stmt = $db->prepare("INSERT INTO reviews (author, content) VALUES (:author, :content)");
        $stmt->execute(['author' => $author, 'content' => $content]);

        echo json_encode(['success' => 'Review submitted successfully.']);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Invalid request method.']);
}
?>