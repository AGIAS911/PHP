<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . "/data.php";

$errors = [];
$email = "";
$password = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Invalid email address.";
    }

    if (empty($password)) {
        $errors["password"] = "Password is required.";
    }


if (empty($errors)) {
    $stmt = $pdo->prepare(
        "SELECT id, name, password, role FROM users WHERE email = ?"
    );

    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password"])) {
        session_regenerate_id(true);

        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_name"] = $user["name"];
        $_SESSION["user_role"] = $user["role"];

        if ($user["role"] === "admin") {
            header("Location: admin.php");
        } else {
            header("Location: dashboard.php");
        }

        exit;
    } else {
        $errors["login"] = "Invalid email or password.";
    }
}

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 400px; margin: 50px auto; padding: 20px; }
        input { width: 100%; padding: 8px; margin: 6px 0 14px; box-sizing: border-box; }
        .error { color: red; font-size: 13px; }
        button { padding: 10px 15px; background: #2e9d5b; color: #fff; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <h2>Login</h2>

    <form action="" method="post">
        <label>Email Address</label>
        <input type="email" name="email" value="<?= e($email) ?>">
        <?php if (isset($errors["email"])): ?><p class="error"><?= $errors["email"] ?></p><?php endif; ?>

        <label>Password</label>
        <input type="password" name="password">
        <?php if (isset($errors["password"])): ?><p class="error"><?= $errors["password"] ?></p><?php endif; ?>
        <?php if (isset($errors["login"])): ?><p class="error"><?= $errors["login"] ?></p><?php endif; ?>

        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="register.php">Register here</a></p>
</body>
</html>