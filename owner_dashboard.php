<?php
session_start();

// Check if owner is logged in
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'owner') {
    header("Location: login.php");
    exit();
}

$host = "localhost";
$username = "root";
$password = "";
$database = "form_data";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$owner_id = $_SESSION['user_id'];

// Delete hostel if requested
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $conn->query("DELETE FROM hostels WHERE id = $delete_id AND owner_id = $owner_id");
    header("Location: owner_dashboard.php");
    exit();
}

// Fetch hostels for this owner
$sql = "SELECT * FROM hostels WHERE owner_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $owner_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Owner Dashboard | HostelHunt</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #74ABE2, #5563DE);
      color: #333;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .navbar {
      background: rgba(0, 0, 0, 0.2);
    }

    .navbar-brand span {
      color: #ffbd59;
      font-weight: 700;
      font-size: 1.5rem;
    }

    .navbar a.nav-link {
      color: #fff !important;
      font-weight: 500;
      margin: 0 10px;
      transition: 0.3s ease;
    }

    .navbar a.nav-link:hover {
      color: #ffbd59 !important;
    }

    .container {
      flex: 1;
      margin-top: 40px;
    }

    .card {
      border: none;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .card img {
      height: 200px;
      object-fit: cover;
    }

    .footer_section {
      text-align: center;
      padding: 15px;
      color: #fff;
      background: rgba(0,0,0,0.3);
      margin-top: auto;
    }

    .btn-add {
      background: #ffbd59;
      color: #333;
      font-weight: 600;
      border: none;
      margin-bottom: 20px;
    }

    .btn-add:hover {
      background: #ffd37a;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
  <div class="container-fluid px-4">
    <a class="navbar-brand" href="home.php">
      <img src="images/hostel-logo.png" alt="" style="height: 40px;">
      <span>HostelHunt</span>
    </a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="owner_dashboard.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
  <h2 class="text-white text-center mb-4">Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?> 👋</h2>

  <div class="text-end">
    <a href="add_hostel.php" class="btn btn-add">+ Add New Hostel</a>
  </div>

  <div class="row">
    <?php if ($result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="col-md-4 mb-4">
          <div class="card">
            <img src="<?= htmlspecialchars($row['image_path'] ?: 'images/default-hostel.jpg') ?>" class="card-img-top" alt="Hostel Image">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($row['name']) ?></h5>
              <p class="card-text mb-1"><strong>Location:</strong> <?= htmlspecialchars($row['location']) ?></p>
              <p class="card-text mb-1"><strong>Rent:</strong> ₹<?= htmlspecialchars($row['rent']) ?></p>
              <p class="card-text mb-1"><strong>Available Beds:</strong> <?= htmlspecialchars($row['available_beds']) ?></p>
              <div class="d-flex justify-content-between mt-3">
                <a href="edit_hostel.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                <a href="owner_dashboard.php?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this hostel?');">Delete</a>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p class="text-center text-white">You haven’t added any hostels yet.</p>
    <?php endif; ?>
  </div>
</div>

<footer class="footer_section">
  <p>&copy; <span id="displayYear"></span> All Rights Reserved by <a href="#">Asma Kazi</a></p>
</footer>

<script>
  document.getElementById("displayYear").textContent = new Date().getFullYear();
</script>

</body>
</html>
