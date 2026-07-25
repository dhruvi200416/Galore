<?php include 'ad_co_profile_handler.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | RKU Galore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --galore-red: #dc3545;
            --galore-gray: #6c757d;
            --galore-dark: #333;
            --glass: rgba(255, 255, 255, 0.05);
        }

        /* ADD BUTTON */
        .btn-add-profile {
            background: linear-gradient(135deg, #ff4d5a, var(--galore-red));
            color: #fff;
            padding: 15px 22px;
            border: none;
            border-radius: 12px;
            font-size: 1.05rem;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .btn-add-profile:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(220, 53, 69, 0.45);
        }

        /* STATUS BUTTON STYLES */
        .btn-status {
            padding: 8px 15px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
            font-size: 0.9rem;
            min-width: 90px;
        }

        .btn-status:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .btn-status-inactive {
            background: linear-gradient(135deg, #6c757d, #495057);
            color: white;
        }

        .btn-status-active {
            background: linear-gradient(135deg, #198754, #157347);
            color: white;
        }

        /* FORM */
        .add-profile-form-container {
            background: #ffffff;
            width: 100%;
            max-width: 900px;
            margin: 30px auto;
            padding: 45px;
            border-radius: 18px;
            border-top: 6px solid var(--galore-red);
            box-shadow: 0 20px 45px rgba(220, 53, 69, 0.18);
            display: none;
        }

        .form-title {
            text-align: center;
            color: var(--galore-red);
            font-size: 2.2rem;
            margin-bottom: 25px;
            font-weight: 800;
        }

        #profileForm {
            display: grid;
            grid-template-columns: 1fr;
            gap: 18px;
        }

        @media (min-width: 768px) {
            #profileForm {
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
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--galore-gray);
            margin-bottom: 6px;
            text-transform: uppercase;
        }

        .galore-input,
        .galore-select {
            padding: 13px 15px;
            border: 2px solid #ddd;
            border-radius: 10px;
            font-size: 0.95rem;
        }

        .galore-input:focus,
        .galore-select:focus {
            outline: none;
            border-color: var(--galore-red);
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.15);
        }

        /* Disabled select styling */
        .galore-select:disabled {
            background-color: #e9ecef;
            cursor: not-allowed;
            opacity: 0.7;
        }

        /* Image preview styling */
        .image-preview-container {
            margin-top: 10px;
            text-align: center;
        }

        .image-preview {
            max-width: 100px;
            max-height: 100px;
            border-radius: 50%;
            border: 3px solid var(--galore-red);
            object-fit: cover;
            display: none;
        }

        .file-input-wrapper {
            position: relative;
        }

        .custom-file-upload {
            display: inline-block;
            padding: 13px 15px;
            background: #f8f9fa;
            border: 2px solid #ddd;
            border-radius: 10px;
            cursor: pointer;
            width: 100%;
            text-align: left;
            color: var(--galore-gray);
        }

        .custom-file-upload i {
            margin-right: 8px;
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

        .form-buttons {
            display: flex;
            justify-content: center;
            gap: 12px;
        }

        .btn-save {
            background: linear-gradient(135deg, #ff4d5a, var(--galore-red));
            color: white;
            padding: 15px 22px;
            border-radius: 12px;
            font-weight: bold;
            border: none;
        }

        .btn-cancel {
            background: #6c757d;
            color: white;
            padding: 15px 22px;
            border-radius: 12px;
            font-weight: bold;
            border: none;
        }

        /* TABLE CONTAINER */
        .data-table-container {
            background: #ffffff;
            padding: 30px;
            border-radius: 18px;
            border-top: 6px solid var(--galore-red);
            box-shadow: 0 20px 45px rgba(220, 53, 69, 0.18);
            margin-top: 30px;
            width: 100%;
            overflow-x: auto;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .table-header h2 {
            color: var(--galore-red);
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
        }

        .search-box {
            position: relative;
            min-width: 250px;
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
            border: 2px solid #ddd;
            border-radius: 10px;
            font-size: 0.95rem;
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--galore-red);
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.15);
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table thead {
            background: rgba(220, 53, 69, 0.1);
        }

        .data-table th {
            padding: 15px;
            text-align: left;
            font-weight: 700;
            color: var(--galore-red);
            border-bottom: 2px solid var(--galore-red);
        }

        .data-table td {
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
            vertical-align: middle;
        }

        .data-table tbody tr:hover {
            background: rgba(220, 53, 69, 0.1);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--galore-red);
        }

        .action-btn {
            padding: 8px 15px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
            margin-right: 8px;
            margin-bottom: 5px;
        }

        .action-btn:last-child {
            margin-right: 0;
        }

        .action-btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .main-content {
            padding: 30px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .top-bar {
            background: #ffffff;
            padding: 25px;
            border-radius: 18px;
            border-top: 6px solid var(--galore-red);
            box-shadow: 0 20px 45px rgba(220, 53, 69, 0.18);
            margin-bottom: 30px;
        }

        .top-bar h1 {
            color: var(--galore-red);
            font-size: 2rem;
            font-weight: 800;
            margin: 0;
        }

        .pagination-container {
            margin-top: 25px;
            display: flex;
            justify-content: center;
        }

        .pagination .page-link {
            color: var(--galore-red);
            border: 1px solid #dee2e6;
            margin: 0 2px;
            border-radius: 8px;
            padding: 8px 15px;
        }

        .pagination .active .page-link {
            background: var(--galore-red);
            color: white;
            border-color: var(--galore-red);
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            background: #f8f9fa;
        }

        /* Validation Styles */
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
    </style>
</head>

<body>

    <?php require 'ad_co_header.php'; ?>

    <main class="main-content">

        <div class="top-bar d-flex justify-content-between align-items-center mb-3">
            <h1>Co-coordinator Profiles</h1>
            <button class="btn-add-profile" id="openFormBtn">
                <i class="bi bi-plus-circle"></i> Add New Profile
            </button>
        </div>

        <!-- ADD / EDIT PROFILE FORM -->
        <div class="add-profile-form-container" id="addProfileForm" style="display:none;">
            <h3 class="form-title" id="formTitleText">Add New Co-coordinator Profile</h3>

            <form id="profileForm" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="edit_id" id="edit_id" value="">

                <div class="galore-input-group">
                    <label class="galore-label">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="full_name" class="galore-input" data-validation="required min alphabetic" data-min="3" data-max="50" placeholder="Enter full name">
                    <span id="full_name_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="galore-input" data-validation="required email" placeholder="Enter email address">
                    <span id="email_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Phone <span class="text-danger">*</span></label>
                    <input type="tel" name="phone" class="galore-input" data-validation="required min numeric" data-min="10" placeholder="Enter phone number">
                    <span id="phone_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Branch <span class="text-danger">*</span></label>
                    <input type="text" name="branch" class="galore-input" data-validation="required min" data-min="3" placeholder="Enter branch">
                    <span id="branch_error" class="error-message"></span>
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
                    <label class="galore-label">Role <span class="text-danger">*</span></label>
                    <select name="role" id="roleSelect" class="galore-input" data-validation="required select">
                        <option value="">Select Role</option>
                        <option value="Admin">Admin</option>
                        <option value="Coordinator">Coordinator</option>
                        <option value="Co-coordinator" selected>Co-coordinator</option>
                    </select>
                    <span id="role_error" class="error-message"></span>
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
                    </select>
                    <span id="school_error" class="error-message"></span>
                </div>

                <!-- Coordinator Role Field - Event Names Dropdown -->
                <div class="galore-input-group" id="coordinatorRoleGroup" style="display: none;">
                    <label class="galore-label">Coordinator Role (Event Name) <span id="coordinatorRoleRequired" class="text-danger">*</span></label>
                    <select name="coordinator_role" id="coordinator_role" class="galore-select" data-validation="select">
                        <option value="">Select Event</option>
                        <option value="Cricket">Cricket</option>
                        <option value="Football">Football</option>
                        <option value="Volleyball">Volleyball</option>
                        <option value="Basketball">Basketball</option>
                        <option value="Badminton">Badminton</option>
                        <option value="Table Tennis">Table Tennis</option>
                        <option value="Chess">Chess</option>
                        <option value="Carrom">Carrom</option>
                        <option value="Athletics">Athletics</option>
                        <option value="Kabaddi">Kabaddi</option>
                        <option value="Kho-Kho">Kho-Kho</option>
                        <option value="Singing">Singing</option>
                        <option value="Dancing">Dancing</option>
                        <option value="Rangoli">Rangoli</option>
                        <option value="Debate">Debate</option>
                        <option value="Quiz">Quiz</option>
                        <option value="Drama">Drama</option>
                        <option value="Painting">Painting</option>
                        <option value="Photography">Photography</option>
                    </select>
                    <span id="coordinator_role_error" class="error-message"></span>
                    <small class="text-muted">Select the event this co-coordinator is responsible for</small>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="galore-input" data-validation="required select" id="statusSelect">
                        <option value="">Select Status</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                    <span id="status_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" id="password" class="galore-input" data-validation="required" placeholder="Enter password">
                    <span id="password_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Confirm Password <span class="text-danger">*</span></label>
                    <input type="password" name="confirm_password" id="confirm_password" class="galore-input" data-validation="required" placeholder="Confirm password">
                    <span id="confirm_password_error" class="error-message"></span>
                </div>

                <div class="galore-input-group full-width">
                    <label class="galore-label">Profile Image</label>
                    <div class="file-input-wrapper">
                        <div class="custom-file-upload">
                            <i class="bi bi-camera"></i>
                            <span id="file-name">Choose file...</span>
                        </div>
                        <input type="file" name="profile_pic" accept="image/*" id="profile_pic">
                    </div>
                    <span id="profile_pic_error" class="error-message"></span>
                    <div class="image-preview-container">
                        <img id="imagePreview" class="image-preview" src="#" alt="Profile Preview">
                    </div>
                </div>

                <div class="form-buttons">
                    <button type="submit" name="submit_c_profile" class="btn-save">Save Profile</button>
                    <button type="button" class="btn-cancel" id="cancelForm">Cancel</button>
                </div>
            </form>
        </div>

        <!-- DATA TABLE -->
        <div class="data-table-container">
            <div class="table-header">
                <h2>Registered Co-coordinators</h2>
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchInput" placeholder="Search by name or email...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Branch</th>
                            <th>Event Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </thead>
                    <tbody id="tableBody"></tbody>
                </table>
            </div>

            <div class="pagination-container">
                <ul class="pagination" id="pagination"></ul>
            </div>
        </div>

    </main>

    <!-- VIEW MODAL -->
    <div class="modal fade" id="viewModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius:18px;border-top:6px solid var(--galore-red);">
                <div class="modal-header text-white" style="background:var(--galore-red);">
                    <h5 class="modal-title fw-bold"><i class="fas fa-user-friends me-2"></i>Co-coordinator Full Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body text-center">
                    <img id="v_profile_pic" src="" alt="Profile" style="width:100px;height:100px;border-radius:50%;border:3px solid var(--galore-red);margin-bottom:15px;display:none;">
                    <div class="row g-2 text-start">
                        <div class="col-sm-6"><b>ID:</b> <span id="v_id"></span></div>
                        <div class="col-sm-6"><b>Full Name:</b> <span id="v_full_name"></span></div>
                        <div class="col-sm-6"><b>Email:</b> <span id="v_email"></span></div>
                        <div class="col-sm-6"><b>Phone:</b> <span id="v_phone"></span></div>
                        <div class="col-sm-6"><b>Branch:</b> <span id="v_branch"></span></div>
                        <div class="col-sm-6"><b>Gender:</b> <span id="v_gender"></span></div>
                        <div class="col-sm-6"><b>Role:</b> <span id="v_role"></span></div>
                        <div class="col-sm-6"><b>School:</b> <span id="v_school"></span></div>
                        <div class="col-sm-12"><b>Event Role:</b> <span id="v_coordinator_role"></span></div>
                        <div class="col-sm-6"><b>Status:</b> <span id="v_status"></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Store all profiles from PHP
        let allProfiles = <?php echo json_encode($allProfiles); ?>;
        let currentPage = 1;
        const rowsPerPage = 5;

        const addProfileForm = document.getElementById("addProfileForm");
        const formTitleText = document.getElementById("formTitleText");
        const imagePreview = document.getElementById("imagePreview");
        const fileNameSpan = document.getElementById("file-name");
        const statusSelect = document.getElementById("statusSelect");
        const coordinatorRoleGroup = document.getElementById("coordinatorRoleGroup");

        // Function to toggle coordinator role field visibility based on role selection
        function toggleCoordinatorRoleField() {
            const roleSelect = document.getElementById("roleSelect");
            if (roleSelect && coordinatorRoleGroup) {
                if (roleSelect.value === 'Co-coordinator') {
                    coordinatorRoleGroup.style.display = "flex";
                } else {
                    coordinatorRoleGroup.style.display = "none";
                    document.getElementById("coordinator_role").value = "";
                }
            }
        }

        // STATUS TOGGLE FUNCTION
        window.toggleStatus = function(id) {
            if (confirm('Are you sure you want to change the status of this co-coordinator?')) {
                window.location.href = "?toggle_status_id=" + id;
            }
        };

        // Open form for adding new profile
        document.getElementById("openFormBtn").addEventListener("click", () => {
            formTitleText.textContent = "Add New Co-coordinator Profile";
            document.getElementById("edit_id").value = "";
            document.getElementById("profileForm").reset();
            imagePreview.style.display = "none";
            fileNameSpan.textContent = "Choose file...";
            
            if (statusSelect) statusSelect.disabled = false;
            $('select[name="status"]').val('Active');
            $('select[name="role"]').val('Co-coordinator');
            toggleCoordinatorRoleField();
            
            $("input[name='password']").attr("data-validation", "required");
            $("input[name='confirm_password']").attr("data-validation", "required");
            
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            addProfileForm.style.display = "block";
            addProfileForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });

        // Cancel form
        document.getElementById("cancelForm").addEventListener("click", () => {
            addProfileForm.style.display = "none";
            document.getElementById("profileForm").reset();
            document.getElementById("edit_id").value = "";
            imagePreview.style.display = "none";
            fileNameSpan.textContent = "Choose file...";
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            if (statusSelect) statusSelect.disabled = false;
        });

        // Image preview
        document.getElementById("profile_pic").addEventListener("change", function(e) {
            const fileName = this.files[0] ? this.files[0].name : "Choose file...";
            fileNameSpan.textContent = fileName;

            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = "block";
                }
                reader.readAsDataURL(this.files[0]);
            } else {
                imagePreview.style.display = "none";
            }
        });

        // Role change event
        $("#roleSelect").on("change", function() {
            toggleCoordinatorRoleField();
        });

        // Edit profile function
        window.editProfile = function(id) {
            const profile = allProfiles.find(p => p.id == id);
            if (profile) {
                formTitleText.textContent = "Edit Co-coordinator Profile";
                document.getElementById("edit_id").value = profile.id;

                document.getElementById("profileForm").full_name.value = profile.full_name;
                document.getElementById("profileForm").email.value = profile.email;
                document.getElementById("profileForm").phone.value = profile.phone;
                document.getElementById("profileForm").branch.value = profile.branch;
                document.getElementById("profileForm").gender.value = profile.gender;
                document.getElementById("profileForm").role.value = profile.role;
                document.getElementById("profileForm").school.value = profile.school;
                document.getElementById("coordinator_role").value = profile.coordinator_role || '';
                document.getElementById("profileForm").status.value = profile.status;
                document.getElementById("profileForm").password.value = '';
                document.getElementById("profileForm").confirm_password.value = '';

                toggleCoordinatorRoleField();

                if (statusSelect) statusSelect.disabled = true;

                $("input[name='password']").attr("data-validation", "");
                $("input[name='confirm_password']").attr("data-validation", "");

                if (profile.profile_pic) {
                    imagePreview.src = profile.profile_pic;
                    imagePreview.style.display = "block";
                    fileNameSpan.textContent = "Current image: " + profile.profile_pic.split('/').pop();
                } else {
                    imagePreview.style.display = "none";
                    fileNameSpan.textContent = "Choose file...";
                }

                $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
                $(".error-message").text("");

                addProfileForm.style.display = "block";
                addProfileForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        };

        // Delete profile function
        window.deleteProfile = function(id) {
            if (confirm("Are you sure you want to delete this profile? This action cannot be undone.")) {
                window.location.href = "?delete_id=" + id;
            }
        };

        // View profile function
        window.viewProfile = function(profile) {
            document.getElementById("v_id").textContent = profile.id;
            document.getElementById("v_full_name").textContent = profile.full_name;
            document.getElementById("v_email").textContent = profile.email;
            document.getElementById("v_phone").textContent = profile.phone;
            document.getElementById("v_branch").textContent = profile.branch;
            document.getElementById("v_gender").textContent = profile.gender;
            document.getElementById("v_role").textContent = profile.role;
            document.getElementById("v_school").textContent = profile.school;
            document.getElementById("v_coordinator_role").textContent = profile.coordinator_role || 'N/A';
            
            let statusClass = profile.status === 'Active' ? 'btn-status-active' : 'btn-status-inactive';
            document.getElementById("v_status").innerHTML = `<button class="btn-status ${statusClass}" style="cursor:default;">${profile.status}</button>`;
            
            if (profile.profile_pic) {
                document.getElementById("v_profile_pic").src = profile.profile_pic;
                document.getElementById("v_profile_pic").style.display = "inline-block";
            } else {
                document.getElementById("v_profile_pic").style.display = "none";
            }
            
            new bootstrap.Modal(document.getElementById("viewModal")).show();
        };

        // Render table with pagination
        function renderTable() {
            const tbody = document.getElementById("tableBody");
            tbody.innerHTML = "";

            const searchTerm = document.getElementById("searchInput").value.toLowerCase();
            const filteredData = allProfiles.filter(p =>
                (p.full_name && p.full_name.toLowerCase().includes(searchTerm)) ||
                (p.email && p.email.toLowerCase().includes(searchTerm)) ||
                (p.phone && p.phone.toLowerCase().includes(searchTerm))
            );

            const start = (currentPage - 1) * rowsPerPage;
            const paginatedData = filteredData.slice(start, start + rowsPerPage);

            if (paginatedData.length === 0) {
                tbody.innerHTML = `<tr><td colspan="9" class="text-center py-4">
                    <i class="bi bi-inbox fs-1 d-block mb-3" style="color: #ddd;"></i>
                    <h5 style="color: #999;">No data found</h5>
                </td></tr>`;
            } else {
                paginatedData.forEach(p => {
                    const imageHtml = p.profile_pic ?
                        `<img src="${p.profile_pic}" class="user-avatar" alt="Profile">` :
                        `<div class="user-avatar" style="background:var(--galore-gray);display:flex;align-items:center;justify-content:center;color:white;">${(p.full_name ? p.full_name.charAt(0) : '?')}</div>`;

                    let statusClass = p.status === 'Active' ? 'btn-status-active' : 'btn-status-inactive';

                    tbody.innerHTML += `
                        <tr>
                            <td>${p.id}</td>
                            <td>${imageHtml}</td>
                            <td><strong>${escapeHtml(p.full_name)}</strong></td>
                            <td>${escapeHtml(p.email)}</td>
                            <td>${escapeHtml(p.phone)}</td>
                            <td>${escapeHtml(p.branch)}</td>
                            <td><span class="badge bg-info">${escapeHtml(p.coordinator_role) || '—'}</span></td>
                            <td>
                                <button class="btn-status ${statusClass}" onclick="toggleStatus(${p.id})">
                                    ${p.status}
                                </button>
                            </td>
                            <td>
                                <div class="d-flex flex-column flex-sm-row gap-2">
                                    <button class="action-btn btn-view" onclick='viewProfile(${JSON.stringify(p).replace(/'/g, "\\'")})'>View</button>
                                    <button class="action-btn btn-edit" onclick="editProfile(${p.id})"> Edit</button>
                                    <button class="action-btn btn-delete" onclick="deleteProfile(${p.id})"> Delete</button>
                                </div>
                            </td>
                        </tr>
                    `;
                });
            }

            renderPagination(filteredData.length);
        }

        function renderPagination(totalRows) {
            const totalPages = Math.ceil(totalRows / rowsPerPage);
            const pagination = document.getElementById("pagination");
            pagination.innerHTML = "";

            if (totalPages === 0 || totalRows === 0) {
                pagination.innerHTML = '<li class="page-item disabled"><a class="page-link">No data</a></li>';
                return;
            }

            pagination.innerHTML += `<li class="page-item ${currentPage === 1 ? "disabled" : ""}">
                <a class="page-link" href="#" onclick="goPage(${currentPage - 1})">Previous</a>
            </li>`;

            for (let i = 1; i <= totalPages; i++) {
                pagination.innerHTML += `<li class="page-item ${i === currentPage ? "active" : ""}">
                    <a class="page-link" href="#" onclick="goPage(${i})">${i}</a>
                </li>`;
            }

            pagination.innerHTML += `<li class="page-item ${currentPage === totalPages ? "disabled" : ""}">
                <a class="page-link" href="#" onclick="goPage(${currentPage + 1})">Next</a>
            </li>`;
        }

        function goPage(page) {
            const searchTerm = document.getElementById("searchInput").value.toLowerCase();
            const filteredData = allProfiles.filter(p =>
                (p.full_name && p.full_name.toLowerCase().includes(searchTerm)) ||
                (p.email && p.email.toLowerCase().includes(searchTerm)) ||
                (p.phone && p.phone.toLowerCase().includes(searchTerm))
            );
            const totalPages = Math.ceil(filteredData.length / rowsPerPage);
            if (page < 1 || page > totalPages) return;
            currentPage = page;
            renderTable();
        }

        $("#searchInput").on("keyup", function() {
            currentPage = 1;
            renderTable();
        });

        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/[&<>]/g, function(m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }

        // VALIDATION SCRIPT
        $(document).ready(function() {
            function validateInput(input) {
                var field = $(input);
                var value = field.val() ? field.val().trim() : "";
                var errorfield = $("#" + field.attr("name") + "_error");
                var validationType = field.data("validation");
                var minLength = field.data("min") || 0;
                let errorMessage = "";

                // Special handling for password fields in edit mode
                if (field.attr("name") === "confirm_password" || field.attr("name") === "password") {
                    var editId = $("#edit_id").val();
                    var password = $("input[name='password']").val();
                    var confirm = $("input[name='confirm_password']").val();
                    
                    if (editId && editId !== "") {
                        if ((password !== "" || confirm !== "") && password !== confirm) {
                            errorMessage = "Passwords do not match.";
                        }
                    } else {
                        if (field.attr("name") === "password" && value === "") {
                            errorMessage = "Password is required.";
                        } else if (field.attr("name") === "confirm_password" && value === "") {
                            errorMessage = "Confirm password is required.";
                        } else if (password !== confirm) {
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
                    if (validationType.includes("required") && value === "") {
                        errorMessage = "This field is required.";
                    }

                    if (value !== "" && !errorMessage) {
                        if (validationType.includes("min") && value.length < minLength) {
                            errorMessage = `This field must be at least ${minLength} characters long.`;
                        }
                        if (validationType.includes('alphabetic') && !/^[a-zA-Z\s]+$/.test(value)) {
                            errorMessage = "Please enter alphabetic characters only.";
                        }
                        if (validationType.includes("numeric") && !/^[0-9]+$/.test(value)) {
                            errorMessage = "Please enter numbers only.";
                        }
                        if (validationType.includes("email") && !/^[\w-\.]+@([\w-]+\.)+[\w]{2,4}$/.test(value)) {
                            errorMessage = "Please enter a valid email address.";
                        }
                        if (validationType.includes("select") && value === "") {
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

                if (!isValid) {
                    e.preventDefault();
                    if (firstInvalidField) $(firstInvalidField).focus();
                    return false;
                }
                return true;
            });
            
            toggleCoordinatorRoleField();
        });

        renderTable();
    </script>
</body>

</html>