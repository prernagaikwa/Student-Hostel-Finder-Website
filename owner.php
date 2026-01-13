<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "form_data";

$conn = new mysqli($host, $username, $password, $database,3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $location = $_POST['location'];
    $available_beds = $_POST['available_beds'];
    $rent = $_POST['rent'];
   // $price = $_POST['price'];
    $image_path = 'uploads/' . basename($_FILES['image']['name']);

    // File upload
    if (move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
        $stmt = $conn->prepare("
           INSERT INTO hostels (name, gender, address, location, available_beds, rent, image_path)
        VALUES (?, ?, ?, ?, ?, ?, ?)
 
        ");
      //  $stmt->bind_param("ssssiiis", $name, $gender, $address, $location, $available_beds, $rent, $price, $image_path);
        $stmt->bind_param("ssssiis", $name, $gender, $address, $location, $available_beds, $rent, $image_path);

        if ($stmt->execute()) {
            $success_message = "✅ Hostel registered successfully! It will now appear to students.";
        } else {
            $error_message = "❌ Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error_message = "❌ Failed to upload image.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Hostel</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <style>
        body {
            background: linear-gradient(135deg, #5563DE, #74ABE2);
            font-family: 'Poppins', sans-serif;
        }
        .container {
            max-width: 600px;
            margin-top: 60px;
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
            font-weight: 600;
            color: #333;
        }
        .btn-primary {
            background-color: #5563DE;
            border: none;
            font-weight: 600;
            transition: 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #3945b6;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Hostel Registration</h2>
        <?php if (isset($success_message)) { ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php } ?>
        <?php if (isset($error_message)) { ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php } ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Hostel Name</label>
                <input type="text" class="form-control" name="name" required>
            </div>

            <div class="form-group">
                <label>Gender</label>
                <select class="form-control" name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>

            <div class="form-group">
                <label>Address</label>
                <textarea class="form-control" name="address" rows="3" required></textarea>
            </div>

            <div class="form-group">
                <label>City / Location</label>
                <input type="text" class="form-control" name="location" required>
            </div>

            <div class="form-group">
                <label>Available Beds</label>
                <input type="number" class="form-control" name="available_beds" required>
            </div>

            <div class="form-group">
                <label>Rent (per month)</label>
                <input type="number" class="form-control" name="rent" required>
            </div>

           <!-- // <div class="form-group">
             //   <label>Price (Total or Other)</label>
                //<input type="number" class="form-control" name="price" required>
           // </div> -->

            <div class="form-group">
                <label>Upload Hostel Image</label>
                <input type="file" class="form-control-file" name="image" accept="image/*" required>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Register Hostel</button>
        </form>
    </div>

    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>
