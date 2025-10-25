<?php include 'header.php'; ?>
<?php include_once 'connect.php'; include_once 'sidebar.php';?>
<?php $conn = connectdb(); ?>

<!-- STYLES & LIBS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
  .card-header { background-color: #c82333; color: white; font-weight: bold; text-align: center; }
  .btn-red { background-color: #c82333; color: white; font-weight: bold; }
  .btn-red:hover { background-color: #a71d2a; }
  .fa-pen, .fa-trash { cursor: pointer; margin-right: 10px; }
</style>

<div class="container mt-3">
  <?php if (isset($_GET['msg'])): ?>
    <div class="alert alert-success text-center">
      <?= $_GET['msg'] === 'added' ? "✅ Client added successfully." : ($_GET['msg'] === 'updated' ? "✅ Client updated successfully." : "🗑️ Client deleted successfully.") ?>
    </div>
  <?php endif; ?>
  <br>
  <!-- Add Client Form -->
  <form method="POST" action="clients-action.php">
    <div class="card shadow mb-4">
      <div class="card-header">Add New Client</div>
      <div class="card-body">
        <div class="form-row">
          <div class="form-group col-md-6"><label>Company Name</label><input type="text" name="company_name" class="form-control" required></div>
          <div class="form-group col-md-6"><label>Industry Type</label><input type="text" name="industry_type" class="form-control"></div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6"><label>Contact Person</label><input type="text" name="contact_person" class="form-control" required></div>
          <div class="form-group col-md-6"><label>Phone</label><input type="text" name="phone" class="form-control"></div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6"><label>Email</label><input type="email" name="email" class="form-control"></div>
          <div class="form-group col-md-6"><label>Country</label><input type="text" name="country" class="form-control"></div>
        </div>
        <div class="form-group"><label>Address</label><textarea name="address" class="form-control" rows="2"></textarea></div>
        <button type="submit" name="add_client" class="btn btn-red btn-block">Add Client</button>
      </div>
    </div>
  </form>
    <!-- SEARCH + EXPORT -->
      <div class="form-group">
        <input type="text" id="searchInput" class="form-control" placeholder="🔍 Search by company name...">
      </div>
  <!-- Clients Table -->
  <div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
      <span>All Clients</span>
      <div>
        <a href="clients-action.php?action=generate_pdf" class="btn btn-sm btn-danger"><i class="fas fa-file-pdf"></i> Generate PDF</a>
        <?php if (file_exists('reports/clients_report.pdf')): ?>
          <a href="reports/clients_report.pdf" class="btn btn-sm btn-secondary" target="_blank"><i class="fas fa-eye"></i> View PDF</a>
        <?php endif; ?>
      </div>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-bordered" id="clientTable">
        <thead>
          <tr>
            <th>#</th><th>Company</th><th>Industry</th><th>Contact</th><th>Email</th><th>Phone</th><th>Country</th><th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          $res = $conn->query("SELECT * FROM clients ORDER BY client_id DESC");
          while ($row = $res->fetch_assoc()):
          ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($row['company_name']) ?></td>
            <td><?= htmlspecialchars($row['industry_type']) ?></td>
            <td><?= htmlspecialchars($row['contact_person']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td><?= htmlspecialchars($row['country']) ?></td>
            <td>
              <i class="fas fa-pen text-warning editBtn"
                data-id="<?= $row['client_id'] ?>"
                data-company="<?= htmlspecialchars($row['company_name']) ?>"
                data-industry="<?= htmlspecialchars($row['industry_type']) ?>"
                data-contact="<?= htmlspecialchars($row['contact_person']) ?>"
                data-phone="<?= htmlspecialchars($row['phone']) ?>"
                data-email="<?= htmlspecialchars($row['email']) ?>"
                data-address="<?= htmlspecialchars($row['address']) ?>"
                data-country="<?= htmlspecialchars($row['country']) ?>"></i>
              <a href="clients-action.php?delete=<?= $row['client_id'] ?>" onclick="return confirm('Delete this client?')">
                <i class="fas fa-trash text-danger"></i>
              </a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="editForm" class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Edit Client</h5>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="client_id" id="edit_id">
        <input type="hidden" name="action" value="update">
        <div class="form-group"><label>Company Name</label><input type="text" name="company_name" id="edit_company" class="form-control" required></div>
        <div class="form-group"><label>Industry Type</label><input type="text" name="industry_type" id="edit_industry" class="form-control"></div>
        <div class="form-group"><label>Contact</label><input type="text" name="contact_person" id="edit_contact" class="form-control" required></div>
        <div class="form-group"><label>Phone</label><input type="text" name="phone" id="edit_phone" class="form-control"></div>
        <div class="form-group"><label>Email</label><input type="email" name="email" id="edit_email" class="form-control"></div>
        <div class="form-group"><label>Address</label><textarea name="address" id="edit_address" class="form-control"></textarea></div>
        <div class="form-group"><label>Country</label><input type="text" name="country" id="edit_country" class="form-control"></div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-red">Save Changes</button>
      </div>
    </form>
  </div>
</div>

<!-- JS LIBS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
  $(document).ready(function () {
    // Modal population
    $('.editBtn').on('click', function () {
      $('#edit_id').val($(this).data('id'));
      $('#edit_company').val($(this).data('company'));
      $('#edit_industry').val($(this).data('industry'));
      $('#edit_contact').val($(this).data('contact'));
      $('#edit_phone').val($(this).data('phone'));
      $('#edit_email').val($(this).data('email'));
      $('#edit_address').val($(this).data('address'));
      $('#edit_country').val($(this).data('country'));
      $('#editModal').modal('show');
    });

    // Update client via modal
    $('#editForm').submit(function (e) {
      e.preventDefault();
      $.post('clients-action.php', $(this).serialize(), function (response) {
        if (response.trim() === 'success') {
          $('#editModal').modal('hide');
          location.href = "clients.php?msg=updated";
        }
      });
    });

    // 🔍 Live Search Filter
    $('#searchInput').on("keyup", function () {
      var value = $(this).val().toLowerCase();
      $("#clientTable tbody tr").filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });
</script>


<?php include 'footer.php'; ?>
