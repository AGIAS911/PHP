<?php 
require_once __DIR__ . "/../config/Database.php"; 
require_once __DIR__ . "/../classes/UserRepository.php";

$database = new Database();
$pdo = $database->connect();

$userRepository = new UserRepository($pdo);
$users = $userRepository->getAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">


    <div class="container mt-5">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 text-dark mb-0">Users Dashboard</h1>
            <a href="create.php" class="btn btn-primary shadow-sm">
                + Add New User
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                
                <?php if (empty($users)): ?>
                    <div class="alert alert-info m-4 text-center" role="alert">
                        No users found. Click "Add New User" to get started.
                    </div>
                <?php else: ?>

                    <div class="table-responsive">
      
                        <table class="table table-hover table-striped align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col" class="ps-4">ID</th>
                                    <th scope="col">First Name</th>
                                    <th scope="col">Last Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Contact Number</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Created At</th>
                                    <th scope="col" class="text-center pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td class="ps-4 fw-bold">
                                            <?= htmlspecialchars((string) $user["id"], ENT_QUOTES, "UTF-8") ?>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars($user["first_name"], ENT_QUOTES, "UTF-8") ?>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars($user["last_name"], ENT_QUOTES, "UTF-8") ?>
                                        </td>
                                        <td>
                                            <a href="mailto:<?= htmlspecialchars($user["email"], ENT_QUOTES, "UTF-8") ?>" class="text-decoration-none">
                                                <?= htmlspecialchars($user["email"], ENT_QUOTES, "UTF-8") ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars($user["contact_number"], ENT_QUOTES, "UTF-8") ?>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars($user["address"], ENT_QUOTES, "UTF-8") ?>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars($user["created_at"], ENT_QUOTES, "UTF-8") ?>
                                        </td>
                                        <td class="text-center pe-4">
                                    
                                            <a href="edit.php?id=<?= (int) $user["id"] ?>" class="btn btn-sm btn-outline-warning me-1">
                                                Edit
                                            </a>

                                  
                                            <form method="POST" action="delete.php" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                <input type="hidden" name="id" value="<?= (int) $user["id"] ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                <?php endif; ?>

            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>