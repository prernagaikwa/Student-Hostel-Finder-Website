<?php
// ✅ SHOW ERRORS (temporary for debugging on hosting)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ✅ LOG ERRORS
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php_error.log');

// ✅ connect database
include("db_connect_hosting.php");

// ✅ messages
$success_message = "";
$error_message = "";

// ✅ Handle form submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $gender = trim($_POST['gender'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $available_beds = (int)($_POST['available_beds'] ?? 0);
    $rent = (int)($_POST['rent'] ?? 0);

    // ✅ Upload Folder
    $upload_folder = "uploads/";

    // ✅ Check uploads folder exists
    if (!is_dir($upload_folder)) {
        mkdir($upload_folder, 0777, true);
    }

    // ✅ File Upload check
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $error_message = "❌ Image upload failed! Code: " . ($_FILES['image']['error'] ?? 'No file');
    } else {

        $file_name = time() . "_" . basename($_FILES['image']['name']);
        $image_path = $upload_folder . $file_name;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {

            // ✅ Insert query
            $stmt = $conn->prepare("
                INSERT INTO hostels (name, gender, address, location, available_beds, rent, image_path)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");

            if ($stmt) {
                $stmt->bind_param("ssssiis", $name, $gender, $address, $location, $available_beds, $rent, $image_path);

                if ($stmt->execute()) {
                    $success_message = "✅ Hostel Registered Successfully!";
                } else {
                    $error_message = "❌ Database Error: " . $stmt->error;
                }

                $stmt->close();
            } else {
                $error_message = "❌ Prepare statement failed: " . $conn->error;
            }

        } else {
            $error_message = "❌ Failed to move uploaded image!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Owner Hostel Registration | HostelHunt</title>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

  <style>
    body{
      background: linear-gradient(135deg, #74ABE2, #5563DE);
      font-family: 'Poppins', sans-serif;
      min-height: 100vh;
      display:flex;
      justify-content:center;
      align-items:center;
    }
    .card{
      width:100%;
      max-width:550px;
      border-radius:15px;
      padding:25px;
      box-shadow:0 8px 25px rgba(0,0,0,0.2);
    }
    .btn-primary{
      background:#5563DE;
      border:none;
      font-weight:600;
    }
    .btn-primary:hover{
      background:#3945b6;
    }
  </style>
</head>

<body>

<div class="card">
  <h2 class="text-center mb-3">🏠 Owner Hostel Registration</h2>
  <p class="text-center text-muted">Add hostel details so students can find it</p>

  <!-- ✅ messages -->
  <?php if (!empty($success_message)) { ?>
    <div class="alert alert-success"><?= $success_message ?></div>
  <?php } ?>

  <?php if (!empty($error_message)) { ?>
    <div class="alert alert-danger"><?= $error_message ?></div>
  <?php } ?>

  <!-- ✅ FORM -->
  <form method="POST" enctype="multipart/form-data">

    <div class="mb-3">
      <label class="form-label">Hostel Name</label>
      <input type="text" class="form-control" name="name" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Gender</label>
      <select class="form-control" name="gender" required>
        <option value="">Select Gender</option>
        <option value="Male">Male Hostel</option>
        <option value="Female">Female Hostel</option>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Address</label>
      <textarea class="form-control" name="address" rows="3" required></textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Location / City</label>
      <input type="text" class="form-control" name="location" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Available Beds</label>
      <input type="number" class="form-control" name="available_beds" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Rent (per month)</label>
      <input type="number" class="form-control" name="rent" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Upload Hostel Image</label>
      <input type="file" class="form-control" name="image" accept="image/*" required>
    </div>

    <button type="submit" class="btn btn-primary w-100">Register Hostel</button>

    <div class="text-center mt-3">
      <a href="index.php" class="text-decoration-none">← Back to Home</a>
    </div>

  </form>
</div>

</body>
</html>
