<?php
include 'ad_login_handler.php';
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
            /* RED COLOR FOR TABLE HEADINGS */
            border-bottom: 2px solid var(--galore-red);
            /* RED BORDER */
        }

        .data-table td {
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
            vertical-align: middle;
        }

        .data-table tbody tr:hover {
            background: rgba(220, 53, 69, 0.1);
            /* RED HOVER */
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

        @media (max-width: 768px) {
            .main-content {
                padding: 15px;
            }

            .table-header {
                flex-direction: column;
                align-items: stretch;
            }

            .search-box {
                min-width: 100%;
            }

            .action-btn {
                display: block;
                width: 100%;
                margin-bottom: 8px;
            }
        }

        /* TABLE */
        .pagination-container {
            margin-top: 25px;
            /* UPDATED FROM 15px TO 25px */
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
    </style>
</head>

<body>

    <?php require 'admin_header.php'; ?>

    <main class="main-content">

        <div class="top-bar d-flex justify-content-between align-items-center flex-wrap gap-3" id="topBar">
            <h1 class="mb-0">Login Header Management</h1>
            <!-- <button class="btn-add-user" id="openFormBtn">
                <i class="bi bi-plus-circle"></i> Add Header Data
            </button> -->
        </div>

        <!-- FORM -->
        <div class="add-user-form-container" id="addHeaderForm" style="display:none;">
            <h3 class="form-title" id="formTitleText">Add Login Header</h3>

            <form id="headerForm" method="POST" action="">
                <input type="hidden" name="edit_id" id="edit_id" value="">

                <div class="galore-input-group">
                    <label class="galore-label">Hero Title</label>
                    <input type="text" name="hero_title" class="galore-input" data-validation="required min" data-min="3" data-max="100">
                    <span id="hero_title_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Hero Subtitle</label>
                    <input type="text" name="hero_subtitle" class="galore-input" data-validation="required min" data-min="3" data-max="100">
                    <span id="hero_subtitle_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Form Title</label>
                    <input type="text" name="form_title" class="galore-input" data-validation="required min" data-min="3" data-max="100">
                    <span id="form_title_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Date</label>
                    <input type="date" name="date" class="galore-input" data-validation="required future-date" id="dateField">
                    <span id="date_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Footer Note</label>
                    <input type="text" name="footer_note" class="galore-input" data-validation="required min" data-min="3" data-max="100">
                    <span id="footer_note_error" class="error-message"></span>
                </div>

                <div class="form-buttons">
                    <button type="submit" name="submit" class="btn-save">Save</button>
                    <button type="button" class="btn-cancel" id="cancelForm">Cancel</button>
                </div>

            </form>
        </div>

        <!-- TABLE -->
        <div class="data-table-container">

            <div class="table-header" id="tableHeader">
                <h2 class="mb-0">Login Header Data</h2>

                <div class="search-box" id="searchBox">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchInput" placeholder="Search...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Hero Title</th>
                            <th>Form Title</th>
                            <th id="actionsHeader">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="headerTableBody"></tbody>
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
                    <h5 class="modal-title fw-bold">Header Full Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <p><b>ID:</b> <span id="v_id"></span></p>
                    <p><b>Hero Title:</b> <span id="v_hero_title"></span></p>
                    <p><b>Hero Subtitle:</b> <span id="v_hero_subtitle"></span></p>
                    <p><b>Form Title:</b> <span id="v_form_title"></span></p>
                    <p><b>Date:</b> <span id="v_date"></span></p>
                    <p><b>Footer Note:</b> <span id="v_footer_note"></span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Use PHP to pass database headers to JavaScript
        let headerData = <?php echo json_encode($headers); ?>;

        // If no headers in database, use empty array
        if (!headerData || headerData.length === 0) {
            headerData = [];
        }

        const rowsPerPage = 5;
        let currentPage = 1;
        let editId = null; // Track editing row

        const addHeaderForm = $("#addHeaderForm");
        const formTitleText = $("#formTitleText");

        // Function to set min date attribute
        function setMinDate() {
            let today = new Date().toISOString().split("T")[0];
            $("#dateField").attr("min", today);
        }

        $("#openFormBtn").click(() => {
            formTitleText.text("Add Login Header");
            editId = null;
            $("#edit_id").val("");
            $("#headerForm")[0].reset();
            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            setMinDate();
            addHeaderForm.slideDown();
        });

        $("#cancelForm").click(() => {
            addHeaderForm.slideUp();
            $("#headerForm")[0].reset();
            $("#edit_id").val("");
            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            editId = null;
        });

        function renderTable() {
            let tbody = $("#headerTableBody");
            tbody.html("");

            const searchValue = $("#searchInput").val().toLowerCase();
            const filteredData = headerData.filter(h => h.hero_title.toLowerCase().includes(searchValue));
            const start = (currentPage - 1) * rowsPerPage;
            const paginatedData = filteredData.slice(start, start + rowsPerPage);

            paginatedData.forEach(h => {
                tbody.append(`
                <tr>
                    <td>${h.id}</td>
                    <td>${h.hero_title}</td>
                    <td>${h.form_title}</td>
                    <td>
                        <button class="action-btn btn-view" onclick="viewHeader(${h.id})">View</button>
                        <button class="action-btn btn-edit" onclick="editHeader(${h.id})">Edit</button>
                        <button class="action-btn btn-delete" onclick="deleteHeader(${h.id})">Delete</button>
                    </td>
                </tr>`);
            });

            renderPagination(filteredData.length);
        }

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
                <li class="page-item ${currentPage === totalPages ? "disabled" : ""}">
                    <a class="page-link" href="#" onclick="goPage(${currentPage + 1})">Next</a>
                </li>
            `);
        }

        function goPage(page) {
            let totalPages = Math.ceil(headerData.length / rowsPerPage);
            if (page < 1 || page > totalPages) return;
            currentPage = page;
            renderTable();
        }

        function viewHeader(id) {
            let h = headerData.find(x => x.id == id);
            $("#v_id").text(h.id);
            $("#v_hero_title").text(h.hero_title);
            $("#v_hero_subtitle").text(h.hero_subtitle);
            $("#v_form_title").text(h.form_title);
            // Use display_date for better formatting, fallback to formatted date if not available
            $("#v_date").text(h.display_date || h.event_date);
            $("#v_footer_note").text(h.footer_note);
            new bootstrap.Modal(document.getElementById("viewModal")).show();
        }

        function deleteHeader(id) {
            if (confirm("Are you sure you want to delete?")) {
                window.location.href = "?delete_id=" + id;
            }
        }

        function editHeader(id) {
            editId = id;
            const h = headerData.find(x => x.id == id);
            formTitleText.text("Edit Login Header");
            $("#edit_id").val(id);

            // Set form values using jQuery for consistency
            $('input[name="hero_title"]').val(h.hero_title);
            $('input[name="hero_subtitle"]').val(h.hero_subtitle);
            $('input[name="form_title"]').val(h.form_title);
            $('input[name="date"]').val(h.event_date);
            $('input[name="footer_note"]').val(h.footer_note);

            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");

            setMinDate();
            addHeaderForm.slideDown();
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

                        // Future date validation
                        if (validationType.includes("future-date")) {
                            let today = new Date().toISOString().split("T")[0];
                            if (value < today) {
                                errorMessage = "Please select a future date.";
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

            // Header form submission with validation
            $("#headerForm").on("submit", function(e) {
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
        renderTable();
    </script>

</body>

</html>