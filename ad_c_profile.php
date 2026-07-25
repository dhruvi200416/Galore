<?php require 'ad_c_profile_handler.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | RKU Galore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        :root {
            --galore-red: #dc3545;
            --galore-gray: #6c757d;
            --galore-dark: #333;
            --card-shadow: 0 20px 30px -10px rgba(220, 53, 69, 0.12);
            --hover-lift: translateY(-6px);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f8f9fc;
            font-family: 'Segoe UI', system-ui, -apple-system, 'Roboto', sans-serif;
        }

        .main-content {
            padding: 30px;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* ========== TOP BAR ========== */
        .top-bar {
            background: #ffffff;
            padding: 20px 28px;
            border-radius: 28px;
            border-top: 6px solid var(--galore-red);
            box-shadow: 0 20px 45px rgba(220, 53, 69, 0.12);
            margin-bottom: 30px;
            margin-left: 25%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            max-width: 100%;
            width: 50%;
        }

        .top-bar h1 {
            color: var(--galore-red);
            font-size: 1.9rem;
            font-weight: 800;
            margin: 0;
        }

        /* ========== CARDS CONTAINER - Centered based on top bar ========== */
        .cards-container {
            background: transparent;
            margin-top: 20px;
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .coordinator-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 28px;
            margin-bottom: 40px;
            width: 50%;
            /* margin-left: 25%; */
        }

        /* ========== ADD BUTTON ========== */
        .btn-add-user {
            background: linear-gradient(135deg, #ff4d5a, var(--galore-red));
            color: #fff;
            padding: 12px 24px;
            border: none;
            border-radius: 40px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.25s ease;
            box-shadow: 0 5px 12px rgba(220, 53, 69, 0.3);
        }

        .btn-add-user:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 22px rgba(220, 53, 69, 0.4);
        }

        /* FORM PANEL - Centered */
        .add-user-form-container {
            background: #ffffff;
            width: 100%;
            max-width: 1000px;
            margin: 30px auto;
            padding: 40px 45px;
            border-radius: 28px;
            border-top: 6px solid var(--galore-red);
            box-shadow: 0 20px 45px rgba(220, 53, 69, 0.18);
            transition: all 0.2s;
        }

        .form-title {
            text-align: center;
            color: var(--galore-red);
            font-size: 2rem;
            margin-bottom: 28px;
            font-weight: 800;
            letter-spacing: -0.3px;
        }

        /* Grid form */
        #coordinatorForm {
            display: grid;
            grid-template-columns: 1fr;
            gap: 18px;
        }

        @media (min-width: 768px) {
            #coordinatorForm {
                grid-template-columns: 1fr 1fr;
            }

            .form-buttons {
                grid-column: span 2;
            }

            .full-width {
                grid-column: span 2;
            }
        }

        .galore-input-group {
            display: flex;
            flex-direction: column;
        }

        .galore-label {
            font-size: 0.7rem;
            font-weight: 800;
            color: var(--galore-gray);
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .galore-input {
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 14px;
            font-size: 0.95rem;
            transition: 0.2s;
            background: #fff;
        }

        .galore-input:focus {
            outline: none;
            border-color: var(--galore-red);
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.15);
        }

        .galore-input[readonly] {
            background-color: #f8f9fa;
            cursor: not-allowed;
        }

        /* Disabled status field in edit mode */
        .galore-input.disabled-field,
        .galore-input:disabled {
            background-color: #e9ecef;
            cursor: not-allowed;
            opacity: 0.7;
        }

        /* file upload styling */
        .file-input-wrapper {
            position: relative;
        }

        .custom-file-upload {
            display: inline-block;
            padding: 12px 16px;
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 14px;
            cursor: pointer;
            width: 100%;
            text-align: left;
            color: var(--galore-gray);
            font-weight: 500;
        }

        .custom-file-upload i {
            margin-right: 10px;
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

        .image-preview {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 20px;
            border: 3px solid var(--galore-red);
            background: #f1f5f9;
            margin-top: 12px;
        }

        /* Form buttons */
        .form-buttons {
            display: flex;
            justify-content: center;
            gap: 16px;
            margin-top: 12px;
        }

        .btn-save {
            background: linear-gradient(135deg, #ff4d5a, var(--galore-red));
            color: white;
            padding: 12px 28px;
            border-radius: 40px;
            font-weight: bold;
            border: none;
            transition: 0.2s;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
        }

        .btn-cancel {
            background: #6c757d;
            color: white;
            padding: 12px 28px;
            border-radius: 40px;
            font-weight: bold;
            border: none;
        }

        .btn-cancel:hover {
            background: #5a6268;
        }

        /* STATUS BUTTONS */
        .btn-status {
            padding: 6px 14px;
            border: none;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
            font-size: 0.75rem;
            min-width: 80px;
        }

        .btn-status-active {
            background: linear-gradient(135deg, #28a745, #218838);
            color: white;
        }

        .btn-status-inactive {
            background: linear-gradient(135deg, #6c757d, #495057);
            color: white;
        }

        .btn-status:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }

        /* ========== PROFILE CARDS GRID ========== */
        .profile-card {
            background: #ffffff;
            border-radius: 28px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: all 0.25s ease-in-out;
            border: 1px solid rgba(220, 53, 69, 0.1);
            position: relative;
        }

        .profile-card:hover {
            transform: var(--hover-lift);
            box-shadow: 0 25px 35px -12px rgba(220, 53, 69, 0.25);
        }

        .card-badge {
            position: absolute;
            top: 18px;
            right: 18px;
            z-index: 2;
        }

        .card-img-top-wrapper {
            background: linear-gradient(145deg, #fff0f2, #ffffff);
            padding: 25px 0 15px 0;
            text-align: center;
            border-bottom: 2px solid rgba(220, 53, 69, 0.2);
        }

        .card-img-circle {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid var(--galore-red);
            box-shadow: 0 12px 18px -8px rgba(0, 0, 0, 0.1);
            background: #f1f5f9;
        }

        .card-body-custom {
            padding: 20px 22px 22px;
        }

        .coordinator-name {
            font-size: 1.45rem;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 4px;
        }

        .coordinator-email {
            font-size: 0.8rem;
            color: var(--galore-gray);
            word-break: break-all;
            margin-bottom: 14px;
            border-bottom: 1px dashed #e9ecef;
            padding-bottom: 8px;
        }

        .info-row {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.85rem;
            margin-bottom: 10px;
            color: #334155;
        }

        .info-row i {
            width: 22px;
            color: var(--galore-red);
        }

        .card-actions {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            margin-top: 18px;
        }

        .card-action-btn {
            flex: 1;
            padding: 8px 0;
            border-radius: 40px;
            font-weight: 600;
            font-size: 0.8rem;
            border: none;
            background: #f1f5f9;
            color: #1e293b;
            transition: 0.2s;
        }

        .card-action-btn i {
            margin-right: 6px;
        }

        .card-action-btn:hover {
            background: var(--galore-red);
            color: white;
        }

        /* Search Section */
        .search-section {
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
        }

        .search-box {
            position: relative;
            min-width: 260px;
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--galore-gray);
        }

        .search-box input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 2px solid #e2e8f0;
            border-radius: 40px;
            font-size: 0.9rem;
            background: white;
            transition: 0.2s;
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--galore-red);
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.2);
        }

        /* Validation styles */
        .error-message {
            font-size: 0.7rem;
            margin-top: 4px;
            display: block;
            color: #dc3545;
            animation: fadeIn 0.2s ease;
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

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-3px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .field-note {
            font-size: 0.7rem;
            color: #6c757d;
            margin-top: 5px;
        }

        /* Modal enhancements */
        .modal-content {
            border-radius: 28px;
            border-top: 6px solid var(--galore-red);
        }

        /* Responsive adjustments */
        @media (max-width: 1200px) {
            .coordinator-grid {
                width: 70%;
                margin-left: 15%;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 20px;
            }

            .top-bar {
                padding: 20px;
                flex-direction: column;
                text-align: center;
                width: 90%;
                margin-left: 5%;
            }

            .top-bar h1 {
                font-size: 1.5rem;
            }

            .search-section {
                width: 100%;
                justify-content: center;
            }

            .search-box {
                width: 100%;
            }

            .add-user-form-container {
                padding: 30px 25px;
            }

            .coordinator-grid {
                width: 90%;
                margin-left: 5%;
                gap: 20px;
            }
        }
    </style>
</head>

<body>

    <?php require 'ad_c_header.php'; ?>

    <main class="main-content">
        <!-- TOP BAR -->
        <div class="top-bar">
            <h1><i class="fas fa-user-tie me-2"></i>Coordinators Profile Cards</h1>
            <div class="search-section">
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchInput" placeholder="Search by name, email or branch...">
                </div>
                <button class="btn-add-user" id="openFormBtn">
                    <i class="bi bi-plus-circle me-1"></i> Add Coordinator
                </button>
            </div>
        </div>

        <!-- ADD / EDIT FORM -->
        <div class="add-user-form-container" id="addCoordinatorForm" style="display:none;">
            <h3 class="form-title" id="formTitleText">Add New Coordinator</h3>
            <form id="coordinatorForm" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="edit_id" id="recordId" value="">

                <!-- Profile Image Field -->
                <div class="galore-input-group full-width">
                    <label class="galore-label">Profile Image <span id="imageRequiredLabel">(Optional)</span></label>
                    <div class="file-input-wrapper">
                        <div class="custom-file-upload">
                            <i class="bi bi-camera"></i>
                            <span id="file-name">Choose file...</span>
                        </div>
                        <input type="file" id="imageUpload" name="profile_image" class="galore-input" accept="image/*">
                    </div>
                    <span id="profile_image_error" class="error-message"></span>
                    <div id="imagePreviewContainer" style="margin-top: 8px;">
                        <img id="imagePreview" class="image-preview" src="#" alt="Preview" style="display: none;">
                    </div>
                    <small class="text-muted mt-1" id="imageHelpText">Leave empty to keep existing image when editing</small>
                </div>

                <!-- Personal info grid -->
                <div class="galore-input-group">
                    <label class="galore-label">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="full_name" class="galore-input" placeholder="Dr. Rajesh Kumar" data-validation="required min alphabetic" data-min="3" data-max="50">
                    <span id="full_name_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Email (Employee ID)</label>
                    <input type="email" name="employee_id" id="employee_id" class="galore-input" readonly placeholder="Auto-filled from email">
                    <div class="field-note">Unique identifier (auto-filled)</div>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="galore-input" placeholder="rajesh.kumar@galore.edu" data-validation="required email" data-max="100">
                    <span id="email_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Phone Number <span class="text-danger">*</span></label>
                    <input type="tel" name="phone" class="galore-input" placeholder="+91 98765 43210" data-validation="required min number" data-min="10" data-max="15">
                    <span id="phone_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Gender <span class="text-danger">*</span></label>
                    <select name="gender" class="galore-input" data-validation="required select">
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                    <span id="gender_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Branch <span class="text-danger">*</span></label>
                    <input type="text" name="branch" class="galore-input" placeholder="Computer Science, Mechanical" data-validation="required min" data-min="2">
                    <span id="branch_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">School <span class="text-danger">*</span></label>
                    <select name="school" class="galore-input" data-validation="required select">
                        <option value="">Select School</option>
                        <option value="School of Engineering">School of Engineering</option>
                        <option value="School of Management">School of Management</option>
                        <option value="School of Computer Science">School of Computer Science</option>
                        <option value="School of Design">School of Design</option>
                        <option value="School of Law">School of Law</option>
                        <option value="School of Pharmacy">School of Pharmacy</option>
                        <option value="School of Nursing">School of Nursing</option>
                        <option value="School of Architecture">School of Architecture</option>
                        <option value="School of Liberal Arts">School of Liberal Arts</option>
                        <option value="School of Sciences">School of Sciences</option>
                        <option value="School of Physiotherapy">School of Physiotherapy</option>
                        <option value="School of Ayurvedic">School of Ayurvedic</option>
                        <option value="School of Technology">School of Technology</option>
                    </select>
                    <span id="school_error" class="error-message"></span>
                </div>

                <!-- Password Fields - Only for Add Mode -->
                <div class="galore-input-group" id="passwordFieldsContainer">
                    <label class="galore-label">Password <span class="text-danger" id="passwordRequired">*</span></label>
                    <input type="password" name="password" id="password" class="galore-input" placeholder="Enter password" data-validation="required min" data-min="6">
                    <span id="password_error" class="error-message"></span>
                </div>

                <div class="galore-input-group" id="confirmPasswordContainer">
                    <label class="galore-label">Confirm Password <span class="text-danger" id="confirmPasswordRequired">*</span></label>
                    <input type="password" name="confirm_password" id="confirm_password" class="galore-input" placeholder="Confirm password" data-validation="required min" data-min="6">
                    <span id="confirm_password_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Status <span class="text-danger">*</span></label>
                    <select name="status" id="statusField" class="galore-input" data-validation="required select">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                    <span id="status_error" class="error-message"></span>
                    <div class="field-note" id="statusNote" style="display:none;">Status can only be changed from the profile card</div>
                </div>

                <div class="form-buttons">
                    <button type="submit" name="submit" class="btn-save"><i class="fas fa-save me-2"></i>Save Coordinator</button>
                    <button type="button" class="btn-cancel" id="cancelForm"><i class="fas fa-times me-2"></i>Cancel</button>
                </div>
                <div class="text-center mt-2"><small class="text-muted"><i class="fas fa-info-circle me-1 text-danger"></i> Fields with * are required</small></div>
            </form>
        </div>

        <!-- PROFILE CARDS GRID SECTION -->
        <div class="cards-container">
            <div class="coordinator-grid" id="coordinatorGrid"></div>
        </div>
    </main>

    <!-- VIEW MODAL -->
    <div class="modal fade" id="viewModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header text-white" style="background:var(--galore-red); border-radius: 28px 28px 0 0;">
                    <h5 class="modal-title fw-bold"><i class="fas fa-id-card me-2"></i>Coordinator Full Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <img id="v_profile_image" src="" alt="Profile" style="width:130px; height:130px; border-radius:50%; border:4px solid var(--galore-red); object-fit:cover;">
                    </div>
                    <div class="row g-3">
                        <div class="col-sm-6"><b>ID:</b> <span id="v_id"></span></div>
                        <div class="col-sm-6"><b>Email (ID):</b> <span id="v_employee_id"></span></div>
                        <div class="col-sm-6"><b>Full Name:</b> <span id="v_full_name"></span></div>
                        <div class="col-sm-6"><b>Email:</b> <span id="v_email"></span></div>
                        <div class="col-sm-6"><b>Phone:</b> <span id="v_phone"></span></div>
                        <div class="col-sm-6"><b>Gender:</b> <span id="v_gender"></span></div>
                        <div class="col-sm-6"><b>Branch:</b> <span id="v_branch"></span></div>
                        <div class="col-sm-6"><b>School:</b> <span id="v_school"></span></div>
                        <div class="col-sm-6"><b>Status:</b> <span id="v_status"></span></div>
                        <div class="col-sm-6"><b>Role:</b> <span id="v_role"></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Coordinator data passed from PHP handler
        let coordinatorData = <?php echo json_encode($coordinatorData ?? []); ?>;
        if (!coordinatorData || !Array.isArray(coordinatorData)) coordinatorData = [];

        let isEditing = false;

        const addFormDiv = document.getElementById("addCoordinatorForm");
        const formTitle = document.getElementById("formTitleText");
        const recordId = document.getElementById("recordId");
        const imagePreview = document.getElementById("imagePreview");
        const statusField = document.getElementById("statusField");
        const statusNote = document.getElementById("statusNote");
        const passwordFieldsContainer = document.getElementById("passwordFieldsContainer");
        const confirmPasswordContainer = document.getElementById("confirmPasswordContainer");
        const passwordRequired = document.getElementById("passwordRequired");
        const confirmPasswordRequired = document.getElementById("confirmPasswordRequired");

        // Auto-fill employee_id from email
        const emailInput = document.querySelector('input[name="email"]');
        if (emailInput) {
            emailInput.addEventListener('input', function() {
                const emailValue = this.value;
                document.querySelector('input[name="employee_id"]').value = emailValue;
            });
        }

        // Show form for Add
        document.getElementById("openFormBtn").addEventListener("click", () => {
            formTitle.innerText = "Add New Coordinator";
            isEditing = false;
            recordId.value = "";
            document.getElementById("coordinatorForm").reset();
            $("#file-name").text("Choose file...");
            imagePreview.style.display = "none";
            imagePreview.src = "#";
            document.querySelector('input[name="employee_id"]').value = "";

            // Show password fields for add mode
            passwordFieldsContainer.style.display = "block";
            confirmPasswordContainer.style.display = "block";
            passwordRequired.style.display = "inline";
            confirmPasswordRequired.style.display = "inline";
            document.getElementById("password").removeAttribute("disabled");
            document.getElementById("confirm_password").removeAttribute("disabled");
            document.getElementById("password").setAttribute("data-validation", "required min");
            document.getElementById("confirm_password").setAttribute("data-validation", "required min");

            // Enable status field and set default to Active for new coordinators
            statusField.disabled = false;
            statusField.classList.remove("disabled-field");
            statusNote.style.display = "none";
            $('select[name="status"]').val('Active');

            $("#imageRequiredLabel").text("(Optional)");
            $("#imageHelpText").show();
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            addFormDiv.style.display = "block";
            // Smooth scroll to form
            addFormDiv.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        });

        // Cancel form
        document.getElementById("cancelForm").addEventListener("click", () => {
            addFormDiv.style.display = "none";
            resetFormFields();
        });

        function resetFormFields() {
            document.getElementById("coordinatorForm").reset();
            $("#file-name").text("Choose file...");
            imagePreview.style.display = "none";
            imagePreview.src = "#";
            recordId.value = "";
            statusField.disabled = false;
            statusNote.style.display = "none";
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
        }

        // Image preview logic
        $("#imageUpload").on("change", function() {
            const file = this.files[0];
            if (file) {
                $("#file-name").text(file.name);
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = "block";
                };
                reader.readAsDataURL(file);
            } else {
                $("#file-name").text("Choose file...");
                imagePreview.style.display = "none";
            }
        });

        // Edit coordinator
        window.editUser = function(id) {
            const user = coordinatorData.find(u => u.id == id);
            if (!user) return;
            isEditing = true;
            recordId.value = id;
            formTitle.innerText = "Edit Coordinator";

            $('input[name="full_name"]').val(user.full_name || '');
            $('input[name="employee_id"]').val(user.employee_id || user.email || '');
            $('input[name="email"]').val(user.email || '');
            $('input[name="phone"]').val(user.phone || '');
            $('select[name="gender"]').val(user.gender || '');
            $('input[name="branch"]').val(user.branch || '');
            $('input[name="school"]').val(user.school || '');

            // Hide password fields for edit mode
            passwordFieldsContainer.style.display = "none";
            confirmPasswordContainer.style.display = "none";
            passwordRequired.style.display = "none";
            confirmPasswordRequired.style.display = "none";
            document.getElementById("password").setAttribute("disabled", "disabled");
            document.getElementById("confirm_password").setAttribute("disabled", "disabled");
            document.getElementById("password").removeAttribute("data-validation");
            document.getElementById("confirm_password").removeAttribute("data-validation");

            // Disable status field in edit mode - status can only be changed from card
            statusField.disabled = true;
            statusField.classList.add("disabled-field");
            statusNote.style.display = "block";
            $('select[name="status"]').val(user.status || 'Active');

            if (user.profile_image && user.profile_image !== '') {
                imagePreview.src = user.profile_image;
                imagePreview.style.display = "block";
                const fileNameHint = user.profile_image.split('/').pop();
                $("#file-name").text("Current: " + fileNameHint);
            } else {
                imagePreview.style.display = "none";
                $("#file-name").text("Choose file...");
            }

            $("#imageRequiredLabel").text("(Optional)");
            $("#imageHelpText").show();
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            addFormDiv.style.display = "block";
            addFormDiv.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        };

        // Toggle status
        window.toggleStatus = function(id) {
            if (confirm("Change status of this coordinator?")) {
                window.location.href = "?toggle_id=" + id;
            }
        };

        // Delete user
        window.deleteUser = function(id) {
            if (confirm("Delete coordinator permanently?")) {
                window.location.href = "?delete_id=" + id;
            }
        };

        // View user
        window.viewUser = function(id) {
            const user = coordinatorData.find(u => u.id == id);
            if (!user) return;
            const vImage = document.getElementById("v_profile_image");
            vImage.src = user.profile_image && user.profile_image !== '' ? user.profile_image : 'https://via.placeholder.com/130x130?text=No+Image';

            const fields = ['id', 'employee_id', 'full_name', 'email', 'phone', 'gender', 'branch', 'school', 'status', 'role'];
            fields.forEach(f => {
                const span = document.getElementById("v_" + f);
                if (span) span.innerText = user[f] || '-';
            });
            new bootstrap.Modal(document.getElementById("viewModal")).show();
        };

        // Render cards (without pagination)
        function renderCards() {
            const grid = document.getElementById("coordinatorGrid");
            grid.innerHTML = "";
            const searchTerm = document.getElementById("searchInput").value.toLowerCase();
            const filtered = coordinatorData.filter(c =>
                (c.full_name && c.full_name.toLowerCase().includes(searchTerm)) ||
                (c.email && c.email.toLowerCase().includes(searchTerm)) ||
                (c.branch && c.branch.toLowerCase().includes(searchTerm))
            );

            if (filtered.length === 0) {
                grid.innerHTML = `<div style="grid-column:1/-1; text-align:center; padding:60px 20px;">
                <i class="bi bi-person-x fs-1" style="color: #ddd;"></i>
                <h5 class="mt-3 text-muted">No coordinators found</h5>
                <p class="text-muted">Try adjusting your search or add a new coordinator</p>
            </div>`;
                return;
            }

            filtered.forEach(c => {
                const profileImg = (c.profile_image && c.profile_image !== '') ? c.profile_image : 'https://via.placeholder.com/120x120?text=Profile';
                const statusClass = (c.status === 'Active') ? 'btn-status-active' : 'btn-status-inactive';
                const statusText = c.status || 'Inactive';
                const card = document.createElement("div");
                card.className = "profile-card";
                card.innerHTML = `
                <div class="card-badge">
                    <button class="btn-status ${statusClass}" onclick="toggleStatus(${c.id})">${statusText}</button>
                </div>
                <div class="card-img-top-wrapper">
                    <img src="${profileImg}" class="card-img-circle" alt="${escapeHtml(c.full_name)}" onerror="this.src='https://via.placeholder.com/120x120?text=No+Image'">
                </div>
                <div class="card-body-custom">
                    <div class="coordinator-name">${escapeHtml(c.full_name) || 'Unnamed'}</div>
                    <div class="coordinator-email"><i class="far fa-envelope me-1"></i> ${escapeHtml(c.email) || '-'}</div>
                    <div class="info-row"><i class="fas fa-graduation-cap"></i> <span>${escapeHtml(c.branch) || '—'}</span></div>
                    <div class="info-row"><i class="fas fa-school"></i> <span>${escapeHtml(c.school) || '—'}</span></div>
                    <div class="info-row"><i class="fas fa-phone-alt"></i> <span>${escapeHtml(c.phone) || '—'}</span></div>
                    <div class="card-actions">
                        <button class="card-action-btn" onclick="viewUser(${c.id})"><i class="fas fa-eye"></i> View</button>
                        <button class="card-action-btn" onclick="editUser(${c.id})"><i class="fas fa-edit"></i> Edit</button>
                        <button class="card-action-btn" onclick="deleteUser(${c.id})"><i class="fas fa-trash-alt"></i> Del</button>
                    </div>
                </div>
            `;
                grid.appendChild(card);
            });
        }

        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/[&<>]/g, function(m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }

        document.getElementById("searchInput").addEventListener("keyup", () => {
            renderCards();
        });

        // Password validation function
        function validatePasswordMatch() {
            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("confirm_password").value;
            const errorSpan = document.getElementById("confirm_password_error");
            
            if (!isEditing && confirmPassword !== "") {
                if (password !== confirmPassword) {
                    errorSpan.text("Passwords do not match!");
                    document.getElementById("confirm_password").classList.add("is-invalid");
                    document.getElementById("confirm_password").classList.remove("is-valid");
                    return false;
                } else {
                    errorSpan.text("");
                    document.getElementById("confirm_password").classList.remove("is-invalid");
                    document.getElementById("confirm_password").classList.add("is-valid");
                    return true;
                }
            }
            return true;
        }

        // Validation
        function validateInput(input) {
            let field = $(input);
            let val = field.val()?.trim() || "";
            let errorSpan = $("#" + field.attr("name") + "_error");
            let rules = field.data("validation") || "";
            let msg = "";

            if (rules.includes("required") && val === "") msg = "This field is required.";
            if (!msg && val) {
                if (rules.includes("min") && val.length < (field.data("min") || 0)) msg = `Minimum ${field.data("min")} characters required.`;
                if (rules.includes("alphabetic") && !/^[a-zA-Z\s\.]+$/.test(val)) msg = "Only letters allowed.";
                if (rules.includes("email") && !/^[\w-\.]+@([\w-]+\.)+[\w]{2,4}$/.test(val)) msg = "Invalid email address.";
                if (rules.includes("number") && !/^[0-9+\-\s]+$/.test(val.replace(/[\s\+]/g, ''))) msg = "Please enter valid phone number.";
                if (rules.includes("select") && val === "") msg = "Please select an option.";
            }

            if (msg) {
                errorSpan.text(msg);
                field.addClass("is-invalid").removeClass("is-valid");
                return false;
            } else {
                errorSpan.text("");
                field.removeClass("is-invalid").addClass("is-valid");
                return true;
            }
        }

        $("input, select").on("input change", function() {
            if ($(this).attr("readonly")) return;
            if ($(this).attr("disabled")) return;
            validateInput(this);
            if ($(this).attr("name") === "password" || $(this).attr("name") === "confirm_password") {
                validatePasswordMatch();
            }
        });

        $("#coordinatorForm").on("submit", function(e) {
            let valid = true;
            
            // Skip validation for disabled fields
            $(this).find("input, select").each(function() {
                if ($(this).attr("readonly")) return true;
                if ($(this).attr("disabled")) return true;
                if (!validateInput(this)) valid = false;
            });
            
            // Validate password match only if not editing and password fields are visible
            if (!isEditing) {
                if (!validatePasswordMatch()) valid = false;
            }
            
            if (!valid) {
                e.preventDefault();
                return false;
            }
            return true;
        });

        // Escape key to close form
        $(document).keydown(function(e) {
            if (e.key === "Escape" && addFormDiv.style.display === "block") {
                addFormDiv.style.display = "none";
                resetFormFields();
            }
        });

        // Initial render
        renderCards();
    </script>
</body>

</html>