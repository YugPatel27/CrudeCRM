<?php
ob_start();
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
include_once 'connect.php';
$conn = connectdb();

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT name, email, password, role, status, created_at FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
  <meta charset="UTF-8">
  <title>CRM Dashboard</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="theme-assets/images/ico/favicon.ico">
  <link href="https://fonts.googleapis.com/css?family=Muli:300,400,600,700|Comfortaa:300,400,700" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css">
  <link rel="stylesheet" href="theme-assets/css/vendors.css">
  <link rel="stylesheet" href="theme-assets/vendors/css/charts/chartist.css">
  <link rel="stylesheet" href="theme-assets/css/app-lite.css">
  <link rel="stylesheet" href="theme-assets/css/core/menu/menu-types/vertical-menu.css">
  <link rel="stylesheet" href="theme-assets/css/core/colors/palette-gradient.css">
  <link rel="stylesheet" href="theme-assets/css/pages/dashboard-ecommerce.css">

  <style>
    @media (max-width: 768px) {
      .main-menu {
        position: fixed;
        left: -250px;
        top: 0;
        bottom: 0;
        width: 250px;
        background-color: #fff;
        z-index: 1050;
        transition: left 0.3s ease-in-out;
      }

      .main-menu.active {
        left: 0;
      }

      .app-content, .content-wrapper {
        margin-left: 0 !important;
      }

      .overlay-sidebar {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 100vw;
        background-color: rgba(0,0,0,0.5);
        z-index: 1049;
      }

      .overlay-sidebar.show {
        display: block;
      }

      .author-branding {
        display: none;
      }
    }

    .author-branding {
      display: flex;
      align-items: center;
      margin-right: 15px;
      padding: 3px 10px;
      border-left: 2px solid #ccc;
      transition: background 0.3s ease;
    }

    .author-branding img {
      border-radius: 50%;
      height: 35px;
      width: 35px;
      object-fit: cover;
      margin-right: 8px;
    }

    .author-branding span {
      font-weight: 600;
      color: #5c5c5c;
      font-family: 'Comfortaa', cursive;
      transition: color 0.3s ease;
    }

    .author-branding:hover {
      background-color: #f3f3f3;
    }

    .author-branding:hover span {
      color: #d9534f;
    }
  </style>
</head>
<body class="vertical-layout vertical-menu 2-columns menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-color="bg-light" data-col="2-columns">

<!-- Top Navbar -->
<nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-semi-light">
  <div class="navbar-wrapper">
    <div class="navbar-container content">
      <div class="collapse navbar-collapse show" id="navbar-mobile">
        <ul class="nav navbar-nav mr-auto float-left">
          <li class="nav-item d-block d-md-none">
            <a class="nav-link nav-menu-main menu-toggle hidden-xs" href="javascript:void(0);" onclick="toggleSidebar()"><i class="ft-menu"></i></a>
          </li>
        </ul>
        <ul class="nav navbar-nav float-right">
          <!-- User Profile Dropdown -->
          <li class="dropdown dropdown-user nav-item">
            <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
              <span class="avatar avatar-online">
                <img src="theme-assets/images/portrait/small/avatar-s-19.png" alt="avatar"><i></i>
              </span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <div class="arrow_box_right">
                <a class="dropdown-item" href="#">
                  <span class="avatar avatar-online">
                    <img src="theme-assets/images/portrait/small/avatar-s-19.png" alt="avatar">
                    <span class="user-name text-bold-700 ml-1"><?= htmlspecialchars($user['name']) ?></span>
                  </span>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#profileModal"><i class="ft-user"></i>Profile</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php"><i class="ft-power"></i> Logout</a>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>

<!-- Sidebar Overlay for small screens -->
<div class="overlay-sidebar" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<?php
// Handle inline profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['profile_update'])) {
  $newName = trim($_POST['name']);
  $newEmail = trim($_POST['email']);

  $stmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE user_id = ?");
  $stmt->bind_param("ssi", $newName, $newEmail, $_SESSION['user_id']);
  if ($stmt->execute()) {
    echo "<script>alert('Profile updated'); window.location.href = window.location.href;</script>";
    log_activity($conn, $_SESSION['user_id'], 'profile', 'Updated profile info');
    exit;
  } else {
    echo "<script>alert('Error updating profile');</script>";
  }
}
?>
<!-- Profile Modal -->
<div class="modal fade" id="profileModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="post" class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Edit Profile</h5>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="profile_update" value="1">
        <input class="form-control mb-2" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
        <input class="form-control mb-2" type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        <input class="form-control mb-2" value="<?= htmlspecialchars($user['role']) ?>" readonly>
        <input class="form-control" value="<?= htmlspecialchars($user['created_at']) ?>" readonly>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-danger">Save</button>
      </div>
    </form>
  </div>
</div>

<!-- Scripts -->
<script src="theme-assets/vendors/js/vendors.min.js"></script>
<script src="theme-assets/vendors/js/charts/chartist.min.js"></script>
<script src="theme-assets/js/core/app-menu-lite.js"></script>
<script src="theme-assets/js/core/app-lite.js"></script>
<script src="theme-assets/js/scripts/pages/dashboard-lite.js"></script>

<script>
  function toggleSidebar() {
    var sidebar = document.getElementById("mainSidebar");
    var overlay = document.getElementById("sidebarOverlay");
    sidebar.classList.toggle("active");
    overlay.classList.toggle("show");
  }
</script>
</body>
</html>
<?php ob_end_flush(); ?>