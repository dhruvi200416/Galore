<?php
include 'ad_rules_circular_handler.php';
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
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom CSS -->
    <style>
        :root {
            --galore-red: #dc3545;
            --galore-gray: #6c757d;
            --galore-dark: #333;
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

        .btn-status-inactive {
            background: linear-gradient(135deg, #6c757d, #495057);
            color: white;
        }

        /* FORM */
        .add-user-form-container {
            background: #ffffff;
            width: 100%;
            max-width: 1200px;
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

        #circularForm {
            display: grid;
            grid-template-columns: 1fr;
            gap: 18px;
        }

        @media (min-width: 768px) {
            #circularForm {
                grid-template-columns: 1fr 1fr;
            }

            .form-buttons {
                grid-column: span 2;
            }

            .rules-grid-form {
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

        .galore-select {
            padding: 13px 15px;
            border: 2px solid #ddd;
            border-radius: 10px;
            font-size: 0.95rem;
            background-color: white;
        }

        .galore-textarea {
            padding: 13px 15px;
            border: 2px solid #ddd;
            border-radius: 10px;
            font-size: 0.95rem;
            min-height: 100px;
            resize: vertical;
        }

        .galore-input:focus,
        .galore-select:focus,
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

        /* FILE ICONS */
        .file-icon {
            font-size: 1.2rem;
            margin-right: 8px;
        }

        .pdf-icon {
            color: #dc3545;
        }

        .word-icon {
            color: #0d6efd;
        }

        .file-link {
            color: #333;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .file-link:hover {
            color: var(--galore-red);
            padding-left: 5px;
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

        /* DETAILS GRID FOR MODAL */
        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .details-full {
            grid-column: span 2;
        }

        .rule-block {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            border-left: 4px solid var(--galore-red);
        }

        .rule-block h6 {
            color: var(--galore-red);
            font-weight: 700;
            margin-bottom: 10px;
            border-bottom: 2px solid #ffe3e6;
            padding-bottom: 5px;
        }

        .rule-block p {
            margin: 5px 0;
            font-size: 0.9rem;
        }

        .rule-badge {
            display: inline-block;
            background: var(--galore-red);
            color: white;
            padding: 3px 10px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
            margin: 2px;
        }

        /* Enhanced Modal Styles */
        .modal-xl-custom {
            max-width: 1400px;
            
        }
        
        .modal-dialog-centered {
            display: flex;
            align-items: center;
            min-height: calc(100% - 3.5rem);
        }

        .modal-content {
            border-radius: 18px;
            border-top: 6px solid var(--galore-red);
        }

        .modal-header {
            background: var(--galore-red);
            color: white;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .modal-body {
            padding: 30px;
        }

        /* Rules Grid for Modal */
        .rules-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        /* Rules Grid for Form */
        .rules-grid-form {
            background: #fff9f9;
            border-radius: 15px;
            padding: 20px;
            border: 2px dashed var(--galore-red);
            margin-top: 15px;
        }

        .rule-category {
            background: white;
            border-radius: 10px;
            padding: 15px;
            border: 1px solid #ffe3e6;
        }

        .rule-category h5 {
            color: var(--galore-red);
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .rule-item-input {
            margin-bottom: 10px;
        }

        .rule-item-input label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #555;
            margin-bottom: 3px;
        }

        .remove-rule {
            color: var(--galore-red);
            cursor: pointer;
            font-size: 0.9rem;
        }

        .add-rule-btn {
            background: none;
            border: 2px dashed var(--galore-red);
            color: var(--galore-red);
            padding: 10px;
            border-radius: 8px;
            width: 100%;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .add-rule-btn:hover {
            background: var(--galore-red);
            color: white;
        }
    </style>
</head>

<body>

    <?php require 'admin_header.php'; ?>

    <main class="main-content">

        <div class="top-bar d-flex justify-content-between align-items-center flex-wrap gap-3" id="topBar">
            <h1 class="mb-0"><i class="fas fa-file-alt me-2"></i>Rules & Circulars Management</h1>
            <button class="btn-add-user" id="openFormBtn">
                <i class="bi bi-plus-circle"></i> Add Circular
            </button>
        </div>

        <!-- ADD/EDIT FORM -->
        <div class="add-user-form-container" id="addCircularForm" style="display:none;">
            <h3 class="form-title" id="formTitleText">Add New Circular</h3>

            <form id="circularForm" method="POST" action="">
                <input type="hidden" name="edit_id" id="edit_id" value="">
                <input type="hidden" name="detailed_rules" id="detailed_rules_input" value="">

                <div class="galore-input-group">
                    <label class="galore-label">Date <span class="text-danger">*</span></label>
                    <input type="text" name="date" class="galore-input" data-validation="required" placeholder="DD/MM/YYYY">
                    <span id="date_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Event Name <span class="text-danger">*</span></label>
                    <input type="text" name="display_name" class="galore-input" data-validation="required min" data-min="3" data-max="100" placeholder="e.g., Cricket Rules">
                    <span id="display_name_error" class="error-message"></span>
                </div>

                <!-- Detailed Rules Section -->
                <div class="rules-grid-form" id="rulesGridForm">
                    <h5 class="text-danger mb-3"><i class="fas fa-list-ul me-2"></i>Detailed Rules</h5>
                    <div id="rulesCategories"></div>
                    <button type="button" class="add-rule-btn mt-3" id="addCategoryBtn">
                        <i class="fas fa-plus-circle me-2"></i>Add Rule Category
                    </button>
                </div>

                <div class="form-buttons">
                    <button type="submit" name="submit" class="btn-save">Save Circular</button>
                    <button type="button" class="btn-cancel" id="cancelForm">Cancel</button>
                </div>

            </form>
        </div>

        <!-- DATA TABLE -->
        <div class="data-table-container">
            <div class="table-header" id="tableHeader">
                <h2 class="mb-0">Circulars List</h2>
                <div class="search-box" id="searchBox">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchInput" placeholder="Search circulars...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Event Name</th>
                            <th>Status</th>
                            <th id="actionsHeader">Actions</th>
                        </thead>
                    <tbody id="circularTableBody"></tbody>
                 </table>
            </div>

            <div class="pagination-container">
                <ul class="pagination" id="pagination"></ul>
            </div>
        </div>

    </main>

    <!-- VIEW MODAL - Enhanced with detailed rules -->
    <div class="modal fade"style="margin-left:20%;" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="viewModalLabel"><i class="fas fa-file-alt me-2"></i><span id="v_display_name"></span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Basic Information -->
                    <div class="details-grid">
                        <div class="rule-block">
                            <h6><i class="fas fa-hashtag me-2"></i>ID</h6>
                            <p id="v_id"></p>
                        </div>
                        <div class="rule-block">
                            <h6><i class="fas fa-calendar me-2"></i>Date</h6>
                            <p id="v_date"></p>
                        </div>
                        <div class="rule-block">
                            <h6><i class="fas fa-tag me-2"></i>Status</h6>
                            <p id="v_status"></p>
                        </div>
                    </div>

                    <!-- Preview Link -->
                    <div class="rule-block mb-3">
                        <h6><i class="fas fa-link me-2"></i>Preview Link</h6>
                        <div class="p-3 border rounded bg-light">
                            <a href="#" id="v_preview_link" target="_blank" class="file-link">
                                <i id="v_preview_icon" class="fa-solid fa-file-text text-secondary me-2"></i>
                                <span id="v_preview_text"></span>
                            </a>
                        </div>
                        <small class="text-muted">Click to view/download the file</small>
                    </div>

                    <!-- Detailed Rules Section -->
                    <div class="rule-block" id="detailedRulesSection">
                        <h6><i class="fas fa-list-ul me-2"></i>Detailed Rules</h6>
                        <div id="v_detailed_rules" class="rules-grid mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Use PHP to pass database circulars to JavaScript
        let circularData = <?php echo json_encode($circularData); ?>;

        // If no circulars in database, use empty array
        if (!circularData || circularData.length === 0) {
            circularData = [];
        }

        const rowsPerPage = 5;
        let currentPage = 1;
        let editId = null;
        let categoryCounter = 0;

        const addCircularForm = $("#addCircularForm");
        const formTitleText = $("#formTitleText");

        // Toggle status function - no alert
        function toggleStatus(id) {
            window.location.href = "?toggle_status=" + id;
        }

        // Function to add new rule category to form
        function addRuleCategory(categoryData = null) {
            categoryCounter++;
            const categoryId = `category_${categoryCounter}`;

            let categoryHtml = `
                <div class="rule-category mb-3" id="${categoryId}">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <input type="text" class="galore-input category-name" placeholder="Category Name (e.g., Timings)" value="${categoryData ? categoryData.category : ''}" style="width: 70%;">
                        <span class="remove-rule" onclick="removeCategory('${categoryId}')"><i class="fas fa-trash-alt"></i> Remove</span>
                    </div>
                    <div class="rules-list" id="${categoryId}_rules">`;

            if (categoryData && categoryData.rules) {
                categoryData.rules.forEach(rule => {
                    categoryHtml += `
                        <div class="rule-item-input mb-2">
                            <input type="text" class="galore-input rule-text" placeholder="Rule" value="${rule.replace(/"/g, '&quot;')}">
                        </div>`;
                });
            } else {
                categoryHtml += `
                        <div class="rule-item-input mb-2">
                            <input type="text" class="galore-input rule-text" placeholder="Rule">
                        </div>`;
            }

            categoryHtml += `
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="addRule('${categoryId}')">
                        <i class="fas fa-plus-circle"></i> Add Rule
                    </button>
                </div>`;

            $("#rulesCategories").append(categoryHtml);
        }

        // Function to add rule to a category
        window.addRule = function(categoryId) {
            $(`#${categoryId}_rules`).append(`
                <div class="rule-item-input mb-2">
                    <input type="text" class="galore-input rule-text" placeholder="Rule">
                </div>
            `);
        };

        // Function to remove category
        window.removeCategory = function(categoryId) {
            $(`#${categoryId}`).remove();
        };

        // Add category button click
        $("#addCategoryBtn").click(() => {
            addRuleCategory();
        });

        // Open form button
        $("#openFormBtn").click(() => {
            formTitleText.text("Add New Circular");
            editId = null;
            $("#edit_id").val("");
            $("#circularForm")[0].reset();
            $("#rulesCategories").empty();
            categoryCounter = 0;
            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            addRuleCategory(); // Add one empty category by default
            addCircularForm.slideDown();
        });

        // Cancel form button
        $("#cancelForm").click(() => {
            addCircularForm.slideUp();
            $("#circularForm")[0].reset();
            $("#edit_id").val("");
            $("#rulesCategories").empty();
            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            editId = null;
        });

        // Helper function to escape HTML
        function escapeHtml(text) {
            if (!text) return '';
            return text.replace(/[&<>]/g, function(m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }

        // Render table with pagination
        function renderTable() {
            let tbody = $("#circularTableBody");
            tbody.html("");

            const searchValue = $("#searchInput").val().toLowerCase();
            const filteredData = circularData.filter(c =>
                c.display_name.toLowerCase().includes(searchValue) ||
                c.circular_date.toLowerCase().includes(searchValue)
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
                paginatedData.forEach(c => {
                    const statusClass = c.status === 'Active' ? 'btn-status-active' : 'btn-status-inactive';
                    
                    tbody.append(`
                        <tr>
                            <td>${c.id}</td>
                            <td>${escapeHtml(c.circular_date)}</td>
                            <td>${escapeHtml(c.display_name)}</td>
                            <td>
                                <button class="btn-status ${statusClass}" onclick="toggleStatus(${c.id})">
                                    ${c.status}
                                </button>
                            </td>
                            <td>
                                <button class="action-btn btn-view" onclick="viewCircular(${c.id})"> View</button>
                                <button class="action-btn btn-edit" onclick="editCircular(${c.id})"> Edit</button>
                                <button class="action-btn btn-delete" onclick="deleteCircular(${c.id})"> Delete</button>
                            </td>
                        </tr>
                    `);
                });
            }

            renderPagination(filteredData.length);
        }

        // Render pagination controls
        function renderPagination(totalRows) {
            let totalPages = Math.ceil(totalRows / rowsPerPage);
            let pagination = $("#pagination");
            pagination.html("");

            if (totalPages === 0) {
                pagination.html('<li class="page-item disabled"><a class="page-link">No data</a></li>');
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

        // Navigate to page
        function goPage(page) {
            const searchValue = $("#searchInput").val().toLowerCase();
            const filteredData = circularData.filter(c =>
                c.display_name.toLowerCase().includes(searchValue) ||
                c.circular_date.toLowerCase().includes(searchValue)
            );
            let totalPages = Math.ceil(filteredData.length / rowsPerPage);
            if (page < 1 || page > totalPages) return;
            currentPage = page;
            renderTable();
        }

        // View circular details
        function viewCircular(id) {
            let c = circularData.find(x => x.id == id);

            // Set basic info
            $("#v_id").text(c.id);
            $("#v_date").text(c.circular_date);
            $("#v_display_name").text(c.display_name);
            $("#v_status").html(`<span class="badge ${c.status === 'Active' ? 'bg-success' : 'bg-secondary'}">${c.status}</span>`);

            // Set preview link
            $("#v_preview_link").attr("href", "#");
            $("#v_preview_text").text(c.display_name);

            // Display detailed rules
            if (c.detailed_rules && c.detailed_rules.length > 0) {
                let rulesHtml = '';
                c.detailed_rules.forEach(category => {
                    rulesHtml += `<div class="rule-block">`;
                    rulesHtml += `<h6>${escapeHtml(category.category)}</h6>`;
                    category.rules.forEach(rule => {
                        rulesHtml += `<p>${escapeHtml(rule)}</p>`;
                    });
                    rulesHtml += `</div>`;
                });
                $("#v_detailed_rules").html(rulesHtml);
            } else {
                $("#v_detailed_rules").html('<p class="text-muted">No detailed rules available.</p>');
            }

            // Show modal
            const modalElement = document.getElementById('viewModal');
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
        }

        // Delete circular
        function deleteCircular(id) {
            if (confirm("Are you sure you want to delete this circular?")) {
                window.location.href = "?delete_id=" + id;
            }
        }

        // Edit circular
        function editCircular(id) {
            editId = id;
            const c = circularData.find(x => x.id == id);
            formTitleText.text("Edit Circular");
            $("#edit_id").val(id);

            // Populate form fields
            $('input[name="date"]').val(c.circular_date);
            $('input[name="display_name"]').val(c.display_name);

            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");

            // Populate rules categories
            $("#rulesCategories").empty();
            categoryCounter = 0;
            if (c.detailed_rules && c.detailed_rules.length > 0) {
                c.detailed_rules.forEach(category => {
                    addRuleCategory(category);
                });
            } else {
                addRuleCategory();
            }

            addCircularForm.slideDown();
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

            // Circular form submission with validation
            $("#circularForm").on("submit", function(e) {
                let isValid = true;
                let firstInvalidField = null;

                $(this).find("input, textarea, select").each(function() {
                    // Skip validation for rule category inputs and rule text inputs as they're optional
                    if ($(this).hasClass('category-name') || $(this).hasClass('rule-text')) {
                        return true;
                    }
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

                // Collect rules data
                let detailedRules = [];
                $(".rule-category").each(function() {
                    let categoryName = $(this).find(".category-name").val().trim();
                    if (categoryName) {
                        let rules = [];
                        $(this).find(".rule-text").each(function() {
                            let ruleText = $(this).val().trim();
                            if (ruleText) {
                                rules.push(ruleText);
                            }
                        });
                        if (rules.length > 0) {
                            detailedRules.push({
                                category: categoryName,
                                rules: rules
                            });
                        }
                    }
                });

                // Set the detailed rules as JSON in hidden input
                $("#detailed_rules_input").val(JSON.stringify(detailedRules));

                // If validation passes, allow form to submit normally
                return true;
            });
        });

        // Initial render
        renderTable();
    </script>

</body>

</html>