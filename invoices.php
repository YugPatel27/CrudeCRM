<?php
include_once 'connect.php';
include_once 'sidebar.php';
$conn = connectdb();

// ADD INVOICE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_invoice'])) {
    $stmt = $conn->prepare("INSERT INTO invoices (client_id, amount, tax, total_amount, invoice_date, due_date, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("idddsss",
        $_POST['client_id'],
        $_POST['amount'],
        $_POST['tax'],
        $_POST['total_amount'],
        $_POST['invoice_date'],
        $_POST['due_date'],
        $_POST['status']
    );
    $stmt->execute();
    $stmt->close();
    header("Location: invoices.php?msg=added");
    exit();
}

// UPDATE INVOICE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_invoice'])) {
    $stmt = $conn->prepare("UPDATE invoices SET client_id=?, amount=?, tax=?, total_amount=?, invoice_date=?, due_date=?, status=? WHERE invoice_id=?");
    $stmt->bind_param("idddsssi",
        $_POST['client_id'],
        $_POST['amount'],
        $_POST['tax'],
        $_POST['total_amount'],
        $_POST['invoice_date'],
        $_POST['due_date'],
        $_POST['status'],
        $_POST['invoice_id']
    );
    $stmt->execute();
    $stmt->close();
    echo "<script>window.location.href = 'invoices.php?msg=updated';</script>";
    exit();
}

// DELETE INVOICE
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM invoices WHERE invoice_id = $id");
    header("Location: invoices.php?msg=deleted");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Invoices - CrudeCRM</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
    .container { margin-top: 60px; }
    .card-header {
      background-color: #F44336;
      color: white;
      font-size: 1.25rem;
      font-weight: bold;
      text-align: center;
    }
    .btn-red { background-color: #F44336; color: white; font-weight: 600; border: none; }
    .btn-red:hover { background-color: #D32F2F; }
    .modal-header { background-color: #F44336; color: white; }
    .modal-footer .btn-success { background-color: #F44336; border: none; }
    .modal-footer .btn-success:hover { background-color: #D32F2F; }
    .table thead th { background-color: #D32F2F; color: white; text-align: center; }
    .table-striped tbody tr:hover { background-color: #ffe0e0; cursor: pointer; }
    .alert { margin-top: 20px; }
    .fa-pen-to-square, .fa-trash { cursor: pointer; margin: 0 5px; }
    #searchInput {
      margin-bottom: 15px;
      border: 2px solid #F44336;
      padding: 6px 12px;
      border-radius: 5px;
      width: 100%;
    }
  </style>
</head>
<body>
<?php $skipHeaderWrapper = true; include 'header.php'; ?>
<div class="container">
  <?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success text-center">
      <?php
        if ($_GET['msg'] === 'added') echo "✅ Invoice added successfully.";
        elseif ($_GET['msg'] === 'updated') echo "✅ Invoice updated successfully.";
        elseif ($_GET['msg'] === 'deleted') echo "🗑️ Invoice deleted successfully.";
      ?>
    </div>
  <?php endif; ?>

  <div class="card shadow">
    <div class="card-header">Invoices & Billing</div>
    <div class="card-body">
      <button class="btn btn-red mb-3" data-toggle="modal" data-target="#addModal">+ Add Invoice</button>
      <input type="text" id="searchInput" placeholder="Search by Invoice ID or Client ID">
      <div class="table-responsive">
        <table class="table table-striped table-bordered text-center" id="invoiceTable">
          <thead>
            <tr>
              <th>#</th>
              <th>Client ID</th>
              <th>Amount (₹)</th>
              <th>Tax (₹)</th>
              <th>Total (₹)</th>
              <th>Invoice Date</th>
              <th>Due Date</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php
          $result = $conn->query("SELECT * FROM invoices ORDER BY invoice_id DESC");
          $i = 1;
          while ($inv = $result->fetch_assoc()):
          ?>
            <tr>
              <td><?= $inv['invoice_id'] ?></td>
              <td><?= $inv['client_id'] ?></td>
              <td><?= number_format($inv['amount'], 2) ?></td>
              <td><?= number_format($inv['tax'], 2) ?></td>
              <td><?= number_format($inv['total_amount'], 2) ?></td>
              <td><?= $inv['invoice_date'] ?></td>
              <td><?= $inv['due_date'] ?></td>
              <td><?= $inv['status'] ?></td>
              <td>
                <i class="fa-solid fa-pen-to-square text-warning editBtn"
                   data-id="<?= $inv['invoice_id'] ?>"
                   data-client="<?= $inv['client_id'] ?>"
                   data-amount="<?= $inv['amount'] ?>"
                   data-tax="<?= $inv['tax'] ?>"
                   data-total="<?= $inv['total_amount'] ?>"
                   data-date="<?= $inv['invoice_date'] ?>"
                   data-due="<?= $inv['due_date'] ?>"
                   data-status="<?= $inv['status'] ?>"></i>
                <a href="?delete=<?= $inv['invoice_id'] ?>" onclick="return confirm('Delete this invoice?')">
                  <i class="fa-solid fa-trash text-danger"></i>
                </a>
              </td>
            </tr>
          <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal">
  <div class="modal-dialog">
    <form method="POST" class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Add Invoice</h5>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <input name="client_id" type="number" class="form-control mb-2" placeholder="Client ID" required>
        <input name="amount" type="number" step="0.01" class="form-control mb-2" placeholder="Amount" required>
        <input name="tax" type="number" step="0.01" class="form-control mb-2" placeholder="Tax" required>
        <input name="total_amount" type="number" step="0.01" class="form-control mb-2" placeholder="Total Amount" required>
        <input name="invoice_date" type="date" class="form-control mb-2" required>
        <input name="due_date" type="date" class="form-control mb-2" required>
        <select name="status" class="form-control" required>
          <option value="">-- Select Status --</option>
          <option>Paid</option>
          <option>Unpaid</option>
          <option>Pending</option>
        </select>
      </div>
      <div class="modal-footer">
        <button name="add_invoice" class="btn btn-success">Save</button>
      </div>
    </form>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal">
  <div class="modal-dialog">
    <form method="POST" class="modal-content">
      <div class="modal-header"><h5 class="modal-title">Edit Invoice</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="invoice_id" id="edit_id">
        <input name="client_id" type="number" id="edit_client" class="form-control mb-2" required>
        <input name="amount" type="number" step="0.01" id="edit_amount" class="form-control mb-2" required>
        <input name="tax" type="number" step="0.01" id="edit_tax" class="form-control mb-2" required>
        <input name="total_amount" type="number" step="0.01" id="edit_total" class="form-control mb-2" required>
        <input name="invoice_date" type="date" id="edit_date" class="form-control mb-2" required>
        <input name="due_date" type="date" id="edit_due" class="form-control mb-2" required>
        <select name="status" id="edit_status" class="form-control" required>
          <option value="Paid">Paid</option>
          <option value="Unpaid">Unpaid</option>
          <option value="Pending">Pending</option>
        </select>
      </div>
      <div class="modal-footer">
        <button name="update_invoice" class="btn btn-success">Update</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Edit Button fill modal
  $('.editBtn').on('click', function () {
    $('#edit_id').val($(this).data('id'));
    $('#edit_client').val($(this).data('client'));
    $('#edit_amount').val($(this).data('amount'));
    $('#edit_tax').val($(this).data('tax'));
    $('#edit_total').val($(this).data('total'));
    $('#edit_date').val($(this).data('date'));
    $('#edit_due').val($(this).data('due'));
    $('#edit_status').val($(this).data('status'));
    $('#editModal').modal('show');
  });

  // Search
  $('#searchInput').on('keyup', function () {
    const value = $(this).val().toLowerCase();
    $('#invoiceTable tbody tr').filter(function () {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
</script>

<?php include 'footer.php'; ?>
