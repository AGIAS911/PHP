<?php
declare(strict_types=1);
session_start();
require_once __DIR__ . "/data.php";

$errors = [];
$name = $email = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name  = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
 

    if (mb_strlen($name) < 2) {
        $errors["name"] = "Name must be at least 2 characters.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["errors"] = "Invalid email address.";  
    }
    if (mb_strlen($password) < 6) {
        $errors["password"] = "Password must be at least 6 characters.";
    }

 
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors["email"] = "This email is already registered.";
        }
    }
 
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $hashedPassword]);
 
        header("Location: login.php?registered=success");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 400px; margin: 50px auto; padding: 20px; }
        input { width: 100%; padding: 8px; margin: 6px 0 14px; box-sizing: border-box; }
        .error { color: red; font-size: 13px; }
        button { padding: 10px 15px; background: #2e9d5b; color: #fff; border: none; cursor: pointer; }
    </style>
</head>
<body>
    <h2>Create an Account</h2>
    
    <form action="" method="post">
        <label>Full Name</label>
        <input type="text" name="name" value="<?= e($name) ?>">
        <?php if (isset($errors["name"])): ?><p class="error"><?= $errors["name"] ?></p><?php endif; ?>

        <label>Email Address</label>
        <input type="email" name="email" value="<?= e($email) ?>">
        <?php if (isset($errors["email"])): ?><p class="error"><?= $errors["email"] ?></p><?php endif; ?>

        <label>Password</label>
        <input type="password" name="password">
        <?php if (isset($errors["password"])): ?><p class="error"><?= $errors["password"] ?></p><?php endif; ?>

        <button type="submit">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>