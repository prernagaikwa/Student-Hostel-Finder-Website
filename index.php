<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>HostelHunt</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="bg-light d-flex justify-content-center align-items-center vh-100">

  <div class="text-center p-4 bg-white shadow rounded" style="max-width:450px; width:100%;">
    <h1 class="mb-2">🏠 HostelHunt</h1>
    <p class="text-muted mb-4">Choose your role</p>

    <div class="d-grid gap-3">
      <a href="register.php" class="btn btn-primary btn-lg">👩‍🎓 I am Student</a>
      <a href="owner.php" class="btn btn-danger btn-lg">🏠 I am Owner</a>
    </div>

    <p class="mt-4 text-muted small">
      &copy; <?= date('Y') ?> HostelHunt | Designed by <strong>Prerna Gaikwad</strong>
    </p>
  </div>

</body>
</html>
