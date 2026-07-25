<?php

include 'session.php';

// Get user data from database
$email = $_SESSION['email'];
$query = "SELECT * FROM registration WHERE email = '$email'";
$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) == 1) {
    $user = mysqli_fetch_assoc($result);
} else {
    // If user not found, logout
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Profile | RKU Galore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Add jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --galore-red: #dc3545;
            --galore-red-dark: #b02a37;
            --galore-gray: #6c757d;
        }

        body {
            font-family: "Segoe UI", Arial, sans-serif;
            margin: 0;
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

        /* ===== PROFILE CARD ===== */
        .profile-card {
            position: relative;
            z-index: 2;
            max-width: 900px;
            margin: 60px auto 60px;
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 25px 50px rgba(220, 53, 69, 0.2);
            padding: 45px;
            border-top: 6px solid var(--galore-red);
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 30px;
            margin-bottom: 35px;
        }

        .profile-header img {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--galore-red);
        }

        /* ===== FORM STYLING (Integrated into Info Grid) ===== */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .info-box {
            background: #fff5f5;
            border-left: 5px solid var(--galore-red);
            padding: 12px 20px;
            border-radius: 12px;
            position: relative;
        }

        .info-box label {
            color: var(--galore-gray);
            font-weight: 600;
            font-size: 0.85rem;
            display: block;
            margin-bottom: 4px;
        }

        .form-control-galore {
            width: 100%;
            border: none;
            background: transparent;
            font-weight: 600;
            color: #333;
            font-size: 1.05rem;
            padding: 0;
            transition: all 0.3s ease;
        }

        .form-control-galore:focus {
            outline: none;
            color: var(--galore-red);
        }

        /* Validation Styles */
        .form-control-galore.is-valid {
            color: #28a745;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right center;
            background-size: 16px;
            padding-right: 20px;
        }

        .form-control-galore.is-invalid {
            color: var(--galore-red);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right center;
            background-size: 16px;
            padding-right: 20px;
        }

        .error {
            color: #dc3545;
            font-size: 0.7rem;
            margin-top: 4px;
            display: none;
            position: absolute;
            bottom: -18px;
            left: 20px;
        }

        .small.text-danger {
            font-size: 0.7rem;
            color: #dc3545;
            margin-top: 4px;
        }

        /* File input styling */
        .form-control-sm {
            border: 2px solid #ddd;
            border-radius: 8px;
            padding: 8px;
            font-size: 0.85rem;
            width: 100%;
        }

        .form-control-sm:focus {
            border-color: var(--galore-red);
            outline: none;
        }

        /* ===== BUTTONS ===== */
        .profile-actions {
            text-align: center;
            margin-top: 40px;
        }

        .galore-btn {
            padding: 14px 36px;
            background: linear-gradient(135deg, #ff4d5a, var(--galore-red));
            color: #fff;
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
            margin: 0 12px;
            display: inline-block;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .galore-btn:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(220, 53, 69, 0.45);
        }

        .btn-secondary-galore {
            background: var(--galore-gray);
        }

        /* Success/Error Messages */
        .alert {
            margin-bottom: 20px;
            border-radius: 10px;
        }
    </style>
</head>

<body>

<?php include 'navbar.php'; ?>

<section class="hero">
    <h1 class="display-1 display-md-2 display-sm-3">Edit Profile</h1>
    <p class="lead lead-sm">Update your information for RKU Galore</p>
</section>

<div class="profile-card" data-aos="fade-up">
    
    <?php if(isset($_GET['success']) && $_GET['success'] == 1): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> Profile updated successfully!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <?php if(isset($_GET['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i> Error: <?php echo htmlspecialchars($_GET['error']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <form action="update_profile.php" method="POST" enctype="multipart/form-data" id="profileForm">
        
        <div class="profile-header flex-column flex-md-row text-center text-md-start" data-aos="fade-right">
            <div class="position-relative mb-3 mb-md-0 me-md-4">
                <?php
                $profile_pic = "uploads/profile_pics/" . $user['profile_pic'];
                if (empty($user['profile_pic']) || !file_exists($profile_pic)) {
                    $profile_pic = "website/default-avatar.jpg";
                }
                ?>
                <img src="<?php echo $profile_pic; ?>" alt="Profile Picture" id="preview" class="img-fluid">
                <input type="file" 
                       name="profile_pic" 
                       class="form-control form-control-sm mt-2" 
                       accept="image/*"
                       onchange="previewImage(this)">
                <small class="text-muted">Max size: 2MB (JPG, PNG, GIF only)</small>
            </div>
            <div>
                <h3 class="mb-1 h3 h4-sm"><?php echo htmlspecialchars($user['full_name']); ?></h3>
                <p class="mb-0 text-muted lead lead-sm">Update your profile information below</p>
            </div>
        </div>

        <div class="info-grid">
            <!-- Enrollment Number (Read Only) -->
            <div class="info-box">
                <label>Enrollment Number *</label>
                <input type="text" 
                       name="enrollment_no" 
                       class="form-control-galore" 
                       value="<?php echo htmlspecialchars($user['enrollment_no']); ?>"
                       readonly
                       style="background-color: #f0f0f0; cursor: not-allowed;">
                <small class="error" id="enrollment_no_error"></small>
                <small class="text-muted" style="font-size: 0.7rem; display: block;">Enrollment number cannot be changed</small>
            </div>

            <!-- Full Name -->
            <div class="info-box">
                <label>Full Name *</label>
                <input type="text" 
                       name="full_name" 
                       class="form-control-galore" 
                       value="<?php echo htmlspecialchars($user['full_name']); ?>"
                       data-validation="required alphabetic min"
                       data-min="3"
                       data-max="50"
                       required>
                <small class="error" id="full_name_error"></small>
            </div>

            <!-- Semester -->
            <div class="info-box">
                <label>Semester *</label>
                <select name="semester" 
                        class="form-control-galore"
                        data-validation="required select"
                        required>
                    <option value="">Select Semester</option>
                    <?php for($i = 1; $i <= 8; $i++): ?>
                    <option value="<?php echo $i; ?>" <?php echo ($user['semester'] == $i) ? 'selected' : ''; ?>>
                        Semester <?php echo $i; ?>
                    </option>
                    <?php endfor; ?>
                </select>
                <small class="error" id="semester_error"></small>
            </div>

            <!-- School -->
            <div class="info-box">
                <label>School *</label>
                <input type="text" 
                       name="school" 
                       class="form-control-galore" 
                       value="<?php echo htmlspecialchars($user['school']); ?>"
                       data-validation="required min"
                       data-min="2"
                       data-max="50"
                       required>
                <small class="error" id="school_error"></small>
            </div>

            <!-- Email -->
            <div class="info-box">
                <label>RKU Email *</label>
                <input type="email" 
                       name="email" 
                       class="form-control-galore" 
                       value="<?php echo htmlspecialchars($user['email']); ?>"
                       data-validation="required email"
                       data-max="100"
                       required>
                <small class="error" id="email_error"></small>
            </div>

            <!-- Gender -->
            <div class="info-box">
                <label>Gender *</label>
                <select name="gender" 
                        class="form-control-galore"
                        data-validation="required select"
                        required>
                    <option value="">Select Gender</option>
                    <option value="Male" <?php echo ($user['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo ($user['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                    <option value="Other" <?php echo ($user['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                </select>
                <small class="error" id="gender_error"></small>
            </div>

            <!-- Branch -->
            <div class="info-box">
                <label>Branch *</label>
                <input type="text" 
                       name="branch" 
                       class="form-control-galore" 
                       value="<?php echo htmlspecialchars($user['branch']); ?>"
                       data-validation="required min"
                       data-min="2"
                       data-max="50"
                       required>
                <small class="error" id="branch_error"></small>
            </div>

            <!-- Contact Number -->
            <div class="info-box">
                <label>Contact Number *</label>
                <input type="text" 
                       name="phone" 
                       class="form-control-galore" 
                       value="<?php echo htmlspecialchars($user['phone']); ?>"
                       data-validation="required number min max"
                       data-min="10"
                       data-max="10"
                       required>
                <small class="error" id="phone_error"></small>
            </div>
        </div>

        <div class="profile-actions">
            <button type="submit" name="update_profile" class="galore-btn">Save Changes</button>
            <a href="profile.php" class="galore-btn btn-secondary-galore">Cancel</a>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>

<!-- Validation and Preview Script -->
<script>
$(document).ready(function () {
    // Initialize AOS
    AOS.init({ duration: 1200, once: true });
});

// Image preview function
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Form validation
$('#profileForm').on('submit', function(e) {
    let isValid = true;
    
    // Clear previous errors
    $('.error').hide();
    $('.form-control-galore').removeClass('is-invalid is-valid');
    
    // Validate each field
    $('[data-validation]').each(function() {
        let field = $(this);
        let value = field.val().trim();
        let rules = field.data('validation').split(' ');
        let fieldName = field.attr('name');
        
        for(let rule of rules) {
            if(rule === 'required' && value === '') {
                showError(field, fieldName.replace('_', ' ') + ' is required');
                isValid = false;
                break;
            }
            
            if(rule === 'email' && value !== '') {
                let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if(!emailRegex.test(value)) {
                    showError(field, 'Enter a valid email address');
                    isValid = false;
                    break;
                }
            }
            
            if(rule === 'number' && value !== '') {
                if(isNaN(value)) {
                    showError(field, 'Must contain only numbers');
                    isValid = false;
                    break;
                }
            }
            
            if(rule === 'min' && value !== '') {
                let min = field.data('min');
                if(value.length < min) {
                    showError(field, 'Minimum ' + min + ' characters required');
                    isValid = false;
                    break;
                }
            }
            
            if(rule === 'max' && value !== '') {
                let max = field.data('max');
                if(value.length > max) {
                    showError(field, 'Maximum ' + max + ' characters allowed');
                    isValid = false;
                    break;
                }
            }
            
            if(rule === 'select' && value === '') {
                showError(field, 'Please select an option');
                isValid = false;
                break;
            }
        }
        
        if(isValid && value !== '') {
            field.addClass('is-valid');
        }
    });
    
    if(!isValid) {
        e.preventDefault();
    }
});

function showError(field, message) {
    field.addClass('is-invalid');
    let errorId = '#' + field.attr('name') + '_error';
    $(errorId).text(message).show();
}
</script>

</body>
</html>