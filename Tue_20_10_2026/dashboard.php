<?php 
require_once __DIR__ . '/config/Database.php';

$database = new Database();
$pdo = $database->connect();

$products = $pdo->query('
    SELECT products.*, categories.name AS category_name 
    FROM products 
    LEFT JOIN categories ON products.category_id = categories.id
    ORDER BY products.id DESC
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
<body class="bg-light">
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Product Management</h2>
        <div>
            <a href="add.php" class="btn btn-primary">+ Add product</a>
            <button onclick="window.location.href='index.php'" class="btn btn-danger">Logout</button>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" class="ps-3">#</th>
                            <th scope="col">Image</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Stock</th>
                            <th scope="col">Category</th>
                            <th scope="col" class="text-center pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($products)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No products found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <th scope="row" class="ps-3"><?= $counter++ ?></th>
                                    <td>
                                        <?php if (!empty($product['image']) && file_exists(__DIR__ . '/uploads/' . $product['image'])): ?>
                                            <img src="uploads/<?= e($product['image']) ?>" width="50" height="50" class="rounded object-fit-cover border">
                                        <?php else: ?>
                                            <span class="badge bg-secondary">No image</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="fw-semibold"><?= e($product["name"]) ?></td>
                                    <td>$<?= number_format((float)$product["price"], 2) ?></td>
                                    <td><?= e((string)$product["stock"]) ?></td>
                                    <td><span class="badge bg-info text-dark"><?= e($product["category_name"] ?? 'Uncategorized') ?></span></td>
                                    <td class="text-center pe-3">
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-warning" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editModal"
                                                data-id="<?= $product['id'] ?>"
                                                data-name="<?= e($product['name']) ?>"
                                                data-price="<?= e((string)$product['price']) ?>"    
                                                data-stock="<?= e((string)$product['stock']) ?>"
                                                data-category="<?= $product['category_id'] ?>"
                                                data-image="<?= !empty($product['image']) ? e($product['image']) : '' ?>"
                                                onclick="fillEditModal(this)">
                                            Edit
                                        </button>

                                        <form action="delete.php" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                            <input type="hidden" name="id" value="<?= e((string)$product['id']) ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="update.php" method="POST" enctype="multipart/form-data">
          <div class="modal-body">
              <input type="hidden" name="id" id="edit_id">
              
              <div class="mb-3">
                  <label class="form-label fw-semibold">Product Name</label>
                  <input type="text" name="name" id="edit_name" class="form-control" required>
              </div>
              
              <div class="mb-3">
                  <label class="form-label fw-semibold">Price</label>
                  <input type="number" step="0.01" name="price" id="edit_price" class="form-control" required>
              </div>

              <div class="mb-3">
                  <label class="form-label fw-semibold">Stock</label>
                  <input type="number" name="stock" id="edit_stock" class="form-control" required>
              </div>

              <div class="mb-3">
                  <label class="form-label fw-semibold">Category</label>
                  <select name="category_id" id="edit_category" class="form-select" required>
                      <?php foreach ($categories as $cat): ?>
                          <option value="<?= $cat['id'] ?>"><?= e($cat['name']) ?></option>
                      <?php endforeach; ?>
                  </select>
              </div>

              <div class="mb-3">
                  <label class="form-label fw-semibold">Current Image</label>
                  <div id="image_preview_box" class="mb-2">
                      <img id="current_image_preview" src="" width="70" height="70" class="rounded object-fit-cover border d-none">
                      <p id="no_image_text" class="text-muted small mb-0 d-none">No image uploaded</p>
                  </div>
                  <label class="form-label fw-semibold">Change Image (Optional)</label>
                  <input type="file" name="image" class="form-control" accept="image/*">
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save Changes</button>
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

    const imageName = button.getAttribute('data-image');
    const previewImg = document.getElementById('current_image_preview');
    const noImgText = document.getElementById('no_image_text');

    if (imageName && imageName !== '') {
        previewImg.src = 'uploads/' + imageName;
        previewImg.classList.remove('d-none');
        noImgText.classList.add('d-none');
    } else {
        previewImg.src = '';
        previewImg.classList.add('d-none');
        noImgText.classList.remove('d-none');
    }
}
</script>
</body>
</html>