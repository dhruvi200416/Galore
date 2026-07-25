<?php
// Include the handler file which contains all PHP logic and database operations
include 'ad_home_coordinator_handler.php';
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

        /* FORM GRID */
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

        /* Image Preview Styling */
        .image-preview-container {
            margin-top: 10px;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid var(--galore-red);
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
        }

        .image-preview {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Table Image Styling */
        .table-image-container {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid var(--galore-red);
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
        }

        .table-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Modal Image Styling */
        .modal-image-container {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid var(--galore-red);
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
        }

        .modal-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
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

        /* ACTION BUTTONS */
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
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .top-bar h1 {
            color: var(--galore-red);
            font-size: 2rem;
            font-weight: 800;
            margin: 0;
        }

        /* File input styling */
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
        
        body {
            background: #f8f9fa;
        }
    </style>
</head>

<body>

    <?php require 'admin_header.php' ?>

    <main class="main-content">

        <div class="top-bar">
            <h1 class="mb-0">Home Coordinators Management</h1>
            <button class="btn-add-user" id="openFormBtn">
                <i class="bi bi-plus-circle"></i> Add New Coordinator
            </button>
        </div>

        <!-- ADD COORDINATOR FORM -->
        <div class="add-user-form-container" id="addCoordinatorForm" style="display:none;">
            <h3 class="form-title" id="formTitleText">Add New Coordinator</h3>

            <form id="coordinatorForm" method="POST" enctype="multipart/form-data" action="home_coordinators_handler.php">
                <input type="hidden" name="edit_id" id="edit_id" value="">

                <!-- IMAGE FIELD -->
                <div class="galore-input-group" id="imageFieldGroup">
                    <label class="galore-label">Image <span class="text-danger" id="imageRequired">*</span></label>
                    <div class="file-input-wrapper">
                        <div class="custom-file-upload">
                            <i class="bi bi-camera"></i>
                            <span id="file-name">Choose file...</span>
                        </div>
                        <input type="file" name="image" id="imageInput" class="galore-input" accept="image/*" data-validation="required">
                    </div>
                    <div class="image-preview-container" id="imagePreviewContainer" style="display:none;">
                        <img id="imagePreview" class="image-preview" src="#" alt="Preview">
                    </div>
                    <span id="image_error" class="error-message"></span>
                    <small class="text-muted mt-1" id="imageHelpText">Leave empty to keep existing image when editing</small>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="galore-input" data-validation="required min alphabetic" data-min="3" data-max="100">
                    <span id="name_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Role <span class="text-danger">*</span></label>
                    <input type="text" name="role" class="galore-input" data-validation="required min alphabetic" data-min="3" data-max="100">
                    <span id="role_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Phone <span class="text-danger">*</span></label>
                    <input type="text" name="phone" class="galore-input" data-validation="required min number" data-min="10" data-max="15">
                    <span id="phone_error" class="error-message"></span>
                </div>

                <div class="form-buttons">
                    <button type="submit" name="submit" class="btn-save">Save Coordinator</button>
                    <button type="button" class="btn-cancel" id="cancelForm">Cancel</button>
                </div>

            </form>
        </div>

        <!-- DATA TABLE -->
        <div class="data-table-container">
            <div class="table-header">
                <h2 class="mb-0">Home Coordinators Data</h2>
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchInput" placeholder="Search coordinators...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th id="actionsHeader">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="coordinatorTableBody"></tbody>
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
                    <h5 class="modal-title fw-bold">Coordinator Full Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body text-center">
                    <div id="v_image_container" class="modal-image-container" style="display:none;">
                        <img id="v_image" class="modal-image" src="#" alt="Coordinator">
                    </div>
                    <p><b>ID:</b> <span id="v_id"></span></p>
                    <p><b>Name:</b> <span id="v_name"></span></p>
                    <p><b>Role:</b> <span id="v_role"></span></p>
                    <p><b>Phone:</b> <span id="v_phone"></span></p>
                    <p><b>Status:</b> <span id="v_status"></span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Use PHP to pass database coordinators to JavaScript
        let coordinatorsData = <?php echo json_encode($coordinatorsData); ?>;

        // If no coordinators in database, use empty array
        if (!coordinatorsData || coordinatorsData.length === 0) {
            coordinatorsData = [];
        }

        const rowsPerPage = 5;
        let currentPage = 1;
        let editId = null;
        let currentImage = null;
        let isEditing = false;

        const addCoordinatorForm = $("#addCoordinatorForm");
        const formTitleText = $("#formTitleText");
        const imageInput = document.getElementById("imageInput");
        const imagePreview = document.getElementById("imagePreview");
        const imagePreviewContainer = document.getElementById("imagePreviewContainer");
        const imageRequired = $("#imageRequired");
        const imageHelpText = $("#imageHelpText");

        // File name display and image preview
        $("#imageInput").on("change", function() {
            const fileName = this.files[0] ? this.files[0].name : "Choose file...";
            $("#file-name").text(fileName);

            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    currentImage = e.target.result;
                    imagePreview.src = currentImage;
                    imagePreviewContainer.style.display = "flex";
                }
                reader.readAsDataURL(this.files[0]);
            }
            validateInput(this);
        });

        $("#openFormBtn").click(() => {
            formTitleText.text("Add New Coordinator");
            editId = null;
            isEditing = false;
            $("#edit_id").val("");
            $("#coordinatorForm")[0].reset();
            $("#file-name").text("Choose file...");
            imagePreviewContainer.style.display = "none";
            currentImage = null;
            
            // Update UI for add mode - make image required
            imageRequired.text("*");
            imageHelpText.hide();
            
            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            addCoordinatorForm.slideDown();
        });

        $("#cancelForm").click(() => {
            addCoordinatorForm.slideUp();
            $("#coordinatorForm")[0].reset();
            $("#edit_id").val("");
            $("#file-name").text("Choose file...");
            imagePreviewContainer.style.display = "none";
            currentImage = null;
            editId = null;
            isEditing = false;
            
            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
        });

        function renderTable() {
            let tbody = $("#coordinatorTableBody");
            tbody.html("");

            const searchValue = $("#searchInput").val().toLowerCase();
            const filteredData = coordinatorsData.filter(c =>
                String(c.name).toLowerCase().includes(searchValue) ||
                String(c.role).toLowerCase().includes(searchValue) ||
                String(c.phone).toLowerCase().includes(searchValue)
            );

            const start = (currentPage - 1) * rowsPerPage;
            const paginatedData = filteredData.slice(start, start + rowsPerPage);

            if (paginatedData.length === 0) {
                tbody.append(`
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <i class="bi bi-inbox fs-1 d-block mb-3" style="color: #ddd;"></i>
                            <h5 style="color: #999;">No data found</h5>
                        </td>
                    </tr>
                `);
            } else {
                paginatedData.forEach(c => {
                    const imageDisplay = c.image && c.image.trim() !== "" ? 
                        `<div class="table-image-container">
                            <img src="${c.image}" class="table-image" alt="${c.name}">
                        </div>` : 
                        "<div class='table-image-container' style='background:var(--galore-gray);color:white;font-size:20px;'><i class='bi bi-person-fill'></i></div>";

                    tbody.append(`
                    <tr>
                        <td>${c.id}</td>
                        <td>${imageDisplay}</td>
                        <td>${c.name}</td>
                        <td>${c.role}</td>
                        <td>
                            <button class="btn-status ${c.status === 'Active' ? 'btn-status-active' : 'btn-status-inactive'}" 
                                    onclick="toggleStatus(${c.id})">
                                ${c.status}
                            </button>
                        </td>
                        <td>
                            <button class="action-btn btn-view" onclick="viewCoordinator(${c.id})">View</button>
                            <button class="action-btn btn-edit" onclick="editCoordinator(${c.id})">Edit</button>
                            <button class="action-btn btn-delete" onclick="deleteCoordinator(${c.id})">Delete</button>
                        </td>
                    </tr>`);
                });
            }

            renderPagination(filteredData.length);
        }

        function renderPagination(totalRows) {
            let totalPages = Math.ceil(totalRows / rowsPerPage);
            let pagination = $("#pagination");
            pagination.html("");

            if (totalPages === 0) {
                pagination.html("");
                return;
            }

            // Previous Button
            pagination.append(`
                <li class="page-item ${currentPage === 1 ? "disabled" : ""}">
                    <a class="page-link" href="#" onclick="goPage(${currentPage - 1})">Previous</a>
                </li>
            `);

            // Page Numbers
            for (let i = 1; i <= totalPages; i++) {
                pagination.append(`
                    <li class="page-item ${i === currentPage ? "active" : ""}">
                        <a class="page-link" href="#" onclick="goPage(${i})">${i}</a>
                    </li>
                `);
            }

            // Next Button
            pagination.append(`
                <li class="page-item ${currentPage === totalPages ? "disabled" : ""}">
                    <a class="page-link" href="#" onclick="goPage(${currentPage + 1})">Next</a>
                </li>
            `);
        }

        function goPage(page) {
            const searchValue = $("#searchInput").val().toLowerCase();
            const filteredData = coordinatorsData.filter(c =>
                String(c.name).toLowerCase().includes(searchValue) ||
                String(c.role).toLowerCase().includes(searchValue) ||
                String(c.phone).toLowerCase().includes(searchValue)
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

        /* TOGGLE STATUS FUNCTION - WITHOUT ALERT */
        function toggleStatus(id) {
            window.location.href = "ad_home_coordinator_handler.php?toggle_id=" + id;
        }

        // VALIDATION SCRIPT
        function validateInput(input) {
            var field = $(input);
            var value = field.val() ? field.val().trim() : "";
            var errorfield = $("#" + field.attr("name") + "_error");
            var validationType = field.data("validation");
            var minLength = field.data("min") || 0;
            var maxLength = field.data("max") || 9999;
            let errorMessage = "";
            var isFileInput = field.attr("type") === "file";

            if (validationType) {
                // Skip required validation for image when editing
                if (field.attr("name") === "image" && isEditing) {
                    errorfield.text("");
                    field.removeClass("is-invalid").addClass("is-valid");
                    return true;
                }
                
                if (validationType.includes("required")) {
                    if (isFileInput) {
                        // For file input, check if we're in edit mode
                        if (!isEditing && (!field[0].files || field[0].files.length === 0)) {
                            errorMessage = "This field is required.";
                        }
                    } else if (value === "" || value === "0" || value === null) {
                        errorMessage = "This field is required.";
                    }
                }

                if (value !== "" && !errorMessage && !isFileInput) {
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

                    // Add numeric validation for phone
                    if (validationType.includes("number")) {
                        var number_regex = /^[0-9+\-\s]+$/;
                        if (!number_regex.test(value)) {
                            errorMessage = "Please enter a valid phone number.";
                        }
                    }

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

        // Special handling for file input
        $("#imageInput").on("change", function() {
            var field = $(this);
            var errorfield = $("#image_error");
            
            if (isEditing) {
                // When editing, file is optional
                if (this.files && this.files.length > 0) {
                    errorfield.text("");
                    field.addClass("is-valid").removeClass("is-invalid");
                } else {
                    // No file selected when editing is fine - clear any errors
                    errorfield.text("");
                    field.removeClass("is-invalid is-valid");
                }
            } else {
                // When adding new, file is required
                if (!this.files || this.files.length === 0) {
                    errorfield.text("This field is required.");
                    field.addClass("is-invalid").removeClass("is-valid");
                } else {
                    errorfield.text("");
                    field.addClass("is-valid").removeClass("is-invalid");
                }
            }
        });

        // Form submission with validation
        $("#coordinatorForm").on("submit", function(e) {
            let isValid = true;
            let firstInvalidField = null;

            $(this).find("input, textarea, select").each(function() {
                // Skip validation for image when editing
                if ($(this).attr("name") === "image" && isEditing) {
                    return true;
                }
                
                if (!validateInput(this)) {
                    isValid = false;
                    if (!firstInvalidField) {
                        firstInvalidField = this;
                    }
                }
            });

            // Special validation for image field when adding new
            if (!isEditing) {
                const imageField = $("#imageInput");
                if (!imageField[0].files || imageField[0].files.length === 0) {
                    $("#image_error").text("This field is required.");
                    imageField.addClass("is-invalid").removeClass("is-valid");
                    isValid = false;
                    if (!firstInvalidField) {
                        firstInvalidField = imageField[0];
                    }
                }
            }

            if (!isValid) {
                e.preventDefault();
                if (firstInvalidField) {
                    $(firstInvalidField).focus();
                }
                return false;
            }

            return true;
        });

        function editCoordinator(id) {
            editId = id;
            isEditing = true;
            const coordinator = coordinatorsData.find(c => c.id == id);

            formTitleText.text("Edit Coordinator");
            $("#edit_id").val(id);

            // Fill form with coordinator data
            $('input[name="name"]').val(coordinator.name);
            $('input[name="role"]').val(coordinator.role);
            $('input[name="phone"]').val(coordinator.phone);

            // Handle image - show existing image but don't require new one
            if (coordinator.image) {
                currentImage = coordinator.image;
                imagePreview.src = currentImage;
                imagePreviewContainer.style.display = "flex";
                $("#file-name").text("Current image: " + coordinator.image.split('/').pop());
            }
            
            // Update UI for edit mode - make image optional
            imageRequired.text("(Optional)");
            imageHelpText.show();

            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");

            addCoordinatorForm.slideDown();
        }

        function deleteCoordinator(id) {
            if (confirm("Are you sure you want to delete this coordinator?")) {
                window.location.href = "ad_home_coordinator_handler.php?delete_id=" + id;
            }
        }

        function viewCoordinator(id) {
            const coordinator = coordinatorsData.find(c => c.id == id);
            if (coordinator) {
                $("#v_id").text(coordinator.id);
                
                // Handle image in modal
                const vImageContainer = $("#v_image_container");
                const vImage = $("#v_image");
                
                if (coordinator.image) {
                    vImage.attr("src", coordinator.image);
                    vImageContainer.show();
                } else {
                    vImageContainer.hide();
                }
                
                $("#v_name").text(coordinator.name);
                $("#v_role").text(coordinator.role);
                $("#v_phone").text(coordinator.phone);
                $("#v_status").text(coordinator.status);
                
                new bootstrap.Modal(document.getElementById("viewModal")).show();
            }
        }

        // Handle escape key to close form
        $(document).keydown(function(e) {
            if (e.key === "Escape" && addCoordinatorForm.is(":visible")) {
                addCoordinatorForm.slideUp();
                $("#coordinatorForm")[0].reset();
                $("#file-name").text("Choose file...");
                imagePreviewContainer.style.display = "none";
                editId = null;
                isEditing = false;
                currentImage = null;
                $('.is-valid, .is-invalid').removeClass('is-valid is-invalid');
                $('.error-message').text('');
            }
        });

        renderTable();
    </script>
</body>

</html>