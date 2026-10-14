
<?php
require_once __DIR__ . "/data.php";
session_start();

if (isset($_GET["delete"])) {
    $id = (int) $_GET["delete"];

    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: admin.php");
    exit;
}

$users = $pdo->query(
    "SELECT id, name, email, role FROM users"
)->fetchAll(PDO::FETCH_ASSOC);
$counter = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
       <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>
<body>
    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">id</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Role</th>
      <th scope="col"></th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>

<?php foreach ($users as $user): ?>
    <tr>
      <th scope="row"><?= $counter++ ?></th>
      <td><?= e($user["id"]) ?></td>
      <td><?= e($user["name"]) ?></td>
      <td><?= e($user["email"]) ?></td>
      <td><?= e($user["role"]) ?></td>
     
<td>
    <form action="delete.php" method="POST"
          onsubmit="return confirm('Are you sure you want to delete this user?');">

        <input type="hidden" name="id"
               value="<?= e($user['id']) ?>">

        <button type="submit" class="btn btn-outline-danger">
            Delete
        </button>
    </form>
</td>

<td>
    <a href="edit.php?id=<?= $user['id'] ?>"
       class="btn btn-outline-warning">
        Edit
    </a>
</td>

  

    </tr>
    <?php endforeach; ?>
  
  </tbody>
</table>
<a href="add.php" class="btn btn-outline-primary">Add User</a>
<button onclick="window.location.href='logout.php'" class="btn btn-danger">Logout</button>
</body>
</html>