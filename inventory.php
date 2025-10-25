<?php include 'header.php'; ?>
<?php
include_once 'connect.php';
include_once 'sidebar.php';
$conn = connectdb();

// Handle AJAX Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'update') {
  $stmt = $conn->prepare("UPDATE inventory SET product_id=?, location=?, quantity=?, last_updated=NOW() WHERE inventory_id=?");
  $stmt->bind_param("ssii", $_POST['product_id'], $_POST['location'], $_POST['quantity'], $_POST['inventory_id']);
  $stmt->execute(); echo 'success'; exit;
}

// Handle AJAX Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'delete') {
  $stmt = $conn->prepare("DELETE FROM inventory WHERE inventory_id=?");
  $stmt->bind_param("i", $_POST['inventory_id']);
  $stmt->execute(); echo 'success'; exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Inventory Management</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
    .card-header {
      background-color: #F44336;
      color: white;
      font-weight: 600;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .btn-red { background-color: #F44336; color: white; font-weight: bold; }
    .btn-red:hover { background-color: #d32f2f; }
    .table th {
      background-color: #fce4ec;
      color: #b71c1c;
      text-align: center;
    }
    .table td { vertical-align: middle; }
  </style>
</head>
<body>
<br>
<div class="container mt-4">
  <div class="card shadow">
    <div class="card-header">
      <span>Inventory Management</span>
      <div>
        <a href="generate_inventory_report.php" class="btn btn-light btn-sm">
          <i class="fas fa-file-pdf"></i> Generate Report
        </a>
        <button class="btn btn-light btn-sm ml-2" data-toggle="modal" data-target="#addModal">
          <i class="fas fa-plus-circle"></i> Add Inventory
        </button>
      </div>
    </div>
    <div class="card-body">
      <?php if (isset($_GET['success']) && isset($_GET['file'])): ?>
        <div class="alert alert-success">
          ✅ PDF Report generated successfully:
          <a href="<?= htmlspecialchars($_GET['file']) ?>" target="_blank" class="font-weight-bold">View Report</a>
        </div>
      <?php endif; ?>

      <?php if (isset($_GET['msg']) && $_GET['msg'] == 'added'): ?>
        <div class="alert alert-success">✅ Inventory record added successfully!</div>
      <?php endif; ?>

      <table id="inventoryTable" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Product ID</th>
            <th>Location</th>
            <th>Quantity</th>
            <th>Last Updated</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $res = $conn->query("SELECT * FROM inventory ORDER BY inventory_id DESC");
          while ($r = $res->fetch_assoc()):
          ?>
          <tr>
            <td><?= $r['inventory_id'] ?></td>
            <td><?= htmlspecialchars($r['product_id']) ?></td>
            <td><?= htmlspecialchars($r['location']) ?></td>
            <td><?= $r['quantity'] ?></td>
            <td><?= $r['last_updated'] ?></td>
            <td>
              <button class="btn btn-warning btn-sm edit-btn"
                data-id="<?= $r['inventory_id'] ?>"
                data-product="<?= htmlspecialchars($r['product_id']) ?>"
                data-location="<?= htmlspecialchars($r['location']) ?>"
                data-quantity="<?= $r['quantity'] ?>">
                <i class="fas fa-pen"></i>
              </button>
              <button class="btn btn-danger btn-sm delete-btn"
                data-id="<?= $r['inventory_id'] ?>">
                <i class="fas fa-trash-alt"></i>
              </button>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="add_inventory.php" class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Add Inventory</h5>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="form-group"><label>Product ID</label><input name="product_id" class="form-control" required></div>
        <div class="form-group"><label>Location</label><input name="location" class="form-control" required></div>
        <div class="form-group"><label>Quantity</label><input name="quantity" type="number" class="form-control" required></div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-red">Add</button>
      </div>
    </form>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="editForm" class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5>Edit Inventory</h5>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="inventory_id" id="edit_id">
        <input type="hidden" name="action" value="update">
        <div class="form-group"><label>Product ID</label><input name="product_id" id="edit_product" class="form-control" required></div>
        <div class="form-group"><label>Location</label><input name="location" id="edit_location" class="form-control" required></div>
        <div class="form-group"><label>Quantity</label><input name="quantity" id="edit_quantity" class="form-control" type="number" required></div>
      </div>
      <div class="modal-footer"><button class="btn btn-red">Save Changes</button></div>
    </form>
  </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="deleteForm" class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5>Confirm Delete</h5>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this inventory record?</p>
        <input type="hidden" name="inventory_id" id="delete_id">
        <input type="hidden" name="action" value="delete">
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button class="btn btn-red">Delete</button>
      </div>
    </form>
  </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function () {
  $('#inventoryTable').DataTable();

  $('.edit-btn').click(function () {
    $('#edit_id').val($(this).data('id'));
    $('#edit_product').val($(this).data('product'));
    $('#edit_location').val($(this).data('location'));
    $('#edit_quantity').val($(this).data('quantity'));
    $('#editModal').modal('show');
  });

  $('#editForm').submit(function (e) {
    e.preventDefault();
    $.post('', $(this).serialize(), function (res) {
      if (res.trim() === 'success') {
        alert('✅ Inventory record updated!');
        location.reload();
      }
    });
  });

  $('.delete-btn').click(function () {
    $('#delete_id').val($(this).data('id'));
    $('#deleteModal').modal('show');
  });

  $('#deleteForm').submit(function (e) {
    e.preventDefault();
    $.post('', $(this).serialize(), function (res) {
      if (res.trim() === 'success') {
        alert('🗑️ Inventory record deleted!');
        location.reload();
      }
    });
  });
});
</script>

<?php include 'footer.php'; ?>
