<?php
include 'ad_contact_message_handler.php';
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

        #contactMessageForm {
            display: grid;
            grid-template-columns: 1fr;
            gap: 18px;
        }

        @media (min-width: 768px) {
            #contactMessageForm {
                grid-template-columns: 1fr 1fr;
            }

            .message-group {
                grid-column: span 2;
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
        }

        .btn-cancel {
            background: #6c757d;
            color: white;
            padding: 15px 22px;
            border-radius: 12px;
            font-weight: bold;
            border: none;
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

        <div class="top-bar d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3" id="topBar">
            <h1 class="mb-0">Contact Message Management</h1>
            <button class="btn-add-user" id="openFormBtn">
                <i class="bi bi-plus-circle"></i> Add Test Message
            </button>
        </div>

        <!-- FORM -->
        <div class="add-user-form-container" id="addContactMessageForm" style="display:none;">
            <h3 class="form-title" id="formTitleText">Add Contact Message</h3>

            <form id="contactMessageForm" method="POST" action="">
                <input type="hidden" name="edit_id" id="edit_id" value="">

                <div class="galore-input-group">
                    <label class="galore-label">Full Name <span class="text-danger">*</span></label>
                    <input type="text" name="full_name" class="galore-input" data-validation="required min alphabetic" data-min="3" data-max="100">
                    <span id="full_name_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="galore-input" data-validation="required email" data-max="100">
                    <span id="email_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Phone Number <span class="text-danger">*</span></label>
                    <input type="tel" name="phone" class="galore-input" data-validation="required min number" data-min="10" data-max="15">
                    <span id="phone_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Subject <span class="text-danger">*</span></label>
                    <input type="text" name="subject" class="galore-input" data-validation="required min" data-min="3" data-max="200">
                    <span id="subject_error" class="error-message"></span>
                </div>

                <div class="galore-input-group message-group">
                    <label class="galore-label">Message <span class="text-danger">*</span></label>
                    <textarea name="message" class="galore-textarea" data-validation="required min" data-min="10" data-max="1000"></textarea>
                    <span id="message_error" class="error-message"></span>
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
                <h2 class="mb-0">Contact Messages</h2>

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
                            <th>Full Name</th>
                            <th>Email</th>
                            <th id="actionsHeader">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="messageTableBody"></tbody>
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
                    <h5 class="modal-title fw-bold">Message Full Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <p><b>ID:</b> <span id="v_id"></span></p>
                    <p><b>Full Name:</b> <span id="v_full_name"></span></p>
                    <p><b>Email:</b> <span id="v_email"></span></p>
                    <p><b>Phone:</b> <span id="v_phone"></span></p>
                    <p><b>Subject:</b> <span id="v_subject"></span></p>
                    <p><b>Message:</b> <span id="v_message"></span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Use PHP to pass database messages to JavaScript
        let contactMessagesData = <?php echo json_encode($contactMessagesData); ?>;

        // If no messages in database, use empty array
        if (!contactMessagesData || contactMessagesData.length === 0) {
            contactMessagesData = [];
        }

        const rowsPerPage = 5;
        let currentPage = 1;
        let editId = null; // Track editing row

        const addContactMessageForm = $("#addContactMessageForm");
        const formTitleText = $("#formTitleText");

        // Open form button
        $("#openFormBtn").click(() => {
            formTitleText.text("Add Contact Message");
            editId = null;
            $("#edit_id").val("");
            $("#contactMessageForm")[0].reset();
            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            addContactMessageForm.slideDown();
        });

        // Cancel form button
        $("#cancelForm").click(() => {
            addContactMessageForm.slideUp();
            $("#contactMessageForm")[0].reset();
            $("#edit_id").val("");
            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            editId = null;
        });

        // Render table with pagination
        function renderTable() {
            let tbody = $("#messageTableBody");
            tbody.html("");

            const searchValue = $("#searchInput").val().toLowerCase();
            const filteredData = contactMessagesData.filter(m =>
                m.full_name.toLowerCase().includes(searchValue) ||
                m.email.toLowerCase().includes(searchValue) ||
                m.subject.toLowerCase().includes(searchValue) ||
                m.message.toLowerCase().includes(searchValue)
            );

            const start = (currentPage - 1) * rowsPerPage;
            const paginatedData = filteredData.slice(start, start + rowsPerPage);

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
                paginatedData.forEach(m => {
                    tbody.append(`
                    <tr>
                        <td>${m.id}</td>
                        <td>${m.full_name}</td>
                        <td>${m.email}</td>
                        <td>
                            <button class="action-btn btn-view" onclick="viewMessage(${m.id})">View</button>
                            <button class="action-btn btn-edit" onclick="editMessage(${m.id})">Edit</button>
                            <button class="action-btn btn-delete" onclick="deleteMessage(${m.id})">Delete</button>
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
        function goPage(page) {
            const searchValue = $("#searchInput").val().toLowerCase();
            const filteredData = contactMessagesData.filter(m =>
                m.full_name.toLowerCase().includes(searchValue) ||
                m.email.toLowerCase().includes(searchValue) ||
                m.subject.toLowerCase().includes(searchValue) ||
                m.message.toLowerCase().includes(searchValue)
            );
            const totalPages = Math.ceil(filteredData.length / rowsPerPage);
            if (page < 1 || page > totalPages) return;
            currentPage = page;
            renderTable();
        }

        // View message details
        function viewMessage(id) {
            let m = contactMessagesData.find(x => x.id == id);
            $("#v_id").text(m.id);
            $("#v_full_name").text(m.full_name);
            $("#v_email").text(m.email);
            $("#v_phone").text(m.phone);
            $("#v_subject").text(m.subject);
            $("#v_message").text(m.message);
            new bootstrap.Modal(document.getElementById("viewModal")).show();
        }

        // Delete message
        function deleteMessage(id) {
            if (confirm("Are you sure you want to delete this message?")) {
                window.location.href = "?delete_id=" + id;
            }
        }

        // Edit message
        function editMessage(id) {
            editId = id;
            const m = contactMessagesData.find(x => x.id == id);
            formTitleText.text("Edit Contact Message");
            $("#edit_id").val(id);
            
            // Set form values
            $('input[name="full_name"]').val(m.full_name);
            $('input[name="email"]').val(m.email);
            $('input[name="phone"]').val(m.phone);
            $('input[name="subject"]').val(m.subject);
            $('textarea[name="message"]').val(m.message);
            
            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            
            addContactMessageForm.slideDown();
        }

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

                        // Add alphabetic validation for name
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

            // Contact message form submission with validation
            $("#contactMessageForm").on("submit", function(e) {
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

        // Initial render
        renderTable();
    </script>

</body>

</html>