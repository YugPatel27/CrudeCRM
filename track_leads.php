<?php include 'header.php'; include_once 'sidebar.php';?>
<?php
$conn = new mysqli("localhost", "root", "", "crmcrude");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Fetch leads
$leads = $conn->query("SELECT * FROM leads ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Leads - CrudeCRM</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      background-color: #f4f6fb;
    }

    .main-container {
      margin-left: 250px;
      padding: 30px;
    }

    .section-title {
      background-color: #dc3545;
      color: white;
      padding: 12px 20px;
      border-top-left-radius: 6px;
      border-top-right-radius: 6px;
      font-weight: 600;
      font-size: 17px;
      margin-bottom: 0;
    }

    .table-container {
      background: white;
      border: 1px solid #dee2e6;
      border-radius: 6px;
      box-shadow: 0 0 6px rgba(0, 0, 0, 0.05);
      overflow-x: auto;
    }

    .search-container {
      margin: 20px 0;
      display: flex;
      justify-content: flex-end;
    }

    .search-container input {
      padding: 8px 14px;
      border-radius: 6px;
      border: 1px solid #ccc;
      width: 280px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      padding: 12px 14px;
      border: 1px solid #dee2e6;
      text-align: left;
    }

    th {
      font-weight: bold;
    }

    tr:hover {
      background-color: #f9f9f9;
    }

    @media (max-width: 768px) {
      .main-container {
        margin-left: 0;
        padding: 20px;
      }

      .search-container {
        justify-content: center;
      }

      .search-container input {
        width: 100%;
      }
    }
  </style>
</head>
<body>

<div class="main-container">
  <div class="section-title">
    Track Leads
  </div>

  <div class="table-container">
    <!-- Search -->
    <div class="search-container">
      <input type="text" id="leadSearch" onkeyup="filterLeads()" placeholder="Search by name, contact, status...">
    </div>

    <table id="leadsTable">
      <thead>
        <tr>
          <th>Client Name</th>
          <th>Contact</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Source</th>
          <th>Status</th>
          <th>Assigned</th>
          <th>Remarks</th>
          <th>Created</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $leads->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['client_name']) ?></td>
            <td><?= htmlspecialchars($row['contact_person']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td><?= htmlspecialchars($row['source']) ?></td>
            <td><?= htmlspecialchars($row['status']) ?></td>
            <td><?= htmlspecialchars($row['assigned_to']) ?></td>
            <td><?= htmlspecialchars($row['remarks']) ?></td>
            <td><?= date("d M Y", strtotime($row['created_at'])) ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
  function filterLeads() {
    let input = document.getElementById("leadSearch").value.toLowerCase();
    let rows = document.querySelectorAll("#leadsTable tbody tr");
    rows.forEach(row => {
      const cells = Array.from(row.getElementsByTagName("td"));
      const match = cells.some(cell => cell.innerText.toLowerCase().includes(input));
      row.style.display = match ? "" : "none";
    });
  }
</script>
<?php include 'footer.php'; ?>