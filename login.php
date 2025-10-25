<?php
ob_start();
session_start();

header("X-Content-Type-Options: nosniff");
header("Cache-Control: public, max-age=31536000, immutable");

// Include database connection
include_once 'connect.php'; 
$conn = connectdb(); // Use the connectdb function to get the connection

// LOGIN LOGIC
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $loginInput = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE (name = ? OR email = ?) AND status = 1");
    $stmt->bind_param("ss", $loginInput, $loginInput);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if ($password === $user['password']) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            header("Location: index.php");
            exit();
        } else {
            echo "<script>alert('Incorrect password'); window.location.href='login.php';</script>";
        }
    } else {
        echo "<script>alert('User not found or inactive'); window.location.href='login.php';</script>";
    }
    $stmt->close();
}

// REGISTER LOGIC
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $name = trim($_POST['reg_name']);
    $email = trim($_POST['reg_email']);
    $password = trim($_POST['reg_password']);
    $role = trim($_POST['reg_role']);
    $status = 1;
    $created_at = date("Y-m-d H:i:s");

    if (empty($name) || empty($email) || empty($password) || empty($role)) {
        echo "<script>alert('All fields are required.'); window.history.back();</script>";
        exit();
    }

    $check = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "<script>alert('Email already registered. Please login.'); window.history.back();</script>";
        exit();
    }
    $check->close();

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role, status, created_at) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssis", $name, $email, $password, $role, $status, $created_at);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful. You can now login.'); window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Registration failed. Try again.'); window.history.back();</script>";
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>CrudeCRM Login</title>
<link href="https://fonts.googleapis.com/css?family=Muli:300,400,600,700&display=swap" rel="stylesheet">
<style>
  * {
    box-sizing: border-box;
    font-family: 'Muli', sans-serif;
  }

  body {
    margin: 0;
    height: 100vh;
    background: linear-gradient(to right, #F44336, #FF5252);
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .container {
    width: 900px;
    max-width: 100%;
    background: white;
    border-radius: 14px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    display: flex;
    overflow: hidden;
  }

  .left-panel {
  width: 50%;
  background: linear-gradient(135deg, #C62828, #FF5252);
  color: white;
  padding: 50px 30px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
}

.left-panel img {
  width: 220px;
  margin-bottom: 25px;
  border-radius: 8px;
  background: rgba(255, 255, 255, 0.1);
  padding: 10px;
}

  .left-panel h1 {
    font-size: 26px;
    margin-bottom: 10px;
  }

  .left-panel p {
    font-size: 14px;
    line-height: 1.6;
    max-width: 280px;
  }

  .right-panel {
    width: 50%;
    padding: 40px 30px;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .form-box {
    display: none;
    width: 100%;
  }

  .form-box.active {
    display: block;
  }

  .form-box h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #F44336;
  }

  .form-box label {
    font-weight: 600;
    margin-bottom: 4px;
    display: inline-block;
    font-size: 14px;
  }

  .form-box input,
  .form-box select {
    width: 100%;
    padding: 12px 15px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 30px;
    font-size: 15px;
    transition: border-color 0.3s ease;
  }

  .form-box input:focus,
  .form-box select:focus {
    border-color: #F44336;
    outline: none;
  }

  .form-box button {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 30px;
    background: linear-gradient(to right, #F44336, #FF5252);
    color: white;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
  }

  .form-box button:hover {
    box-shadow: 0 4px 10px rgba(244, 67, 54, 0.4);
  }

  .form-box .toggle {
    text-align: center;
    margin-top: 10px;
    font-size: 14px;
  }

  .form-box .toggle a {
    color: #F44336;
    text-decoration: none;
    font-weight: 600;
  }

  .form-box .toggle a:hover {
    text-decoration: underline;
  }

  @media (max-width: 768px) {
    .container {
      flex-direction: column;
      width: 90%;
    }

    .left-panel, .right-panel {
      width: 100%;
      height: auto;
    }

    .left-panel {
      padding: 30px;
    }
  }
</style>
</head>
<body>
  <div class="container">
    <!-- Left -->
    <div class="left-panel">
  <img src="https://cdn-icons-png.flaticon.com/512/2038/2038664.png" alt="CRM Red Illustration">
  <h1>Welcome to CrudeCRM</h1>
  <p>Smart crude oil tracking, sales, and billing all in one dashboard.</p>
  </div>


    <!-- Right -->
    <div class="right-panel">
      <!-- Login Form -->
      <form method="POST" class="form-box active" id="loginForm">
        <h2>Login</h2>
        <label for="username">Username or Email</label>
        <input type="text" name="username" id="username" required autocomplete="username" placeholder="Enter name or email" />
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required autocomplete="current-password" placeholder="Enter password" />
        <button type="submit" name="login">Login</button>
        <div class="toggle">No account? <a href="#" onclick="toggleForms()">Register</a></div>
      </form>

      <!-- Register Form -->
      <form method="POST" class="form-box" id="registerForm">
        <h2>Register</h2>
        <label for="reg_name">Full Name</label>
        <input type="text" name="reg_name" id="reg_name" required autocomplete="name" />
        <label for="reg_email">Email</label>
        <input type="email" name="reg_email" id="reg_email" required autocomplete="email" />
        <label for="reg_password">Password</label>
        <input type="password" name="reg_password" id="reg_password" required autocomplete="new-password" />
        <label for="reg_role">Select Role</label>
        <select name="reg_role" id="reg_role" required aria-label="User role">
          <option value="">-- Select Role --</option>
          <option value="sales">Sales</option>
          <option value="manager">Manager</option>
        </select>
        <button type="submit" name="register">Register</button>
        <div class="toggle">Already registered? <a href="#" onclick="toggleForms()">Login</a></div>
      </form>
    </div>
  </div>

  <script>
    function toggleForms() {
      document.getElementById('loginForm').classList.toggle('active');
      document.getElementById('registerForm').classList.toggle('active');
    }
  </script>
</body>
</html>
<?php ob_end_flush(); ?>
