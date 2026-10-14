
<?php
require_once __DIR__ . "/data.php";
session_start();
$errors = [];
$name = "";
$email = "";
$password = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($name === "") {
        $errors["name"] = "Enter your name.";
    }

    if ($email === "") {
        $errors["email"] = "Enter your email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Enter a valid email.";
    } else {
        $stmt = $pdo->prepare(
            "SELECT id FROM users WHERE email = ?"
        );
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $errors["email"] = "This email is already registered.";
        }
    }

    if ($password === "") {
        $errors["password"] = "Enter your password.";
    }

    if (empty($errors)) {

        $hashPassword = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $stmt = $pdo->prepare(
            "INSERT INTO users (name, email, password)
             VALUES (?, ?, ?)"
        );

        $stmt->execute([
            $name,
            $email,
            $hashPassword
        ]);

        $success = "Registration successful!";

        $name = "";
        $email = "";
        $password = "";
    }
     header("Location: admin.php");
     exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body>

    <form method="POST" class="container mt-5 w-50">

        <?php if ($success !== ""): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>

            <input
                type="text"
                class="form-control"
                id="name"
                name="name"
                placeholder="Enter your full name"
                value="<?= htmlspecialchars($name) ?>"
                required>

            <div class="text-danger">
                <?= htmlspecialchars($errors["name"] ?? "") ?>
            </div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>

            <input
                type="email"
                class="form-control"
                id="email"
                name="email"
                placeholder="name@example.com"
                value="<?= htmlspecialchars($email) ?>"
                required>

            <div class="text-danger">
                <?= htmlspecialchars($errors["email"] ?? "") ?>
            </div>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>

            <input
                type="password"
                class="form-control"
                id="password"
                name="password"
                placeholder="Enter your password"
                required>

            <div class="text-danger">
                <?= htmlspecialchars($errors["password"] ?? "") ?>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">
            Submit
        </button>

    </form>

</body>
</html>
