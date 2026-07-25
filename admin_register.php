<?php
include 'admin_register_handler.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | RKU Galore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">


    <!-- FORM + TABLE CSS -->
    <style>
        :root {
            --galore-red: #dc3545;
            --galore-gray: #6c757d;
            --galore-dark: #333;
            --glass: rgba(255, 255, 255, 0.05);
        }

        /* ADD BUTTON */
        .btn-add-user {
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

        .btn-add-user:hover {
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

        .btn-status-active {
            background: linear-gradient(135deg, #28a745, #218838);
            color: white;
        }

        .btn-status-pending {
            background: linear-gradient(135deg, #ffc107, #e0a800);
            color: #333;
        }

        .btn-status-inactive {
            background: linear-gradient(135deg, #6c757d, #495057);
            color: white;
        }

        /* FORM */
        .add-user-form-container {
            background: #ffffff;
            width: 100%;
            max-width: 900px;
            margin: 30px auto;
            padding: 45px;
            border-radius: 18px;
            border-top: 6px solid var(--galore-red);
            box-shadow: 0 20px 45px rgba(220, 53, 69, 0.18);
        }

        .form-title {
            text-align: center;
            color: var(--galore-red);
            font-size: 2.2rem;
            margin-bottom: 25px;
            font-weight: 800;
        }

        /* ✅ FIXED GRID FORM */
        #userForm {
            display: grid;
            grid-template-columns: 1fr;
            gap: 18px;
        }

        @media (min-width: 768px) {
            #userForm {
                grid-template-columns: 1fr 1fr;
            }

            .form-buttons {
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

        .galore-input {
            padding: 13px 15px;
            border: 2px solid #ddd;
            border-radius: 10px;
            font-size: 0.95rem;
        }

        .galore-input:focus {
            outline: none;
            border-color: var(--galore-red);
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.15);
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

        /* TABLE CONTAINER WITH RED BORDER - ADDED CSS */
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

        @media (max-width: 991.98px) {
            /* Sidebar visibility styles would go here */
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

    <?php require 'admin_header.php' ?>

    <main class="main-content">

        <div class="top-bar d-flex justify-content-between align-items-center mb-3">
            <h1>User Management</h1>
            <button class="btn-add-user" id="openFormBtn">
                <i class="bi bi-plus-circle"></i> Add New User
            </button>
        </div>

        <!-- ADD USER FORM -->
        <div class="add-user-form-container" id="addUserForm" style="display:none;">
            <h3 class="form-title" id="formTitleText">Add New User</h3>

            <form id="userForm" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="edit_id" id="edit_id" value="">
                
                <div class="galore-input-group">
                    <label class="galore-label">Enrollment No</label>
                    <input type="text" name="enrollment_no" class="galore-input" data-validation="required" data-min="3" data-max="12" placeholder="Enter enrollment number">
                    <span id="enrollment_no_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Full Name</label>
                    <input type="text" name="full_name" class="galore-input" data-validation="required min alphabetic" data-min="3" data-max="50" placeholder="Enter full name">
                    <span id="full_name_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Email</label>
                    <input type="email" name="email" class="galore-input" data-validation="required email" data-max="100" placeholder="Enter email address">
                    <span id="email_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Phone</label>
                    <input type="tel" name="phone" class="galore-input" data-validation="required min numeric" data-min="10" data-max="15" placeholder="Enter phone number">
                    <span id="phone_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Branch</label>
                    <input type="text" name="branch" class="galore-input" data-validation="required alphabetic min" data-min="3" data-max="20" placeholder="Enter branch">
                    <span id="branch_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Semester</label>
                    <select name="semester" class="galore-input" data-validation="required select">
                        <option value="">Select Semester</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                    </select>
                    <span id="semester_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Gender</label>
                    <select name="gender" class="galore-input" data-validation="required select">
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                    <span id="gender_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">School</label>
                    <input type="text" name="school" class="galore-input" data-validation="required" data-min="3" data-max="20" placeholder="Enter school">
                    <span id="school_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Status</label>
                    <select name="status" class="galore-input" data-validation="required select">
                        <option value="">Select Status</option>
                        <option value="Active">Active</option>
                        <option value="Pending">Pending</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                    <span id="status_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Profile Image</label>
                    <div class="file-input-wrapper">
                        <div class="custom-file-upload">
                            <i class="bi bi-camera"></i>
                            <span id="file-name">Choose file...</span>
                        </div>
                        <input type="file" name="profile_pic" class="galore-input" accept="image/jpeg, image/png, image/jpg, image/gif" id="profile_pic">
                    </div>
                    <span id="profile_pic_error" class="error-message"></span>
                    <div class="image-preview-container">
                        <img id="imagePreview" class="image-preview" src="#" alt="Profile Preview">
                    </div>
                </div>

                <div class="form-buttons">
                    <button type="submit" name="submit" class="btn-save">Save</button>
                    <button type="button" class="btn-cancel" id="cancelForm">Cancel</button>
                </div>
            </form>
        </div>

        <!-- DATA TABLE -->
        <div class="data-table-container">
            <div class="table-header">
                <h2>Registered Users</h2>
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchInput" placeholder="Search users...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Enrollment No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <!-- <th>Phone</th>
                            <th>Branch</th>
                            <th>Semester</th>
                            <th>Gender</th> -->
                            <th>School</th>
                            <th>Status</th>
                            <!-- <th>Registration Date</th> -->
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody"></tbody>
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
                    <h5 class="modal-title fw-bold">User Full Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body text-center">
                    <img id="v_profile_pic" src="" alt="Profile" style="width:100px;height:100px;border-radius:50%;border:3px solid var(--galore-red);margin-bottom:15px;display:none;">
                    <p><b>ID:</b> <span id="v_id"></span></p>
                    <p><b>Enrollment:</b> <span id="v_enrollment_no"></span></p>
                    <p><b>Name:</b> <span id="v_full_name"></span></p>
                    <p><b>Email:</b> <span id="v_email"></span></p>
                    <p><b>Phone:</b> <span id="v_phone"></span></p>
                    <p><b>Branch:</b> <span id="v_branch"></span></p>
                    <p><b>Semester:</b> <span id="v_semester"></span></p>
                    <p><b>Gender:</b> <span id="v_gender"></span></p>
                    <p><b>School:</b> <span id="v_school"></span></p>
                    <p><b>Status:</b> <span id="v_status"></span></p>
                    <p><b>Registration Date:</b> <span id="v_registration_date"></span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Use PHP to pass database users to JavaScript
        let userData = <?php echo json_encode($users); ?>;

        // If no users in database, use empty array
        if (!userData || userData.length === 0) {
            userData = [];
        }

        const rowsPerPage = 5;
        let currentPage = 1;
        let editId = null;
        let isEditing = false;

        const addUserForm = document.getElementById("addUserForm");
        const formTitleText = document.getElementById("formTitleText");
        const imagePreview = document.getElementById("imagePreview");
        const fileNameSpan = document.getElementById("file-name");

        // ==================== STATUS TOGGLE FUNCTION ====================
        window.toggleStatus = function(id) {
            window.location.href = "?toggle_status_id=" + id;
        };

        document.getElementById("openFormBtn").addEventListener("click", () => {
            formTitleText.textContent = "Add New User";
            editId = null;
            isEditing = false;
            document.getElementById("edit_id").value = "";
            document.getElementById("userForm").reset();
            // Clear image preview
            imagePreview.style.display = "none";
            fileNameSpan.textContent = "Choose file...";
            // Clear all validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            addUserForm.style.display = "block";
        });

        document.getElementById("cancelForm").addEventListener("click", () => {
            addUserForm.style.display = "none";
            document.getElementById("userForm").reset();
            document.getElementById("edit_id").value = "";
            // Clear image preview
            imagePreview.style.display = "none";
            fileNameSpan.textContent = "Choose file...";
            // Clear all validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            editId = null;
            isEditing = false;
        });

        // Image preview and file name display
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

        function editUser(id) {
            editId = id;
            isEditing = true;
            const user = userData.find(u => u.id == id);

            formTitleText.textContent = "Edit User";
            document.getElementById("edit_id").value = id;

            document.getElementById("userForm").enrollment_no.value = user.enrollment_no;
            document.getElementById("userForm").full_name.value = user.full_name;
            document.getElementById("userForm").email.value = user.email;
            document.getElementById("userForm").phone.value = user.phone;
            document.getElementById("userForm").branch.value = user.branch;
            document.getElementById("userForm").semester.value = user.semester;
            document.getElementById("userForm").gender.value = user.gender;
            document.getElementById("userForm").school.value = user.school;
            document.getElementById("userForm").status.value = user.status;

            // Show existing image if available
            if (user.profile_pic) {
                imagePreview.src = user.profile_pic;
                imagePreview.style.display = "block";
                fileNameSpan.textContent = "Current image: " + user.profile_pic.split('/').pop();
            } else {
                imagePreview.style.display = "none";
                fileNameSpan.textContent = "Choose file...";
            }

            // Clear all validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");

            addUserForm.style.display = "block";
        }

        function deleteUser(id) {
            if (confirm("Are you sure you want to delete this user?")) {
                window.location.href = "?delete_id=" + id;
            }
        }

        function viewUser(id) {
            const user = userData.find(u => u.id == id);
            document.getElementById("v_id").textContent = user.id;
            document.getElementById("v_enrollment_no").textContent = user.enrollment_no;
            document.getElementById("v_full_name").textContent = user.full_name;
            document.getElementById("v_email").textContent = user.email;
            document.getElementById("v_phone").textContent = user.phone;
            document.getElementById("v_branch").textContent = user.branch;
            document.getElementById("v_semester").textContent = user.semester;
            document.getElementById("v_gender").textContent = user.gender;
            document.getElementById("v_school").textContent = user.school;
            document.getElementById("v_status").textContent = user.status;
            document.getElementById("v_registration_date").textContent = user.registration_date;
            
            if (user.profile_pic) {
                document.getElementById("v_profile_pic").src = user.profile_pic;
                document.getElementById("v_profile_pic").style.display = "inline-block";
            } else {
                document.getElementById("v_profile_pic").style.display = "none";
            }
            
            new bootstrap.Modal(document.getElementById("viewModal")).show();
        }

        function renderTable() {
            const tbody = document.getElementById("userTableBody");
            tbody.innerHTML = "";

            const searchTerm = document.getElementById("searchInput").value.toLowerCase();
            const filteredData = userData.filter(u =>
                u.full_name.toLowerCase().includes(searchTerm) ||
                u.enrollment_no.toLowerCase().includes(searchTerm) ||
                u.email.toLowerCase().includes(searchTerm) ||
                u.phone.toLowerCase().includes(searchTerm)
            );

            const start = (currentPage - 1) * rowsPerPage;
            const paginatedData = filteredData.slice(start, start + rowsPerPage);

            if (paginatedData.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="13" class="text-center py-4">
                            <i class="bi bi-inbox fs-1 d-block mb-3" style="color: #ddd;"></i>
                            <h5 style="color: #999;">No data found</h5>
                        </td>
                    </tr>
                `;
            } else {
                paginatedData.forEach(u => {
                    const imageHtml = u.profile_pic ?
                        `<img src="${u.profile_pic}" class="user-avatar" alt="Profile">` :
                        `<div class="user-avatar" style="background:var(--galore-gray);display:flex;align-items:center;justify-content:center;color:white;">${u.full_name.charAt(0)}</div>`;

                    let statusClass = '';
                    if (u.status === 'Active') {
                        statusClass = 'btn-status-active';
                    } else if (u.status === 'Pending') {
                        statusClass = 'btn-status-pending';
                    } else if (u.status === 'Inactive') {
                        statusClass = 'btn-status-inactive';
                    }

                    tbody.innerHTML += `
                    <tr>
                        <td>${u.id}</td>
                        <td>${imageHtml}</td>
                        <td>${u.enrollment_no}</td>
                        <td>${u.full_name}</td>
                        <td>${u.email}</td>
                        <!--<td>${u.phone}</td>
                        <td>${u.branch}</td>
                        <td>${u.semester}</td>
                        <td>${u.gender}</td>-->
                        <td>${u.school}</td>
                        <td>
                            <button class="btn-status ${statusClass}" onclick="toggleStatus(${u.id})">
                                ${u.status}
                            </button>
                        </td>
                        <!--<td>${u.registration_date ? new Date(u.registration_date).toLocaleDateString() : 'N/A'}</td>-->
                        <td>
                            <div class="d-flex flex-column flex-sm-row gap-2 gap-sm-2">
                                <button class="action-btn btn-view" onclick="viewUser(${u.id})">View</button>
                                <button class="action-btn btn-edit" onclick="editUser(${u.id})">Edit</button>
                                <button class="action-btn btn-delete" onclick="deleteUser(${u.id})">Delete</button>
                            </div>
                        </td>
                    </tr>`;
                });
            }

            renderPagination(filteredData.length);
        }

        function renderPagination(totalRows) {
            const totalPages = Math.ceil(totalRows / rowsPerPage);
            const pagination = document.getElementById("pagination");
            pagination.innerHTML = "";

            if (totalPages === 0) {
                pagination.innerHTML = '<li class="page-item disabled"><a class="page-link">No data</a></li>';
                return;
            }

            pagination.innerHTML += `
            <li class="page-item ${currentPage === 1 ? "disabled" : ""}">
                <a class="page-link" href="#" onclick="goPage(${currentPage - 1})">Previous</a>
            </li>`;

            for (let i = 1; i <= totalPages; i++) {
                pagination.innerHTML += `
                <li class="page-item ${i === currentPage ? "active" : ""}">
                    <a class="page-link" href="#" onclick="goPage(${i})">${i}</a>
                </li>`;
            }

            pagination.innerHTML += `
            <li class="page-item ${currentPage === totalPages ? "disabled" : ""}">
                <a class="page-link" href="#" onclick="goPage(${currentPage + 1})">Next</a>
            </li>`;
        }

        function goPage(page) {
            const searchTerm = document.getElementById("searchInput").value.toLowerCase();
            const filteredData = userData.filter(u =>
                u.full_name.toLowerCase().includes(searchTerm) ||
                u.enrollment_no.toLowerCase().includes(searchTerm) ||
                u.email.toLowerCase().includes(searchTerm) ||
                u.phone.toLowerCase().includes(searchTerm)
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

        // VALIDATION SCRIPT
        $(document).ready(function() {
            function validateInput(input) {
                var field = $(input);
                var value = field.val() ? field.val().trim() : "";
                var errorfield = $("#" + field.attr("name") + "_error");
                var validationType = field.data("validation");
                var minLength = field.data("min") || 0;
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

                        if (validationType.includes('alphabetic')) {
                            let alphabet_regex = /^[a-zA-Z\s]+$/;
                            if (!alphabet_regex.test(value)) {
                                errorMessage = "Please enter alphabetic characters only.";
                            }
                        }

                        if (validationType.includes("numeric")) {
                            let numeric_regex = /^[0-9]+$/;
                            if (!numeric_regex.test(value)) {
                                errorMessage = "Please enter numbers only.";
                            }
                        }

                        if (validationType.includes("email")) {
                            const emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w]{2,4}$/;
                            if (!emailRegex.test(value)) {
                                errorMessage = "Please enter a valid email address.";
                            }
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

            $("#userForm").on("submit", function(e) {
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
                    e.preventDefault();
                    if (firstInvalidField) {
                        $(firstInvalidField).focus();
                    }
                    return false;
                }

                return true;
            });
        });

        renderTable();
    </script>

</body>

</html>