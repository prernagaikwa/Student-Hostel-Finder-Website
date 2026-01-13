<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Registration</title>

    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #74ABE2, #5563DE);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            background: #fff;
            padding: 40px 50px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        label {
            display: block;
            text-align: left;
            font-weight: 500;
            margin-bottom: 8px;
            color: #444;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1.5px solid #ccc;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        input:focus, select:focus {
            border-color: #5563DE;
            outline: none;
            box-shadow: 0 0 5px rgba(85, 99, 222, 0.4);
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            background: #5563DE;
            color: #fff;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s ease;
        }

        button:hover {
            background: #3b4fc3;
        }

        .owner-btn {
            display: inline-block;
            margin-top: 15px;
            background: #e84545;
            color: #fff;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s ease;
        }

        .owner-btn:hover {
            background: #d32f2f;
        }

        p {
            margin-top: 10px;
        }
    </style>
</head>
<body>

<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$database = "form_data";

$conn = new mysqli($host, $username, $password, $database,3307);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $contactNumber = $_POST['contactNumber'];
    $collegeName = $_POST['collegeName'];
    $gender = $_POST['gender'];

    $stmt = $conn->prepare("INSERT INTO registrations (name, contactNumber, collegeName, gender) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $contactNumber, $collegeName, $gender);

    if ($stmt->execute()) {
        echo "<p style='color: green; text-align:center;'>Registration successful!</p>";
        header("Location: student_dashboard.php?gender=" . $gender);
        exit();
    } else {
        echo "<p style='color: red; text-align:center;'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}
$conn->close();
?>

<form id="myForm" method="post">
    <h2>Participant Registration</h2>

    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="contactNumber">Contact Number:</label>
    <input type="tel" id="contactNumber" name="contactNumber" pattern="^[7-9][0-9]{9}$" required>

    <label for="collegeName">College Name:</label>
    <input type="text" id="collegeName" name="collegeName" required>

    <label for="gender">Gender:</label>
    <select id="gender" name="gender" required>
        <option value="">Select Gender</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Other">Other</option>
    </select>

    <button type="submit">Submit</button>

    <!-- <a href="owner.php" class="owner-btn">Register as Owner</a> -->
</form>

</body>
</html>
