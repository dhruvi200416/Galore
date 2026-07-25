<?php
include 'ad_co_school_handler.php';
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

    <!-- Font Awesome for additional icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- FORM + TABLE CSS (same styling as gallery page) -->
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

        /* ICON STYLES */
        .icon-preview {
            font-size: 24px;
            color: var(--galore-red);
            width: 40px;
            text-align: center;
        }

        .icon-preview-small {
            font-size: 18px;
            color: var(--galore-red);
            margin-right: 5px;
        }

        .school-icon-display {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        /* .count-badge {
            background: var(--galore-red);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
            min-width: 60px;
            text-align: center;
        } */

        /* ACTION BUTTONS */
        .action-btn {
            padding: 8px 15px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
            margin-right: 5px;
            margin-bottom: 5px;
            font-size: 0.9rem;
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

        /* Icon selector styling */
        .icon-selector {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 5px;
        }

        .icon-option {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            font-size: 24px;
            color: var(--galore-gray);
            transition: all 0.2s;
        }

        .icon-option:hover {
            border-color: var(--galore-red);
            color: var(--galore-red);
            transform: scale(1.1);
        }

        .icon-option.selected {
            border-color: var(--galore-red);
            background: rgba(220, 53, 69, 0.1);
            color: var(--galore-red);
        }

        .icon-input-group {
            position: relative;
        }

        .icon-input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
            color: var(--galore-gray);
        }

        .icon-input-group input {
            padding-left: 45px;
        }
    </style>
</head>

<body>

    <?php require 'ad_co_header.php'; ?>

    <main class="main-content">

        <div class="top-bar d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3" id="topBar">
            <h1 class="mb-0">School Management</h1>
            <button class="btn-add-school" id="openFormBtn">
                <i class="bi bi-plus-circle"></i> Add New School
            </button>
        </div>

        <!-- FORM -->
        <div class="add-school-form-container" id="addSchoolForm" style="display:none;">
            <h3 class="form-title" id="formTitleText">Add School</h3>

            <form id="schoolForm" method="POST" action="">
                <input type="hidden" name="edit_id" id="edit_id" value="">

                <div class="galore-input-group">
                    <label class="galore-label">Icon 1 (Main Icon) <span class="text-danger">*</span></label>
                    <div class="icon-input-group">
                        <i class="fas fa-university" id="icon1Preview"></i>
                        <input type="text" name="icon1" class="galore-input" placeholder="e.g., fa-university" id="icon1Input" data-validation="required min" data-min="3" data-max="30">
                    </div>
                    <span id="icon1_error" class="error-message"></span>
                    <div class="icon-selector">
                        <div class="icon-option" data-icon="fa-university"><i class="fas fa-university"></i></div>
                        <div class="icon-option" data-icon="fa-school"><i class="fas fa-school"></i></div>
                        <div class="icon-option" data-icon="fa-graduation-cap"><i class="fas fa-graduation-cap"></i></div>
                        <div class="icon-option" data-icon="fa-book-open"><i class="fas fa-book-open"></i></div>
                        <div class="icon-option" data-icon="fa-flask"><i class="fas fa-flask"></i></div>
                    </div>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Username <span class="text-danger">*</span></label>
                    <input type="text" name="username" class="galore-input" placeholder="Enter username" data-validation="required min alphabetic" data-min="3" data-max="50">
                    <span id="username_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">School Name <span class="text-danger">*</span></label>
                    <input type="text" name="school_name" class="galore-input" placeholder="Enter school name" data-validation="required min alphabetic" data-min="3" data-max="100">
                    <span id="school_name_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="galore-input" placeholder="school@example.com" data-validation="required email" data-max="100">
                    <span id="email_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Icon 2 (Secondary Icon) <span class="text-danger">*</span></label>
                    <div class="icon-input-group">
                        <i class="fas fa-users" id="icon2Preview"></i>
                        <input type="text" name="icon2" class="galore-input" placeholder="e.g., fa-users" id="icon2Input" data-validation="required min" data-min="3" data-max="30">
                    </div>
                    <span id="icon2_error" class="error-message"></span>
                    <div class="icon-selector">
                        <div class="icon-option" data-icon="fa-users"><i class="fas fa-users"></i></div>
                        <div class="icon-option" data-icon="fa-user-graduate"><i class="fas fa-user-graduate"></i></div>
                        <div class="icon-option" data-icon="fa-chalkboard-user"><i class="fas fa-chalkboard-user"></i></div>
                        <div class="icon-option" data-icon="fa-user-tie"><i class="fas fa-user-tie"></i></div>
                    </div>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Icon 3 (Event Icon) <span class="text-danger">*</span></label>
                    <div class="icon-input-group">
                        <i class="fas fa-calendar" id="icon3Preview"></i>
                        <input type="text" name="icon3" class="galore-input" placeholder="e.g., fa-calendar" id="icon3Input" data-validation="required min" data-min="3" data-max="30">
                    </div>
                    <span id="icon3_error" class="error-message"></span>
                    <div class="icon-selector">
                        <div class="icon-option" data-icon="fa-calendar"><i class="fas fa-calendar"></i></div>
                        <div class="icon-option" data-icon="fa-calendar-alt"><i class="fas fa-calendar-alt"></i></div>
                        <div class="icon-option" data-icon="fa-calendar-check"><i class="fas fa-calendar-check"></i></div>
                        <div class="icon-option" data-icon="fa-clock"><i class="fas fa-clock"></i></div>
                    </div>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Total Students <span class="text-danger">*</span></label>
                    <input type="number" name="student_count" class="galore-input" min="0" placeholder="e.g., 500" data-validation="required min number" data-min="0" data-max="10000">
                    <span id="student_count_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Total Events <span class="text-danger">*</span></label>
                    <input type="number" name="event_count" class="galore-input" min="0" placeholder="e.g., 25" data-validation="required min number" data-min="0" data-max="500">
                    <span id="event_count_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Registered Count <span class="text-danger">*</span></label>
                    <input type="number" name="registered_count" class="galore-input" min="0" placeholder="e.g., 150" data-validation="required min number" data-min="0" data-max="10000">
                    <span id="registered_count_error" class="error-message"></span>
                </div>

                <div class="form-buttons">
                    <button type="submit" name="submit" class="btn-save">Save School</button>
                    <button type="button" class="btn-cancel" id="cancelForm">Cancel</button>
                </div>

            </form>
        </div>

        <!-- TABLE -->
        <div class="data-table-container">

            <div class="table-header" id="tableHeader">
                <h2 class="mb-0">Schools Data</h2>

                <div class="search-box" id="searchBox">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchInput" placeholder="Search schools...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Icon 1</th>
                            <th>Username</th>
                            <th>School Name</th>
                            <!-- <th>Email</th>
                            <th>Icon 2</th>
                            <th>Icon 3</th>
                            <th>Students</th>
                            <th>Events</th>
                            <th>Registered</th> -->
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
                    <h5 class="modal-title fw-bold">School Full Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <div class="school-icon-display justify-content-center">
                            <i class="fas" id="v_icon1_display"></i>
                            <i class="fas" id="v_icon2_display"></i>
                            <i class="fas" id="v_icon3_display"></i>
                        </div>
                    </div>
                    <table class="table table-borderless">
                        <tr>
                            <th>ID:</th>
                            <td><span id="v_id"></span></td>
                        </tr>
                        <tr>
                            <th>Username:</th>
                            <td><span id="v_username"></span></td>
                        </tr>
                        <tr>
                            <th>School Name:</th>
                            <td><span id="v_school_name"></span></td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td><span id="v_email"></span></td>
                        </tr>
                        <tr>
                            <th>Icon 1:</th>
                            <td><i class="fas" id="v_icon1"></i> <span id="v_icon1_text"></span></td>
                        </tr>
                        <tr>
                            <th>Icon 2:</th>
                            <td><i class="fas" id="v_icon2"></i> <span id="v_icon2_text"></span></td>
                        </tr>
                        <tr>
                            <th>Icon 3:</th>
                            <td><i class="fas" id="v_icon3"></i> <span id="v_icon3_text"></span></td>
                        </tr>
                        <tr>
                            <th>Total Students:</th>
                            <td><span id="v_student_count" class="count-badge"></span></td>
                        </tr>
                        <tr>
                            <th>Total Events:</th>
                            <td><span id="v_event_count" class="count-badge"></span></td>
                        </tr>
                        <tr>
                            <th>Registered Count:</th>
                            <td><span id="v_registered_count" class="count-badge"></span></td>
                        </tr>
                    </table>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div> -->
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
            formTitleText.text("Add New School");
            editId = null;
            $("#edit_id").val("");
            $("#schoolForm")[0].reset();
            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            $('.icon-option').removeClass('selected');
            $('#icon1Preview, #icon2Preview, #icon3Preview').removeClass().addClass('fas');
            addSchoolForm.slideDown();
        });

        // Cancel form button
        $("#cancelForm").click(() => {
            addSchoolForm.slideUp();
            $("#schoolForm")[0].reset();
            $("#edit_id").val("");
            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            $('.icon-option').removeClass('selected');
            $('#icon1Preview, #icon2Preview, #icon3Preview').removeClass().addClass('fas');
            editId = null;
        });

        // Icon selector functionality
        $('.icon-option').click(function() {
            const iconClass = $(this).data('icon');
            const parentRow = $(this).closest('.galore-input-group');
            const input = parentRow.find('input[type="text"]');
            const previewIcon = parentRow.find('.icon-input-group i');

            // Update input value
            input.val(iconClass);

            // Update preview icon
            previewIcon.removeClass().addClass('fas ' + iconClass);

            // Highlight selected option
            parentRow.find('.icon-option').removeClass('selected');
            $(this).addClass('selected');

            // Trigger validation
            input.trigger('input');
        });

        // Update preview when typing
        $('#icon1Input').on('input', function() {
            $('#icon1Preview').removeClass().addClass('fas ' + $(this).val());
        });

        $('#icon2Input').on('input', function() {
            $('#icon2Preview').removeClass().addClass('fas ' + $(this).val());
        });

        $('#icon3Input').on('input', function() {
            $('#icon3Preview').removeClass().addClass('fas ' + $(this).val());
        });

        // Render table with pagination
        function renderTable() {
            let tbody = $("#schoolTableBody");
            tbody.html("");

            const searchValue = $("#searchInput").val().toLowerCase();
            const filteredData = schoolData.filter(school =>
                school.username.toLowerCase().includes(searchValue) ||
                school.school_name.toLowerCase().includes(searchValue) ||
                school.email.toLowerCase().includes(searchValue)
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
                    tbody.append(`
                    <tr>
                        <td>${school.id}</td>
                        <td><i class="fas ${school.icon1} icon-preview"></i></td>
                        <td>${school.username}</td>
                        <td>${school.school_name}</td>
                       <!-- <td>${school.email}</td>
                        <td><i class="fas ${school.icon2} icon-preview"></i></td>
                        <td><i class="fas ${school.icon3} icon-preview"></i></td>
                        <td>${school.student_count}</td>
                        <td>${school.event_count}</td>
                        <td><span class="count-badge">${school.registered_count}</span></td>-->
                        <td>
                            <div class="d-flex flex-column flex-sm-row gap-2 gap-sm-2">
                                <button class="action-btn btn-view" onclick="viewSchool(${school.id})"> View</button>
                                <button class="action-btn btn-edit" onclick="editSchool(${school.id})"> Edit</button>
                                <button class="action-btn btn-delete" onclick="deleteSchool(${school.id})"> Delete</button>
                            </div>
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
                school.username.toLowerCase().includes(searchValue) ||
                school.school_name.toLowerCase().includes(searchValue) ||
                school.email.toLowerCase().includes(searchValue)
            );
            let totalPages = Math.ceil(filteredData.length / rowsPerPage);

            if (page < 1 || page > totalPages) return;
            currentPage = page;
            renderTable();
        };

        // View school details
        window.viewSchool = function(id) {
            let school = schoolData.find(x => x.id == id);

            $("#v_id").text(school.id);
            $("#v_username").text(school.username);
            $("#v_school_name").text(school.school_name);
            $("#v_email").text(school.email);

            $("#v_icon1").removeClass().addClass('fas ' + school.icon1);
            $("#v_icon1_text").text(school.icon1);
            $("#v_icon1_display").removeClass().addClass('fas ' + school.icon1 + ' fa-2x mx-2');

            $("#v_icon2").removeClass().addClass('fas ' + school.icon2);
            $("#v_icon2_text").text(school.icon2);
            $("#v_icon2_display").removeClass().addClass('fas ' + school.icon2 + ' fa-2x mx-2');

            $("#v_icon3").removeClass().addClass('fas ' + school.icon3);
            $("#v_icon3_text").text(school.icon3);
            $("#v_icon3_display").removeClass().addClass('fas ' + school.icon3 + ' fa-2x mx-2');

            $("#v_student_count").text(school.student_count);
            $("#v_event_count").text(school.event_count);
            $("#v_registered_count").text(school.registered_count);

            new bootstrap.Modal(document.getElementById("viewModal")).show();
        };

        // Delete school
        window.deleteSchool = function(id) {
            if (confirm("Are you sure you want to delete this school?")) {
                window.location.href = "?delete_id=" + id;
            }
        };

        // Edit school
        window.editSchool = function(id) {
            editId = id;
            const school = schoolData.find(x => x.id == id);

            formTitleText.text("Edit School");
            $("#edit_id").val(id);

            // Fill form fields
            $('input[name="icon1"]').val(school.icon1);
            $('input[name="username"]').val(school.username);
            $('input[name="school_name"]').val(school.school_name);
            $('input[name="email"]').val(school.email);
            $('input[name="icon2"]').val(school.icon2);
            $('input[name="icon3"]').val(school.icon3);
            $('input[name="student_count"]').val(school.student_count);
            $('input[name="event_count"]').val(school.event_count);
            $('input[name="registered_count"]').val(school.registered_count);

            // Update icon previews
            $('#icon1Preview').removeClass().addClass('fas ' + school.icon1);
            $('#icon2Preview').removeClass().addClass('fas ' + school.icon2);
            $('#icon3Preview').removeClass().addClass('fas ' + school.icon3);

            // Highlight selected icons
            $('.icon-option').removeClass('selected');
            $(`.icon-option[data-icon="${school.icon1}"]`).addClass('selected');
            $(`.icon-option[data-icon="${school.icon2}"]`).addClass('selected');
            $(`.icon-option[data-icon="${school.icon3}"]`).addClass('selected');

            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");

            addSchoolForm.slideDown();
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

                        // Add alphabetic validation for name
                        if (validationType.includes("alphabetic")) {
                            var alphabet_regex = /^[a-zA-Z\s\.\-\']+$/;
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

                        // Numeric value validation
                        if (validationType.includes("number")) {
                            const numberRegex = /^[0-9]+$/;
                            if (!numberRegex.test(value)) {
                                errorMessage = "Please enter only numbers.";
                            }
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

        // Initial render
        renderTable();
    </script>

</body>

</html>