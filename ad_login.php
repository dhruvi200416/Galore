<?php
// ad_login.php
// Admin Login Page for RKU Galore 2026
session_start();

// If already logged in as admin, redirect to dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: admin_dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | RKU Galore</title>

    <!-- Bootstrap -->
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            min-height: 100vh;
            background: var(--galore-bg);
            display: flex;
            flex-direction: column;
        }

        /* ===== HERO (SAME AS STUDENT LOGIN) ===== */
        .hero {
            background: linear-gradient(135deg, #dc3545, #7a1c25);
            color: #fff;
            text-align: center;
            padding: 100px 20px 80px;
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
            font-size: 3.2rem;
            font-weight: 900;
            letter-spacing: 2px;
            margin-bottom: 12px;
        }

        .hero p {
            font-size: 1.2rem;
            opacity: 0.95;
        }

        /* ===== ADMIN BADGE ===== */
        .admin-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.15);
            color: white;
            padding: 8px 20px;
            border-radius: 40px;
            font-size: 0.9rem;
            font-weight: 700;
            letter-spacing: 2px;
            margin-top: 15px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(5px);
        }

        .admin-badge i {
            margin-right: 8px;
        }

        /* ===== LOGIN WRAPPER - CENTERED ===== */
        .galore-login-wrapper {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
            min-height: calc(100vh - 300px);
        }

        /* ===== LOGIN CARD ===== */
        .galore-login-card {
            background: #ffffff;
            width: 100%;
            max-width: 550px;
            margin: 0 auto;
            padding: 45px 45px;
            border-radius: 24px;
            border-top: 6px solid var(--galore-red);
            box-shadow: 0 25px 50px rgba(220, 53, 69, 0.15);
            animation: fadeSlide 0.8s ease forwards;
            position: relative;
            overflow: hidden;
        }

        .galore-login-card::before {
            content: "ADMIN";
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 2.8rem;
            font-weight: 900;
            color: rgba(220, 53, 69, 0.03);
            letter-spacing: 8px;
            z-index: 0;
            pointer-events: none;
        }

        @keyframes fadeSlide {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .galore-login-title {
            text-align: center;
            color: var(--galore-red);
            font-size: 2rem;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .galore-login-title i {
            background: var(--galore-red);
            color: white;
            padding: 12px;
            border-radius: 50%;
            font-size: 1.2rem;
        }

        .galore-login-deadline {
            text-align: center;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--galore-red);
            background: rgba(220, 53, 69, 0.1);
            padding: 8px 20px;
            border-radius: 30px;
            display: inline-block;
            margin: 0 auto 25px;
            letter-spacing: 1px;
            width: fit-content;
            display: table;
        }

        .galore-rules-box {
            background: #fff5f5;
            border-left: 5px solid var(--galore-red);
            padding: 16px 18px;
            border-radius: 12px;
            margin-bottom: 30px;
        }

        .galore-rules-box p {
            margin: 0;
            font-size: 0.85rem;
            line-height: 1.6;
            color: #b02a37;
        }

        .galore-rules-box i {
            margin-right: 8px;
            color: var(--galore-red);
        }

        .galore-input-group {
            margin-bottom: 22px;
            position: relative;
            z-index: 2;
        }

        .galore-login-label {
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--galore-gray);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .galore-login-label i {
            color: var(--galore-red);
            font-size: 0.85rem;
        }

        .galore-login-input {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #e6e6e6;
            border-radius: 14px;
            font-size: 0.95rem;
            transition: all 0.25s ease;
            background: #fafafa;
        }

        .galore-login-input:focus {
            outline: none;
            border-color: var(--galore-red);
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.08);
            background: white;
        }

        .galore-login-input::placeholder {
            color: #b0b0b0;
            font-weight: 300;
            font-size: 0.9rem;
        }

        /* Validation Styles - Added from the reference code */
        .error-message {
            font-size: 0.8rem;
            margin-top: 0.25rem;
            display: block;
            color: #dc3545 !important;
            animation: fadeIn 0.3s ease-in;
            min-height: 20px;
        }

        .is-valid {
            border-color: #198754 !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
            padding-right: calc(1.5em + 0.75rem);
        }

        .is-invalid {
            border-color: #dc3545 !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
            padding-right: calc(1.5em + 0.75rem);
        }

        .is-valid:focus {
            border-color: #198754 !important;
            box-shadow: 0 0 0 4px rgba(25, 135, 84, 0.15) !important;
            outline: none;
        }

        .is-invalid:focus {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.15) !important;
            outline: none;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .galore-login-btn {
            width: 100%;
            background: linear-gradient(135deg, #ff4d5a, var(--galore-red));
            color: #fff;
            padding: 15px;
            border: none;
            border-radius: 14px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            transition: all 0.3s ease;
            letter-spacing: 1px;
            position: relative;
            z-index: 2;
        }

        .galore-login-btn i {
            font-size: 1rem;
        }

        .galore-login-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(220, 53, 69, 0.4);
        }

        .admin-security-box {
            background: #f8f9fa;
            border: 1px dashed var(--galore-red);
            padding: 14px 18px;
            border-radius: 12px;
            margin: 25px 0 5px;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .admin-security-box i {
            color: var(--galore-red);
            font-size: 1.3rem;
        }

        .admin-security-box span {
            font-size: 0.8rem;
            color: var(--galore-dark);
            line-height: 1.5;
        }

        .admin-security-box strong {
            color: var(--galore-red);
        }

        .galore-login-footer {
            text-align: center;
            margin-top: 25px;
            font-size: 0.85rem;
            color: var(--galore-gray);
            padding-top: 15px;
            border-top: 1px solid #f0f0f0;
            position: relative;
            z-index: 2;
        }

        .galore-login-footer a {
            color: var(--galore-red);
            text-decoration: none;
            font-weight: 700;
            margin: 0 5px;
        }

        .galore-login-footer a:hover {
            text-decoration: underline;
        }
    </style>

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <!-- ===== ADMIN LOGIN FORM - PERFECTLY CENTERED ===== -->
    <div class="galore-login-wrapper">
        <div class="galore-login-card w-100" style="max-width: 550px;">

            <h2 class="galore-login-title">
                <i class="fas fa-user-shield"></i> Admin Portal
            </h2>
            <div class="galore-login-deadline">
                <i class="fas fa-calendar-alt"></i> Galore 2026 • Event Control
            </div>

            <div class="galore-rules-box">
                <p>
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Administrator Access Only:</strong> This portal is for
                    event coordinators, faculty advisors, and authorized RKU staff.
                </p>
            </div>

            <form id="loginForm" method="POST" action="admin_dashboard.php">

                <div class="galore-input-group">
                    <label class="galore-login-label">
                        <i class="fas fa-envelope"></i> Admin Email
                    </label>
                    <input type="email" name="admin_email" id="admin_email"
                        class="galore-login-input w-100"
                        placeholder="admin@rkugalore.edu.in"
                        data-validation="required email"
                        autofocus>
                    <span id="admin_email_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-login-label">
                        <i class="fas fa-key"></i> Password
                    </label>
                    <input type="password" name="admin_password" id="admin_password"
                        class="galore-login-input w-100"
                        placeholder="Enter 6-digit numeric password"
                        data-validation="required min numeric"
                        data-min="6"
                        maxlength="6">
                    <span id="admin_password_error" class="error-message"></span>
                </div>

                <button type="submit" class="galore-login-btn w-100" id="loginBtn">
                    <i class="fas fa-sign-in-alt"></i> Access Dashboard
                </button>

                <div class="admin-security-box d-flex align-items-center gap-3">
                    <i class="fas fa-fingerprint"></i>
                    <span>
                        <strong>Secure Login:</strong> 256-bit encryption.
                        All activities are logged.
                    </span>
                </div>

            </form>

        </div>
    </div>

    <!-- jQuery for validation -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $(document).ready(function() {
            // Validation function - exactly matching the reference code structure
            function validateInput(input) {
                var field = $(input);
                var value = field.val() ? field.val().trim() : "";
                var errorfield = $("#" + field.attr("name") + "_error");
                var validationType = field.data("validation");
                var minLength = field.data("min") || 0;
                let errorMessage = "";

                if (validationType) {
                    // Required validation
                    if (validationType.includes("required")) {
                        if (value === "" || value === "0" || value === null) {
                            errorMessage = "This field is required.";
                        }
                    }

                    // Only check other validations if field is not empty and no error yet
                    if (value !== "" && !errorMessage) {
                        // Minimum length validation
                        if (validationType.includes("min") && value.length < minLength) {
                            errorMessage = `This field must be at least ${minLength} characters long.`;
                        }

                        // Email validation
                        if (validationType.includes("email")) {
                            const emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w]{2,4}$/;
                            if (!emailRegex.test(value)) {
                                errorMessage = "Please enter a valid email address.";
                            }
                        }
                        // Add this to your validation function
                        if (validationType.includes("numeric")) {
                            let numeric_regex = /^[0-9]+$/;
                            if (!numeric_regex.test(value)) {
                                errorMessage = "Please enter numbers only.";
                            }
                        }
                    }

                    // Show/hide error message and apply classes
                    if (errorMessage) {
                        errorfield.text(errorMessage);
                        field.addClass("is-invalid").removeClass("is-valid");
                        return false;
                    } else {
                        errorfield.text("");
                        field.removeClass("is-invalid").addClass("is-valid");
                        return true;
                    }
                }
                return true;
            }

            // Attach validation to input events - exactly like reference code
            $("input").on("input change", function() {
                validateInput(this);
            });

            // Form submission with validation - exactly like reference code
            $("#loginForm").on("submit", function(e) {
                e.preventDefault();
                let isValid = true;
                let firstInvalidField = null;

                // Validate all inputs
                $(this).find("input").each(function() {
                    if (!validateInput(this)) {
                        isValid = false;
                        if (!firstInvalidField) {
                            firstInvalidField = this;
                        }
                    }
                });

                // If validation fails, focus first invalid field
                if (!isValid) {
                    if (firstInvalidField) {
                        $(firstInvalidField).focus();
                    }
                    return false;
                }

                // If validation passes, submit the form
                // For demo purposes, you can uncomment the line below to see it working
                // alert("Validation passed! Form would submit now.");

                // Actually submit the form
                this.submit();
            });

            // Optional: Add real-time validation for password as user types
            $("#admin_password").on("keyup", function() {
                validateInput(this);
            });
        });
    </script>

</body>

</html>