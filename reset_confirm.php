<?php
include 'reset_confirm_handler.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | RKU Galore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --galore-red: #dc3545; --galore-gray: #6c757d; }
        body { font-family: 'Segoe UI', Roboto, sans-serif; margin: 0; min-height: 100vh; }
        .hero { background: linear-gradient(135deg, #dc3545, #7a1c25); color: #fff; text-align: center; padding: 160px 20px 100px; position: relative; overflow: hidden; }
        .hero::after { content: ""; position: absolute; bottom: -60px; left: 0; width: 100%; height: 120px; background: #fff; border-radius: 50% 50% 0 0; }
        .hero h1 { font-size: 3.5rem; font-weight: 900; letter-spacing: 2px; margin-bottom: 12px; }
        .hero p { font-size: 1.2rem; opacity: 0.95; }
        .galore-reset-wrapper { display: flex; justify-content: center; align-items: center; padding: 60px 20px 80px; }
        .galore-reset-card { background: #ffffff; width: 100%; max-width: 900px; padding: 40px; border-radius: 18px; border-top: 6px solid var(--galore-red); box-shadow: 0 20px 45px rgba(220, 53, 69, 0.18); animation: fadeSlide 0.8s ease forwards; }
        @keyframes fadeSlide { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }
        .galore-reset-title { text-align: center; color: var(--galore-red); font-size: 2rem; margin-bottom: 8px; }
        .galore-reset-subtitle { text-align: center; font-size: 0.9rem; font-weight: 500; color: var(--galore-gray); margin-bottom: 25px; }
        .galore-rules-box { background: #fff5f5; border-left: 5px solid var(--galore-red); padding: 15px; border-radius: 10px; margin-bottom: 25px; }
        .alert-success { background-color: #d4edda; border-color: #c3e6cb; color: #155724; border-radius: 10px; margin-bottom: 20px; padding: 12px 15px; }
        .alert-danger { background-color: #f8d7da; border-color: #f5c6cb; color: #721c24; border-radius: 10px; margin-bottom: 20px; padding: 12px 15px; }
        .galore-input-group { margin-bottom: 18px; }
        .galore-reset-label { font-size: 0.75rem; font-weight: 700; color: var(--galore-gray); margin-bottom: 6px; text-transform: uppercase; display: block; }
        .galore-reset-input { width: 100%; padding: 13px 15px; border: 2px solid #ddd; border-radius: 10px; font-size: 0.95rem; }
        .galore-reset-input:focus { outline: none; border-color: var(--galore-red); box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.15); }
        .galore-reset-input.is-invalid { border-color: #dc3545; }
        .galore-reset-input.is-valid { border-color: #28a745; }
        .error-text { color: #dc3545; font-size: 0.75rem; margin-top: 5px; display: none; }
        .error-text.show { display: block; }
        .galore-reset-btn { width: 100%; background: linear-gradient(135deg, #ff4d5a, var(--galore-red)); color: #fff; padding: 14px; border: none; border-radius: 12px; font-size: 1rem; font-weight: bold; cursor: pointer; margin-top: 10px; transition: all 0.3s ease; }
        .galore-reset-btn:hover:not(:disabled) { transform: translateY(-3px); box-shadow: 0 12px 30px rgba(220, 53, 69, 0.45); }
        .galore-reset-btn:disabled { opacity: 0.6; cursor: not-allowed; }
        .galore-reset-footer { text-align: center; margin-top: 22px; font-size: 0.85rem; color: var(--galore-gray); }
        .galore-reset-footer a { color: var(--galore-red); text-decoration: none; font-weight: 700; }
        .toggle-password-icon { position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #6c757d; z-index: 10; }
        .position-relative { position: relative; }
        .redirect-timer { text-align: center; margin-top: 15px; font-size: 0.85rem; color: var(--galore-gray); }
        @media (max-width: 768px) { .hero h1 { font-size: 2.2rem; } .galore-reset-card { padding: 25px; } }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <section class="hero">
        <h1>Reset Password</h1>
        <p>Create a new password for your account</p>
    </section>
    
    <div class="galore-reset-wrapper">
        <div class="galore-reset-card">
            <h2 class="galore-reset-title">🔐 Create New Password</h2>
            <div class="galore-reset-subtitle">
                <?php if ($token_valid && !empty($user_name)): ?>
                    Welcome, <?php echo htmlspecialchars($user_name); ?>!
                <?php else: ?>
                    Reset your account password
                <?php endif; ?>
            </div>
            
            <?php if (!empty($success_message)): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i> <?php echo htmlspecialchars($success_message); ?>
                </div>
                <div class="redirect-timer">
                    <i class="fas fa-clock me-1"></i> Redirecting to <a href="login.php">Login Page</a> in <span id="countdown">3</span> seconds...
                </div>
                <script>
                    let seconds = 3;
                    const timer = setInterval(function() {
                        seconds--;
                        document.getElementById('countdown').textContent = seconds;
                        if (seconds <= 0) {
                            clearInterval(timer);
                            window.location.href = 'login.php';
                        }
                    }, 1000);
                </script>
            <?php endif; ?>
            
            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i> <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>
            
            <?php if ($token_valid && empty($success_message)): ?>
                <div class="galore-rules-box">
                    <p><strong>Note:</strong> Password must be at least 6 characters long.</p>
                </div>
                
                <form method="POST" id="resetPasswordForm">
                    <!-- Hidden fields -->
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                    <input type="hidden" name="user_table" value="<?php echo $user_table; ?>">
                    
                    <div class="galore-input-group">
                        <label class="galore-reset-label">New Password *</label>
                        <div class="position-relative">
                            <input type="password" name="new_password" id="new_password" class="galore-reset-input" placeholder="Enter new password" required>
                            <span class="toggle-password-icon" onclick="togglePassword('new_password')"><i class="fas fa-eye"></i></span>
                        </div>
                        <div id="new_password_error" class="error-text"></div>
                    </div>
                    
                    <div class="galore-input-group">
                        <label class="galore-reset-label">Confirm New Password *</label>
                        <div class="position-relative">
                            <input type="password" name="confirm_password" id="confirm_password" class="galore-reset-input" placeholder="Confirm new password" required>
                            <span class="toggle-password-icon" onclick="togglePassword('confirm_password')"><i class="fas fa-eye"></i></span>
                        </div>
                        <div id="confirm_password_error" class="error-text"></div>
                        <div id="passwordMatchMessage"></div>
                    </div>
                    
                    <button type="submit" name="reset_password" id="resetBtn" class="galore-reset-btn">Reset Password</button>
                </form>
            <?php endif; ?>
            
            <div class="galore-reset-footer">
                <a href="login.php">Back to Login</a> | <a href="forgot_password.php">Resend Reset Link</a>
            </div>
        </div>
    </div>
    
    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function togglePassword(fieldId) {
            var field = document.getElementById(fieldId);
            var icon = field.nextElementSibling.querySelector('i');
            if (field.type === "password") {
                field.type = "text";
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = "password";
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
        
        $(document).ready(function() {
            // Password validation
            $('#new_password, #confirm_password').on('keyup', function() {
                var newPassword = $('#new_password').val();
                var confirmPassword = $('#confirm_password').val();
                
                if (newPassword.length > 0 && newPassword.length < 6) {
                    $('#new_password_error').text('Password must be at least 6 characters').addClass('show');
                    $('#new_password').addClass('is-invalid');
                } else {
                    $('#new_password_error').removeClass('show');
                    $('#new_password').removeClass('is-invalid');
                }
                
                if (confirmPassword.length > 0 && newPassword !== confirmPassword) {
                    $('#confirm_password_error').text('Passwords do not match').addClass('show');
                    $('#confirm_password').addClass('is-invalid');
                    $('#resetBtn').prop('disabled', true);
                } else if (confirmPassword.length > 0 && newPassword === confirmPassword) {
                    $('#confirm_password_error').removeClass('show');
                    $('#confirm_password').removeClass('is-invalid');
                    $('#resetBtn').prop('disabled', false);
                } else {
                    $('#confirm_password_error').removeClass('show');
                    $('#resetBtn').prop('disabled', false);
                }
            });
        });
    </script>
</body>
</html>

<?php mysqli_close($con); ?>