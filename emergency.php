<DOCTYPE HTML
<html lang="en">
<head> 
    <title>Emergency Help</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>  
<?php include('header.php'); ?>

    <main class="container my-5">
        <h1 class="text-center text-danger mb-4">
            <i class="bi bi-exclamation-triangle-fill"></i> Emergency Veterinary Help
        </h1>
        <p class="lead text-center">
            In case of a pet emergency, please contact our 24/7 emergency hotline immediately:
        </p>
        <div class="text-center my-4">
            <h2 class="display-4 text-primary">+1-800-EMERGENCY</h2>
            <p class="text-muted">Available 24/7 for urgent veterinary assistance</p>
        </div>
        <section class="emergency-tips bg-light p-4 rounded shadow">
            <h3 class="text-success mb-3">Emergency Care Tips</h3>
            <ul>
                <li>Stay calm and assess the situation.</li>
                <li>Keep your pet comfortable and still.</li>
                <li>Contact your nearest emergency veterinary clinic.</li>
                <li>Have your pet's medical records ready if possible.</li>
            </ul>
        </section>
                        <!--Emergency Section-->
    <section id="emergency" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-danger text-center mb-4">
            <i class="bi bi-ambulance"></i> Emergency Portal
            </h2>
            <p class="text-center text-muted mb-5">
                For urgent medical attention, please fill out this form — our on-duty vets will prioritize your case.
            </p>
            <form action="submit_appointment.php" method="POST" class="p-4 border rounded shadow bg-white">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Owner Name</label>
                    <input type="text" name="owner_name" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Contact Number</label>
                    <input type="tel" name="contact" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Animal Type</label>
                    <input type="text" name="species" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Location / Address</label>
                    <input type="text" name="address" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label for="care" class="form-label text-danger fw-semibold">
                            Type of Emergency Assistance Needed:
                    </label> 
                    <select id="care" name="care" class="form-select border-danger" required> 
                        <option value="">Select Response Type</option>
                        <option value="Field Response (Vet Dispatch)">🚑 Field Response (Vet visits immediately)</option>
                        <option value="Emergency Transport (Bring to Hospital)">🏥 Emergency Transport (Bring to hospital)</option>
                        <option value="Critical Advisory Only (Immediate Call Back)">📞 Critical Advisory (Immediate call back)</option>
                    </select>
                <div class="form-text text-muted">
                        Select the most suitable response based on the animal’s condition.
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label">Describe the Emergency</label>
                    <textarea name="symptoms" class="form-control" rows="3" required></textarea>
                </div>
            </div>

            <input type="hidden" name="appointment_type" value="Emergency Case">
            <input type="hidden" name="approval_status" value="urgent">
            <input type="hidden" name="payment_status" value="pending">

              <div class="text-center mt-4">
                    <button type="submit" class="btn btn-danger btn-lg px-5">
                    <i class="bi bi-send-fill"></i> Submit Emergency
                    </button>
                </div>
            </form>
        </div>
    </section>
    </main>