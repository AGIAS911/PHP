<?php 
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category_id = $_POST['category_id'];

    $stmt = $pdo->prepare('UPDATE products SET name = ?, price = ?, stock = ?, category_id = ? WHERE id = ?');
    $stmt->execute([$name, $price, $stock, $category_id, $id]);

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}