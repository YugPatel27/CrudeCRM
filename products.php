<?php include 'header.php'; ?>
<?php
include_once 'connect.php'; // Ensure db.php is included to establish the database connection
include_once 'sidebar.php';
$conn = connectdb(); // Use the connectdb function to get the connection

// Handle Add Product form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    $unit_of_measure = $_POST['unit_of_measure'];
    $description = $_POST['description'];
    $status = 1;
    $created_at = date("Y-m-d H:i:s");

    $stmt = $conn->prepare("INSERT INTO products (product_name, category, unit_of_measure, description, status, created_at) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssis", $product_name, $category, $unit_of_measure, $description, $status, $created_at);

    if ($stmt->execute()) {
        echo "<script>alert('Product added successfully'); window.location.href='products.php';</script>";
    } else {
        echo "<script>alert('Failed to add product');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Product - CrudeCRM</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
    }
    .card-header {
      background-color: #F44336;  /* Light Red Theme */
      color: white;
      font-size: 1.25rem;
      text-align: center;
      font-weight: 600;
    }
    .btn-red {
      background-color: #F44336;
      color: white;
      font-weight: 600;
      border: none;
    }
    .btn-red:hover {
      background-color: #D32F2F;
    }
    .form-group label {
      font-weight: 600;
    }
    .container {
      max-width: 500px;
      margin-top: 60px;
    }
  </style>
</head>
<body>
  <div class="container">
    <form method="POST">
      <div class="card shadow">
        <div class="card-header">Add New Product</div>
        <div class="card-body">

          <div class="form-group">
            <label for="product_name">Product Name</label>
            <input type="text" name="product_name" id="product_name" class="form-control" required>
          </div>

          <div class="form-group">
            <label for="category">Category</label>
            <select name="category" id="category" class="form-control" required>
              <option value="">-- Select Category --</option>
              <option value="Crude">Crude</option>
              <option value="Refined">Refined</option>
              <option value="Gas">Gas</option>
              <option value="Other">Other</option>
            </select>
          </div>

          <div class="form-group">
            <label for="unit_of_measure">Unit of Measure</label>
            <input type="text" name="unit_of_measure" id="unit_of_measure" class="form-control" placeholder="e.g. Barrel, Liter, Ton" required>
          </div>

          <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3" placeholder="Optional product details..."></textarea>
          </div>

          <button type="submit" name="add_product" class="btn btn-red btn-block">Submit</button>
        </div>
      </div>
    </form>
  </div>


<div class="container" style="max-width: auto">
  <div class="card shadow ">
    <div class="card-header">🧾 Place New Order</div>
    <div class="card-body">

      <form action="process-order.php" method="POST">

        <!-- Client Dropdown -->
        <div class="form-group">
          <label for="client_id">Select Client</label>
          <select name="client_id" id="client_id" class="form-control" required>
            <option value="">-- Select Client --</option>
            <?php
            $clients = $conn->query("SELECT client_id, company_name FROM clients WHERE status = 1");
            while ($row = $clients->fetch_assoc()) {
              echo "<option value='{$row['client_id']}'>{$row['company_name']}</option>";
            }
            ?>
          </select>
        </div>

        <!-- Product Dropdown -->
        <div class="form-group">
          <label for="product_id">Select Product</label>
          <select name="product_id" id="product_id" class="form-control" required>
            <option value="">-- Select Product --</option>
            <?php
            $products = $conn->query("SELECT product_id, product_name FROM products WHERE status = 1");
            while ($row = $products->fetch_assoc()) {
              echo "<option value='{$row['product_id']}'>{$row['product_name']}</option>";
            }
            ?>
          </select>
        </div>

        <!-- Quantity -->
        <div class="form-group">
          <label for="quantity">Quantity</label>
          <input type="number" name="quantity" id="quantity" class="form-control" min="1" step="any" required>
        </div>

        <!-- Order Date -->
        <div class="form-group">
          <label for="order_date">Order Date</label>
          <input type="date" name="order_date" id="order_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
        </div>

        <!-- Notes -->
        <div class="form-group">
          <label for="notes">Additional Notes (Optional)</label>
          <textarea name="notes" id="notes" rows="3" class="form-control" placeholder="Any special instructions..."></textarea>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-red btn-block">Submit Order</button>

      </form>
    </div>
  </div>
</div>
 <?php include 'footer.php'; ?>
