<!DOCTYPE HTML>
<html lang="en">
<head>
 <title>Appointment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
<?php include('header.php'); ?>

    <main>
        <h1>Welcome to eVetCare System</h1>
        <p>Your trusted partner in animal healthcare management.</p>
    </main>

<?php include('db_connect.php'); ?>

<form action="submit_appointment.php" method="POST" enctype="multipart/form-data" 
      class="container my-5 p-4 border rounded shadow bg-white">

  <h2 class="text-center text-primary mb-4">
    <i class="bi bi-calendar-heart"></i> Book Veterinary Appointment
  </h2>

  <!-- Owner Information -->
  <div class="mb-4">
    <h5 class="text-success border-start border-3 ps-2 mb-3">Owner Information</h5>
    <div class="row g-3">
      <div class="col-md-6">
        <label for="owner_name" class="form-label">Owner Name:</label>
        <input type="text" id="owner_name" name="owner_name" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label for="contact" class="form-label">Contact Number:</label>
        <input type="tel" id="contact" name="contact" class="form-control" 
               placeholder="10-digit number" pattern="[0-9]{10}" required>
      </div>
      <div class="col-md-6">
        <label for="email" class="form-label">Email:</label>
        <input type="email" id="email" name="email" class="form-control" 
               placeholder="owner@example.com" required>
      </div>
      <div class="col-md-6">
        <label for="address" class="form-label">Address:</label>
        <input type="text" id="address" name="address" class="form-control" 
               placeholder="City / Town / Area" required>
      </div>
    </div>
  </div>

  <!-- Pet Information -->
  <div class="mb-4">
    <h5 class="text-success border-start border-3 ps-2 mb-3">Pet Information</h5>
    <div class="row g-3">
      <div class="col-md-6">
        <label for="pet_name" class="form-label">Pet Name:</label>
        <input type="text" id="pet_name" name="pet_name" class="form-control" required>
      </div>
      <div class="col-md-3">
        <label for="age" class="form-label">Age (years):</label>
        <input type="number" id="age" name="age" class="form-control" min="0" step="0.1" required>
      </div>
      <div class="col-md-3">
        <label for="sex" class="form-label">Sex:</label>
        <select id="sex" name="sex" class="form-select" required>
          <option value="">Select</option>
          <option>Male</option>
          <option>Female</option>
        </select>
      </div>
      <div class="col-md-6">
        <label for="species" class="form-label">Animal Species:</label>
        <input type="text" id="species" name="species" class="form-control" 
               placeholder="Dog, Cat, Cow, Goat, etc." required>
      </div>
      <div class="col-md-6">
        <label for="breed" class="form-label">Breed:</label>
        <input type="text" id="breed" name="breed" class="form-control" placeholder="If known">
      </div>
    </div>
  </div>

  <!-- Clinical Information -->
  <div class="mb-4">
    <h5 class="text-success border-start border-3 ps-2 mb-3">Clinical Information</h5>
    <div class="row g-3">
      <div class="col-md-6">
        <label for="symptom_duration" class="form-label">Duration of Symptoms:</label>
        <select id="symptom_duration" name="symptom_duration" class="form-select">
          <option>Less than 1 day</option>
          <option>1–3 days</option>
          <option>4–7 days</option>
          <option>More than a week</option>
        </select>
      </div>
      <div class="col-md-6">
        <label for="photo" class="form-label">Attach Photo (Optional):</label>
        <input type="file" id="photo" name="photo" class="form-control" accept="image/*">
      </div>
      <div class="col-12">
        <label for="symptoms" class="form-label">Symptoms:</label>
        <textarea id="symptoms" name="symptoms" class="form-control" rows="3" 
                  placeholder="Describe symptoms such as fever, loss of appetite..." required></textarea>
      </div>
      <div class="col-12">
        <label for="previous_treatment" class="form-label">Previous Treatment / Vaccination:</label>
        <textarea id="previous_treatment" name="previous_treatment" class="form-control" rows="2" 
                  placeholder="Mention any prior medication, vaccination, or treatment"></textarea>
      </div>
    </div>
  </div>

  <!-- Appointment Details -->
  <div class="mb-4">
    <h5 class="text-success border-start border-3 ps-2 mb-3">Appointment Details</h5>
    <div class="row g-3">
      <div class="col-md-6">
        <label for="appointment_date" class="form-label">Preferred Appointment Date:</label>
        <input type="date" id="appointment_date" name="appointment_date" class="form-control" required min="<?= date('Y-m-d'); ?>">
      </div>

      <div class="col-12">
        <label for="remarks" class="form-label">Additional Remarks:</label>
        <textarea id="remarks" name="remarks" class="form-control" rows="2" 
                  placeholder="Any additional details or concerns..."></textarea>
      </div>
    </div>
  </div>

  <!-- Hidden / Auto Fields -->
  <input type="hidden" name="fee" value="200.00">
  <input type="hidden" name="payment_status" value="pending">
  <input type="hidden" name="approval_status" value="pending">

  <!-- Submit Button -->
  <div class="text-center">
    <button type="submit" class="btn btn-primary btn-lg px-5">
      <i class="bi bi-send-fill"></i> Submit Appointment
    </button>
  </div>
</form>

<div class="container my-5">
 
</div>

</body>
</html>