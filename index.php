<html>
    <head>
        <title>Animal Care</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
<body>
<?php include('header.php'); ?>
<main>

  <!-- 🩺 Hero Section -->
  <section class="hero-section text-center text-white py-5" 
           style="background: url('images/vet-banner.jpg') center/cover no-repeat;">
    <div class="container py-5">
      <h1 class="fw-bold">Welcome to eVetCare</h1>
      <p>Your Trusted Platform for Veterinary Appointments & Emergency Care</p>
      <div class="mt-4">
        <a href="appointment_form.php" class="btn btn-success btn-lg me-3">
          <i class="bi bi-calendar2-check"></i> Book Appointment
        </a>
        <a href="emergency.php" class="btn btn-danger btn-lg">
          <i class="bi bi-exclamation-triangle-fill"></i> Emergency Help
        </a>
      </div>
    </div>
  </section>

  <!-- 🐾 Mission Section -->
  <section class="py-5 bg-light">
    <div class="container text-center">
      <h2 class="text-primary fw-bold mb-3">Our Mission</h2>
      <p class="lead text-muted mx-auto" style="max-width: 800px;">
        At <strong>eVetCare</strong>, we are dedicated to providing the best care for your beloved animals. 
        Our team of certified government veterinarians ensures that every pet and livestock receives timely, 
        compassionate, and expert medical attention whenever needed.
      </p>
    </div>
  </section>

</main>

    <footer>
    <?php include('footer.php'); ?>
    </footer>