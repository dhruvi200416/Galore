<?php
include 'ad_c_sch_handler.php';
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

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- FORM + TABLE CSS -->
    <style>
        :root {
            --galore-red: #dc3545;
            --galore-gray: #6c757d;
            --galore-dark: #333;
            --glass: rgba(255, 255, 255, 0.05);
        }

        /* ADD BUTTON */
        .btn-add-school {
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

        .btn-add-school:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(220, 53, 69, 0.45);
        }

        /* FORM */
        .add-school-form-container {
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

        #schoolForm {
            display: grid;
            grid-template-columns: 1fr;
            gap: 18px;
        }

        @media (min-width: 768px) {
            #schoolForm {
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

        .galore-textarea {
            padding: 13px 15px;
            border: 2px solid #ddd;
            border-radius: 10px;
            font-size: 0.95rem;
            min-height: 120px;
            resize: vertical;
        }

        .galore-input:focus,
        .galore-textarea:focus {
            outline: none;
            border-color: var(--galore-red);
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.15);
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
            cursor: pointer;
            transition: 0.3s ease;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.3);
        }

        .btn-cancel {
            background: #6c757d;
            color: white;
            padding: 15px 22px;
            border-radius: 12px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .btn-cancel:hover {
            background: #5a6268;
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

        /* TABLE CONTAINER WITH RED BORDER */
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
            min-width: 300px;
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--galore-gray);
            font-size: 1rem;
        }

        .search-box input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 50px;
            font-size: 0.95rem;
            background-color: #f8f9fa;
            transition: all 0.3s ease;
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--galore-red);
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.15);
            background-color: #ffffff;
        }

        .search-box input::placeholder {
            color: #999;
            font-style: italic;
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
            gap: 20px;
        }

        .top-bar h1 {
            color: var(--galore-red);
            font-size: 2rem;
            font-weight: 800;
            margin: 0;
        }

        /* PAGINATION */
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
            cursor: pointer;
            transition: 0.3s ease;
        }

        .pagination .page-link:hover {
            background: rgba(220, 53, 69, 0.1);
            border-color: var(--galore-red);
        }

        .pagination .active .page-link {
            background: var(--galore-red);
            color: white;
            border-color: var(--galore-red);
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            background: #f8f9fa;
            cursor: not-allowed;
        }

        /* Modal Styles */
        .modal-content {
            border-radius: 18px;
            border-top: 6px solid var(--galore-red);
        }

        .modal-header {
            background: var(--galore-red);
            color: white;
            border-radius: 12px 12px 0 0;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        .modal-body {
            padding: 30px;
        }

        .detail-item {
            margin-bottom: 15px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .detail-label {
            font-weight: 700;
            color: var(--galore-red);
            margin-right: 10px;
        }

        /* Text for no data */
        .text-center.py-4 i {
            color: #ddd;
        }
        
        .text-center.py-4 h5 {
            color: #999;
        }

        /* Badge for ID */
        .badge.bg-secondary {
            background-color: var(--galore-gray) !important;
            padding: 5px 10px;
            font-size: 0.85rem;
        }
    </style>
</head>

<body>

    <?php require 'ad_c_header.php'; ?>

    <main class="main-content">

        <div class="top-bar d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3" id="topBar">
            <h1 class="mb-0"><i class="fas fa-school me-2"></i>School Page Management</h1>
            <!-- <button class="btn-add-school" id="openFormBtn">
                <i class="bi bi-plus-circle"></i> Add School Page
            </button> -->
        </div>

        <!-- ADD / EDIT SCHOOL FORM -->
        <div class="add-school-form-container" id="addSchoolForm" style="display:none;">
            <h3 class="form-title" id="formTitleText">Add School Page</h3>

            <form id="schoolForm" method="POST" action="">
                <input type="hidden" name="edit_id" id="edit_id" value="">

                <div class="galore-input-group">
                    <label class="galore-label">Hero Title <span class="text-danger">*</span></label>
                    <input type="text" name="hero_title" class="galore-input" placeholder="Enter hero title" data-validation="required min" data-min="5" data-max="100">
                    <span id="hero_title_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Hero Subtitle <span class="text-danger">*</span></label>
                    <input type="text" name="hero_subtitle" class="galore-input" placeholder="Enter hero subtitle" data-validation="required min" data-min="10" data-max="200">
                    <span id="hero_subtitle_error" class="error-message"></span>
                </div>

                <!-- Status field removed from form - now only in table -->

                <div class="form-buttons">
                    <button type="submit" name="submit" class="btn-save"><i class="fas fa-save me-2"></i>Save</button>
                    <button type="button" class="btn-cancel" id="cancelForm"><i class="fas fa-times me-2"></i>Cancel</button>
                </div>

                <div class="text-center mt-3">
                    <small class="text-muted"><i class="fas fa-info-circle me-1 text-danger"></i> Fields marked with <span class="text-danger">*</span> are required</small>
                </div>
            </form>
        </div>

        <!-- DATA TABLE -->
        <div class="data-table-container">
            <div class="table-header" id="tableHeader">
                <h2 class="mb-0">School Pages List</h2>
                <div class="search-box" id="searchBox">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchInput" placeholder="Search by title or subtitle...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Hero Title</th>
                            <th>Hero Subtitle</th>
                            <th>Status</th>
                            <th id="actionsHeader">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="schoolTableBody"></tbody>
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
                    <h5 class="modal-title fw-bold"><i class="fas fa-info-circle me-2"></i>School Page Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-school" style="font-size: 4rem; color: var(--galore-red); opacity: 0.5;"></i>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="detail-item">
                                <span class="detail-label">ID:</span>
                                <span id="v_id"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="detail-item">
                                <span class="detail-label">Hero Title:</span>
                                <span id="v_hero_title"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="detail-item">
                                <span class="detail-label">Hero Subtitle:</span>
                                <span id="v_hero_subtitle"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="detail-item">
                                <span class="detail-label">Status:</span>
                                <span id="v_status"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Use PHP to pass database schools to JavaScript
        let schoolData = <?php echo json_encode($schoolData); ?>;

        // If no schools in database, use empty array
        if (!schoolData || schoolData.length === 0) {
            schoolData = [];
        }

        const rowsPerPage = 5;
        let currentPage = 1;
        let editId = null; // Track editing row

        const addSchoolForm = $("#addSchoolForm");
        const formTitleText = $("#formTitleText");

        // Open form button
        $("#openFormBtn").click(() => {
            formTitleText.text("Add School Page");
            editId = null;
            $("#edit_id").val("");
            $("#schoolForm")[0].reset();
            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            
            // Status field removed - no need to set default
            
            addSchoolForm.slideDown(300);
        });

        // Cancel form button
        $("#cancelForm").click(() => {
            addSchoolForm.slideUp(300);
            $("#schoolForm")[0].reset();
            $("#edit_id").val("");
            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            editId = null;
        });

        // Render table with pagination
        function renderTable() {
            let tbody = $("#schoolTableBody");
            tbody.html("");

            const searchValue = $("#searchInput").val().toLowerCase();
            const filteredData = schoolData.filter(school =>
                school.hero_title.toLowerCase().includes(searchValue) ||
                school.hero_subtitle.toLowerCase().includes(searchValue)
            );

            const start = (currentPage - 1) * rowsPerPage;
            const paginatedData = filteredData.slice(start, start + rowsPerPage);

            if (paginatedData.length === 0) {
                tbody.append(`
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            <i class="bi bi-inbox fs-1 d-block mb-3" style="color: #ddd;"></i>
                            <h5 style="color: #999;">No data found</h5>
                        </td>
                    </tr>
                `);
            } else {
                paginatedData.forEach(school => {
                    const statusClass = school.status === 'Active' ? 'btn-status-active' : 'btn-status-inactive';
                    
                    tbody.append(`
                    <tr>
                        <td><span >${school.id}</span></td>
                        <td>${school.hero_title}</td>
                        <td>${school.hero_subtitle}</td>
                        <td>
                            <button class="btn-status ${statusClass}" onclick="toggleStatus(${school.id})">
                                ${school.status}
                            </button>
                        </td>
                        <td>
                            <button class="action-btn btn-view" onclick="viewSchool(${school.id})"> View</button>
                            <button class="action-btn btn-edit" onclick="editSchool(${school.id})"> Edit</button>
                            <button class="action-btn btn-delete" onclick="deleteSchool(${school.id})"> Delete</button>
                        </td>
                    </tr>`);
                });
            }

            renderPagination(filteredData.length);
        }

        // Render pagination controls
        function renderPagination(totalRows) {
            let totalPages = Math.ceil(totalRows / rowsPerPage);
            let pagination = $("#pagination");
            pagination.html("");

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
                <li class="page-item ${currentPage === totalPages || totalPages === 0 ? "disabled" : ""}">
                    <a class="page-link" href="#" onclick="goPage(${currentPage + 1})">Next</a>
                </li>
            `);
        }

        // Navigate to page
        window.goPage = function(page) {
            const searchValue = $("#searchInput").val().toLowerCase();
            const filteredData = schoolData.filter(school =>
                school.hero_title.toLowerCase().includes(searchValue) ||
                school.hero_subtitle.toLowerCase().includes(searchValue)
            );
            let totalPages = Math.ceil(filteredData.length / rowsPerPage);

            if (page < 1 || page > totalPages) return;
            currentPage = page;
            renderTable();
        };

         /* TOGGLE STATUS FUNCTION */
        function toggleStatus(id) {
            window.location.href = "?toggle_id=" + id;
        }

        // View school details
        window.viewSchool = function(id) {
            let school = schoolData.find(x => x.id == id);
            $("#v_id").text(school.id);
            $("#v_hero_title").text(school.hero_title);
            $("#v_hero_subtitle").text(school.hero_subtitle);
            $("#v_status").text(school.status);
            new bootstrap.Modal(document.getElementById("viewModal")).show();
        };

        // Delete school
        window.deleteSchool = function(id) {
            if (confirm("Are you sure you want to delete this school page?")) {
                window.location.href = "?delete_id=" + id;
            }
        };

        // Edit school
        window.editSchool = function(id) {
            editId = id;
            const school = schoolData.find(x => x.id == id);

            formTitleText.text("Edit School Page");
            $("#edit_id").val(id);

            // Fill form fields (status field removed)
            $('input[name="hero_title"]').val(school.hero_title);
            $('input[name="hero_subtitle"]').val(school.hero_subtitle);
            
            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");

            addSchoolForm.slideDown(300);
        };

        // Search functionality
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

            // School form submission with validation
            $("#schoolForm").on("submit", function(e) {
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
                    e.preventDefault(); // Prevent form submission
                    if (firstInvalidField) {
                        $(firstInvalidField).focus();
                    }
                    return false;
                }

                // If validation passes, allow form to submit normally
                return true;
            });
        });

        // Handle escape key to close form
        $(document).keydown(function(e) {
            if (e.key === "Escape" && addSchoolForm.is(":visible")) {
                addSchoolForm.slideUp(300);
                $("#schoolForm")[0].reset();
                $("#edit_id").val("");
                $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
                $(".error-message").text("");
                editId = null;
            }
        });

        // Initial render
        renderTable();
    </script>

</body>

</html>