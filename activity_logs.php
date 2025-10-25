<?php include 'header.php'; ?>
<?php
include_once 'connect.php';
include_once 'sidebar.php';
$conn = connectdb();

// Fetch all logs with user name
$query = "
    SELECT al.*, u.name 
    FROM activity_logs al
    LEFT JOIN users u ON al.user_id = u.user_id
    ORDER BY al.timestamp DESC
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Activity Logs - CrudeCRM</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <style>
    html, body {
      height: 100%;
      margin: 0;
      display: flex;
      flex-direction: column;
    }
    .content-wrapper {
      flex: 1 0 auto;
    }
    footer {
      flex-shrink: 0;
    }
    body {
      background-color: #f9f9f9;
      font-family: 'Segoe UI', sans-serif;
    }
    .card-header {
      background-color: #b71c1c;
      color: white;
      font-size: 1.25rem;
      font-weight: 600;
    }
    .table th {
      background-color: #fce4ec;
      color: #b71c1c;
    }
    .search-box {
      max-width: 300px;
      margin-bottom: 15px;
    }
    .table td {
      vertical-align: middle;
    }
  </style>
</head>
<body>

<!-- Content Wrapper -->
<div class="content-wrapper">
  <div class="container mt-5">
    <div class="card shadow">
      <div class="card-header">
        <i class="fas fa-history mr-2"></i>Activity Logs
      </div>
      <div class="card-body">
        <input type="text" class="form-control search-box" id="searchLogs" placeholder="🔍 Search by user, module or action...">

        <div class="table-responsive">
          <table class="table table-bordered table-hover" id="logsTable">
            <thead>
              <tr class="text-center">
                <th>#</th>
                <th>User</th>
                <th>Module</th>
                <th>Action</th>
                <th>IP Address</th>
                <th>Timestamp</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1; while ($log = $result->fetch_assoc()): ?>
              <tr>
                <td><?= $i++ ?></td>
                <td class="user"><?= htmlspecialchars($log['name'] ?? 'Unknown') ?></td>
                <td class="module"><?= htmlspecialchars($log['module']) ?></td>
                <td class="action"><?= htmlspecialchars($log['action']) ?></td>
                <td class="ip"><?= htmlspecialchars($log['ip_address']) ?></td>
                <td><?= htmlspecialchars(date("d-M-Y h:i A", strtotime($log['timestamp']))) ?></td>
              </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Filter Table Script -->
<script>
  $('#searchLogs').on('keyup', function () {
    const value = $(this).val().toLowerCase();
    $('#logsTable tbody tr').filter(function () {
      $(this).toggle(
        $(this).find('.user').text().toLowerCase().indexOf(value) > -1 ||
        $(this).find('.module').text().toLowerCase().indexOf(value) > -1 ||
        $(this).find('.action').text().toLowerCase().indexOf(value) > -1 ||
        $(this).find('.ip').text().toLowerCase().indexOf(value) > -1
      );
    });
  });
</script>

<?php include 'footer.php'; ?>