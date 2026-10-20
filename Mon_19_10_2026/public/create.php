<?php

require_once __DIR__ . "/../config/Database.php";
require_once __DIR__ . "/../classes/UserRepository.php";

$database = new Database();
$pdo = $database->connect();

$userRepository = new UserRepository($pdo);
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstName = trim($_POST["first_name"] ?? "");
    $lastName = trim($_POST["last_name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $contactNumber = trim($_POST["contact_number"] ?? "");
    $address = trim($_POST["address"] ?? "");

    if ($firstName === "" || $lastName === "" || $email === "" || $contactNumber === "" || $address === "") {
        $error = "Please enter valid information.";
    } else {
        try {
            $success = $userRepository->create(
                $firstName,
                $lastName,
                $email,
                $contactNumber,
                $address
            );

            if ($success) {
                header("Location: index.php");
                exit;
            }

            $error = "Failed to create user.";
        } catch (PDOException $e) {
            $error = "Could not create user. Please check the information and try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
    <!-- استدعاء Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">

                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body p-4 p-md-5">

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2 class="h3 text-dark fw-bold mb-0">Create New User</h2>
                        </div>

                        <?php if ($error !== ""): ?>
                            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                                <?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="">

                            <div class="row g-3 mb-3">
                                <div class="col-sm-6">
                                    <label for="first_name" class="form-label fw-semibold">First Name</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="first_name"
                                        name="first_name"
                                        maxlength="100"
                                        placeholder="e.g. John"
                                        value="<?= htmlspecialchars($_POST["first_name"] ?? "", ENT_QUOTES, "UTF-8") ?>"
                                        required>
                                </div>

                                <div class="col-sm-6">
                                    <label for="last_name" class="form-label fw-semibold">Last Name</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="last_name"
                                        name="last_name"
                                        maxlength="100"
                                        placeholder="e.g. Doe"
                                        value="<?= htmlspecialchars($_POST["last_name"] ?? "", ENT_QUOTES, "UTF-8") ?>"
                                        required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email Address</label>
                                <input
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    maxlength="150"
                                    placeholder="name@example.com"
                                    value="<?= htmlspecialchars($_POST["email"] ?? "", ENT_QUOTES, "UTF-8") ?>"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="contact_number" class="form-label fw-semibold">Contact Number</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="contact_number"
                                    name="contact_number"
                                    maxlength="20"
                                    placeholder="+962..."
                                    value="<?= htmlspecialchars($_POST["contact_number"] ?? "", ENT_QUOTES, "UTF-8") ?>"
                                    required>
                            </div>

                            <div class="mb-4">
                                <label for="address" class="form-label fw-semibold">Address</label>
                                <textarea
                                    class="form-control"
                                    id="address"
                                    name="address"
                                    rows="3"
                                    maxlength="255"
                                    placeholder="Enter street or building details"
                                    required><?= htmlspecialchars($_POST["address"] ?? "", ENT_QUOTES, "UTF-8") ?></textarea>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                                    Create User
                                </button>
                                <a href="index.php" class="btn btn-outline-secondary">
                                    Back to Dashboard
                                </a>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>