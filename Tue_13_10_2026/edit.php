
<?php
require_once __DIR__ . "/data.php";

$id = (int) ($_GET["id"] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    exit("User not found");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");

    if ($name !== "" && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $pdo->prepare(
            "UPDATE users SET name = ?, email = ? WHERE id = ?"
        );

        $stmt->execute([$name, $email, $id]);

        header("Location: admin.php");
        exit;
    }
}
?>

<form method="POST" class="container mt-5">
    <label class="form-label">Name</label>
    <input class="form-control mb-3" name="name"
           value="<?= e($user['name']) ?>" required>

    <label class="form-label">Email</label>
    <input class="form-control mb-3" type="email" name="email"
           value="<?= e($user['email']) ?>" required>

    <button class="btn btn-primary">Save Changes</button>
</form>
