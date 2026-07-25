<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Confirm Password | RKU Galore</title>
  
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

    /* ===== HERO SECTION ===== */
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

    /* ===== CONFIRM CARD ===== */
    .galore-confirm-wrapper {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 60px 20px 80px;
    }

    .galore-confirm-card {
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

    .galore-confirm-title {
      text-align: center;
      color: var(--galore-red);
      font-size: 2rem;
      margin-bottom: 8px;
    }

    .galore-confirm-deadline {
      text-align: center;
      font-size: 0.85rem;
      font-weight: 600;
      color: var(--galore-red);
      background: rgba(220, 53, 69, 0.1);
      padding: 6px 14px;
      border-radius: 20px;
      display: inline-block;
      margin: 0 auto 25px;
      width: fit-content;
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

    .galore-rules-box i {
      color: var(--galore-red);
      margin-right: 8px;
    }

    .galore-input-group {
      margin-bottom: 18px;
      position: relative;
    }

    .galore-confirm-label {
      font-size: 0.75rem;
      font-weight: 700;
      color: var(--galore-gray);
      margin-bottom: 6px;
      text-transform: uppercase;
      display: block;
    }

    .galore-confirm-input {
      width: 100%;
      padding: 13px 15px;
      border: 2px solid #ddd;
      border-radius: 10px;
      font-size: 0.95rem;
      transition: all 0.3s ease;
      box-sizing: border-box;
    }

    .galore-confirm-input:focus {
      outline: none;
      border-color: var(--galore-red);
      box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.15);
    }

    /* Validation Styles */
    .galore-confirm-input.is-valid {
      border-color: #28a745;
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
      background-repeat: no-repeat;
      background-position: right calc(0.375em + 0.1875rem) center;
      background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    .galore-confirm-input.is-invalid {
      border-color: var(--galore-red);
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
      background-repeat: no-repeat;
      background-position: right calc(0.375em + 0.1875rem) center;
      background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    .error-message {
      color: #dc3545;
      font-size: 0.75rem;
      margin-top: 5px;
      display: none;
      font-weight: 500;
    }

    .error-message i {
      margin-right: 4px;
    }

    .password-strength {
      margin-top: 8px;
      font-size: 0.8rem;
    }

    .strength-bar {
      height: 4px;
      background: #e0e0e0;
      border-radius: 2px;
      margin: 5px 0;
      overflow: hidden;
    }

    .strength-fill {
      height: 100%;
      width: 0;
      transition: width 0.3s ease;
    }

    .strength-text {
      color: var(--galore-gray);
      font-size: 0.75rem;
    }

    .strength-weak .strength-fill {
      background: #dc3545;
      width: 33.33%;
    }

    .strength-weak .strength-text {
      color: #dc3545;
    }

    .strength-medium .strength-fill {
      background: #ffc107;
      width: 66.66%;
    }

    .strength-medium .strength-text {
      color: #ffc107;
    }

    .strength-strong .strength-fill {
      background: #28a745;
      width: 100%;
    }

    .strength-strong .strength-text {
      color: #28a745;
    }

    .match-indicator {
      font-size: 0.8rem;
      margin-top: 5px;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    .match-indicator i {
      font-size: 0.9rem;
    }

    .match-success {
      color: #28a745;
    }

    .match-error {
      color: #dc3545;
    }

    .galore-confirm-btn {
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

    .galore-confirm-btn:hover:not(:disabled) {
      transform: translateY(-3px);
      box-shadow: 0 12px 30px rgba(220, 53, 69, 0.45);
    }

    .galore-confirm-btn:disabled {
      opacity: 0.6;
      cursor: not-allowed;
      transform: none;
      box-shadow: none;
    }

    .galore-confirm-footer {
      text-align: center;
      margin-top: 22px;
      font-size: 0.85rem;
      color: var(--galore-gray);
    }

    .galore-confirm-footer a {
      color: var(--galore-red);
      text-decoration: none;
      font-weight: 700;
    }

    .galore-confirm-footer a:hover {
      text-decoration: underline;
    }

    .info-box {
      background: #e7f3ff;
      border-left: 5px solid #17a2b8;
      padding: 15px;
      border-radius: 10px;
      margin-bottom: 25px;
    }

    .info-box p {
      margin: 0;
      font-size: 0.85rem;
      line-height: 1.5;
      color: #0c5460;
    }

    .info-box i {
      color: #17a2b8;
      margin-right: 8px;
    }

    /* Password requirements checklist */
    .password-checklist {
      background: #f8f9fa;
      border-radius: 8px;
      padding: 12px 15px;
      margin-top: 10px;
      font-size: 0.8rem;
      border: 1px solid #e9ecef;
    }

    .checklist-item {
      margin-bottom: 6px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .checklist-item i {
      width: 16px;
      font-size: 0.8rem;
    }

    .checklist-item .fa-check-circle {
      color: #28a745;
    }

    .checklist-item .fa-times-circle {
      color: #dc3545;
    }

    .checklist-item .fa-circle {
      color: #6c757d;
      font-size: 0.5rem;
      vertical-align: middle;
    }
  </style>
</head>

<body>

  <?php include 'navbar.php'; ?>

  <!-- ===== HERO ===== -->
  <section class="hero">
    <h1 class="display-1 display-md-2 display-sm-3"><i class="fas fa-lock me-3"></i> Confirm Password</h1>
    <p class="lead lead-sm">Set a strong password for your Galore account</p>
  </section>

  <!-- ===== CONFIRM PASSWORD FORM ===== -->
  <div class="galore-confirm-wrapper">
    <div class="galore-confirm-card">

      <h2 class="galore-confirm-title h2 h3-sm">🔐 Set New Password</h2>
      <div class="galore-confirm-deadline">Complete by: 12 January 2026</div>

      <div class="info-box">
        <p class="mb-0">
          <i class="fas fa-shield-alt"></i>
          <strong>Password Requirements:</strong> Minimum 8 characters with at least
          one uppercase letter, one lowercase letter, one number, and one special character.
        </p>
      </div>

      <form action="update_password.php" method="POST" id="confirmForm">

        <div class="galore-input-group">
          <label class="galore-confirm-label">New Password *</label>
          <input type="password" 
                 name="new_password" 
                 id="newPassword"
                 class="galore-confirm-input"
                 placeholder="Enter new password"
                 data-validation="required min strongPassword"
                 data-min="8"
                 data-max="50">
          <div class="password-strength" id="strengthIndicator">
            <div class="strength-bar">
              <div class="strength-fill"></div>
            </div>
            <span class="strength-text" id="strengthText">Enter password</span>
          </div>
          <div class="error-message" id="new_password_error"></div>
          
          <!-- Password Requirements Checklist -->
          <div class="password-checklist" id="passwordChecklist">
            <div class="checklist-item" id="checkLength">
              <i class="fas fa-circle"></i> At least 8 characters
            </div>
            <div class="checklist-item" id="checkLower">
              <i class="fas fa-circle"></i> One lowercase letter
            </div>
            <div class="checklist-item" id="checkUpper">
              <i class="fas fa-circle"></i> One uppercase letter
            </div>
            <div class="checklist-item" id="checkNumber">
              <i class="fas fa-circle"></i> One number
            </div>
            <div class="checklist-item" id="checkSpecial">
              <i class="fas fa-circle"></i> One special character (!@#$%^&*)
            </div>
          </div>
        </div>

        <div class="galore-input-group">
          <label class="galore-confirm-label">Confirm Password *</label>
          <input type="password" 
                 name="confirm_password" 
                 id="confirmPassword"
                 class="galore-confirm-input"
                 placeholder="Re-enter new password"
                 data-validation="required confirmPassword"
                 data-confirm="new_password">
          <div class="match-indicator" id="matchIndicator">
            <i class="fas fa-circle"></i>
            <span id="matchText">Waiting for confirmation</span>
          </div>
          <div class="error-message" id="confirm_password_error"></div>
        </div>

        <div class="galore-rules-box">
          <p class="mb-0">
            <i class="fas fa-info-circle"></i>
            <strong>Note:</strong> After password reset, you'll be redirected to login
            with your new password. Keep your password confidential.
          </p>
        </div>

        <button type="submit" class="galore-confirm-btn" id="submitBtn">
          <i class="fas fa-check-circle me-2"></i> Update Password
        </button>

      </form>

      <div class="galore-confirm-footer">
        <a href="forgot_password.php"><i class="fas fa-arrow-left me-1"></i> Back to Forgot Password</a><br>
        Remember your password? <a href="login.php">Login Here</a>
      </div>

    </div>
  </div>

  <?php include 'footer.php'; ?>

  <!-- Add jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Add spinner animation style -->
  <style>
    .fa-spin {
      animation: fa-spin 2s infinite linear;
    }
    @keyframes fa-spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(359deg); }
    }
  </style>

</body>

</html>