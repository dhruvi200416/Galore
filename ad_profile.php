<?php
include 'ad_profile_handler.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Admin Dashboard | RKU Galore</title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --galore-red: #dc3545;
            --galore-red-dark: #b02a37;
            --galore-bg: #f8f9fa;
            --galore-dark: #212529;
            --galore-gray: #6c757d;
            --galore-white: #ffffff;
            --galore-light-red: #fff5f5;
            --galore-success: #28a745;
            --sidebar-width: 250px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Roboto, sans-serif;
            background: var(--galore-bg);
            margin: 0;
            min-height: 100vh;
            display: flex;
            overflow: hidden;
        }

        /* Custom Scrollbar for the entire page and containers */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--galore-red);
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--galore-red-dark);
        }

        /* Firefox scrollbar */
        * {
            scrollbar-width: thin;
            scrollbar-color: var(--galore-red) #f1f1f1;
        }

        .sidebar {
            width: var(--sidebar-width);
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            background: var(--galore-dark);
            color: white;
            z-index: 100;
        }

        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .profile-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: transparent;
            width: 100%;
            height: 100%;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .profile-wrapper.form-visible {
            justify-content: flex-start;
            padding: 20px;
        }

        .content-container {
            width: 100%;
            max-width: 620px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            padding: 0;
            margin: auto;
        }

        .profile-wrapper.form-visible .content-container {
            padding: 0;
            margin: 0 auto;
        }

        .btn-add-profile {
            background: linear-gradient(135deg, #ff4d5a, var(--galore-red));
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 14px;
            font-size: 0.95rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-add-profile:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(220, 53, 69, 0.3);
        }

        .profile-card {
            background: var(--galore-white);
            width: 100%;
            border-radius: 24px;
            border-top: 6px solid var(--galore-red);
            box-shadow: 0 20px 40px rgba(220, 53, 69, 0.15);
            overflow: visible;
            animation: fadeIn 0.6s ease;
            margin: 0;
            max-height: calc(100vh - 60px);
            display: flex;
            flex-direction: column;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .profile-header {
            background: linear-gradient(145deg, #fff5f5, #ffffff);
            padding: 25px 30px 20px;
            text-align: center;
            border-bottom: 1px solid #ffe0e0;
            flex-shrink: 0;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            margin: 0 auto 12px;
            position: relative;
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid white;
            box-shadow: 0 10px 20px rgba(220, 53, 69, 0.25);
        }

        .avatar-icon {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: linear-gradient(135deg, #dc3545, #b02a37);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 4px solid white;
            box-shadow: 0 10px 20px rgba(220, 53, 69, 0.25);
        }

        .avatar-icon i {
            font-size: 3rem;
            color: white;
        }

        .status-badge {
            position: absolute;
            bottom: 8px;
            right: 8px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: var(--galore-success);
            border: 3px solid white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .profile-name {
            color: var(--galore-dark);
            font-size: 1.6rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .profile-id {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--galore-dark);
            color: white;
            padding: 5px 18px;
            border-radius: 30px;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .profile-id i {
            color: #ff8a92;
        }

        .profile-details {
            padding: 20px 25px;
            flex: 1;
            overflow-y: auto;
            min-height: 0;
        }

        /* Custom scrollbar for profile details */
        .profile-details::-webkit-scrollbar {
            width: 6px;
        }

        .profile-details::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .profile-details::-webkit-scrollbar-thumb {
            background: var(--galore-red);
            border-radius: 10px;
        }

        .section-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--galore-dark);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title i {
            color: var(--galore-red);
            font-size: 0.9rem;
        }

        .section-title:after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, var(--galore-red), transparent);
            margin-left: 10px;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-bottom: 15px;
        }

        .detail-item {
            display: flex;
            align-items: center;
            padding: 12px;
            background: #fafafa;
            border-radius: 16px;
            border-left: 4px solid var(--galore-red);
            transition: all 0.3s ease;
        }

        .detail-item:hover {
            background: #fff5f5;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(220, 53, 69, 0.1);
        }

        .detail-icon {
            width: 40px;
            height: 40px;
            background: var(--galore-light-red);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--galore-red);
            font-size: 1rem;
            margin-right: 12px;
        }

        .detail-content {
            flex: 1;
        }

        .detail-label {
            font-size: 0.6rem;
            color: var(--galore-gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
            font-weight: 700;
        }

        .detail-value {
            font-size: 0.9rem;
            color: var(--galore-dark);
            font-weight: 600;
            word-break: break-word;
        }

        .detail-sub {
            font-size: 0.65rem;
            color: var(--galore-gray);
            margin-top: 2px;
        }

        .gender-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .gender-male {
            background: #cce5ff;
            color: #004085;
        }

        .gender-female {
            background: #f8d7da;
            color: #721c24;
        }

        .status-active {
            color: var(--galore-success);
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.85rem;
        }

        .status-inactive {
            color: var(--galore-red);
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.85rem;
        }

        .btn-toggle-status {
            background: none;
            border: none;
            padding: 0;
            margin-left: 8px;
            color: var(--galore-red);
            cursor: pointer;
            font-size: 0.75rem;
        }

        .btn-toggle-status:hover {
            text-decoration: underline;
        }

        /* Button Styles */
        .action-buttons {
            display: flex;
            gap: 15px;
            padding: 0 25px 20px;
            flex-shrink: 0;
        }

        .btn-action {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: linear-gradient(135deg, #fff5f5, #ffffff);
            border: 2px solid var(--galore-red);
            color: var(--galore-red);
            padding: 12px 20px;
            border-radius: 40px;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-action:hover {
            background: var(--galore-red);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.3);
        }

        .btn-action i {
            font-size: 1rem;
        }

        /* Change Password Section - Link Button */
        .change-password-section {
            padding: 0 25px 25px;
            border-top: 1px solid rgba(220, 53, 69, 0.2);
            margin-top: 5px;
            flex-shrink: 0;
        }

        .change-password-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            background: linear-gradient(135deg, #fff5f5, #ffffff);
            border: 2px solid var(--galore-red);
            color: var(--galore-red);
            padding: 12px 20px;
            border-radius: 40px;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .change-password-btn:hover {
            background: var(--galore-red);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.3);
        }

        .change-password-btn i {
            font-size: 1rem;
        }

        .add-profile-form-container {
            background: var(--galore-white);
            width: 100%;
            padding: 25px;
            border-radius: 24px;
            border-top: 6px solid var(--galore-red);
            box-shadow: 0 20px 40px rgba(220, 53, 69, 0.15);
            display: none;
            animation: fadeIn 0.6s ease;
            margin-top: 0;
            margin-bottom: 0;
            max-height: calc(100vh - 80px);
            overflow-y: auto;
        }

        /* Custom scrollbar for form */
        .add-profile-form-container::-webkit-scrollbar {
            width: 6px;
        }

        .add-profile-form-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .add-profile-form-container::-webkit-scrollbar-thumb {
            background: var(--galore-red);
            border-radius: 10px;
        }

        .profile-wrapper.form-visible .add-profile-form-container {
            margin-top: 20px;
            margin-bottom: 20px;
            display: block;
        }

        .profile-wrapper.form-visible .profile-card {
            display: none;
        }

        .form-title {
            text-align: center;
            color: var(--galore-red);
            font-size: 1.6rem;
            margin-bottom: 20px;
            font-weight: 700;
        }

        #profileForm {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        @media (max-width: 768px) {
            #profileForm {
                grid-template-columns: 1fr;
            }
        }

        .full-width {
            grid-column: span 2;
        }

        @media (max-width: 768px) {
            .full-width {
                grid-column: span 1;
            }
        }

        .galore-input-group {
            display: flex;
            flex-direction: column;
        }

        .galore-label {
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--galore-gray);
            margin-bottom: 4px;
            text-transform: uppercase;
        }

        .galore-input,
        .galore-select {
            padding: 10px 12px;
            border: 1px solid #dee2e6;
            border-radius: 14px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .galore-select:disabled {
            background-color: #e9ecef;
            cursor: not-allowed;
            opacity: 0.7;
        }

        .galore-input:focus,
        .galore-select:focus {
            outline: none;
            border-color: var(--galore-red);
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
        }

        .file-input-wrapper {
            position: relative;
        }

        .custom-file-upload {
            display: inline-block;
            padding: 10px 12px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 14px;
            cursor: pointer;
            width: 100%;
            text-align: left;
            color: var(--galore-gray);
            font-size: 0.9rem;
        }

        .custom-file-upload i {
            margin-right: 6px;
            color: var(--galore-red);
        }

        input[type="file"] {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            cursor: pointer;
        }

        .image-preview-container {
            margin-top: 8px;
            text-align: center;
        }

        .image-preview {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            border: 2px solid var(--galore-red);
            object-fit: cover;
            display: none;
        }

        .error-message {
            font-size: 0.7rem;
            margin-top: 3px;
            display: block;
            color: #dc3545;
        }

        .is-valid {
            border-color: #28a745 !important;
        }

        .is-invalid {
            border-color: #dc3545 !important;
        }

        .form-buttons {
            grid-column: span 2;
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 8px;
        }

        @media (max-width: 768px) {
            .form-buttons {
                grid-column: span 1;
            }
        }

        .btn-save,
        .btn-cancel {
            padding: 10px 20px;
            border: none;
            border-radius: 14px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-save {
            background: linear-gradient(135deg, #ff4d5a, var(--galore-red));
            color: white;
        }

        .btn-save:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(220, 53, 69, 0.3);
        }

        .btn-cancel {
            background: var(--galore-gray);
            color: white;
        }

        .btn-cancel:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(108, 117, 125, 0.3);
        }

        .no-data-container {
            text-align: center;
            padding: 50px 20px;
            background: var(--galore-white);
            border-radius: 24px;
            border-top: 6px solid var(--galore-red);
            box-shadow: 0 20px 40px rgba(220, 53, 69, 0.15);
            width: 100%;
            animation: fadeIn 0.6s ease;
        }

        .no-data-icon {
            font-size: 3.5rem;
            color: #ddd;
            margin-bottom: 12px;
        }

        .no-data-text {
            color: #999;
            font-size: 1rem;
            margin-bottom: 15px;
        }

        @media (max-width: 991.98px) {
            :root {
                --sidebar-width: 0px;
            }

            .sidebar {
                display: none;
            }

            body {
                overflow: auto;
            }

            .main-content {
                margin-left: 0;
                height: auto;
                min-height: 100vh;
                overflow: visible;
            }

            .profile-wrapper {
                height: auto;
                min-height: 100vh;
                padding: 15px;
                justify-content: flex-start;
                overflow-y: visible;
            }

            .content-container {
                max-width: 100%;
                padding: 0;
            }

            .details-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }
            
            .profile-card {
                max-height: none;
            }
        }
    </style>
</head>

<body>

    <?php include 'admin_header.php'; ?>

    <div class="main-content">
        <div class="profile-wrapper" id="profileWrapper">
            <div class="content-container">
                
                <!-- ADD / EDIT PROFILE FORM -->
                <div class="add-profile-form-container" id="addProfileForm">
                    <h3 class="form-title" id="formTitleText"><?php echo $latestProfile ? 'Edit Profile' : 'Add New Profile'; ?></h3>
                    <form id="profileForm" method="POST" enctype="multipart/form-data" action="ad_profile_handler.php">
                        <input type="hidden" name="edit_id" id="edit_id" value="<?php echo $latestProfile ? $latestProfile['id'] : ''; ?>">

                        <div class="galore-input-group">
                            <label class="galore-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="full_name" class="galore-input" data-validation="required min alphabetic" data-min="3" data-max="50" value="<?php echo $latestProfile ? htmlspecialchars($latestProfile['full_name']) : ''; ?>">
                            <span id="full_name_error" class="error-message"></span>
                        </div>
                        <div class="galore-input-group">
                            <label class="galore-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="galore-input" data-validation="required email" value="<?php echo $latestProfile ? htmlspecialchars($latestProfile['email']) : ''; ?>">
                            <span id="email_error" class="error-message"></span>
                        </div>
                        <div class="galore-input-group">
                            <label class="galore-label">Phone <span class="text-danger">*</span></label>
                            <input type="tel" name="phone" class="galore-input" data-validation="required min numeric" data-min="10" value="<?php echo $latestProfile ? htmlspecialchars($latestProfile['phone']) : ''; ?>">
                            <span id="phone_error" class="error-message"></span>
                        </div>
                        <div class="galore-input-group">
                            <label class="galore-label">Branch <span class="text-danger">*</span></label>
                            <input type="text" name="branch" class="galore-input" data-validation="required alphabetic min" data-min="3" value="<?php echo $latestProfile ? htmlspecialchars($latestProfile['branch']) : ''; ?>">
                            <span id="branch_error" class="error-message"></span>
                        </div>
                        <div class="galore-input-group">
                            <label class="galore-label">Gender <span class="text-danger">*</span></label>
                            <select name="gender" class="galore-select" data-validation="required select">
                                <option value="">Select</option>
                                <option value="Male" <?php echo ($latestProfile && $latestProfile['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                <option value="Female" <?php echo ($latestProfile && $latestProfile['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                <option value="Other" <?php echo ($latestProfile && $latestProfile['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                            </select>
                            <span id="gender_error" class="error-message"></span>
                        </div>
                        
                        <!-- Role field - only show for Admin users, but disabled for editing -->
                        <?php if ($logged_in_role == 'Admin'): ?>
                        <div class="galore-input-group">
                            <label class="galore-label">Role <span class="text-danger">*</span></label>
                            <select name="role" class="galore-select" data-validation="required select" disabled>
                                <option value="">Select</option>
                                <option value="Admin" <?php echo ($latestProfile && $latestProfile['role'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                                <option value="Coordinator" <?php echo ($latestProfile && $latestProfile['role'] == 'Coordinator') ? 'selected' : ''; ?>>Coordinator</option>
                                <option value="Co-cordinator" <?php echo ($latestProfile && $latestProfile['role'] == 'Co-cordinator') ? 'selected' : ''; ?>>Co-cordinator</option>
                            </select>
                            <input type="hidden" name="role" value="<?php echo $latestProfile ? $latestProfile['role'] : ''; ?>">
                            <span id="role_error" class="error-message"></span>
                            <small class="text-muted" style="font-size: 0.7rem;">Role cannot be changed</small>
                        </div>
                        <?php else: ?>
                        <input type="hidden" name="role" value="<?php echo $logged_in_role; ?>">
                        <?php endif; ?>
                        
                        <div class="galore-input-group">
                            <label class="galore-label">School <span class="text-danger">*</span></label>
                            <input type="text" name="school" class="galore-input" data-validation="required" value="<?php echo $latestProfile ? htmlspecialchars($latestProfile['school']) : ''; ?>">
                            <span id="school_error" class="error-message"></span>
                        </div>
                        <div class="galore-input-group">
                            <label class="galore-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="galore-select" data-validation="required select">
                                <option value="">Select</option>
                                <option value="Active" <?php echo ($latestProfile && $latestProfile['status'] == 'Active') ? 'selected' : ''; ?>>Active</option>
                                <option value="Inactive" <?php echo ($latestProfile && $latestProfile['status'] == 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                            </select>
                            <span id="status_error" class="error-message"></span>
                        </div>
                        <div class="galore-input-group">
                            <label class="galore-label">Password <?php echo !$latestProfile ? '<span class="text-danger">*</span>' : ''; ?></label>
                            <input type="password" name="password" class="galore-input" data-validation="<?php echo !$latestProfile ? 'required' : ''; ?>" value="">
                            <span id="password_error" class="error-message"></span>
                        </div>
                        <div class="galore-input-group">
                            <label class="galore-label">Confirm Password <?php echo !$latestProfile ? '<span class="text-danger">*</span>' : ''; ?></label>
                            <input type="password" name="confirm_password" class="galore-input" data-validation="<?php echo !$latestProfile ? 'required' : ''; ?>" value="">
                            <span id="confirm_password_error" class="error-message"></span>
                        </div>
                        <div class="galore-input-group full-width">
                            <label class="galore-label">Profile Image</label>
                            <div class="file-input-wrapper">
                                <div class="custom-file-upload">
                                    <i class="fas fa-camera"></i>
                                    <span id="file-name"><?php echo $latestProfile && $latestProfile['profile_pic'] ? 'Current: ' . basename($latestProfile['profile_pic']) : 'Choose file...'; ?></span>
                                </div>
                                <input type="file" name="profile_pic" accept="image/*" id="profile_pic">
                            </div>
                            <span id="profile_pic_error" class="error-message"></span>
                            <div class="image-preview-container">
                                <img id="imagePreview" class="image-preview" src="<?php echo $latestProfile && $latestProfile['profile_pic'] ? $latestProfile['profile_pic'] : '#'; ?>" alt="Preview">
                            </div>
                        </div>
                        <div class="form-buttons">
                            <button type="submit" name="submit_c_profile" class="btn-save">Save Profile</button>
                            <button type="button" class="btn-cancel" id="cancelForm">Cancel</button>
                        </div>
                    </form>
                </div>

                <!-- PROFILE CARD -->
                <?php if ($latestProfile): ?>
                    <div class="profile-card">
                        <div class="profile-header">
                            <div class="profile-avatar">
                                <?php if ($latestProfile['profile_pic'] && file_exists($latestProfile['profile_pic'])): ?>
                                    <img src="<?php echo $latestProfile['profile_pic']; ?>" alt="Profile Photo">
                                <?php else: ?>
                                    <div class="avatar-icon">
                                        <i class="fas fa-user-shield"></i>
                                    </div>
                                <?php endif; ?>
                                <span class="status-badge" title="<?php echo $latestProfile['status'] == 'Active' ? 'Online' : 'Offline'; ?>"></span>
                            </div>
                            <h1 class="profile-name"><?php echo htmlspecialchars($latestProfile['full_name']); ?></h1>
                            <div class="profile-id">
                                <i class="fas fa-id-card"></i> <?php echo strtoupper(htmlspecialchars($latestProfile['role'])); ?>
                            </div>
                        </div>
                        <div class="profile-details">
                            <div class="section-title">
                                <i class="fas fa-user-circle"></i> Personal Information
                            </div>
                            <div class="details-grid">
                                <div class="detail-item">
                                    <div class="detail-icon"><i class="fas fa-envelope"></i></div>
                                    <div class="detail-content">
                                        <div class="detail-label">Email Address</div>
                                        <div class="detail-value"><?php echo htmlspecialchars($latestProfile['email']); ?></div>
                                        <div class="detail-sub">Primary contact</div>
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-icon"><i class="fas fa-phone-alt"></i></div>
                                    <div class="detail-content">
                                        <div class="detail-label">Phone Number</div>
                                        <div class="detail-value"><?php echo htmlspecialchars($latestProfile['phone']); ?></div>
                                        <div class="detail-sub">Available 9 AM - 6 PM</div>
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-icon"><i class="fas fa-venus-mars"></i></div>
                                    <div class="detail-content">
                                        <div class="detail-label">Gender</div>
                                        <div class="detail-value">
                                            <span class="gender-badge <?php echo $latestProfile['gender'] == 'Male' ? 'gender-male' : ($latestProfile['gender'] == 'Female' ? 'gender-female' : ''); ?>">
                                                <i class="fas fa-<?php echo $latestProfile['gender'] == 'Male' ? 'mars' : ($latestProfile['gender'] == 'Female' ? 'venus' : 'genderless'); ?>"></i> 
                                                <?php echo $latestProfile['gender']; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-icon"><i class="fas fa-circle"></i></div>
                                    <div class="detail-content">
                                        <div class="detail-label">Account Status</div>
                                        <div class="detail-value">
                                            <?php if ($latestProfile['status'] == 'Active'): ?>
                                                <span class="status-active"><i class="fas fa-check-circle"></i> Active</span>
                                            <?php else: ?>
                                                <span class="status-inactive"><i class="fas fa-times-circle"></i> Inactive</span>
                                            <?php endif; ?>
                                            <button class="btn-toggle-status" onclick="toggleStatus(<?php echo $latestProfile['id']; ?>)">
                                                <i class="fas fa-sync-alt"></i> Toggle
                                            </button>
                                        </div>
                                        <div class="detail-sub">Verified account</div>
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-icon"><i class="fas fa-code-branch"></i></div>
                                    <div class="detail-content">
                                        <div class="detail-label">Branch</div>
                                        <div class="detail-value"><?php echo htmlspecialchars($latestProfile['branch']); ?></div>
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-icon"><i class="fas fa-school"></i></div>
                                    <div class="detail-content">
                                        <div class="detail-label">School</div>
                                        <div class="detail-value"><?php echo htmlspecialchars($latestProfile['school']); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Action buttons -->
                        <div class="action-buttons">
                            <button class="btn-action" onclick="editProfile(<?php echo $latestProfile['id']; ?>)">
                                <i class="fas fa-user-edit"></i> Edit Profile
                            </button>
                        </div>
                        <!-- Change Password Section - Link to separate page -->
                        <div class="change-password-section">
                            <a href="ad_change_password.php" class="change-password-btn">
                                <i class="fas fa-key"></i> Change Password
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="no-data-container">
                        <div class="no-data-icon"><i class="fas fa-user-shield"></i></div>
                        <h5 class="no-data-text">No profile found for your role</h5>
                        <button class="btn-add-profile" onclick="openProfileForm()">
                            <i class="fas fa-plus-circle"></i> Create Your Profile
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let latestProfile = <?php echo json_encode($latestProfile); ?>;
        let editId = latestProfile ? latestProfile.id : null;
        let loggedInRole = '<?php echo $logged_in_role; ?>';

        const profileWrapper = document.getElementById("profileWrapper");
        const addProfileForm = document.getElementById("addProfileForm");
        const formTitleText = document.getElementById("formTitleText");
        const imageUpload = document.getElementById("profile_pic");
        const imagePreview = document.getElementById("imagePreview");
        const fileNameSpan = document.getElementById("file-name");

        window.toggleStatus = function(id) {
            if (confirm('Are you sure you want to toggle the status? If toggling to Inactive, you will be logged out.')) {
                window.location.href = "ad_profile_handler.php?toggle_status_id=" + id;
            }
        };

        window.openProfileForm = function() {
            if (latestProfile) {
                formTitleText.textContent = "Edit Profile";
                document.getElementById("edit_id").value = latestProfile.id;
                document.getElementById("profileForm").full_name.value = latestProfile.full_name || '';
                document.getElementById("profileForm").email.value = latestProfile.email || '';
                document.getElementById("profileForm").phone.value = latestProfile.phone || '';
                document.getElementById("profileForm").branch.value = latestProfile.branch || '';
                document.getElementById("profileForm").gender.value = latestProfile.gender || '';
                document.getElementById("profileForm").school.value = latestProfile.school || '';
                document.getElementById("profileForm").status.value = latestProfile.status || '';
                document.getElementById("profileForm").password.value = '';
                document.getElementById("profileForm").confirm_password.value = '';
                if (latestProfile.profile_pic) {
                    imagePreview.src = latestProfile.profile_pic;
                    imagePreview.style.display = "block";
                    fileNameSpan.textContent = "Current: " + latestProfile.profile_pic.split('/').pop();
                } else {
                    imagePreview.style.display = "none";
                    fileNameSpan.textContent = "Choose file...";
                }
            } else {
                formTitleText.textContent = "Add New Profile";
                document.getElementById("edit_id").value = "";
                document.getElementById("profileForm").reset();
                imagePreview.style.display = "none";
                fileNameSpan.textContent = "Choose file...";
            }
            
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            profileWrapper.classList.add('form-visible');
            addProfileForm.style.display = "block";
            setTimeout(function() {
                profileWrapper.scrollTop = 0;
            }, 100);
        };

        window.editProfile = function(id) {
            openProfileForm();
        };

        document.getElementById("cancelForm").addEventListener("click", function() {
            addProfileForm.style.display = "none";
            profileWrapper.classList.remove('form-visible');
            profileWrapper.scrollTop = 0;
        });

        if (imageUpload) {
            imageUpload.addEventListener('change', function(e) {
                const fileName = this.files[0] ? this.files[0].name : "Choose file...";
                fileNameSpan.textContent = fileName;
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = "block";
                    };
                    reader.readAsDataURL(this.files[0]);
                } else {
                    imagePreview.style.display = "none";
                }
            });
        }

        // Display session messages with SweetAlert
        <?php if (isset($_SESSION['profile_success'])): ?>
            Swal.fire({
                title: 'Success!',
                text: '<?php echo $_SESSION['profile_success']; ?>',
                icon: 'success',
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'OK'
            });
            <?php unset($_SESSION['profile_success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['profile_error'])): ?>
            Swal.fire({
                title: 'Error!',
                text: '<?php echo $_SESSION['profile_error']; ?>',
                icon: 'error',
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'OK'
            });
            <?php unset($_SESSION['profile_error']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['password_success'])): ?>
            Swal.fire({
                title: 'Success!',
                text: '<?php echo $_SESSION['password_success']; ?>',
                icon: 'success',
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'OK'
            });
            <?php unset($_SESSION['password_success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['password_error'])): ?>
            Swal.fire({
                title: 'Error!',
                text: '<?php echo $_SESSION['password_error']; ?>',
                icon: 'error',
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'OK'
            });
            <?php unset($_SESSION['password_error']); ?>
        <?php endif; ?>

        function validateInput(input) {
            var field = $(input);
            var value = field.val() ? field.val().trim() : "";
            var errorfield = $("#" + field.attr("name") + "_error");
            var validationType = field.data("validation");
            var minLength = field.data("min") || 0;
            let errorMessage = "";

            if (field.attr("name") === "confirm_password" || field.attr("name") === "password") {
                var password = $("input[name='password']").val();
                var confirm = $("input[name='confirm_password']").val();
                
                if (field.attr("name") === "password" && !latestProfile && value === "") {
                    errorMessage = "Password is required.";
                } else if (field.attr("name") === "confirm_password" && !latestProfile && value === "") {
                    errorMessage = "Confirm password is required.";
                } else if ((password !== "" || confirm !== "") && password !== confirm) {
                    if (field.attr("name") === "password" || field.attr("name") === "confirm_password") {
                        errorMessage = "Passwords do not match.";
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

            if (validationType) {
                if (validationType.includes("required")) {
                    if (value === "" || value === "0" || value === null) {
                        errorMessage = "This field is required.";
                    }
                }
                if (value !== "" && !errorMessage) {
                    if (validationType.includes("min") && value.length < minLength) {
                        errorMessage = `Minimum ${minLength} characters.`;
                    }
                    if (validationType.includes('alphabetic') && !/^[a-zA-Z\s]+$/.test(value)) {
                        errorMessage = "Letters only.";
                    }
                    if (validationType.includes("numeric") && !/^[0-9]+$/.test(value)) {
                        errorMessage = "Numbers only.";
                    }
                    if (validationType.includes("email") && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                        errorMessage = "Invalid email.";
                    }
                    if (validationType.includes("select") && value === "") {
                        errorMessage = "Select an option.";
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

        $(document).ready(function() {
            $("input, textarea, select").on("input change", function() {
                validateInput(this);
            });

            $("input[name='password'], input[name='confirm_password']").on("keyup", function() {
                validateInput($("input[name='password']")[0]);
                validateInput($("input[name='confirm_password']")[0]);
            });

            $("#profileForm").on("submit", function(e) {
                let isValid = true;
                let firstInvalidField = null;
                
                $(this).find("input, textarea, select").each(function() {
                    if (!validateInput(this)) {
                        isValid = false;
                        if (!firstInvalidField) firstInvalidField = this;
                    }
                });
                
                if (latestProfile) {
                    var password = $("input[name='password']").val();
                    var confirm = $("input[name='confirm_password']").val();
                    if ((password !== "" || confirm !== "") && password !== confirm) {
                        isValid = false;
                        $("input[name='password'], input[name='confirm_password']").addClass("is-invalid");
                        $("#password_error, #confirm_password_error").text("Passwords do not match.");
                        if (!firstInvalidField) firstInvalidField = $("input[name='password']")[0];
                    }
                }
                
                if (!isValid) {
                    e.preventDefault();
                    if (firstInvalidField) $(firstInvalidField).focus();
                    return false;
                }
            });
        });
    </script>
</body>

</html>