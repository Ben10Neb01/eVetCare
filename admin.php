<?php
session_start();
include('db_connect.php');

$logged_in = false;
$error = "";

// If admin is already logged in, skip password prompt
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    $logged_in = true;
}

// Handle login form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'])) {
    $username = trim($_POST['username']);
    $password = md5(trim($_POST['password'])); // must match database hash

    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password' AND role='admin'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        $logged_in = true;
    } else {
        $error = "❌ Invalid admin credentials!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Panel - eVetCare</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet"/>
</head>
<body class="bg-light">
<div class="container py-5">

  <h1 class="text-center text-dark mb-4 fw-bold">
    <i class="bi bi-shield-lock"></i> Admin Panel
  </h1>

  <?php if (!$logged_in): ?>
    <!-- Admin Login Form -->
    <div class="col-md-5 mx-auto">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="text-center mb-3">Admin Login</h5>
          <?php if ($error): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
          <?php endif; ?>
          <form method="POST">
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-dark w-100">Login</button>
          </form>
        </div>
      </div>
    </div>
  <?php else: ?>
    <!-- Full Appointment Database -->
    <div class="text-end mb-3">
      <a href="logout.php" class="btn btn-outline-danger"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>

    <?php
      $query = $conn->query("SELECT * FROM appointments ORDER BY appointment_date DESC");
      if ($query && $query->num_rows > 0):
          $results = $query->fetch_all(MYSQLI_ASSOC);
    ?>
    <div class="table-responsive">
      <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark text-center">
          <tr>
            <th>ID</th>
            <th>Owner</th>
            <th>Pet</th>
            <th>Species</th>
            <th>Contact</th>
            <th>Date</th>
            <th>Fee (₹)</th>
            <th>Payment</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($results as $row): ?>
          <tr>
            <td class="text-center"><?= $row['appointment_id'] ?></td>
            <td><?= htmlspecialchars($row['owner_name']) ?></td>
            <td><?= htmlspecialchars($row['pet_name']) ?></td>
            <td><?= htmlspecialchars($row['species']) ?></td>
            <td><?= htmlspecialchars($row['contact']) ?></td>
            <td class="text-center"><?= date('d M Y, h:i A', strtotime($row['appointment_date'])) ?></td>
            <td class="text-center">₹<?= number_format((float)$row['fee'], 2) ?></td>
            <td class="text-center"><?= ucfirst($row['payment_status']) ?></td>
            <td class="text-center"><?= ucfirst($row['approval_status']) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php else: ?>
      <div class="alert alert-info text-center">No appointments found.</div>
    <?php endif; ?>
  <?php endif; ?>

  <div class="text-center mt-4">
    <a href="index.php" class="btn btn-outline-primary"><i class="bi bi-house-door"></i> Home</a>
  </div>

</div>
</body>
</html>
