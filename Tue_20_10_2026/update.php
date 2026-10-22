<?php
require_once __DIR__ . '/config/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $name = trim($_POST['name'] ?? '');
    $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
    $stock = filter_input(INPUT_POST, 'stock', FILTER_VALIDATE_INT);
    $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);

    if ($id && $name && $category_id && $price !== false && $stock !== false) {
        $database = new Database();
        $pdo = $database->connect();

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $fileTmp = $_FILES['image']['tmp_name'];
            $fileName = $_FILES['image']['name'];
            $fileSize = $_FILES['image']['size'];
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            $allowedExts = ['jpg', 'jpeg', 'png', 'webp'];

            if (in_array($fileExt, $allowedExts) && $fileSize <= 2 * 1024 * 1024) {
                $newFileName = uniqid('prod_', true) . '.' . $fileExt;
                $uploadDir = __DIR__ . '/uploads/';

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                if (move_uploaded_file($fileTmp, $uploadDir . $newFileName)) {
                    $stmtOld = $pdo->prepare('SELECT image FROM products WHERE id = ?');
                    $stmtOld->execute([$id]);
                    $oldProduct = $stmtOld->fetch(PDO::FETCH_ASSOC);

                    if ($oldProduct && !empty($oldProduct['image'])) {
                        $oldFilePath = $uploadDir . $oldProduct['image'];
                        if (file_exists($oldFilePath)) {
                            unlink($oldFilePath);
                        }
                    }

                    $stmt = $pdo->prepare('UPDATE products SET name = ?, price = ?, stock = ?, category_id = ?, image = ? WHERE id = ?');
                    $stmt->execute([$name, $price, $stock, $category_id, $newFileName, $id]);
                }
            }
        } else {
            $stmt = $pdo->prepare('UPDATE products SET name = ?, price = ?, stock = ?, category_id = ? WHERE id = ?');
            $stmt->execute([$name, $price, $stock, $category_id, $id]);
        }
    }
}

header('Location: dashboard.php');
exit;