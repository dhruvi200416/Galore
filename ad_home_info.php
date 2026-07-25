<?php
// Include the handler file which contains all PHP logic and database operations
include 'ad_home_info_handler.php';
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

        /* FIXED GRID FORM */
        #headerForm {
            display: grid;
            grid-template-columns: 1fr;
            gap: 18px;
        }

        @media (min-width: 768px) {
            #headerForm {
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

        /* TABLE */
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
            color: var(--galore-dark);
            border-bottom: 2px solid #dee2e6;
        }

        .data-table td {
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
            vertical-align: middle;
        }

        .data-table tbody tr:hover {
            background: rgba(220, 53, 69, 0.05);
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
        
        body {
            background: #f8f9fa;
        }
    </style>
</head>

<body>
    <?php require 'admin_header.php'; ?>

    <main class="main-content">

        <!-- TOP BAR -->
        <div class="top-bar">
            <h1 class="mb-0">Homepage Info Management</h1>
            <!-- <button class="btn-add-user" id="openFormBtn">
                <i class="bi bi-plus-circle"></i> Add Homepage Info
            </button> -->
        </div>

        <!-- FORM -->
        <div class="add-user-form-container" id="addHomepageForm" style="display:none;">
            <h3 class="form-title" id="formTitle">Add Homepage Info</h3>

            <form id="homepageForm" method="POST" action="home_info_handler.php">
                <input type="hidden" name="edit_id" id="edit_id" value="">

                <!-- SIDE BY SIDE FORM GRID -->
                <div id="headerForm">

                    <div class="galore-input-group">
                        <label class="galore-label">Heading <span class="text-danger">*</span></label>
                        <input type="text" name="heading" class="galore-input" data-validation="required min alphabetic" data-min="3" data-max="100">
                        <span id="heading_error" class="error-message"></span>
                    </div>

                    <div class="galore-input-group">
                        <label class="galore-label">Sub Heading <span class="text-danger">*</span></label>
                        <input type="text" name="sub_heading" class="galore-input" data-validation="required min" data-min="3" data-max="100">
                        <span id="sub_heading_error" class="error-message"></span>
                    </div>

                    <div class="form-buttons">
                        <button type="submit" name="submit" class="btn-save">Save</button>
                        <button type="button" class="btn-cancel" id="cancelForm">Cancel</button>
                    </div>

                </div>
            </form>
        </div>

        <!-- TABLE -->
        <div class="data-table-container">
            <div class="table-header">
                <h2 class="mb-0">Homepage Info Data</h2>
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchInput" placeholder="Search Heading...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Heading</th>
                            <th>Sub Heading</th>
                            <th id="actionsHeader">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="homepageTableBody"></tbody>
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
                    <h5 class="modal-title fw-bold">Homepage Full Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body text-center">
                    <p><b>ID:</b> <span id="v_id"></span></p>
                    <p><b>Heading:</b> <span id="v_heading"></span></p>
                    <p><b>Sub Heading:</b> <span id="v_sub_heading"></span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Use PHP to pass database info to JavaScript
        let homepageData = <?php echo json_encode($homepageData); ?>;

        // If no info in database, use empty array
        if (!homepageData || homepageData.length === 0) {
            homepageData = [];
        }

        let rowsPerPage = 5;
        let currentPage = 1;
        let editId = null;

        const addHomepageForm = $("#addHomepageForm");
        const formTitle = $("#formTitle");

        // Show Form
        $("#openFormBtn").click(() => {
            formTitle.text("Add Homepage Info");
            editId = null;
            $("#edit_id").val("");
            $("#homepageForm")[0].reset();
            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            addHomepageForm.slideDown();
        });

        // Cancel Form
        $("#cancelForm").click(() => {
            addHomepageForm.slideUp();
            $("#homepageForm")[0].reset();
            $("#edit_id").val("");
            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            editId = null;
        });

        // Render Table
        function renderTable() {
            let tbody = $("#homepageTableBody");
            tbody.html("");

            let searchValue = $("#searchInput").val().toLowerCase();
            let filteredData = homepageData.filter(h =>
                h.heading.toLowerCase().includes(searchValue) ||
                h.sub_heading.toLowerCase().includes(searchValue)
            );

            let start = (currentPage - 1) * rowsPerPage;
            let paginatedData = filteredData.slice(start, start + rowsPerPage);

            if (paginatedData.length === 0) {
                tbody.append(`
                    <tr>
                        <td colspan="4" class="text-center py-4">
                            <i class="bi bi-inbox fs-1 d-block mb-3" style="color: #ddd;"></i>
                            <h5 style="color: #999;">No data found</h5>
                        </td>
                    </tr>
                `);
            } else {
                paginatedData.forEach(h => {
                    tbody.append(`
                        <tr>
                            <td>${h.id}</td>
                            <td>${h.heading}</td>
                            <td>${h.sub_heading}</td>
                            <td>
                                <button class="action-btn btn-view" onclick="viewInfo(${h.id})">View</button>
                                <button class="action-btn btn-edit" onclick="editInfo(${h.id})">Edit</button>
                                <button class="action-btn btn-delete" onclick="deleteInfo(${h.id})">Delete</button>
                            </td>
                        </tr>
                    `);
                });
            }

            renderPagination(filteredData.length);
        }

        // Pagination with Previous and Next buttons
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
            let searchValue = $("#searchInput").val().toLowerCase();
            let filteredData = homepageData.filter(h =>
                h.heading.toLowerCase().includes(searchValue) ||
                h.sub_heading.toLowerCase().includes(searchValue)
            );
            let totalPages = Math.ceil(filteredData.length / rowsPerPage);
            if (page < 1 || page > totalPages) return;
            currentPage = page;
            renderTable();
        }

        // View Modal
        function viewInfo(id) {
            let h = homepageData.find(x => x.id == id);

            $("#v_id").text(h.id);
            $("#v_heading").text(h.heading);
            $("#v_sub_heading").text(h.sub_heading);

            new bootstrap.Modal(document.getElementById("viewModal")).show();
        }

        // Edit
        function editInfo(id) {
            editId = id;
            let h = homepageData.find(x => x.id == id);

            formTitle.text("Edit Homepage Info");
            $("#edit_id").val(id);

            $("#homepageForm [name='heading']").val(h.heading);
            $("#homepageForm [name='sub_heading']").val(h.sub_heading);
            
            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");

            addHomepageForm.slideDown();
        }

        // Delete
        function deleteInfo(id) {
            if (confirm("Are you sure you want to delete this homepage info?")) {
                window.location.href = "home_info_handler.php?delete_id=" + id;
            }
        }

        // Search Live
        $("#searchInput").on("keyup", function () {
            currentPage = 1;
            renderTable();
        });

        // Handle escape key to close form
        $(document).keydown(function(e) {
            if (e.key === "Escape" && addHomepageForm.is(":visible")) {
                addHomepageForm.slideUp();
                $("#homepageForm")[0].reset();
                $("#edit_id").val("");
                $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
                $(".error-message").text("");
                editId = null;
            }
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

                        // Add alphabetic validation
                        if (validationType.includes("alphabetic")) {
                            var alphabet_regex = /^[a-zA-Z\s]+$/;
                            if (!alphabet_regex.test(value)) {
                                errorMessage = "Please enter alphabetic characters only.";
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

            // Homepage form submission with validation
            $("#homepageForm").on("submit", function(e) {
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