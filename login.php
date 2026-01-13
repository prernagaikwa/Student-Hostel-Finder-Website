<?php
session_start();

$host = "localhost";
$username = "root";
$password = "";
$database = "form_data";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST['role']; // student or owner
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Choose table based on role
    $table = ($role === 'owner') ? 'owners' : 'students';
    $id_field = ($role === 'owner') ? 'owner_id' : 'id';

    $sql = "SELECT * FROM $table WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        
        // For now using plain password comparison (since you used === earlier)
        if ($password === $row['password']) {
            
            // Store in session
            $_SESSION['user_id'] = $row[$id_field];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['role'] = $role;

            // Redirect based on role
            if ($role === 'owner') {
                header("Location: owner_dashboard.php");
            } else {
                header("Location: index.php"); // student goes to main page
            }
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No account found with this email for selected role.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login | HostelHunt</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #74ABE2, #5563DE);
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .login-box {
      background: #fff;
      color: #333;
      border-radius: 10px;
      padding: 30px;
      width: 400px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      color: #5563DE;
      margin-bottom: 25px;
    }

    .btn-login {
      background: #5563DE;
      color: #fff;
      font-weight: 600;
    }

    .btn-login:hover {
      background: #4053c5;
    }

    .error {
      color: red;
      text-align: center;
      margin-bottom: 10px;
    }

    .back-link {
      display: block;
      text-align: center;
      margin-top: 15px;
    }

    select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
  </style>
</head>
<body>

  <div class="login-box">
    <h2>Login to HostelHunt</h2>

    <?php if ($error) echo "<p class='error'>$error</p>"; ?>

    <form method="POST">
      <div class="mb-3">
        <label>Select Role</label>
        <select name="role" required>
          <option value="">-- Select Role --</option>
          <option value="student">Student</option>
          <option value="owner">Owner</option>
        </select>
      </div>

      <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>

      <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>

      <button type="submit" class="btn btn-login w-100">Login</button>

      <a href="home.php" class="back-link">← Back to Home</a>
    </form>
  </div>

</body>
</html>
