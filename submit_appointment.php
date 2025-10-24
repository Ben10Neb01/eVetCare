<?php
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  session_start();
  $user_id = $_SESSION['user_id'] ?? null;


    // 🧾 Collect form data
    $owner_name         = $_POST['owner_name'];
    $contact            = $_POST['contact'];
    $address            = $_POST['address'];
    $pet_name           = $_POST['pet_name'];
    $species            = $_POST['species'];
    $breed              = $_POST['breed'];
    $age                = $_POST['age'];
    $sex                = $_POST['sex'];
    $symptom_duration   = $_POST['symptom_duration'];
    $symptoms           = $_POST['symptoms'];
    $previous_treatment = $_POST['previous_treatment'];
    $appointment_date   = $_POST['appointment_date'];
    $remarks            = $_POST['remarks'];
    $email              = ""; // optional field for later use

    // 🐾 Optional file upload handling
    $photo = "";
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
        $photo = $target_file;
    }

    // 🧩 SQL Insert (make sure database table includes these new columns)
   $sql = "INSERT INTO appointments 
(user_id, owner_name, contact, email, address, pet_name, species, breed, age, sex, symptom_duration, symptoms, previous_treatment, appointment_date, remarks, photo)
VALUES 
('$user_id', '$owner_name', '$contact', '$email', '$address', '$pet_name', '$species', '$breed', '$age', '$sex', '$symptom_duration', '$symptoms', '$previous_treatment','$appointment_date', '$remarks', '$photo')";


    echo "<div class='message-box'>";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='success'>";
        echo "<h3>✅ Appointment submitted successfully!</h3>";
        echo "<p>Your Appointment ID: <strong>" . $conn->insert_id . "</strong></p>";
        echo "<div class='btn-links'>";
        echo "<a href='appointment_form.php' class='btn'>Book Another</a>";
        echo "<a href='index.php' class='btn'>Home</a>";
        echo "</div>";
        echo "</div>";
    } else {
        echo "<div class='error'>";
        echo "❌ Error: " . $conn->error;
        echo "</div>";
    }

    echo "</div>";

    $conn->close();
} else {
    echo "<div class='warning'>⚠️ Please submit the form first.</div>";
}
?>
<html>
  <head><style>
    /* General message container */
.message-box {
  max-width: 600px;
  margin: 100px auto;
  padding: 40px;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  text-align: center;
  background-color: #fff;
  font-family: "Segoe UI", sans-serif;
}

/* Success message */
.success {
  color: #155724;
  background-color: #d4edda;
  border: 1px solid #c3e6cb;
  padding: 20px;
  border-radius: 8px;
}

/* Error message */
.error {
  color: #721c24;
  background-color: #f8d7da;
  border: 1px solid #f5c6cb;
  padding: 20px;
  border-radius: 8px;
}

/* Warning message */
.warning {
  color: #856404;
  background-color: #fff3cd;
  border: 1px solid #ffeeba;
  padding: 20px;
  border-radius: 8px;
}

/* Button section */
.btn-links {
  margin-top: 25px;
}

/* Buttons */
.btn-links .btn {
  display: inline-block;
  margin: 5px 10px;
  padding: 10px 20px;
  text-decoration: none;
  background-color: #0d6efd;
  color: white;
  border-radius: 6px;
  font-weight: 500;
  transition: 0.3s ease;
}

.btn-links .btn:hover {
  background-color: #0b5ed7;
  transform: translateY(-2px);
}
  </style></head>
</html>