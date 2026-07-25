<?php
// Start output buffering to prevent header issues
ob_start();

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Database connection
$con = mysqli_connect("localhost", "root", "", "galore2026");

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize variables
$success_message = "";
$error_message = "";
$form_submitted = false;

// Check if form is submitted
if (isset($_POST['change_password_btn'])) {
    $form_submitted = true;
    
    $current_password = trim($_POST['current_password']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);
    
    // Get user details from session
    $user_email = $_SESSION['email'];
    $user_role = $_SESSION['role'];
    
    // Determine which table to use based on user role
    if ($user_role == 'Participant') {
        $table = "registration";
    } else {
        $table = "ad_register";
    }
    
    // Fetch current user data
    $query = "SELECT * FROM $table WHERE email = '$user_email' LIMIT 1";
    $result = mysqli_query($con, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $db_password = $user['password'];
        
        // Verify current password
        $isValid = false;
        
        // Check if password is hashed (length > 20) or plain text
        if (strlen($db_password) > 20) {
            // Hashed password
            $isValid = password_verify($current_password, $db_password);
        } else {
            // Plain text password
            $isValid = ($current_password === $db_password);
        }
        
        if (!$isValid) {
            $error_message = "Current password is incorrect!";
        } elseif ($new_password !== $confirm_password) {
            $error_message = "New password and confirm password do not match!";
        } elseif (strlen($new_password) < 6) {
            $error_message = "Password must be at least 6 characters long!";
        } else {
            // Hash the new password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            
            // Update password in database
            $update_query = "UPDATE $table SET password = '$hashed_password' WHERE email = '$user_email'";
            
            if (mysqli_query($con, $update_query)) {
                $affected_rows = mysqli_affected_rows($con);
                
                if ($affected_rows > 0) {
                    $success_message = "✓ Password changed successfully! Your password has been updated.";
                    
                    // Clear the form fields after successful submission
                    $_POST = array();
                    
                    // Optional: Add JavaScript to redirect after 3 seconds
                    echo '<script>setTimeout(function(){ window.location.href = "profile.php"; }, 3000);</script>';
                } else {
                    $error_message = "No changes were made. Please try again.";
                }
            } else {
                $error_message = "Error updating password: " . mysqli_error($con);
            }
        }
    } else {
        $error_message = "User not found in database!";
    }
}

// Don't close connection here
// mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Change Password | RKU Galore</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

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

    /* ===== HERO ===== */
    .hero {
      background: linear-gradient(135deg, #dc3545, #7a1c25);
      color: #fff;
      text-align: center;
      padding: 160px 20px 100px;
      position: relative;
      overflow: hidden;
    }

    .hero::after {
      content: "";
      position: absolute;
      bottom: -60px;
      left: 0;
      width: 100%;
      height: 120px;
      background: #fff;
      border-radius: 50% 50% 0 0;
    }

    .hero h1 {
      font-size: 3.5rem;
      font-weight: 900;
      letter-spacing: 2px;
      margin-bottom: 12px;
    }

    .hero p {
      font-size: 1.2rem;
      opacity: 0.95;
    }

    /* ===== CHANGE PASSWORD CARD ===== */
    .galore-password-wrapper {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 60px 20px 80px;
    }

    .galore-password-card {
      background: #ffffff;
      width: 100%;
      max-width: 900px;
      padding: 40px;
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

    .galore-password-title {
      text-align: center;
      color: var(--galore-red);
      font-size: 2rem;
      margin-bottom: 8px;
    }

    .galore-password-subtitle {
      text-align: center;
      font-size: 0.9rem;
      font-weight: 500;
      color: var(--galore-gray);
      margin-bottom: 25px;
    }

    .galore-rules-box {
      background: #fff5f5;
      border-left: 5px solid var(--galore-red);
      padding: 15px;
      border-radius: 10px;
      margin-bottom: 25px;
    }

    .galore-rules-box p {
      margin: 0;
      font-size: 0.85rem;
      line-height: 1.5;
      color: #b02a37;
    }

    .alert-success {
      background-color: #d4edda;
      border-color: #c3e6cb;
      color: #155724;
      border-radius: 10px;
      margin-bottom: 20px;
      padding: 12px 15px;
      animation: slideDown 0.5s ease;
    }

    .alert-danger {
      background-color: #f8d7da;
      border-color: #f5c6cb;
      color: #721c24;
      border-radius: 10px;
      margin-bottom: 20px;
      padding: 12px 15px;
      animation: slideDown 0.5s ease;
    }

    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .galore-input-group {
      margin-bottom: 18px;
    }

    .galore-password-label {
      font-size: 0.75rem;
      font-weight: 700;
      color: var(--galore-gray);
      margin-bottom: 6px;
      text-transform: uppercase;
    }

    .galore-password-input {
      width: 100%;
      padding: 13px 15px;
      border: 2px solid #ddd;
      border-radius: 10px;
      font-size: 0.95rem;
      transition: all 0.3s ease;
    }

    .galore-password-input:focus {
      outline: none;
      border-color: var(--galore-red);
      box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.15);
    }

    .galore-password-btn {
      width: 100%;
      background: linear-gradient(135deg, #ff4d5a, var(--galore-red));
      color: #fff;
      padding: 14px;
      border: none;
      border-radius: 12px;
      font-size: 1rem;
      font-weight: bold;
      cursor: pointer;
      margin-top: 10px;
      transition: all 0.3s ease;
    }

    .galore-password-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 30px rgba(220, 53, 69, 0.45);
    }

    .galore-password-btn:disabled {
      opacity: 0.6;
      cursor: not-allowed;
      transform: none;
    }

    .galore-password-footer {
      text-align: center;
      margin-top: 22px;
      font-size: 0.85rem;
      color: var(--galore-gray);
    }

    .galore-password-footer a {
      color: var(--galore-red);
      text-decoration: none;
      font-weight: 700;
    }

    .galore-password-footer a:hover {
      text-decoration: underline;
    }

    .toggle-password-icon {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: var(--galore-gray);
      z-index: 10;
    }

    .toggle-password-icon:hover {
      color: var(--galore-red);
    }

    .password-requirements {
      margin-top: 10px;
      font-size: 0.75rem;
      color: var(--galore-gray);
    }

    .position-relative {
      position: relative;
    }
  </style>
</head>

<body>

  <?php include 'navbar.php'; ?>

  <!-- ===== HERO ===== -->
  <section class="hero">
    <h1 class="display-1 display-md-2 display-sm-3">Change Password</h1>
    <p class="lead lead-sm">Secure your account with a strong password</p>
  </section>

  <!-- ===== CHANGE PASSWORD FORM ===== -->
  <div class="galore-password-wrapper">
    <div class="galore-password-card">

      <h2 class="galore-password-title h2 h3-sm">🔐 Change Password</h2>
      <div class="galore-password-subtitle">Welcome, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</div>

      <?php if (!empty($success_message)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="fas fa-check-circle me-2"></i> 
          <?php echo htmlspecialchars($success_message); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <i class="fas fa-exclamation-circle me-2"></i> 
          <?php echo htmlspecialchars($error_message); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <div class="galore-rules-box">
        <p class="mb-0">
          <strong>Note:</strong> Password must be at least 6 characters long.
        </p>
      </div>

      <form action="" method="POST" id="changePasswordForm">

        <div class="galore-input-group">
          <label class="galore-password-label">Current Password *</label>
          <div class="position-relative">
            <input type="password"
              name="current_password"
              id="current_password"
              class="galore-password-input"
              placeholder="Enter your current password"
              required>
            <span class="toggle-password-icon" onclick="togglePassword('current_password')">
              <i class="fas fa-eye"></i>
            </span>
          </div>
        </div>

        <div class="galore-input-group">
          <label class="galore-password-label">New Password *</label>
          <div class="position-relative">
            <input type="password"
              name="new_password"
              id="new_password"
              class="galore-password-input"
              placeholder="Enter new password"
              required>
            <span class="toggle-password-icon" onclick="togglePassword('new_password')">
              <i class="fas fa-eye"></i>
            </span>
          </div>
        </div>

        <div class="galore-input-group">
          <label class="galore-password-label">Confirm New Password *</label>
          <div class="position-relative">
            <input type="password"
              name="confirm_password"
              id="confirm_password"
              class="galore-password-input"
              placeholder="Confirm new password"
              required>
            <span class="toggle-password-icon" onclick="togglePassword('confirm_password')">
              <i class="fas fa-eye"></i>
            </span>
          </div>
          <div class="password-requirements" id="passwordMatchMessage"></div>
        </div>

        <button type="submit" name="change_password_btn" id="submitBtn" class="galore-password-btn">
          <i class="fas fa-key me-2"></i> Change Password
        </button>

      </form>

      <div class="galore-password-footer">
        <a href="profile.php">Back to Profile</a> |
        <a href="logout.php">Logout</a>
      </div>

    </div>
  </div>

  <?php include 'footer.php'; ?>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Font Awesome -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>



</body>

</html>