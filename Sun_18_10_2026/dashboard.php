<?php 
require_once __DIR__ . '/db.php';

$products = $pdo->query('
    SELECT products.*, categories.name AS category_name 
    FROM products 
    LEFT JOIN categories ON products.category_id = categories.id
')->fetchAll(PDO::FETCH_ASSOC);


$categories = $pdo->query('SELECT * FROM categories')->fetchAll(PDO::FETCH_ASSOC);

$counter = 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Product Name</th>
          <th scope="col">Price</th>
          <th scope="col">Stock</th>
          <th scope="col">Category</th>
          <th scope="col"></th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
    <?php foreach ($products as $product): ?>
        <tr>
          <th scope="row"><?= $counter++ ?></th>
          <td><?= e($product["name"]) ?></td>
          <td><?= e($product["price"]) ?></td>
          <td><?= e($product["stock"]) ?></td>
          <td><?= e($product["category_name"]) ?></td>
         
          <td>
            <form action="delete.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                <input type="hidden" name="id" value="<?= e($product['id']) ?>">
                <button type="submit" class="btn btn-outline-danger">Delete</button>
            </form>
          </td>

          <td>
            <button type="button" 
                    class="btn btn-outline-warning" 
                    data-bs-toggle="modal" 
                    data-bs-target="#editModal"
                    data-id="<?= $product['id'] ?>"
                    data-name="<?= e($product['name']) ?>"
                    data-price="<?= e($product['price']) ?>"    
                    data-stock="<?= e($product['stock']) ?>"
                    data-category="<?= $product['category_id'] ?>"
                    onclick="fillEditModal(this)">
                Edit
            </button>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <a href="add.php" class="btn btn-outline-primary">Add product</a>
    <button onclick="window.location.href='index.php'" class="btn btn-danger">Logout</button>
</div>


<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="update.php" method="POST">
          <div class="modal-body">
              <input type="hidden" name="id" id="edit_id">
              
              <div class="mb-3">
                  <label class="form-label">Product Name</label>
                  <input type="text" name="name" id="edit_name" class="form-control" required>
              </div>
              
              <div class="mb-3">
                  <label class="form-label">Price</label>
                  <input type="number" step="0.01" name="price" id="edit_price" class="form-control" required>
              </div>

             
              <div class="mb-3">
                  <label class="form-label">Stock</label>
                  <input type="number" name="stock" id="edit_stock" class="form-control" required>
              </div>

          
              <div class="mb-3">
                  <label class="form-label">Category</label>
                  <select name="category_id" id="edit_category" class="form-select" required>
                      <?php foreach ($categories as $cat): ?>
                          <option value="<?= $cat['id'] ?>"><?= e($cat['name']) ?></option>
                      <?php endforeach; ?>
                  </select>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button  type="submit" class="btn btn-primary">Save Changes</button>
          </div>
      </form>
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
function fillEditModal(button) {

    document.getElementById('edit_id').value = button.getAttribute('data-id');
    document.getElementById('edit_name').value = button.getAttribute('data-name');
    document.getElementById('edit_price').value = button.getAttribute('data-price');
    document.getElementById('edit_stock').value = button.getAttribute('data-stock');
    document.getElementById('edit_category').value = button.getAttribute('data-category');
}
</script>
</body>
</html>