<?php
// ad_edit_profile.php
// Edit Profile Page for Admin - RKU Galore 2026
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | RKU Galore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        :root {
            --galore-red: #dc3545;
            --galore-red-dark: #b02a37;
            --galore-gray: #6c757d;
            --galore-light-red: #fff5f5;
            --galore-dark: #212529;
            --sidebar-width: 250px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: #f8f9fa;
            margin: 0;
            min-height: 100vh;
            display: flex;
            overflow: hidden;
        }

        /* Sidebar styling */
        .sidebar {
            width: var(--sidebar-width);
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            background: var(--galore-dark);
            color: white;
            z-index: 1000;
        }

        /* Main content area */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        /* Profile card container */
        .profile-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            min-height: 100%;
            padding: 20px;
            background: transparent;
        }

        /* Profile card - MADE SMALLER */
        .profile-card {
            max-width: 700px; /* Reduced from 900px */
            width: 100%;
            background: #fff;
            border-radius: 20px; /* Slightly smaller radius */
            box-shadow: 0 20px 40px rgba(220, 53, 69, 0.15); /* Smaller shadow */
            padding: 30px 35px; /* Reduced padding */
            border-top: 6px solid var(--galore-red); /* Thinner border */
            animation: fadeSlide 0.6s ease;
            margin: 0 auto;
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

        /* Profile header - MADE SMALLER */
        .profile-header {
            display: flex;
            align-items: center;
            gap: 20px; /* Reduced gap */
            margin-bottom: 20px; /* Reduced margin */
            padding-bottom: 15px; /* Reduced padding */
            border-bottom: 2px solid #ffe0e0;
        }

        .profile-avatar {
            position: relative;
        }

        .profile-avatar img {
            width: 90px; /* Reduced from 110px */
            height: 90px; /* Reduced from 110px */
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--galore-red); /* Thinner border */
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.2); /* Smaller shadow */
            background: #f0f0f0;
        }

        .avatar-upload {
            position: absolute;
            bottom: 5px;
            right: 5px;
            background: var(--galore-red);
            width: 28px; /* Reduced from 32px */
            height: 28px; /* Reduced from 32px */
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
            border: 2px solid white;
            transition: all 0.3s ease;
        }

        .avatar-upload:hover {
            background: var(--galore-red-dark);
            transform: scale(1.1);
        }

        .avatar-upload i {
            font-size: 0.8rem; /* Smaller icon */
        }

        #file-input {
            display: none;
        }

        .profile-title h2 {
            color: var(--galore-dark);
            font-size: 1.6rem; /* Reduced from 1.9rem */
            font-weight: 700;
            margin-bottom: 5px; /* Reduced margin */
        }

        .profile-title p {
            color: var(--galore-red);
            font-size: 0.85rem; /* Reduced from 0.95rem */
            font-weight: 600;
            background: rgba(220, 53, 69, 0.1);
            padding: 4px 14px; /* Reduced padding */
            border-radius: 30px; /* Smaller radius */
            display: inline-block;
            margin-bottom: 0;
        }

        .profile-title i {
            margin-right: 6px; /* Smaller margin */
        }

        /* Admin badge - MADE SMALLER */
        .admin-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px; /* Reduced gap */
            background: var(--galore-dark);
            color: white;
            padding: 4px 12px; /* Reduced padding */
            border-radius: 30px; /* Smaller radius */
            font-size: 0.7rem; /* Smaller font */
            font-weight: 600;
            margin-bottom: 15px; /* Reduced margin */
        }

        .admin-badge i {
            color: #ff8a92;
            font-size: 0.8rem; /* Smaller icon */
        }

        /* Form styling */
        form {
            width: 100%;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px; /* Reduced gap from 20px */
        }

        .form-group {
            width: 100%;
        }

        .form-group.full-width {
            grid-column: span 2;
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: 6px; /* Reduced gap */
            color: var(--galore-gray);
            font-weight: 600;
            font-size: 0.7rem; /* Smaller font */
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px; /* Reduced margin */
        }

        .form-label i {
            color: var(--galore-red);
            font-size: 0.8rem; /* Smaller icon */
            width: 14px; /* Smaller width */
        }

        .input-wrapper {
            background: #fff5f5;
            border-left: 3px solid var(--galore-red); /* Thinner border */
            border-radius: 10px; /* Smaller radius */
            padding: 2px 12px; /* Reduced padding */
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }

        .input-wrapper:hover {
            background: #ffe0e0;
            box-shadow: 0 3px 10px rgba(220, 53, 69, 0.1); /* Smaller shadow */
        }

        .input-wrapper i {
            color: var(--galore-red);
            margin-right: 8px; /* Reduced margin */
            font-size: 0.9rem; /* Smaller icon */
            opacity: 0.8;
        }

        .form-control-galore {
            width: 100%;
            border: none;
            background: transparent;
            font-weight: 500;
            color: #333;
            font-size: 0.9rem; /* Smaller font */
            padding: 8px 0; /* Reduced padding */
            transition: all 0.3s ease;
        }

        .form-control-galore:focus {
            outline: none;
            color: var(--galore-red);
        }

        .form-control-galore::placeholder {
            color: #aaa;
            font-weight: 400;
            font-size: 0.85rem; /* Smaller placeholder */
        }

        select.form-control-galore {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%23dc3545' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0 center;
            padding-right: 22px; /* Reduced padding */
        }

        /* Validation Styles */
        .error-message {
            font-size: 0.7rem; /* Smaller font */
            margin-top: 0.2rem;
            display: block;
            color: #dc3545 !important;
            animation: fadeIn 0.3s ease-in;
            min-height: 18px; /* Smaller height */
        }

        .is-valid {
            border-color: #198754 !important;
        }

        .is-invalid {
            border-color: #dc3545 !important;
        }

        .is-valid:focus {
            border-color: #198754 !important;
            box-shadow: 0 0 0 3px rgba(25, 135, 84, 0.15) !important; /* Smaller shadow */
            outline: none;
        }

        .is-invalid:focus {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.15) !important; /* Smaller shadow */
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

        /* Password field note */
        .password-note {
            font-size: 0.65rem; /* Smaller font */
            color: var(--galore-gray);
            margin-top: 4px; /* Reduced margin */
            font-style: italic;
        }

        /* Success message styling */
        .success-message {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 8px; /* Smaller radius */
            padding: 12px 18px; /* Reduced padding */
            margin-bottom: 15px; /* Reduced margin */
            display: flex;
            align-items: center;
            gap: 8px; /* Reduced gap */
            animation: slideDown 0.3s ease;
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            font-size: 0.9rem; /* Smaller font */
        }

        .success-message i {
            font-size: 1.1rem; /* Smaller icon */
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Action buttons - MADE SMALLER */
        .profile-actions {
            display: flex;
            gap: 12px; /* Reduced gap */
            margin-top: 25px; /* Reduced margin */
            justify-content: center;
        }

        .galore-btn {
            padding: 10px 28px; /* Reduced padding */
            background: linear-gradient(135deg, #ff4d5a, var(--galore-red));
            color: #fff;
            border-radius: 40px; /* Smaller radius */
            font-weight: 600;
            font-size: 0.9rem; /* Smaller font */
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px; /* Reduced gap */
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            letter-spacing: 0.5px;
            flex: 1;
        }

        .galore-btn i {
            font-size: 0.9rem; /* Smaller icon */
        }

        .galore-btn:hover {
            transform: translateY(-2px); /* Smaller hover effect */
            box-shadow: 0 8px 18px rgba(220, 53, 69, 0.25); /* Smaller shadow */
        }

        .btn-outline-red {
            background: transparent;
            color: var(--galore-red);
            border: 2px solid var(--galore-red);
        }

        .btn-outline-red:hover {
            background: var(--galore-red);
            color: white;
        }

        /* For very short screens */
        @media (max-height: 700px) {
            .profile-card {
                padding: 20px 25px; /* Further reduced */
            }
            
            .profile-header {
                margin-bottom: 15px;
                padding-bottom: 10px;
            }
            
            .profile-avatar img {
                width: 75px;
                height: 75px;
            }
            
            .profile-title h2 {
                font-size: 1.4rem;
            }
            
            .form-grid {
                gap: 10px;
            }
            
            .profile-actions {
                margin-top: 20px;
            }
            
            .galore-btn {
                padding: 8px 20px;
            }
        }
    </style>
</head>

<body>
        <?php require 'admin_header.php'; ?>

    <!-- Main Content Area with responsive Bootstrap classes -->
    <div class="main-content w-100 w-lg-auto" style="margin-left: 0; margin-left-lg: var(--sidebar-width);">
        <div class="profile-container">
            <div class="profile-card col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5" data-aos="fade-up" style="max-width: 700px;">

                <!-- Admin Badge -->
                <div class="admin-badge">
                    <i class="fas fa-shield-alt"></i> ADMIN • EDIT PROFILE
                </div>

                <!-- Success Message Container -->
                <div id="successMessage" class="success-message" style="display: none;">
                    <i class="fas fa-check-circle"></i>
                    <span id="successMessageText">Profile updated successfully! Redirecting...</span>
                </div>

                <form id="editForm" method="post" enctype="multipart/form-data">
                    <!-- Profile Header with Avatar Upload - responsive flex column on mobile -->
                    <div class="profile-header flex-column flex-sm-row text-center text-sm-start">
                        <div class="profile-avatar">
                            <img src="website/admin-avatar.jpg" alt="Admin Photo" id="preview">
                            <label for="file-input" class="avatar-upload">
                                <i class="fas fa-camera"></i>
                            </label>
                            <input type="file" id="file-input" name="profile_pic" accept="image/*" onchange="previewImage(this)">
                        </div>
                        <div class="profile-title">
                            <h2 id="displayName">Dr. Rajesh Kumar</h2>
                            <p><i class="fas fa-id-card"></i> Admin ID: ADM2024001</p>
                        </div>
                    </div>

                    <!-- Form Grid - 2 Columns on desktop, 1 column on mobile using Bootstrap grid -->
                    <div class="row g-3">
                        <!-- Full Name -->
                        <div class="col-12 col-md-6">
                            <div class="form-label">
                                <i class="fas fa-user"></i> Full Name
                            </div>
                            <div class="input-wrapper">
                                <i class="fas fa-user-circle"></i>
                                <input type="text" id="name" name="name" class="form-control-galore" value="Dr. Rajesh Kumar" placeholder="Enter full name" data-validation="required min alphabetic" data-min="3" data-max="100">
                            </div>
                            <span id="name_error" class="error-message"></span>
                        </div>

                        <!-- Email Address -->
                        <div class="col-12 col-md-6">
                            <div class="form-label">
                                <i class="fas fa-envelope"></i> Email Address
                            </div>
                            <div class="input-wrapper">
                                <i class="fas fa-envelope"></i>
                                <input type="email" id="email" name="email" class="form-control-galore" value="rajesh.kumar@rkugalore.edu.in" placeholder="Enter email" data-validation="required email" data-max="100">
                            </div>
                            <span id="email_error" class="error-message"></span>
                        </div>

                        <!-- Phone Number -->
                        <div class="col-12 col-md-6">
                            <div class="form-label">
                                <i class="fas fa-phone-alt"></i> Phone Number
                            </div>
                            <div class="input-wrapper">
                                <i class="fas fa-phone"></i>
                                <input type="tel" id="phone" name="phone" class="form-control-galore" value="+91 98765 43210" placeholder="Enter phone number" data-validation="required min number" data-min="10" data-max="15">
                            </div>
                            <span id="phone_error" class="error-message"></span>
                        </div>

                        <!-- Gender -->
                        <div class="col-12 col-md-6">
                            <div class="form-label">
                                <i class="fas fa-venus-mars"></i> Gender
                            </div>
                            <div class="input-wrapper">
                                <i class="fas fa-user-tie"></i>
                                <select id="gender" name="gender" class="form-control-galore" data-validation="required select">
                                    <option value="">Select Gender</option>
                                    <option value="Male" selected>Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <span id="gender_error" class="error-message"></span>
                        </div>

                        <!-- New Password -->
                        <div class="col-12 col-md-6">
                            <div class="form-label">
                                <i class="fas fa-lock"></i> New Password
                            </div>
                            <div class="input-wrapper">
                                <i class="fas fa-key"></i>
                                <input type="password" id="password" name="password" class="form-control-galore" placeholder="Enter new password" data-validation="min strongPassword" data-min="6">
                            </div>
                            <span id="password_error" class="error-message"></span>
                            <div class="password-note">
                                <i class="fas fa-info-circle"></i> Leave blank to keep current password
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-12 col-md-6">
                            <div class="form-label">
                                <i class="fas fa-check-circle"></i> Confirm Password
                            </div>
                            <div class="input-wrapper">
                                <i class="fas fa-check"></i>
                                <input type="password" id="confirm_password" name="confirm_password" class="form-control-galore" placeholder="Confirm new password" data-validation="confirmPassword">
                            </div>
                            <span id="confirm_password_error" class="error-message"></span>
                        </div>
                    </div>

                    <!-- Action Buttons - stack on mobile -->
                    <div class="profile-actions flex-column flex-sm-row">
                        <button type="submit" id="submitBtn" class="galore-btn w-100 w-sm-auto">
                            <i class="fas fa-save"></i> Update Profile
                        </button>
                        <a href="ad_profile.php" class="galore-btn btn-outline-red w-100 w-sm-auto">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Image Preview Script -->
    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <!-- Validation and Save Script -->
    <script>
        $(document).ready(function() {
            // Load saved data from localStorage if available
            loadProfileData();
            
            // Phone number validation to allow + and numbers
            $("#phone").on("input", function() {
                var value = $(this).val();
                // Allow + only at the beginning, then numbers
                if (value.length > 0 && value[0] === '+') {
                    $(this).val('+' + value.substr(1).replace(/[^0-9]/g, ''));
                } else {
                    $(this).val(value.replace(/[^0-9]/g, ''));
                }
            });
            
            // Update display name in real-time
            $("#name").on("input", function() {
                $("#displayName").text($(this).val());
            });

            // VALIDATION SCRIPT
            function validateInput(input) {
                var field = $(input);
                var value = field.val() ? field.val().trim() : "";
                var errorfield = $("#" + field.attr("name") + "_error");
                var validationType = field.data("validation");
                var minLength = field.data("min") || 0;
                var maxLength = field.data("max") || 9999;
                let errorMessage = "";

                if (validationType) {
                    if (validationType.includes("required")) {
                        if (value === "" || value === "0" || value === null) {
                            errorMessage = "This field is required.";
                        }
                    }

                    if (value !== "" && !errorMessage) {
                        if (validationType.includes("min") && value.length < minLength) {
                            errorMessage = `This field must be at least ${minLength} characters long.`;
                        }

                        if (validationType.includes("max") && value.length > maxLength) {
                            errorMessage = `This field must be at most ${maxLength} characters long.`;
                        }

                        // Add alphabetic validation
                        if (validationType.includes("alphabetic")) {
                            var alphabet_regex = /^[a-zA-Z\s]+$/;
                            if (!alphabet_regex.test(value)) {
                                errorMessage = "Please enter alphabetic characters only.";
                            }
                        }

                        // Email format validation
                        if (validationType.includes("email")) {
                            const emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w]{2,4}$/;
                            if (!emailRegex.test(value)) {
                                errorMessage = "Please enter a valid email address.";
                            }
                        }

                        // Numeric value validation for phone
                        if (validationType.includes("number")) {
                            var number_regex = /^[0-9+\-\s]+$/;
                            if (!number_regex.test(value)) {
                                errorMessage = "Please enter a valid phone number.";
                            }
                        }

                        // Strong password validation
                        if (validationType.includes("strongPassword") && value.length > 0) {
                            const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/;
                            if (!passwordRegex.test(value)) {
                                errorMessage = "Password must be at least 6 characters and contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
                            }
                        }

                        // Password confirmation validation
                        if (validationType.includes("confirmPassword") && value.length > 0) {
                            const password = $("#password").val();
                            if (value !== password) {
                                errorMessage = "Passwords do not match.";
                            }
                        }

                        // Dropdown selection validation
                        if (validationType.includes("select") && (value === "" || value === "0" || value === null)) {
                            errorMessage = "Please select an option.";
                        }
                    }

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

            $("input, textarea, select").on("input change", function() {
                validateInput(this);
            });

            // Form submission with validation
            $("#editForm").on("submit", function(e) {
                e.preventDefault();
                let isValid = true;
                let firstInvalidField = null;

                $(this).find("input, textarea, select").each(function() {
                    if (!validateInput(this)) {
                        isValid = false;
                        if (!firstInvalidField) {
                            firstInvalidField = this;
                        }
                    }
                });

                if (!isValid) {
                    if (firstInvalidField) {
                        $(firstInvalidField).focus();
                    }
                    return false;
                }

                // Save form data to localStorage
                saveProfileData();
                
                // Show success message
                showSuccessMessage();
                
                // Redirect after 2 seconds
                setTimeout(function() {
                    window.location.href = 'ad_profile.php';
                }, 2000);
                
                return false; // Prevent default form submission
            });
        });
        
        // Function to save profile data to localStorage
        function saveProfileData() {
            var profileData = {
                name: $('#name').val(),
                email: $('#email').val(),
                phone: $('#phone').val(),
                gender: $('#gender').val(),
                image: $('#preview').attr('src')
            };
            
            localStorage.setItem('adminProfile', JSON.stringify(profileData));
            console.log('Profile data saved to localStorage');
        }
        
        // Function to load profile data from localStorage
        function loadProfileData() {
            var savedData = localStorage.getItem('adminProfile');
            if (savedData) {
                try {
                    var profileData = JSON.parse(savedData);
                    
                    // Populate form fields
                    $('#name').val(profileData.name || 'Dr. Rajesh Kumar');
                    $('#email').val(profileData.email || 'rajesh.kumar@rkugalore.edu.in');
                    $('#phone').val(profileData.phone || '+91 98765 43210');
                    $('#gender').val(profileData.gender || 'Male');
                    
                    // Update display name
                    $('#displayName').text(profileData.name || 'Dr. Rajesh Kumar');
                    
                    // Update image if available and not a default
                    if (profileData.image && profileData.image !== 'website/admin-avatar.jpg') {
                        $('#preview').attr('src', profileData.image);
                    }
                    
                    console.log('Profile data loaded from localStorage');
                } catch (e) {
                    console.error('Error loading profile data:', e);
                }
            }
        }
        
        // Function to show success message
        function showSuccessMessage() {
            $('#successMessage').fadeIn(300);
            
            // Auto hide after 2 seconds
            setTimeout(function() {
                $('#successMessage').fadeOut(300);
            }, 1800);
        }
    </script>

    <!-- AOS Library -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true
        });
    </script>

</body>

</html>