<?php
require_once __DIR__ . '/config/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if ($id) {
        $database = new Database();
        $pdo = $database->connect();

        $stmt = $pdo->prepare('SELECT image FROM products WHERE id = ?');
        $stmt->execute([$id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product && !empty($product['image'])) {
            $imagePath = __DIR__ . '/uploads/' . $product['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $stmtDelete = $pdo->prepare('DELETE FROM products WHERE id = ?');
        $stmtDelete->execute([$id]);
    }
}

header('Location: dashboard.php');
exit;