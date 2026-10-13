<?php 

declare(strict_types=1);
session_start();
require_once __DIR__ . "/data.php";

$name = $_SESSION["user_name"] ?? null;




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>Welcome, <?php echo e($name); ?>!</p>

    <button onclick="window.location.href='logout.php'">Logout</button>
</body>
</html>