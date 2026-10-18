<?php 
require_once __DIR__ . '/db.php';

$categories = $pdo->query('SELECT * FROM categories')->fetchAll(PDO::FETCH_ASSOC);

if($_SERVER['REQUEST_METHOD']=== 'POST'){
$proName=trim($_POST['name']);
$proPrice=trim($_POST['price']);
$proStock=trim($_POST['stock']);
$proCategory_id = trim($_POST['category']); 

    $stmt1 = $pdo->prepare(
        "INSERT INTO products (category_id, name, price, stock)
         VALUES (?, ?, ?, ?)"
    );

    $stmt1->execute([
        $proCategory_id,
        $proName,
        $proPrice,
        $proStock
    ]);


header('Location: dashboard.php');
exit;
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">



        
</head>
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

.product-card .form-control {
    width: 100%;
    height: 45px;
    font-size: 15px;
    border-radius: 7px;
}

.product-card .btn {
    height: 45px;
    border-radius: 7px;
    font-size: 16px;
}

</style>
<body
>
    


<div class="container d-flex justify-content-center align-items-center min-vh-100">
  <div class="card p-4 shadow product-card">
    <h3 class="text-center mb-4">Add New Product</h3>

    <form method="post">
      <div class="form-group mb-3">
        <label for="productName" class="form-label">Product Name</label>
        <input
          type="text"
          class="form-control"
          id="productName"
          name="name"
          placeholder="Enter product name"
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
          required
        >
      </div>

      <div class="form-group mb-4">
        <label for="category" class="form-label">Category</label>
        <select
          class="form-control"
          id="category"
          name="category"
          required
        >
          <option value="" selected disabled>Select category</option>
          <?php foreach($categories as $cat): ?>
          <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
         <?php endforeach; ?>
        </select>
      </div>

      <button type="submit" name="submit" class="btn btn-primary w-100">
        Add Product
      </button>
    </form>
  </div>
</div>






</form>
</body>
</html>