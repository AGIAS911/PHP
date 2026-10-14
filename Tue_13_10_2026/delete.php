
<?php
session_start();
require_once __DIR__ . "/data.php";

if (
    !isset($_SESSION["user_id"]) ||
    ($_SESSION["user_role"] ?? "") !== "admin"
) {
    http_response_code(403);
    exit("Access denied.");
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit("Method not allowed.");
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

if (!$id || $id === (int) $_SESSION["user_id"]) {
    exit("Invalid user ID or cannot delete your own account.");
}

$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$id]);

header("Location: admin.php");
exit;
