<?php
session_start();
include('db_connect.php');

// ✅ If admin not logged in, show login form (same page)
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = md5($_POST['password']); // same method used in DB

        $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            if ($user['role'] == 'admin') {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = 'admin';
                header("Location: admin.php"); // reload same page to show dashboard
                exit();
            } else {
                $error = "Access denied — not an admin account!";
            }
        } else {
            $error = "Invalid username or password!";
        }
    }

    // ✅ Show login form for admin if not logged in
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Login - eVetCare</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-light">

    <div class="container py-5">
      <div class="col-md-6 mx-auto bg-white shadow p-4 rounded">
        <h2 class="text-center text-primary mb-4"><i class="bi bi-shield-lock"></i> Admin Login</h2>
        <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

        <form method="POST" action="">
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
      </div>
    </div>

    </body>
    </html>
    <?php
    exit();
}

// ✅ If admin is logged in, show dashboard
$total = $conn->query("SELECT COUNT(*) AS total FROM appointments")->fetch_assoc()['total'] ?? 0;
$emergency = $conn->query("SELECT COUNT(*) AS total FROM appointments WHERE appointment_date IS NULL OR appointment_date = ''")->fetch_assoc()['total'] ?? 0;
$regular = $total - $emergency;

$emergency_cases = $conn->query("SELECT * FROM appointments WHERE appointment_date IS NULL OR appointment_date = '' ORDER BY created_at DESC");
$regular_cases = $conn->query("SELECT * FROM appointments WHERE appointment_date IS NOT NULL AND appointment_date != '' ORDER BY appointment_date ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - eVetCare</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include('header.php'); ?>

<div class="container my-5">
  <h1 class="text-center text-primary fw-bold mb-4">Admin Dashboard</h1>
  <div class="alert alert-info text-center">
    Welcome, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>!
    <a href="logout.php" class="btn btn-outline-danger btn-sm ms-3">Logout</a>
  </div>

  <div class="row text-center mb-5">
    <div class="col-md-4">
      <div class="card border-info shadow-sm"><div class="card-body"><h5>Total</h5><h2><?= $total ?></h2></div></div>
    </div>
    <div class="col-md-4">
      <div class="card border-danger shadow-sm"><div class="card-body"><h5>Emergency</h5><h2><?= $emergency ?></h2></div></div>
    </div>
    <div class="col-md-4">
      <div class="card border-success shadow-sm"><div class="card-body"><h5>Regular</h5><h2><?= $regular ?></h2></div></div>
    </div>
  </div>

  <h3 class="text-danger">🚨 Emergency Cases</h3>
  <div class="table-responsive mb-5">
    <table class="table table-bordered table-striped">
      <thead class="table-danger"><tr><th>ID</th><th>Owner</th><th>Contact</th><th>Pet</th><th>Symptoms</th><th>Created</th></tr></thead>
      <tbody>
      <?php if ($emergency_cases->num_rows > 0): while ($row = $emergency_cases->fetch_assoc()): ?>
        <tr><td><?= $row['appointment_id'] ?></td><td><?= $row['owner_name'] ?></td><td><?= $row['contact'] ?></td><td><?= $row['pet_name'] ?></td><td><?= $row['symptoms'] ?></td><td><?= $row['created_at'] ?></td></tr>
      <?php endwhile; else: ?><tr><td colspan="6" class="text-center text-muted">No emergency cases</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>

  <h3 class="text-success">🐾 Regular Appointments</h3>
  <div class="table-responsive">
    <table class="table table-bordered table-striped">
      <thead class="table-success"><tr><th>ID</th><th>Owner</th><th>Pet</th><th>Species</th><th>Breed</th><th>Date</th></tr></thead>
      <tbody>
      <?php if ($regular_cases->num_rows > 0): while ($row = $regular_cases->fetch_assoc()): ?>
        <tr><td><?= $row['appointment_id'] ?></td><td><?= $row['owner_name'] ?></td><td><?= $row['pet_name'] ?></td><td><?= $row['species'] ?></td><td><?= $row['breed'] ?></td><td><?= $row['appointment_date'] ?></td></tr>
      <?php endwhile; else: ?><tr><td colspan="6" class="text-center text-muted">No regular appointments</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include('footer.php'); ?>
</body>
</html>
