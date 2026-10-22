<?php 
require_once __DIR__ . '/config/Database.php';

$database = new Database();
$pdo = $database->connect();

$categories = $pdo->query('SELECT * FROM categories')->fetchAll(PDO::FETCH_ASSOC);

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $proName = trim($_POST['name'] ?? '');
    $proPrice = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
    $proStock = filter_input(INPUT_POST, 'stock', FILTER_VALIDATE_INT);
    $proCategory_id = filter_input(INPUT_POST, 'category', FILTER_VALIDATE_INT);
    $proDescription = trim($_POST['description'] ?? '');

    if (!$proName || !$proCategory_id || $proPrice === false || $proStock === false) {
        $error = "Please fill in all required fields correctly.";
    } elseif (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $error = "Please upload a product image.";
    } else {
        $fileTmp = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedExts = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($fileExt, $allowedExts)) {
            $error = "Allowed image formats: JPG, JPEG, PNG, WEBP.";
        } elseif ($fileSize > 2 * 1024 * 1024) {
            $error = "Image size must not exceed 2MB.";
        } else {
            $newFileName = uniqid('prod_', true) . '.' . $fileExt;
            $uploadDir = __DIR__ . '/uploads/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            if (move_uploaded_file($fileTmp, $uploadDir . $newFileName)) {
                $stmt1 = $pdo->prepare(
                    "INSERT INTO products (category_id, name, description, price, stock, image)
                     VALUES (?, ?, ?, ?, ?, ?)"
                );

                $stmt1->execute([
                    $proCategory_id,
                    $proName,
                    $proDescription,
                    $proPrice,
                    $proStock,
                    $newFileName
                ]);

                header('Location: dashboard.php');
                exit;
            } else {
                $error = "Failed to upload image.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: Arial, sans-serif;
            margin: 0;
        }
        .product-card {
            width: 100%;
            max-width: 500px;
            border: none;
            border-radius: 12px;
            background-color: white;
        }
        .product-card h3 {
            color: #212529;
            font-weight: bold;
        }
        .product-card label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }
        .product-card .form-control, .product-card .form-select {
            width: 100%;
            height: 45px;
            font-size: 15px;
            border-radius: 7px;
        }
        .product-card textarea.form-control {
            height: auto;
        }
        .product-card .btn {
            height: 45px;
            border-radius: 7px;
            font-size: 16px;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center min-vh-100 py-5">
  <div class="card p-4 shadow product-card">
    <h3 class="text-center mb-4">Add New Product</h3>

    <?php if ($error !== ""): ?>
        <div class="alert alert-danger py-2"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
      <div class="form-group mb-3">
        <label for="productName" class="form-label">Product Name</label>
        <input
          type="text"
          class="form-control"
          id="productName"
          name="name"
          placeholder="Enter product name"
          value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
          required
        >
      </div>

      <div class="form-group mb-3">
        <label for="price" class="form-label">Price</label>
        <input
          type="number"
          class="form-control"
          id="price"
          name="price"
          placeholder="Enter product price"
          min="0"
          step="0.01"
          value="<?= htmlspecialchars($_POST['price'] ?? '') ?>"
          required
        >
      </div>

      <div class="form-group mb-3">
        <label for="stock" class="form-label">Stock</label>
        <input
          type="number"
          class="form-control"
          id="stock"
          name="stock"
          placeholder="Enter stock quantity"
          min="0"
          value="<?= htmlspecialchars($_POST['stock'] ?? '') ?>"
          required
        >
      </div>

      <div class="form-group mb-3">
        <label for="category" class="form-label">Category</label>
        <select
          class="form-select"
          id="category"
          name="category"
          required
        >
          <option value="" selected disabled>Select category</option>
          <?php foreach($categories as $cat): ?>
          <option value="<?= $cat['id'] ?>" <?= (isset($_POST['category']) && $_POST['category'] == $cat['id']) ? 'selected' : '' ?>>
              <?= htmlspecialchars($cat['name']) ?>
          </option>
         <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea
          class="form-control"
          id="description"
          name="description"
          rows="3"
          placeholder="Enter product description"
        ><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
      </div>

      <div class="form-group mb-4">
        <label for="image" class="form-label">Product Image</label>
        <input
          type="file"
          class="form-control"
          id="image"
          name="image"
          accept="image/*"
          required
        >
      </div>

      <button type="submit" name="submit" class="btn btn-primary w-100 mb-2">
        Add Product
      </button>
      <a href="dashboard.php" class="btn btn-outline-secondary w-100">Cancel</a>
    </form>
  </div>
</div>

</body>
</html>