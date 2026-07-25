<?php
// Include the registration handler 
include 'registration_handler.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration | RKU Galore</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

  <!-- Add jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <style>
    :root {
      --galore-red: #dc3545;
      --galore-red-dark: #b02a37;
      --galore-bg: #f8f9fa;
      --galore-dark: #212529;
      --galore-gray: #6c757d;
      --galore-white: #ffffff;
    }

    body {
      font-family: 'Segoe UI', Roboto, sans-serif;
      margin: 0;
      min-height: 100vh;
    }


    .galore-login-wrapper {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 60px 20px 80px;
    }

    .galore-login-card {
      background: #ffffff;
      width: 100%;
      max-width: 900px;
      padding: 45px;
      border-radius: 18px;
      border-top: 6px solid var(--galore-red);
      box-shadow: 0 20px 45px rgba(220, 53, 69, 0.18);
      animation: fadeSlide 0.8s ease forwards;
    }

    @keyframes fadeSlide {
      from {
        opacity: 0;
        transform: translateY(40px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .galore-login-title {
      text-align: center;
      color: var(--galore-red);
      font-size: 2.2rem;
      margin-bottom: 10px;
    }

    .galore-login-deadline {
      text-align: center;
      font-size: 0.9rem;
      font-weight: 600;
      color: var(--galore-red);
      background: rgba(220, 53, 69, 0.1);
      padding: 6px 16px;
      border-radius: 20px;
      display: inline-block;
      margin: 0 auto 35px;
    }

    .alert {
      border-radius: 10px;
      margin-bottom: 20px;
      padding: 15px 20px;
    }

    .alert-success {
      background-color: #d4edda;
      border-color: #c3e6cb;
      color: #155724;
    }

    .alert-danger {
      background-color: #f8d7da;
      border-color: #f5c6cb;
      color: #721c24;
    }

    form {
      display: grid;
      grid-template-columns: 1fr;
      gap: 18px;
    }

    .galore-input-group {
      display: flex;
      flex-direction: column;
    }

    .galore-login-label {
      font-size: 0.75rem;
      font-weight: 700;
      color: var(--galore-gray);
      margin-bottom: 6px;
      text-transform: uppercase;
    }

    .galore-login-input {
      padding: 13px 15px;
      border: 2px solid #ddd;
      border-radius: 10px;
      font-size: 0.95rem;
      transition: all 0.3s ease;
    }

    .galore-login-input:focus {
      outline: none;
      border-color: var(--galore-red);
      box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.15);
    }

    .galore-login-input.is-valid {
      border-color: #28a745;
    }

    .galore-login-input.is-invalid {
      border-color: var(--galore-red);
    }

    .galore-email-note {
      font-size: 0.75rem;
      color: var(--galore-gray);
      margin-top: 6px;
      font-style: italic;
    }

    .galore-login-btn {
      background: linear-gradient(135deg, #ff4d5a, var(--galore-red));
      color: #fff;
      padding: 15px;
      border: none;
      border-radius: 12px;
      font-size: 1.05rem;
      font-weight: bold;
      cursor: pointer;
      margin-top: 10px;
      transition: all 0.3s ease;
    }

    .galore-login-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 30px rgba(220, 53, 69, 0.45);
    }

    .galore-login-footer {
      text-align: center;
      margin-top: 25px;
      font-size: 0.85rem;
      color: var(--galore-red);
      font-weight: 600;
      padding-top: 18px;
      border-top: 1px solid rgba(220, 53, 69, 0.25);
    }

    .phone-input-container {
      position: relative;
      display: flex;
      align-items: center;
    }

    .country-code {
      position: absolute;
      left: 15px;
      color: var(--galore-gray);
      font-weight: 600;
      font-size: 0.95rem;
      pointer-events: none;
    }

    .phone-input {
      padding-left: 70px !important;
    }
  </style>
</head>

<body>

  <?php include 'navbar.php'; ?>

  <!-- ===== HERO ===== -->
  <section class="hero">
    <h1 class="display-1 display-md-2 display-sm-3">Galore 2026 Registration</h1>
    <p class="lead lead-sm">Register now to participate in exciting Galore events</p>
  </section>

  <!-- ===== REGISTRATION FORM ===== -->
  <div class="galore-login-wrapper">
    <div class="galore-login-card">

      <h2 class="galore-login-title h2 h3-sm">🎉 Student Registration</h2>
      <div class="galore-login-deadline">Last Date: 12 January 2026</div>

      <!-- Success/Error Messages -->
      <?php if (!empty($success_message)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="fas fa-check-circle me-2"></i> <?php echo $success_message; ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="fas fa-exclamation-circle me-2"></i> <?php echo $error_message; ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <!-- ONLY CHANGE: Form action changed from login.php to registration.php -->
      <form id="registrationForm" action="registration.php" method="POST" enctype="multipart/form-data">
        <div class="container-fluid p-0">
          <div class="row g-3">
            <div class="col-12 col-md-6">
              <div class="galore-input-group">
                <label class="galore-login-label">Enrollment No *</label>
                <input type="text" name="enrollment_no"
                  class="galore-login-input"
                  placeholder="Enter your enrollment number"
                  value="<?php echo isset($_POST['enrollment_no']) ? htmlspecialchars($_POST['enrollment_no']) : ''; ?>"
                  required>
              </div>
            </div>

            <div class="col-12 col-md-6">
              <div class="galore-input-group">
                <label class="galore-login-label">First Name *</label>
                <input type="text" name="firstName"
                  class="galore-login-input"
                  placeholder="Enter your first name"
                  value="<?php echo isset($_POST['firstName']) ? htmlspecialchars($_POST['firstName']) : ''; ?>"
                  required>
              </div>
            </div>

            <div class="col-12 col-md-6">
              <div class="galore-input-group">
                <label class="galore-login-label">Last Name</label>
                <input type="text" name="lastName"
                  class="galore-login-input"
                  placeholder="Enter your last name (optional)"
                  value="<?php echo isset($_POST['lastName']) ? htmlspecialchars($_POST['lastName']) : ''; ?>">
              </div>
            </div>

            <div class="col-12 col-md-6">
              <div class="galore-input-group">
                <label class="galore-login-label">Branch *</label>
                <input type="text" name="branch"
                  class="galore-login-input"
                  placeholder="e.g. Computer Engineering"
                  value="<?php echo isset($_POST['branch']) ? htmlspecialchars($_POST['branch']) : ''; ?>"
                  required>
              </div>
            </div>

            <div class="col-12 col-md-6">
              <div class="galore-input-group">
                <label class="galore-login-label">Semester *</label>
                <select name="semester" class="galore-login-input" required>
                  <option value="">Select Semester</option>
                  <?php for ($i = 1; $i <= 8; $i++): ?>
                    <option value="<?php echo $i; ?>" <?php echo (isset($_POST['semester']) && $_POST['semester'] == $i) ? 'selected' : ''; ?>>
                      Semester <?php echo $i; ?>
                    </option>
                  <?php endfor; ?>
                </select>
              </div>
            </div>

            <div class="col-12 col-md-6">
              <div class="galore-input-group">
                <label class="galore-login-label">Gender *</label>
                <select name="gender" class="galore-login-input" required>
                  <option value="">Select Gender</option>
                  <option value="Male" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                  <option value="Female" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                  <option value="Other" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                </select>
              </div>
            </div>

            <div class="col-12 col-md-6">
              <div class="galore-input-group">
                <label class="galore-login-label">School *</label>
                <input type="text" name="school"
                  class="galore-login-input"
                  placeholder="e.g. SOE, SOM"
                  value="<?php echo isset($_POST['school']) ? htmlspecialchars($_POST['school']) : ''; ?>"
                  required>
              </div>
            </div>

            <div class="col-12 col-md-6">
              <div class="galore-input-group">
                <label class="galore-login-label">Phone Number *</label>
                <div class="phone-input-container">
                  <span class="country-code">+91</span>
                  <input type="tel" name="phone"
                    class="galore-login-input phone-input"
                    placeholder="9876543210"
                    maxlength="10"
                    pattern="[0-9]{10}"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>"
                    required>
                </div>
                <p class="galore-email-note">Enter 10-digit mobile number (India).</p>
              </div>
            </div>

            <div class="col-12 col-md-6">
              <div class="galore-input-group">
                <label class="galore-login-label">RKU Email *</label>
                <input type="email" name="email"
                  class="galore-login-input"
                  placeholder="yourname@rku.ac.in"
                  value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                  required>
                <p class="galore-email-note">All updates will be sent to this email.</p>
              </div>
            </div>

            <div class="col-12 col-md-6">
              <div class="galore-input-group">
                <label class="galore-login-label">Password *</label>
                <input type="password" name="password"
                  class="galore-login-input"
                  placeholder="Enter password"
                  minlength="6"
                  required>
                <p class="galore-email-note">Minimum 6 characters</p>
              </div>
            </div>

            <div class="col-12 col-md-6">
              <div class="galore-input-group">
                <label class="galore-login-label">Confirm Password *</label>
                <input type="password" name="confirm_password"
                  class="galore-login-input"
                  placeholder="Confirm password"
                  minlength="6"
                  required>
              </div>
            </div>

            <div class="col-12 col-md-6">
              <div class="galore-input-group">
                <label class="galore-login-label">Role *</label>
                <select name="role" class="galore-login-input" required>
                  <option value="">Select Role</option>
                  <option value="Participant" <?php echo (isset($_POST['role']) && $_POST['role'] == 'Participant') ? 'selected' : ''; ?>>Participant</option>
                  <option value="Coordinator" <?php echo (isset($_POST['role']) && $_POST['role'] == 'Coordinator') ? 'selected' : ''; ?>>Coordinator</option>
                  <option value="Judge" <?php echo (isset($_POST['role']) && $_POST['role'] == 'Co-codinator') ? 'selected' : ''; ?>>Co-codinator</option>
                  <option value="Admin" <?php echo (isset($_POST['role']) && $_POST['role'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                </select>
                <p class="galore-email-note">Select your role in Galore 2026.</p>
              </div>
            </div>

            <div class="col-12 col-md-6">
              <div class="galore-input-group">
                <label class="galore-login-label">Profile Picture</label>
                <input type="file" name="profile_pic"
                  class="galore-login-input"
                  accept="image/*">
                <p class="galore-email-note">Upload a clear profile photo. Max size: 2MB (JPG, PNG, GIF only).</p>
              </div>
            </div>

            <div class="col-12">
              <button type="submit" name="reg_btn" class="galore-login-btn w-100">
                <i class="fas fa-user-plus me-2"></i>Complete Registration
              </button>
            </div>
          </div>
        </div>
      </form>

      <div class="galore-login-footer">
        * Required fields - Registration is mandatory for participation in Galore events.
      </div>

    </div>
  </div>

  <?php include 'footer.php'; ?>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>