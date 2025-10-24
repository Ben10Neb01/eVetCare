<?php
include('db_connect.php');

$results = [];
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $owner_name = trim($_POST['owner_name']);
    $contact = trim($_POST['contact']);

    if ($owner_name && $contact) {
        $sql = "SELECT * FROM appointments WHERE owner_name='$owner_name' AND contact='$contact' ORDER BY appointment_date DESC";
        $query = $conn->query($sql);

        if ($query && $query->num_rows > 0) {
            $results = $query->fetch_all(MYSQLI_ASSOC);
        } else {
            $error = "❌ No appointment found. Please check your name and contact number.";
        }
    } else {
        $error = "⚠️ Please enter both your name and contact number.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>View Appointment - eVetCare</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet"/>
</head>
<body class="bg-light">
<div class="container py-5">

  <h1 class="text-center text-primary mb-4 fw-bold">
    <i class="bi bi-journal-text"></i> View My Appointment
  </h1>

  <!-- 🐾 Search Form -->
  <div class="col-md-6 mx-auto mb-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <h5 class="text-center mb-3">Find Your Appointment</h5>
        <?php if (!empty($error)): ?>
          <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST">
          <div class="mb-3">
            <label class="form-label">Owner Name</label>
            <input type="text" name="owner_name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Contact Number</label>
            <input type="text" name="contact" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">View Appointment</button>
        </form>
      </div>
    </div>
  </div>

  <?php if (!empty($results)): ?>
  <!-- 📋 Appointment Results -->
  <div class="table-responsive mt-4">
    <table class="table table-bordered table-striped align-middle">
      <thead class="table-dark text-center">
        <tr>
          <th>ID</th>
          <th>Owner</th>
          <th>Pet</th>
          <th>Species</th>
          <th>Date</th>
          <th>Fee (₹)</th>
          <th>Payment</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($results as $row): ?>
        <?php
          $rowClass =
            ($row['approval_status'] === 'approved') ? 'table-success' :
            (($row['approval_status'] === 'pending') ? 'table-warning' :
            (($row['approval_status'] === 'rejected') ? 'table-danger' : ''));
        ?>
        <tr class="<?= $rowClass ?>">
          <td class="text-center"><?= $row['appointment_id'] ?></td>
          <td><?= htmlspecialchars($row['owner_name']) ?></td>
          <td><?= htmlspecialchars($row['pet_name']) ?></td>
          <td><?= htmlspecialchars($row['species']) ?></td>
          <td class="text-center"><?= date('d M Y, h:i A', strtotime($row['appointment_date'])) ?></td>
          <td class="text-center">₹<?= number_format((float)$row['fee'], 2) ?></td>
          <td class="text-center">
            <span class="badge <?= ($row['payment_status'] === 'paid') ? 'bg-success' : 'bg-warning text-dark' ?>">
              <?= ucfirst($row['payment_status']) ?>
            </span>
          </td>
          <td class="text-center"><?= ucfirst($row['approval_status']) ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>

  <div class="text-center mt-4">
    <a href="index.php" class="btn btn-outline-primary"><i class="bi bi-house-door"></i> Home</a>
  </div>

</div>
</body>
</html>
