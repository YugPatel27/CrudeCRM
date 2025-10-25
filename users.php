<?php
include 'header.php';
include_once 'connect.php';
include_once 'sidebar.php';
$conn = connectdb();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Users - Crude CRM</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body { background-color: #fff; color: #F44336; }
    .card-header { background-color: #F44336; color: white; font-weight: bold; }
    .btn-red { background-color: #c0392b; color: white; }
    .btn-red:hover { background-color: #F44336; color: white; }
    .table th { background-color: #f8f9fa; color: #c0392b; }
  </style>
</head>
<body>
<div class="container mt-5">
  <div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
      <span>User Management</span>
      <div>
        <button class="btn btn-red btn-sm" data-toggle="modal" data-target="#addUserModal"><i class="fas fa-user-plus"></i> Add User</button>
        <button class="btn btn-sm btn-danger" onclick="generatePDF()"><i class="fas fa-file-pdf"></i> Generate Report</button>
        <a href="reports/users_report.pdf" class="btn btn-sm btn-secondary" target="_blank"><i class="fas fa-eye"></i> View PDF</a>
      </div>
    </div>
    <div class="card-body">
      <table id="usersTable" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>#ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Created At</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $result = $conn->query("SELECT * FROM users WHERE status = 1 ORDER BY user_id DESC");
          while ($row = $result->fetch_assoc()) {
            echo "<tr>
              <td>{$row['user_id']}</td>
              <td>{$row['name']}</td>
              <td>{$row['email']}</td>
              <td>{$row['role']}</td>
              <td>{$row['created_at']}</td>
              <td>
                <button class='btn btn-sm btn-red edit-btn' 
                  data-id='{$row['user_id']}' 
                  data-name='{$row['name']}' 
                  data-email='{$row['email']}' 
                  data-role='{$row['role']}'><i class='fas fa-pen'></i></button>
                <form method='POST' action='users-action.php' class='d-inline'>
                  <input type='hidden' name='action' value='delete'>
                  <input type='hidden' name='user_id' value='{$row['user_id']}'>
                  <button class='btn btn-sm btn-danger' onclick=\"return confirm('Delete this user?')\">
                    <i class='fas fa-trash'></i>
                  </button>
                </form>
              </td>
            </tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form id="addUserForm">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title">Add New User</h5>
          <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Role</label>
            <select name="role" class="form-control" required>
              <option value="">Select Role</option>
              <option value="Admin">Admin</option>
              <option value="Sales">Sales</option>
              <option value="Logistics">Logistics</option>
              <option value="Viewer">Viewer</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="action" value="add">
          <button type="submit" class="btn btn-danger">Add User</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form id="editUserForm">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title">Edit User</h5>
          <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="user_id" id="edit_user_id">
          <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" id="edit_name" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" id="edit_email" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Role</label>
            <select name="role" id="edit_role" class="form-control" required>
              <option value="Admin">Admin</option>
              <option value="Sales">Sales</option>
              <option value="Logistics">Logistics</option>
              <option value="Viewer">Viewer</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="action" value="update">
          <button type="submit" class="btn btn-danger">Save Changes</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script>
  $(document).ready(function () {
    $('#usersTable').DataTable();

    // Add User Form
    $('#addUserForm').submit(function (e) {
      e.preventDefault();
      $.ajax({
        url: 'users-action.php',
        method: 'POST',
        data: $(this).serialize(),
        success: function (res) {
          $('#addUserModal').modal('hide');
          alert("User added successfully!");
          location.reload();
        }
      });
    });

    // Edit User Trigger
    $('.edit-btn').click(function () {
      $('#edit_user_id').val($(this).data('id'));
      $('#edit_name').val($(this).data('name'));
      $('#edit_email').val($(this).data('email'));
      $('#edit_role').val($(this).data('role'));
      $('#editUserModal').modal('show');
    });

    // Edit User Submit
    $('#editUserForm').submit(function (e) {
      e.preventDefault();
      $.ajax({
        url: 'users-action.php',
        method: 'POST',
        data: $(this).serialize(),
        success: function () {
          $('#editUserModal').modal('hide');
          alert("User updated successfully!");
          location.reload();
        }
      });
    });
  });

  function generatePDF() {
    $.get("users-action.php?action=generate_pdf", function(response) {
      alert("PDF generated successfully!");
    });
  }
</script>
<?php include 'footer.php'; ?>
