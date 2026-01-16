<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("db_connect_hosting.php");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $contactNumber = $_POST['contactNumber'];
    $collegeName = $_POST['collegeName'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Insert into students table
    
     $stmt = $conn->prepare("INSERT INTO students (name, contactNumber, collegeName, gender, email, password) VALUES (?, ?, ?, ?, ?, ?)");
     $stmt->bind_param("ssssss", $name, $contactNumber, $collegeName, $gender, $email, $password);


    if ($stmt->execute()) {
        header("Location: student_dashboard.php?gender=" . $gender);
        exit();
    } else {
        echo "<p style='color: red; text-align:center;'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>

    <style>
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
    </style>
</head>

<body>

<form id="myForm" method="post">
    <h2>Student Registration</h2>

    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="contactNumber">Contact Number:</label>
    <input type="tel" id="contactNumber" name="contactNumber" pattern="^[7-9][0-9]{9}$" required>

    <label for="collegeName">College Name:</label>
    <input type="text" id="collegeName" name="collegeName" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <label for="gender">Gender:</label>
    <select id="gender" name="gender" required>
        <option value="">Select Gender</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Other">Other</option>
    </select>

    <button type="submit">Submit</button>
</form>

</body>
</html>
