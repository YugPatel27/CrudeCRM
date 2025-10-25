<?php include 'header.php'; ?>
<?php
include_once 'connect.php';
include_once 'sidebar.php';
$conn = connectdb();

// Fetch users for the "Assigned To" dropdown
$user_result = $conn->query("SELECT user_id, name FROM users WHERE status = 1");

// Fetch clients for the "Client Name" dropdown
$client_dropdown_result = $conn->query("SELECT company_name FROM clients ORDER BY company_name ASC");

// Handle Add Lead form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_lead'])) {
    $client_name = $_POST['client_name'];
    $contact_person = $_POST['contact_person'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $source = $_POST['source'];
    $status = $_POST['status'];
    $assigned_to = $_POST['assigned_to'];
    $remarks = $_POST['remarks'];  // Will be empty unless filled dynamically
    $created_at = date("Y-m-d H:i:s");

    $stmt1 = $conn->prepare("INSERT INTO leads (client_name, contact_person, email, phone, source, status, assigned_to, remarks, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt1->bind_param("ssssssiss", $client_name, $contact_person, $email, $phone, $source, $status, $assigned_to, $remarks, $created_at);

    if ($stmt1->execute()) {
        echo "<script>alert('Lead added successfully'); window.location.href='leads.php';</script>";
    } else {
        echo "<script>alert('Failed to add Lead');</script>";
    }
log_activity($conn, $_SESSION['user_id'], 'leads', 'Created new lead: ' . $client_name);

    $stmt1->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Lead - CrudeCRM</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
    }
    .card-header {
      background-color: #F44336;
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
      max-width: 800px;
      margin-top: 60px;
    }
    .static-text {
      background-color: #fff;
      border: 1px solid #ced4da;
      padding: 10px;
      border-radius: 4px;
      min-height: 80px;
      color: #6c757d;
    }
  </style>
</head>
<body>

<div class="container">
  <form method="POST">
    <div class="card shadow">
      <div class="card-header">Add New Lead</div>
      <div class="card-body">

        <div class="form-group">
          <label for="client_name">Select Client Company</label>
          <select name="client_name" id="client_name" class="form-control" required>
            <option value="">-- Select Company --</option>
            <?php while($row = $client_dropdown_result->fetch_assoc()): ?>
              <option value="<?= htmlspecialchars($row['company_name']) ?>"><?= htmlspecialchars($row['company_name']) ?></option>
            <?php endwhile; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="contact_person">Contact Person</label>
          <input type="text" name="contact_person" id="contact_person" class="form-control">
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" name="email" id="email" class="form-control">
        </div>

        <div class="form-group">
          <label for="phone">Phone</label>
          <input type="text" name="phone" id="phone" class="form-control">
        </div>

        <div class="form-group">
          <label for="source">Source</label>
          <select name="source" id="source" class="form-control">
            <option value="Website">Website</option>
            <option value="Referral">Referral</option>
            <option value="Trade Fair">Trade Fair</option>
            <option value="Call">Call</option>
            <option value="Email">Email</option>
          </select>
        </div>

        <div class="form-group">
          <label for="status">Status</label>
          <select name="status" id="status" class="form-control">
            <option value="New">New</option>
            <option value="Contacted">Contacted</option>
            <option value="Qualified">Qualified</option>
            <option value="Rejected">Rejected</option>
          </select>
        </div>

        <div class="form-group">
          <label for="assigned_to">Assigned To</label>
          <select name="assigned_to" id="assigned_to" class="form-control" required>
            <option value="">-- Select User --</option>
            <?php while($user = $user_result->fetch_assoc()): ?>
              <option value="<?= $user['user_id'] ?>"><?= htmlspecialchars($user['name']) ?></option>
            <?php endwhile; ?>
          </select>
        </div>

       <div class="form-group">
          <label for="remarks">Remarks</label>
          <textarea name="remarks" id="remarks" rows="3" class="form-control" placeholder="Enter any remarks..."></textarea>
        </div>

        <button type="submit" name="add_lead" class="btn btn-red btn-block">Add Lead</button>
      </div>
    </div>
  </form>
</div>

<?php include 'footer.php'; ?>
