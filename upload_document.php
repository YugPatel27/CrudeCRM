<?php
include_once 'sidebar.php';

<?php
$conn = new mysqli("localhost", "root", "", "crmcrude");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST["id"]);
    $description = $conn->real_escape_string($_POST["description"]);

    $uploadDir = "documents/";
    if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

    $fileName = basename($_FILES["document"]["name"]);
    $targetFilePath = $uploadDir . time() . "_" . $fileName;

    if (move_uploaded_file($_FILES["document"]["tmp_name"], $targetFilePath)) {
        $stmt = $conn->prepare("INSERT INTO documents (id, description, file_path) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $id, $description, $targetFilePath);
        if ($stmt->execute()) {
            echo "<script>alert('Document uploaded successfully!');</script>";
        } else {
            echo "<script>alert('Database error: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Error uploading file.');</script>";
    }
    log_activity($conn, $_SESSION['user_id'], 'documents', 'Uploaded document: ' . $file_name);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Upload Document</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      background-color: #f4f6fb;
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
    }

    .container-wrapper {
      margin-left: 250px; /* sidebar offset */
      display: flex;
      justify-content: center;
      align-items: center;
      height: calc(100vh - 100px);
    }

    .form-card {
      width: 400px;
      background: #fff;
      border-radius: 5px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .form-header {
      background-color: #dc3545;
      color: #fff;
      padding: 15px;
      text-align: center;
      font-size: 18px;
      font-weight: bold;
      border-top-left-radius: 5px;
      border-top-right-radius: 5px;
    }

    .form-body {
      padding: 25px 30px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    label {
      font-weight: 600;
      display: block;
      margin-bottom: 6px;
    }

    input[type="text"],
    input[type="number"],
    input[type="file"] {
      width: 100%;
      padding: 8px 12px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    button {
      background-color: #dc3545;
      color: white;
      width: 100%;
      padding: 10px;
      border: none;
      border-radius: 6px;
      font-weight: 600;
      cursor: pointer;
    }

    button:hover {
      background-color: #b02a37;
    }

    @media (max-width: 768px) {
      .container-wrapper {
        margin-left: 0;
        padding: 20px;
      }

      .form-card {
        width: 100%;
      }
    }
  </style>
</head>
<body>
<?php $skipHeaderWrapper = true; include 'header.php'; ?>

<div class="container-wrapper">
  <div class="form-card">
    <div class="form-header">
      <i class="fas fa-upload"></i> Upload Document
    </div>
    <div class="form-body">
      <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label for="id">Document ID</label>
          <input type="number" name="id" required>
        </div>

        <div class="form-group">
          <label for="description">Description</label>
          <input type="text" name="description" required>
        </div>

        <div class="form-group">
          <label for="document">Select Document (PDF, DOCX, etc.)</label>
          <input type="file" name="document" accept=".pdf,.doc,.docx,.txt" required>
        </div>

        <button type="submit"><i class="fas fa-save"></i> Upload</button>
      </form>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>