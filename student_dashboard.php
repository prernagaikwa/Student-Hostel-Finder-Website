<?php
session_start();

// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "form_data";

$conn = new mysqli($host, $username, $password, $database,3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get gender filter (optional)
// Get filters
$genderFilter = isset($_GET['gender']) ? $_GET['gender'] : 'All';
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

// Build query dynamically
if ($genderFilter == 'All' && $searchTerm == '') {
    $query = "SELECT * FROM hostels";
    $stmt = $conn->prepare($query);
} elseif ($genderFilter == 'All') {
    $query = "SELECT * FROM hostels WHERE name LIKE ? OR location LIKE ?";
    $stmt = $conn->prepare($query);
    $likeSearch = "%$searchTerm%";
    $stmt->bind_param("ss", $likeSearch, $likeSearch);
} elseif ($searchTerm == '') {
    $query = "SELECT * FROM hostels WHERE gender = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $genderFilter);
} else {
    $query = "SELECT * FROM hostels WHERE gender = ? AND (name LIKE ? OR location LIKE ?)";
    $stmt = $conn->prepare($query);
    $likeSearch = "%$searchTerm%";
    $stmt->bind_param("sss", $genderFilter, $likeSearch, $likeSearch);
}
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HostelHunt - Student Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #eef2f3, #d9e4f5);
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background-color: #2c3e50;
        }

        .navbar-brand span {
            color: #ffbd59;
            font-weight: 600;
            font-size: 1.3rem;
        }

        .navbar .btn-logout {
            background: #e74c3c;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 8px 15px;
            font-weight: 500;
        }

        .navbar .btn-logout:hover {
            background: #c0392b;
        }

        .dashboard-header {
            text-align: center;
            margin: 40px 0 20px;
        }

        .dashboard-header h1 {
            font-weight: 700;
            color: #2c3e50;
        }

        .filter-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .filter-container select, .filter-container button {
            font-size: 1rem;
            padding: 8px 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .filter-container button {
            background-color: #5563DE;
            color: white;
            border: none;
            font-weight: 600;
            transition: 0.3s;
        }

        .filter-container button:hover {
            background-color: #4053c5;
        }
        .filter-container input[type="text"] {
    padding: 8px 15px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 1rem;
    width: 250px;
}


        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-8px);
        }

        .card img {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            height: 200px;
            width: 100%;
            object-fit: cover;
        }

        .card-body {
            text-align: left;
            padding: 15px;
        }

        .card-title {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
        }

        .price {
            font-size: 1.1rem;
            color: #27ae60;
            font-weight: 600;
        }

        .no-data {
            text-align: center;
            font-size: 18px;
            color: #666;
            margin-top: 60px;
            min-height: 50vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        footer {
            text-align: center;
            padding: 15px;
            background: #3f51b5;
            color: white;
            margin-top: auto;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg px-4">
  <a class="navbar-brand" href="#">
    🏠 <span>HostelHunt</span>
  </a>
  <!-- <div class="ms-auto">
    <a href="logout.php" class="btn btn-logout">Logout</a>
  </div> -->
</nav>

<div class="container flex-grow-1">
    <div class="dashboard-header">
        <h1>Student Dashboard</h1>
        <p>Find hostels that suit you best!</p>
    </div>

    <div class="filter-container">
    <form method="get">
        <select name="gender">
            <option value="All" <?= $genderFilter == 'All' ? 'selected' : '' ?>>All Hostels</option>
            <option value="Male" <?= $genderFilter == 'Male' ? 'selected' : '' ?>>Male Hostels</option>
            <option value="Female" <?= $genderFilter == 'Female' ? 'selected' : '' ?>>Female Hostels</option>
        </select>
        <input type="text" name="search" placeholder="Search by location or name" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        <button type="submit">Search</button>
    </form>
</div>

    <div class="row g-4">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $name = htmlspecialchars($row['name'] ?? 'Unnamed Hostel');
                $gender = htmlspecialchars($row['gender'] ?? 'Not specified');
                $address = htmlspecialchars($row['address'] ?? 'Not mentioned');
                $rent = htmlspecialchars($row['rent'] ?? 'N/A');
                $beds = htmlspecialchars($row['available_beds'] ?? 'N/A');
                
                // ✅ Use image_path from uploads folder
                $image = !empty($row['image_path']) && file_exists($row['image_path'])
                    ? htmlspecialchars($row['image_path'])
                    : 'images/default-hostel.jpg';

                echo "
                <div class='col-md-3'>
                    <div class='card'>
                        <img src='$image' alt='Hostel Image'>
                        <div class='card-body'>
                            <h5 class='card-title'>$name</h5>
                            <p><strong>Gender:</strong> $gender</p>
                            <p><strong>Address:</strong> $address</p>
                            <p><strong>Available Beds:</strong> $beds</p>
                            <p class='price'>₹$rent / month</p>
                        </div>
                    </div>
                </div>
                ";
            }
        } else {
            echo "<div class='no-data'><p>😕 No hostels found matching your selection.</p></div>";
        }
        ?>
    </div>
</div>

<footer>
    &copy; <?= date('Y') ?> HostelHunt | Designed by <strong>Prerna Gaikwad</strong>
</footer>

</body>
</html>

<?php $conn->close(); ?>
