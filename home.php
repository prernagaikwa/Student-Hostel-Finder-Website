<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>HostelHunt</title>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="css/bootstrap.css" />
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="css/font-awesome.min.css" rel="stylesheet" />
  <!-- Custom styles -->
  <link href="css/style.css" rel="stylesheet" />
  <link href="css/responsive.css" rel="stylesheet" />

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #eef2f3, #d9e4f5);
      color: #333;
      overflow-x: hidden;
    }

    /* Navbar */
    .navbar {
      background-color: #2c3e50;
      padding: 12px 25px;
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

    /* Hero Section */
    .hero_area {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      text-align: center;
      padding: 0 15px;
      background: linear-gradient(135deg, #74ABE2, #5563DE);
      color: white;
    }

    .hero_area h1 {
      font-size: 3rem;
      font-weight: 700;
      margin-bottom: 20px;
    }

    .hero_area p {
      font-size: 1.2rem;
      max-width: 600px;
      margin: 0 auto 30px;
      color: #f1f1f1;
    }

    .hero-btns a {
      display: inline-block;
      padding: 12px 25px;
      border-radius: 8px;
      font-weight: 600;
      font-size: 1rem;
      text-decoration: none;
      transition: 0.3s ease;
      margin: 10px;
    }

    .student-btn {
      background: #ffbd59;
      color: #333;
    }

    .student-btn:hover {
      background: #ffc96a;
    }

    .owner-btn {
      background: #ffffff;
      color: #5563DE;
      border: 2px solid #ffffff;
    }

    .owner-btn:hover {
      background: transparent;
      color: #fff;
      border-color: #fff;
    }

    .login-link {
      margin-top: 20px;
      color: #fff;
      font-size: 0.95rem;
    }

    .login-link a {
      color: #ffbd59;
      text-decoration: none;
      font-weight: 600;
    }

    .login-link a:hover {
      text-decoration: underline;
    }

    /* Footer */
    footer {
      text-align: center;
      padding: 15px;
      background: #2c3e50;
      color: white;
      font-size: 0.9rem;
    }

    footer a {
      color: #ffbd59;
      text-decoration: none;
    }
  </style>
</head>

<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="#">
      🏠 <span>HostelHunt</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link active" href="index.php">Hostels</a></li>
        <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
      </ul>
    </div> -->
  </nav>

  <!-- Hero Section -->
  <section class="hero_area">
    <h1>Welcome to HostelHunt</h1>
    <p>Find hostels and PGs that feel just like home. Register now to get started!</p>

    <div class="hero-btns">
      <a href="register.php" class="student-btn">Register as Student</a>
      <a href="owner.php" class="owner-btn">Register as Owner</a>
    </div>

    <div class="login-link">
      Already registered? <a href="login.php">Login here</a>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    &copy; <?= date('Y') ?> HostelHunt | Designed by <strong>Asma Kazi</strong>
  </footer>

  <!-- Scripts -->
  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
