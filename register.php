<?php
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // match login.php hash
    $confirm  = md5($_POST['confirm_password']);

    if ($password !== $confirm) {
        $error = "Passwords do not match!";
    } else {
        // Check if username already exists
        $check = $conn->query("SELECT * FROM users WHERE username='$username'");
        if ($check->num_rows > 0) {
            $error = "Username already exists!";
        } else {
            $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', 'user')";
            if ($conn->query($sql) === TRUE) {
                header("Location: login.php?registered=1");
                exit();
            } else {
                $error = "Error registering user: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - eVetCare</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
  <div class="col-md-6 mx-auto bg-white shadow p-4 rounded">
    <h2 class="text-center text-success mb-4"><i class="bi bi-person-plus"></i> Create Account</h2>

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

      <div class="mb-3">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="confirm_password" class="form-control" required>
      </div>

      <button type="submit" class="btn btn-success w-100">Register</button>
    </form>

    <p class="text-center mt-3 text-muted">
      Already have an account? <a href="login.php">Login here</a>
    </p>
  </div>
</div>

</body>
</html>
