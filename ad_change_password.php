<?php
// Include the admin header which contains the navbar
include 'admin_header.php';
// Include the handler file which contains the password change logic
include 'ad_profile_handler.php';

// Get logged-in user data from session
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['full_name'];
$user_role = $_SESSION['role'];
$user_email = $_SESSION['email'];

// Use the existing database connection from handler file
// $con is already defined in ad_profile_handler.php

// Fetch current user's password from database
$fetch_password_query = "SELECT password FROM ad_register WHERE id = '$user_id'";
$password_result = mysqli_query($con, $fetch_password_query);
$current_hashed_password = null;
if ($password_result && mysqli_num_rows($password_result) > 0) {
    $row = mysqli_fetch_assoc($password_result);
    $current_hashed_password = $row['password'];
}

// Display success/error messages using SweetAlert2
if (isset($_SESSION['profile_success'])) {
    echo '<script>
        Swal.fire({
            title: "Success!",
            text: "' . $_SESSION['profile_success'] . '",
            icon: "success",
            confirmButtonColor: "#dc3545",
            timer: 3000
        });
    </script>';
    unset($_SESSION['profile_success']);
}

if (isset($_SESSION['profile_error'])) {
    echo '<script>
        Swal.fire({
            title: "Error!",
            text: "' . $_SESSION['profile_error'] . '",
            icon: "error",
            confirmButtonColor: "#dc3545"
        });
    </script>';
    unset($_SESSION['profile_error']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password | Admin Panel</title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- jQuery Validation Plugin -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        /* Your existing CSS styles remain exactly the same */
        .main-content-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
            background: linear-gradient(120deg, #fdfbfb, #ebedee);
        }
        
        @media (max-width: 991.98px) {
            .main-content-wrapper {
                margin-left: 0 !important;
                padding: 20px 15px;
            }
        }
        
        .password-form-container {
            background: #ffffff;
            width: 100%;
            max-width: 550px;
            padding: 45px;
            border-radius: 24px;
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
            animation: fadeInUp 0.5s ease;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .password-form-container::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 8px;
            background: #dc3545;
        }
        
        .form-header-icon {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .form-header-icon i {
            font-size: 3.5rem;
            background: linear-gradient(135deg, #dc3545, #ff6b6b);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 10px;
        }
        
        .password-form-container h3 {
            color: #dc3545;
            font-weight: 800;
            font-size: 1.8rem;
            margin-bottom: 8px;
            text-align: center;
        }
        
        .form-subtitle {
            text-align: center;
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 35px;
        }
        
        .user-info-card {
            background: #f8f9fa;
            border-radius: 14px;
            padding: 15px 20px;
            margin-bottom: 25px;
            border-left: 4px solid #dc3545;
        }
        
        .user-info-card p {
            margin-bottom: 5px;
            font-size: 0.85rem;
        }
        
        .user-info-card strong {
            color: #dc3545;
        }
        
        .form-group-custom {
            margin-bottom: 25px;
        }
        
        .form-group-custom label {
            font-weight: 700;
            color: #444;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .form-group-custom label i {
            color: #dc3545;
            font-size: 1rem;
        }
        
        .input-wrapper {
            position: relative;
        }
        
        .input-wrapper input {
            width: 100%;
            padding: 14px 18px;
            border: 1.5px solid #f0f0f0;
            border-radius: 14px;
            background-color: #fafafa;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }
        
        .input-wrapper input:focus {
            background-color: #fff;
            border-color: #dc3545;
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.1);
            outline: none;
        }
        
        .input-wrapper input.error {
            border-color: #dc3545;
            background-color: #fff5f5;
        }
        
        label.error {
            color: #dc3545;
            font-size: 0.7rem;
            margin-top: 6px;
            margin-left: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
            font-weight: normal;
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #adb5bd;
            cursor: pointer;
            transition: color 0.3s ease;
            z-index: 10;
        }
        
        .password-toggle:hover {
            color: #dc3545;
        }
        
        .strength-meter {
            margin-top: 12px;
        }
        
        .strength-bar {
            height: 6px;
            background-color: #e9ecef;
            border-radius: 10px;
            overflow: hidden;
        }
        
        .strength-fill {
            height: 100%;
            width: 0%;
            transition: width 0.3s ease, background-color 0.3s ease;
            border-radius: 10px;
        }
        
        .strength-text {
            font-size: 0.7rem;
            margin-top: 6px;
            color: #6c757d;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .btn-update {
            background: linear-gradient(135deg, #dc3545, #ff6b6b);
            color: white;
            border: none;
            width: 100%;
            padding: 16px;
            border-radius: 16px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(220, 53, 69, 0.2);
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .btn-update:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(220, 53, 69, 0.3);
        }
        
        .btn-clear {
            background: #f8f9fa;
            color: #6c757d;
            border: 1.5px solid #e9ecef;
            width: 100%;
            padding: 14px;
            border-radius: 16px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .btn-clear:hover {
            background: #e9ecef;
            border-color: #dee2e6;
        }
        
        @media (max-width: 576px) {
            .password-form-container {
                padding: 30px 20px;
            }
            .password-form-container h3 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="main-content-wrapper">
        <div class="password-form-container">
            <div class="form-header-icon">
                <i class="bi bi-shield-lock"></i>
            </div>
            <h3>Change Password</h3>
            <p class="form-subtitle">Keep your account secure with a strong password</p>
            
            <div class="user-info-card">
                <p><strong><i class="bi bi-person-circle"></i> Name:</strong> <?php echo htmlspecialchars($user_name); ?></p>
                <p><strong><i class="bi bi-envelope"></i> Email:</strong> <?php echo htmlspecialchars($user_email); ?></p>
                <p><strong><i class="bi bi-briefcase"></i> Role:</strong> <?php echo htmlspecialchars($user_role); ?></p>
                <p><strong><i class="bi bi-shield-lock"></i> Password Status:</strong> 
                    <?php if ($current_hashed_password): ?>
                        <span style="color: #28a745;"><i class="bi bi-check-circle-fill"></i> Secured</span>
                    <?php else: ?>
                        <span style="color: #dc3545;"><i class="bi bi-exclamation-triangle-fill"></i> Not Set</span>
                    <?php endif; ?>
                </p>
            </div>
            
            <form id="passwordChangeForm" method="POST" action="ad_profile_handler.php">
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                
                <div class="form-group-custom">
                    <label><i class="bi bi-lock"></i> Current Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="oldPassword" name="old_password" placeholder="Enter your current password" autocomplete="current-password" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('oldPassword', this)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
                
                <div class="form-group-custom">
                    <label><i class="bi bi-key"></i> New Password <span style="font-size: 0.65rem; background: #f0f0f0; padding: 2px 8px; border-radius: 20px;">min. 4 chars</span></label>
                    <div class="input-wrapper">
                        <input type="password" id="newPassword" name="new_password" placeholder="Create a strong password" autocomplete="new-password" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('newPassword', this)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <div class="strength-meter">
                        <div class="strength-bar">
                            <div id="strengthFill" class="strength-fill"></div>
                        </div>
                        <div id="strengthText" class="strength-text">
                            <i class="bi bi-shield-check"></i> Password strength: <span>None</span>
                        </div>
                    </div>
                </div>
                
                <div class="form-group-custom">
                    <label><i class="bi bi-check-circle"></i> Confirm New Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="confirmPassword" name="confirm_new_password" placeholder="Re-type your new password" autocomplete="off" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('confirmPassword', this)">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
                
                <button type="submit" name="update_password" class="btn-update">
                    <i class="bi bi-arrow-repeat"></i> Update Password
                </button>
                <button type="button" id="resetBtn" class="btn-clear">
                    <i class="bi bi-eraser"></i> Clear All
                </button>
            </form>
        </div>
    </div>
    
    <script>
        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            const icon = button.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
        
        function evaluatePasswordStrength(pwd) {
            if (!pwd || pwd.length === 0) {
                return { score: 0, label: 'None', color: '#e9ecef', width: '0%' };
            }
            
            let score = 0;
            if (pwd.length >= 4) score += 1;
            if (pwd.length >= 8) score += 1;
            if (/[A-Z]/.test(pwd)) score += 1;
            if (/[0-9]/.test(pwd)) score += 1;
            if (/[^A-Za-z0-9]/.test(pwd)) score += 1;
            
            let finalScore = Math.min(score, 4);
            
            let label = '', color = '', widthPercent = 0;
            if (finalScore === 0) { label = 'Very weak'; color = '#dc3545'; widthPercent = 20; }
            else if (finalScore === 1) { label = 'Weak'; color = '#fd7e14'; widthPercent = 35; }
            else if (finalScore === 2) { label = 'Fair'; color = '#ffc107'; widthPercent = 55; }
            else if (finalScore === 3) { label = 'Good'; color = '#20c997'; widthPercent = 80; }
            else { label = 'Strong'; color = '#28a745'; widthPercent = 100; }
            
            return { label, color, width: `${widthPercent}%` };
        }
        
        function updateStrengthMeter() {
            const newPwd = document.getElementById('newPassword').value;
            const strength = evaluatePasswordStrength(newPwd);
            const strengthFill = document.getElementById('strengthFill');
            const strengthTextSpan = document.getElementById('strengthText');
            
            strengthFill.style.width = strength.width;
            strengthFill.style.backgroundColor = strength.color;
            strengthTextSpan.innerHTML = `<i class="bi bi-shield-check"></i> Password strength: <span style="color: ${strength.color}; font-weight: 600;">${strength.label}</span>`;
        }
        
        $(document).ready(function() {
            $("#passwordChangeForm").validate({
                rules: {
                    old_password: {
                        required: true
                    },
                    new_password: {
                        required: true,
                        minlength: 4,
                        notEqualTo: "#oldPassword"
                    },
                    confirm_new_password: {
                        required: true,
                        equalTo: "#newPassword"
                    }
                },
                messages: {
                    old_password: {
                        required: "Please enter your current password"
                    },
                    new_password: {
                        required: "Please enter a new password",
                        minlength: "Password must be at least 4 characters",
                        notEqualTo: "New password cannot be the same as current password"
                    },
                    confirm_new_password: {
                        required: "Please confirm your new password",
                        equalTo: "Passwords do not match"
                    }
                },
                errorElement: "label",
                errorPlacement: function(error, element) {
                    error.insertAfter(element.closest('.input-wrapper'));
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
            
            $.validator.addMethod("notEqualTo", function(value, element, param) {
                return value !== $(param).val();
            }, "New password cannot be the same as current password");
            
            $("#newPassword").on('input', function() {
                updateStrengthMeter();
                $("#newPassword").valid();
                $("#confirmPassword").valid();
            });
            
            $("#confirmPassword").on('input', function() {
                $("#confirmPassword").valid();
            });
            
            $("#resetBtn").click(function() {
                $("#passwordChangeForm")[0].reset();
                $("#passwordChangeForm").validate().resetForm();
                updateStrengthMeter();
                const strengthFill = document.getElementById('strengthFill');
                const strengthTextSpan = document.getElementById('strengthText');
                strengthFill.style.width = '0%';
                strengthFill.style.backgroundColor = '#e9ecef';
                strengthTextSpan.innerHTML = `<i class="bi bi-shield-check"></i> Password strength: <span>None</span>`;
            });
            
            updateStrengthMeter();
        });
    </script>
</body>
</html>