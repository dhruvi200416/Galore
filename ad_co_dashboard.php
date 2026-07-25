<?php
// At the very top of admin_dashboard.php
require_once 'admin_auth_check.php';

// Now you can access admin session variables
$admin_name = $_SESSION['full_name'];
$admin_role = $_SESSION['role'];
$admin_email = $_SESSION['email'];

include 'ad_co_dashboard_handler.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | RKU Galore </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS - Same as reference code -->
    <style>
        :root {
            --galore-red: #dc3545;
            --galore-red-dark: #b02a37;
            --galore-gray: #6c757d;
            --galore-dark: #333;
            --galore-light: #f8f9fa;
            --galore-white: #ffffff;
            --light-red: #f8d7da;
            --glass: rgba(255, 255, 255, 0.05);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f9;
        }

        /* ADD BUTTON - Matching reference style */
        .btn-add-table1,
        .btn-add-table2,
        .btn-add-table3 {
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

        .btn-add-table1:hover,
        .btn-add-table2:hover,
        .btn-add-table3:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(220, 53, 69, 0.45);
        }

        .btn-add-table1 i,
        .btn-add-table2 i,
        .btn-add-table3 i {
            font-size: 1.2rem;
            margin-right: 8px;
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

        /* Status Badges for Events - UPDATED with icons */
        .badge-scheduled {
            background: rgba(40, 167, 69, 0.15);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.3);
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .badge-pending {
            background: rgba(255, 193, 7, 0.15);
            color: #ffc107;
            border: 1px solid rgba(255, 193, 7, 0.3);
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .badge-upcoming {
            background: rgba(23, 162, 184, 0.15);
            color: #17a2b8;
            border: 1px solid rgba(23, 162, 184, 0.3);
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .badge-completed {
            background: rgba(108, 117, 125, 0.15);
            color: #6c757d;
            border: 1px solid rgba(108, 117, 125, 0.3);
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        /* FORM CONTAINERS */
        .add-form-container {
            background: #ffffff;
            width: 100%;
            max-width: 1000px;
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

        /* FORM GRID */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        .full-width {
            grid-column: span 2;
        }

        @media (max-width: 768px) {
            .full-width {
                grid-column: span 1;
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
            min-height: 100px;
            resize: vertical;
        }

        .galore-select {
            padding: 13px 15px;
            border: 2px solid #ddd;
            border-radius: 10px;
            font-size: 0.95rem;
            background-color: white;
        }

        .galore-input:focus,
        .galore-textarea:focus,
        .galore-select:focus {
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
            grid-column: span 2;
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .form-buttons {
                grid-column: span 1;
            }
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
            font-size: 1rem;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.4);
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
            min-width: 300px;
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
            white-space: nowrap;
        }

        .data-table td {
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
            vertical-align: middle;
        }

        .data-table tbody tr:hover {
            background: rgba(220, 53, 69, 0.1);
        }

        /* ICON PREVIEW */
        .icon-preview {
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(220, 53, 69, 0.1);
            border-radius: 8px;
            color: var(--galore-red);
        }

        /* ACTION BUTTONS */
        .action-btn {
            padding: 8px 15px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
            margin-right: 5px;
            font-size: 0.85rem;
        }

        .action-btn:last-child {
            margin-right: 0;
        }

        .action-btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
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

        /* TOP BAR */
        .top-bar {
            background: #ffffff;
            padding: 25px 30px;
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

        .main-content {
            padding: 30px;
            max-width: 1600px;
            margin: 0 auto;
        }

        /* MODAL STYLES */
        .modal-content {
            border-radius: 18px;
            border-top: 6px solid var(--galore-red);
        }

        .modal-header {
            background: var(--galore-red);
            color: white;
            padding: 20px;
            border-radius: 18px 18px 0 0;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        .modal-body {
            padding: 30px;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .detail-item {
            margin-bottom: 10px;
        }

        .detail-item.full-width {
            grid-column: span 2;
        }

        .detail-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--galore-gray);
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .detail-value {
            font-size: 1rem;
            padding: 12px 15px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid var(--galore-red);
            word-break: break-word;
        }

        .modal-footer {
            padding: 20px;
            border-top: 1px solid #dee2e6;
            justify-content: center;
        }

        .modal-footer .btn-secondary {
            background: var(--galore-gray);
            border: none;
            padding: 10px 30px;
            border-radius: 8px;
            font-weight: 600;
        }

        .modal-footer .btn-secondary:hover {
            background: #5a6268;
        }
    </style>
</head>

<body>

    <?php require 'ad_co_header.php'; ?>

    <main class="main-content">

        <!-- ==================== TABLE 1: C_DASH1 ==================== -->
        <div class="top-bar d-flex justify-content-between align-items-center flex-wrap gap-3">
            <h1 class="mb-0">Table 1: Coordinator Management</h1>
            <!-- <button class="btn-add-table1" id="openTable1FormBtn">
                <i class="bi bi-plus-circle"></i> Add Record
            </button> -->
        </div>

        <!-- TABLE 1 FORM -->
        <div class="add-form-container" id="addTable1Form">
            <h3 class="form-title" id="table1FormTitleText">Add Record to Table 1</h3>

            <form id="table1Form" method="POST" action="">
                <input type="hidden" name="edit_id" id="table1_edit_id" value="">

                <div class="form-grid">
                    <div class="galore-input-group">
                        <label class="galore-label">Hero Title <span class="text-danger">*</span></label>
                        <input type="text" name="hero_title" class="galore-input" data-validation="required min" data-min="5" data-max="100">
                        <span id="hero_title_error" class="error-message"></span>
                    </div>

                    <div class="galore-input-group">
                        <label class="galore-label">Hero Sub <span class="text-danger">*</span></label>
                        <input type="text" name="hero_sub" class="galore-input" data-validation="required min" data-min="10" data-max="200">
                        <span id="hero_sub_error" class="error-message"></span>
                    </div>

                    <div class="galore-input-group">
                        <label class="galore-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="galore-input" data-validation="required min" data-min="3" data-max="100">
                        <span id="title_error" class="error-message"></span>
                    </div>

                    <div class="galore-input-group">
                        <label class="galore-label">Icon 1 <span class="text-danger">*</span></label>
                        <input type="text" name="icon1" class="galore-input" data-validation="required min" data-min="3" data-max="50" placeholder="e.g., bi-person-badge">
                        <span id="icon1_error" class="error-message"></span>
                    </div>

                    <div class="galore-input-group">
                        <label class="galore-label">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="galore-input" data-validation="required min alphabetic" data-min="3" data-max="100">
                        <span id="name_error" class="error-message"></span>
                    </div>

                    <div class="galore-input-group">
                        <label class="galore-label">Role <span class="text-danger">*</span></label>
                        <input type="text" name="role" class="galore-input" data-validation="required min" data-min="3" data-max="100">
                        <span id="role_error" class="error-message"></span>
                    </div>

                    <div class="galore-input-group full-width">
                        <label class="galore-label">Icon 2 <span class="text-danger">*</span></label>
                        <input type="text" name="icon2" class="galore-input" data-validation="required min" data-min="3" data-max="50" placeholder="e.g., bi-award">
                        <span id="icon2_error" class="error-message"></span>
                    </div>
                </div>

                <div class="form-buttons">
                    <button type="submit" name="submit_c_dash1" class="btn-save">Save Record</button>
                    <button type="button" class="btn-cancel" id="cancelTable1Form">Cancel</button>
                </div>
            </form>
        </div>

        <!-- TABLE 1 DATA TABLE - UPDATED to show only ID, Hero Title, Hero Sub, Name, Status, Actions -->
        <div class="data-table-container">
            <div class="table-header">
                <h2>Table 1: Coordinator Records</h2>
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchTable1Input" placeholder="Search records...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Hero Title</th>
                            <th>Hero Sub</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="table1TableBody"></tbody>
                </table>
            </div>

            <div class="pagination-container">
                <ul class="pagination" id="table1Pagination"></ul>
            </div>
        </div>

        <!-- ==================== TABLE 2: C_DASH2 ==================== -->
        <div class="top-bar d-flex justify-content-between align-items-center flex-wrap gap-3" style="margin-top: 40px;">
            <h1 class="mb-0">Table 2: Icon & Count Management</h1>
            <button class="btn-add-table2" id="openTable2FormBtn">
                <i class="bi bi-plus-circle"></i> Add Record
            </button>
        </div>

        <!-- TABLE 2 FORM -->
        <div class="add-form-container" id="addTable2Form">
            <h3 class="form-title" id="table2FormTitleText">Add Record to Table 2</h3>

            <form id="table2Form" method="POST" action="">
                <input type="hidden" name="edit_id" id="table2_edit_id" value="">

                <div class="form-grid">
                    <div class="galore-input-group">
                        <label class="galore-label">Icon <span class="text-danger">*</span></label>
                        <input type="text" name="icon" class="galore-input" data-validation="required min" data-min="3" data-max="50" placeholder="e.g., bi-people">
                        <span id="icon_error" class="error-message"></span>
                    </div>

                    <div class="galore-input-group">
                        <label class="galore-label">Count <span class="text-danger">*</span></label>
                        <input type="number" name="count" class="galore-input" data-validation="required number" data-min="0">
                        <span id="count_error" class="error-message"></span>
                    </div>

                    <div class="galore-input-group full-width">
                        <label class="galore-label">Detail <span class="text-danger">*</span></label>
                        <textarea name="detail" class="galore-textarea" data-validation="required min" data-min="5" data-max="500"></textarea>
                        <span id="detail_error" class="error-message"></span>
                    </div>
                </div>

                <div class="form-buttons">
                    <button type="submit" name="submit_c_dash2" class="btn-save">Save Record</button>
                    <button type="button" class="btn-cancel" id="cancelTable2Form">Cancel</button>
                </div>
            </form>
        </div>

        <!-- TABLE 2 DATA TABLE - FIXED to display icons properly -->
        <div class="data-table-container">
            <div class="table-header">
                <h2>Table 2: Icon & Count Records</h2>
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchTable2Input" placeholder="Search records...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Icon</th>
                            <th>Count</th>
                            <th>Detail</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="table2TableBody"></tbody>
                </table>
            </div>

            <div class="pagination-container">
                <ul class="pagination" id="table2Pagination"></ul>
            </div>
        </div>

        <!-- ==================== TABLE 3: C_DASH3 (Same as Original Events) ==================== -->
        <div class="top-bar d-flex justify-content-between align-items-center flex-wrap gap-3" style="margin-top: 40px;">
            <h1 class="mb-0">Table 3: Events Management</h1>
            <button class="btn-add-table3" id="openTable3FormBtn">
                <i class="bi bi-plus-circle"></i> Add Event
            </button>
        </div>

        <!-- TABLE 3 FORM -->
        <div class="add-form-container" id="addTable3Form">
            <h3 class="form-title" id="table3FormTitleText">Add Event</h3>

            <form id="table3Form" method="POST" action="">
                <input type="hidden" name="edit_id" id="table3_edit_id" value="">

                <div class="form-grid">
                    <div class="galore-input-group">
                        <label class="galore-label">Event Name <span class="text-danger">*</span></label>
                        <input type="text" name="event_name" class="galore-input" data-validation="required min" data-min="3" data-max="100">
                        <span id="event_name_error" class="error-message"></span>
                    </div>

                    <div class="galore-input-group">
                        <label class="galore-label">Category <span class="text-danger">*</span></label>
                        <select name="category" class="galore-select" data-validation="required select">
                            <option value="">Select Category</option>
                            <option value="Boys & Girls">Boys & Girls</option>
                            <option value="Boys">Boys Only</option>
                            <option value="Girls">Girls Only</option>
                            <option value="Open">Open</option>
                        </select>
                        <span id="category_error" class="error-message"></span>
                    </div>

                    <div class="galore-input-group">
                        <label class="galore-label">School <span class="text-danger">*</span></label>
                        <select name="school" class="galore-select" data-validation="required select">
                            <option value="">Select School</option>
                            <option value="All Schools">All Schools</option>
                            <option value="Engineering">Engineering</option>
                            <option value="Management">Management</option>
                            <option value="Science">Science</option>
                            <option value="Commerce">Commerce</option>
                            <option value="Arts & Culture">Arts & Culture</option>
                        </select>
                        <span id="school_error" class="error-message"></span>
                    </div>

                    <div class="galore-input-group">
                        <label class="galore-label">Date Range <span class="text-danger">*</span></label>
                        <input type="text" name="date_range" class="galore-input" data-validation="required min" data-min="5" data-max="50" placeholder="e.g., 15-17 Feb 2026">
                        <span id="date_range_error" class="error-message"></span>
                    </div>

                    <div class="galore-input-group">
                        <label class="galore-label">Time <span class="text-danger">*</span></label>
                        <input type="time" name="time" class="galore-input" data-validation="required">
                        <span id="time_error" class="error-message"></span>
                    </div>

                    <div class="galore-input-group">
                        <label class="galore-label">Venue <span class="text-danger">*</span></label>
                        <input type="text" name="venue" class="galore-input" data-validation="required min" data-min="3" data-max="100">
                        <span id="venue_error" class="error-message"></span>
                    </div>

                    <div class="galore-input-group">
                        <label class="galore-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="galore-select" data-validation="required select">
                            <option value="">Select Status</option>
                            <option value="Scheduled">Scheduled</option>
                            <option value="Pending">Pending</option>
                            <option value="Upcoming">Upcoming</option>
                            <option value="Completed">Completed</option>
                        </select>
                        <span id="status_error" class="error-message"></span>
                    </div>

                    <div class="galore-input-group">
                        <label class="galore-label">Total Registrations <span class="text-danger">*</span></label>
                        <input type="number" name="total_registrations" class="galore-input" data-validation="required number" data-min="0">
                        <span id="total_registrations_error" class="error-message"></span>
                    </div>

                    <div class="galore-input-group">
                        <label class="galore-label">Pending Registrations <span class="text-danger">*</span></label>
                        <input type="number" name="pending_registrations" class="galore-input" data-validation="required number" data-min="0">
                        <span id="pending_registrations_error" class="error-message"></span>
                    </div>

                    <div class="galore-input-group full-width">
                        <label class="galore-label">Icon <span class="text-danger">*</span></label>
                        <select name="event_icon" class="galore-select" data-validation="required select">
                            <option value="">Select Icon</option>
                            <option value="fa-futbol">Football</option>
                            <option value="fa-baseball-ball">Cricket</option>
                            <option value="fa-basketball-ball">Basketball</option>
                            <option value="fa-volleyball-ball">Volleyball</option>
                            <option value="fa-running">Athletics</option>
                            <option value="fa-chess">Chess</option>
                        </select>
                        <span id="event_icon_error" class="error-message"></span>
                    </div>
                </div>

                <div class="form-buttons">
                    <button type="submit" name="submit_c_dash3" class="btn-save">Save Event</button>
                    <button type="button" class="btn-cancel" id="cancelTable3Form">Cancel</button>
                </div>
            </form>
        </div>

        <!-- TABLE 3 DATA TABLE - UPDATED with status icons -->
        <div class="data-table-container">
            <div class="table-header">
                <h2>Table 3: Events List</h2>
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchTable3Input" placeholder="Search events...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Event Name</th>
                            <th>Category</th>
                            <th>School</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="table3TableBody"></tbody>
                </table>
            </div>

            <div class="pagination-container">
                <ul class="pagination" id="table3Pagination"></ul>
            </div>
        </div>

    </main>

    <!-- VIEW MODAL FOR TABLE 1 -->
    <div class="modal fade" id="viewTable1Modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Table 1: Coordinator Full Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-label">ID</div>
                            <div class="detail-value" id="v1_id"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Hero Title</div>
                            <div class="detail-value" id="v1_hero_title"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Hero Sub</div>
                            <div class="detail-value" id="v1_hero_sub"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Title</div>
                            <div class="detail-value" id="v1_title"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Icon 1</div>
                            <div class="detail-value">
                                <i class="bi" id="v1_icon1_display"></i> <span id="v1_icon1"></span>
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Name</div>
                            <div class="detail-value" id="v1_name"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Role</div>
                            <div class="detail-value" id="v1_role"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Icon 2</div>
                            <div class="detail-value">
                                <i class="bi" id="v1_icon2_display"></i> <span id="v1_icon2"></span>
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Status</div>
                            <div class="detail-value" id="v1_status"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- VIEW MODAL FOR TABLE 2 -->
    <div class="modal fade" id="viewTable2Modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Table 2: Icon & Count Full Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-label">ID</div>
                            <div class="detail-value" id="v2_id"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Icon</div>
                            <div class="detail-value">
                                <i class="bi" id="v2_icon_display"></i> <span id="v2_icon"></span>
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Count</div>
                            <div class="detail-value" id="v2_count"></div>
                        </div>
                        <div class="detail-item full-width">
                            <div class="detail-label">Detail</div>
                            <div class="detail-value" id="v2_detail"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Status</div>
                            <div class="detail-value" id="v2_status"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- VIEW MODAL FOR TABLE 3 (Same as Original Events) -->
    <div class="modal fade" id="viewTable3Modal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Table 3: Event Full Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-label">ID</div>
                            <div class="detail-value" id="v3_id"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Event Name</div>
                            <div class="detail-value" id="v3_name"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Category</div>
                            <div class="detail-value" id="v3_category"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">School</div>
                            <div class="detail-value" id="v3_school"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Date Range</div>
                            <div class="detail-value" id="v3_date"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Time</div>
                            <div class="detail-value" id="v3_time"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Venue</div>
                            <div class="detail-value" id="v3_venue"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Status</div>
                            <div class="detail-value" id="v3_status"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Total Registrations</div>
                            <div class="detail-value" id="v3_total"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Pending Registrations</div>
                            <div class="detail-value" id="v3_pending"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Icon</div>
                            <div class="detail-value">
                                <i class="fas" id="v3_icon_display"></i> <span id="v3_icon"></span>
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
        // Pass PHP data to JavaScript
        let table1Data = <?php echo json_encode($c_dash1Data); ?>;
        let table2Data = <?php echo json_encode($c_dash2Data); ?>;
        let table3Data = <?php echo json_encode($c_dash3Data); ?>;

        // If no data in database, use empty array
        if (!table1Data || table1Data.length === 0) {
            table1Data = [];
        }
        if (!table2Data || table2Data.length === 0) {
            table2Data = [];
        }
        if (!table3Data || table3Data.length === 0) {
            table3Data = [];
        }

        // Pagination settings
        const rowsPerPage = 5;
        let table1CurrentPage = 1;
        let table2CurrentPage = 1;
        let table3CurrentPage = 1;
        let table1EditId = null;
        let table2EditId = null;
        let table3EditId = null;

        // ==================== VALIDATION FUNCTION ====================
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

                    if (validationType.includes("alphabetic")) {
                        // This regex allows letters, numbers, spaces, commas, and emojis/unicode characters
                        if (!/^[\p{L}\p{N}\p{P}\p{S}\s,]+$/u.test(value)) {
                            errorMessage = "Please enter valid characters (letters, numbers, spaces, commas, and emojis allowed).";
                        }
                        // For specific fields that might contain emojis
                        if (field.attr("name") === "name" || field.attr("name") === "hero_title" || field.attr("name") === "title" || field.attr("name") === "detail") {
                            // Skip additional validation for fields that might contain emojis
                        } else if (!/^[a-zA-Z\s,]+$/.test(value)) {
                            // For other fields that shouldn't have emojis, use stricter validation
                            errorMessage = "Please enter alphabetic characters and commas only.";
                        }
                    }

                    if (validationType.includes("number")) {
                        const numberRegex = /^[0-9]+$/;
                        if (!numberRegex.test(value)) {
                            errorMessage = "Please enter only numbers.";
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

        // ==================== TABLE 1 FUNCTIONS ====================

        // Open table 1 form
        $("#openTable1FormBtn").click(() => {
            $("#table1FormTitleText").text("Add Record to Table 1");
            table1EditId = null;
            $("#table1_edit_id").val("");
            $("#table1Form")[0].reset();
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            $("#addTable1Form").slideDown();
            $("#addTable2Form, #addTable3Form").slideUp();
        });

        // Cancel table 1 form
        $("#cancelTable1Form").click(() => {
            $("#addTable1Form").slideUp();
            $("#table1Form")[0].reset();
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            table1EditId = null;
        });

        // Render table 1 - UPDATED to show only ID, Hero Title, Hero Sub, Name, Status, Actions
        function renderTable1() {
            let tbody = $("#table1TableBody");
            tbody.html("");

            const searchValue = $("#searchTable1Input").val().toLowerCase();
            const filteredData = table1Data.filter(item =>
                (item.hero_title && item.hero_title.toLowerCase().includes(searchValue)) ||
                (item.hero_sub && item.hero_sub.toLowerCase().includes(searchValue)) ||
                (item.name && item.name.toLowerCase().includes(searchValue))
            );

            const start = (table1CurrentPage - 1) * rowsPerPage;
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
                paginatedData.forEach(item => {
                    let statusClass = item.status === 'Active' ? 'btn-status-active' : 'btn-status-inactive';
                    tbody.append(`
                    <tr>
                        <td>${item.id}</td>
                        <td>${item.hero_title ? (item.hero_title.substring(0, 25) + (item.hero_title.length > 25 ? '...' : '')) : ''}</td>
                        <td>${item.hero_sub ? (item.hero_sub.substring(0, 25) + (item.hero_sub.length > 25 ? '...' : '')) : ''}</td>
                        <td>${item.name || ''}</td>
                        <td>
                            <button class="btn-status ${statusClass}" onclick="toggleTable1Status(${item.id})">
                                ${item.status}
                            </button>
                        </td>
                        <td>
                            <button class="action-btn btn-view" onclick="viewTable1(${item.id})">View</button>
                            <button class="action-btn btn-edit" onclick="editTable1(${item.id})">Edit</button>
                            <button class="action-btn btn-delete" onclick="deleteTable1(${item.id})">Delete</button>
                        </td>
                    </tr>`);
                });
            }

            renderTable1Pagination(filteredData.length);
        }

        // Toggle table 1 status
        function toggleTable1Status(id) {
            window.location.href = "?toggle_c_dash1_id=" + id;
        }

        // Render table 1 pagination
        function renderTable1Pagination(totalRows) {
            let totalPages = Math.ceil(totalRows / rowsPerPage);
            let pagination = $("#table1Pagination");
            pagination.html("");

            if (totalPages === 0 || totalPages === 1) {
                return;
            }

            pagination.append(`
                <li class="page-item ${table1CurrentPage === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="changeTable1Page(${table1CurrentPage - 1})">Previous</a>
                </li>
            `);

            for (let i = 1; i <= totalPages; i++) {
                pagination.append(`
                    <li class="page-item ${i === table1CurrentPage ? 'active' : ''}">
                        <a class="page-link" href="#" onclick="changeTable1Page(${i})">${i}</a>
                    </li>
                `);
            }

            pagination.append(`
                <li class="page-item ${table1CurrentPage === totalPages ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="changeTable1Page(${table1CurrentPage + 1})">Next</a>
                </li>
            `);
        }

        // Change table 1 page
        function changeTable1Page(page) {
            const filteredData = table1Data.filter(item =>
                (item.hero_title && item.hero_title.toLowerCase().includes($("#searchTable1Input").val().toLowerCase())) ||
                (item.hero_sub && item.hero_sub.toLowerCase().includes($("#searchTable1Input").val().toLowerCase())) ||
                (item.name && item.name.toLowerCase().includes($("#searchTable1Input").val().toLowerCase()))
            );
            let totalPages = Math.ceil(filteredData.length / rowsPerPage);
            if (page < 1 || page > totalPages) return;
            table1CurrentPage = page;
            renderTable1();
        }

        // View table 1
        function viewTable1(id) {
            let item = table1Data.find(x => x.id == id);
            $("#v1_id").text(item.id);
            $("#v1_hero_title").text(item.hero_title || '');
            $("#v1_hero_sub").text(item.hero_sub || '');
            $("#v1_title").text(item.title || '');
            $("#v1_icon1").text(item.icon1 || '');
            $("#v1_icon1_display").attr('class', `bi ${item.icon1 || ''}`);
            $("#v1_name").text(item.name || '');
            $("#v1_role").text(item.role || '');
            $("#v1_icon2").text(item.icon2 || '');
            $("#v1_icon2_display").attr('class', `bi ${item.icon2 || ''}`);
            $("#v1_status").text(item.status || '');
            new bootstrap.Modal(document.getElementById("viewTable1Modal")).show();
        }

        // Edit table 1
        function editTable1(id) {
            table1EditId = id;
            const item = table1Data.find(x => x.id == id);
            $("#table1FormTitleText").text("Edit Record in Table 1");
            $("#table1_edit_id").val(id);

            $('input[name="hero_title"]').val(item.hero_title || '');
            $('input[name="hero_sub"]').val(item.hero_sub || '');
            $('input[name="title"]').val(item.title || '');
            $('input[name="icon1"]').val(item.icon1 || '');
            $('input[name="name"]').val(item.name || '');
            $('input[name="role"]').val(item.role || '');
            $('input[name="icon2"]').val(item.icon2 || '');

            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");

            $("#addTable1Form").slideDown();
            $("#addTable2Form, #addTable3Form").slideUp();
        }

        // Delete table 1
        function deleteTable1(id) {
            if (confirm("Are you sure you want to delete this record?")) {
                window.location.href = "?delete_c_dash1_id=" + id;
            }
        }

        // Table 1 form submission validation
        $("#table1Form").on("submit", function(e) {
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

        // Table 1 search
        $("#searchTable1Input").on("keyup", function() {
            table1CurrentPage = 1;
            renderTable1();
        });

        // ==================== TABLE 2 FUNCTIONS ====================

        // Open table 2 form
        $("#openTable2FormBtn").click(() => {
            $("#table2FormTitleText").text("Add Record to Table 2");
            table2EditId = null;
            $("#table2_edit_id").val("");
            $("#table2Form")[0].reset();
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            $("#addTable2Form").slideDown();
            $("#addTable1Form, #addTable3Form").slideUp();
        });

        // Cancel table 2 form
        $("#cancelTable2Form").click(() => {
            $("#addTable2Form").slideUp();
            $("#table2Form")[0].reset();
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            table2EditId = null;
        });

        // Render table 2 - FIXED to display icons properly
        function renderTable2() {
            let tbody = $("#table2TableBody");
            tbody.html("");

            const searchValue = $("#searchTable2Input").val().toLowerCase();
            const filteredData = table2Data.filter(item =>
                (item.icon && item.icon.toLowerCase().includes(searchValue)) ||
                (item.detail && item.detail.toLowerCase().includes(searchValue))
            );

            const start = (table2CurrentPage - 1) * rowsPerPage;
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
                paginatedData.forEach(item => {
                    let statusClass = item.status === 'Active' ? 'btn-status-active' : 'btn-status-inactive';

                    // Format the icon class properly - ensure it has the 'bi-' prefix if needed
                    let iconClass = item.icon || '';
                    // If the icon doesn't start with 'bi-', add it (unless it's a full class like 'bi bi-people')
                    if (iconClass && !iconClass.includes('bi-') && !iconClass.includes('bi ')) {
                        iconClass = 'bi-' + iconClass;
                    }

                    tbody.append(`
            <tr>
                <td>${item.id}</td>
                <td>
                    <div class="icon-preview">
                        <i class="bi ${iconClass}"></i>
                    </div>
                </td>
                <td>${item.count || 0}</td>
                <td>${item.detail ? (item.detail.substring(0, 30) + (item.detail.length > 30 ? '...' : '')) : ''}</td>
                <td>
                    <button class="btn-status ${statusClass}" onclick="toggleTable2Status(${item.id})">
                        ${item.status}
                    </button>
                </td>
                <td>
                    <button class="action-btn btn-view" onclick="viewTable2(${item.id})">View</button>
                    <button class="action-btn btn-edit" onclick="editTable2(${item.id})">Edit</button>
                    <button class="action-btn btn-delete" onclick="deleteTable2(${item.id})">Delete</button>
                </td>
            </tr>`);
                });
            }

            renderTable2Pagination(filteredData.length);
        }

        // Toggle table 2 status
        function toggleTable2Status(id) {
            window.location.href = "?toggle_c_dash2_id=" + id;
        }

        // Render table 2 pagination
        function renderTable2Pagination(totalRows) {
            let totalPages = Math.ceil(totalRows / rowsPerPage);
            let pagination = $("#table2Pagination");
            pagination.html("");

            if (totalPages === 0 || totalPages === 1) {
                return;
            }

            pagination.append(`
                <li class="page-item ${table2CurrentPage === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="changeTable2Page(${table2CurrentPage - 1})">Previous</a>
                </li>
            `);

            for (let i = 1; i <= totalPages; i++) {
                pagination.append(`
                    <li class="page-item ${i === table2CurrentPage ? 'active' : ''}">
                        <a class="page-link" href="#" onclick="changeTable2Page(${i})">${i}</a>
                    </li>
                `);
            }

            pagination.append(`
                <li class="page-item ${table2CurrentPage === totalPages ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="changeTable2Page(${table2CurrentPage + 1})">Next</a>
                </li>
            `);
        }

        // Change table 2 page
        function changeTable2Page(page) {
            const filteredData = table2Data.filter(item =>
                (item.icon && item.icon.toLowerCase().includes($("#searchTable2Input").val().toLowerCase())) ||
                (item.detail && item.detail.toLowerCase().includes($("#searchTable2Input").val().toLowerCase()))
            );
            let totalPages = Math.ceil(filteredData.length / rowsPerPage);
            if (page < 1 || page > totalPages) return;
            table2CurrentPage = page;
            renderTable2();
        }

        // View table 2
        function viewTable2(id) {
            let item = table2Data.find(x => x.id == id);
            $("#v2_id").text(item.id);
            $("#v2_icon").text(item.icon || '');

            // Format the icon class properly for the modal
            let iconClass = item.icon || '';
            if (iconClass && !iconClass.includes('bi-') && !iconClass.includes('bi ')) {
                iconClass = 'bi-' + iconClass;
            }
            $("#v2_icon_display").attr('class', `bi ${iconClass}`);

            $("#v2_count").text(item.count || 0);
            $("#v2_detail").text(item.detail || '');
            $("#v2_status").text(item.status || '');
            new bootstrap.Modal(document.getElementById("viewTable2Modal")).show();
        }

        // Edit table 2
        function editTable2(id) {
            table2EditId = id;
            const item = table2Data.find(x => x.id == id);
            $("#table2FormTitleText").text("Edit Record in Table 2");
            $("#table2_edit_id").val(id);

            $('input[name="icon"]').val(item.icon || '');
            $('input[name="count"]').val(item.count || 0);
            $('textarea[name="detail"]').val(item.detail || '');

            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");

            $("#addTable2Form").slideDown();
            $("#addTable1Form, #addTable3Form").slideUp();
        }

        // Delete table 2
        function deleteTable2(id) {
            if (confirm("Are you sure you want to delete this record?")) {
                window.location.href = "?delete_c_dash2_id=" + id;
            }
        }

        // Table 2 form submission validation
        $("#table2Form").on("submit", function(e) {
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

        // Table 2 search
        $("#searchTable2Input").on("keyup", function() {
            table2CurrentPage = 1;
            renderTable2();
        });

        // ==================== TABLE 3 FUNCTIONS (Same as Original Events) ====================

        // Open table 3 form
        $("#openTable3FormBtn").click(() => {
            $("#table3FormTitleText").text("Add Event");
            table3EditId = null;
            $("#table3_edit_id").val("");
            $("#table3Form")[0].reset();
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            $("#addTable3Form").slideDown();
            $("#addTable1Form, #addTable2Form").slideUp();
        });

        // Cancel table 3 form
        $("#cancelTable3Form").click(() => {
            $("#addTable3Form").slideUp();
            $("#table3Form")[0].reset();
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            table3EditId = null;
        });

        // Render table 3 - UPDATED with status icons
        function renderTable3() {
            let tbody = $("#table3TableBody");
            tbody.html("");

            const searchValue = $("#searchTable3Input").val().toLowerCase();
            const filteredData = table3Data.filter(e =>
                (e.event_name && e.event_name.toLowerCase().includes(searchValue)) ||
                (e.category && e.category.toLowerCase().includes(searchValue)) ||
                (e.school && e.school.toLowerCase().includes(searchValue))
            );

            const start = (table3CurrentPage - 1) * rowsPerPage;
            const paginatedData = filteredData.slice(start, start + rowsPerPage);

            if (paginatedData.length === 0) {
                tbody.append(`
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="bi bi-inbox fs-1 d-block mb-3" style="color: #ddd;"></i>
                            <h5 style="color: #999;">No data found</h5>
                        </td>
                    </tr>
                `);
            } else {
                paginatedData.forEach(e => {
                    let statusClass = '';
                    let statusIcon = '';

                    if (e.status === 'Scheduled') {
                        statusClass = 'badge-scheduled';
                        statusIcon = 'fa-check-circle';
                    } else if (e.status === 'Pending') {
                        statusClass = 'badge-pending';
                        statusIcon = 'fa-clock';
                    } else if (e.status === 'Upcoming') {
                        statusClass = 'badge-upcoming';
                        statusIcon = 'fa-calendar-plus';
                    } else if (e.status === 'Completed') {
                        statusClass = 'badge-completed';
                        statusIcon = 'fa-check-circle';
                    }

                    tbody.append(`
                    <tr>
                        <td>${e.id}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="me-2 icon-preview" style="width: 30px; height: 30px;">
                                    <i class="fas ${e.icon || ''}"></i>
                                </div>
                                <span>${e.event_name || ''}</span>
                            </div>
                        </td>
                        <td>${e.category || ''}</td>
                        <td>${e.school || ''}</td>
                        <td>${e.date_range || ''}</td>
                        <td><span class="${statusClass}"><i class="fas ${statusIcon} me-1"></i> ${e.status || ''}</span></td>
                        <td>
                            <button class="action-btn btn-view" onclick="viewTable3(${e.id})">View</button>
                            <button class="action-btn btn-edit" onclick="editTable3(${e.id})">Edit</button>
                            <button class="action-btn btn-delete" onclick="deleteTable3(${e.id})">Delete</button>
                        </td>
                    </tr>`);
                });
            }

            renderTable3Pagination(filteredData.length);
        }

        // Render table 3 pagination
        function renderTable3Pagination(totalRows) {
            let totalPages = Math.ceil(totalRows / rowsPerPage);
            let pagination = $("#table3Pagination");
            pagination.html("");

            if (totalPages === 0 || totalPages === 1) {
                return;
            }

            pagination.append(`
                <li class="page-item ${table3CurrentPage === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="changeTable3Page(${table3CurrentPage - 1})">Previous</a>
                </li>
            `);

            for (let i = 1; i <= totalPages; i++) {
                pagination.append(`
                    <li class="page-item ${i === table3CurrentPage ? 'active' : ''}">
                        <a class="page-link" href="#" onclick="changeTable3Page(${i})">${i}</a>
                    </li>
                `);
            }

            pagination.append(`
                <li class="page-item ${table3CurrentPage === totalPages ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="changeTable3Page(${table3CurrentPage + 1})">Next</a>
                </li>
            `);
        }

        // Change table 3 page
        function changeTable3Page(page) {
            const filteredData = table3Data.filter(e =>
                (e.event_name && e.event_name.toLowerCase().includes($("#searchTable3Input").val().toLowerCase())) ||
                (e.category && e.category.toLowerCase().includes($("#searchTable3Input").val().toLowerCase())) ||
                (e.school && e.school.toLowerCase().includes($("#searchTable3Input").val().toLowerCase()))
            );
            let totalPages = Math.ceil(filteredData.length / rowsPerPage);
            if (page < 1 || page > totalPages) return;
            table3CurrentPage = page;
            renderTable3();
        }

        // View table 3
        function viewTable3(id) {
            let e = table3Data.find(x => x.id == id);
            $("#v3_id").text(e.id);
            $("#v3_name").text(e.event_name || '');
            $("#v3_category").text(e.category || '');
            $("#v3_school").text(e.school || '');
            $("#v3_date").text(e.date_range || '');
            $("#v3_time").text(e.time || '');
            $("#v3_venue").text(e.venue || '');
            $("#v3_status").text(e.status || '');
            $("#v3_total").text(e.total_registrations || 0);
            $("#v3_pending").text(e.pending_registrations || 0);
            $("#v3_icon").text(e.icon || '');
            $("#v3_icon_display").attr('class', `fas ${e.icon || ''}`);
            new bootstrap.Modal(document.getElementById("viewTable3Modal")).show();
        }

        // Edit table 3
        function editTable3(id) {
            table3EditId = id;
            const e = table3Data.find(x => x.id == id);
            $("#table3FormTitleText").text("Edit Event");
            $("#table3_edit_id").val(id);

            $('input[name="event_name"]').val(e.event_name || '');
            $(`select[name="category"]`).val(e.category || '');
            $(`select[name="school"]`).val(e.school || '');
            $('input[name="date_range"]').val(e.date_range || '');

            // Format time for input
            if (e.time) {
                let timeValue = "10:00";
                let timeParts = e.time.split(' ');
                if (timeParts.length > 1) {
                    let time = timeParts[0];
                    let period = timeParts[1];
                    let [hours, minutes] = time.split(':');
                    if (period === 'PM' && hours !== '12') {
                        hours = parseInt(hours) + 12;
                    } else if (period === 'AM' && hours === '12') {
                        hours = '00';
                    }
                    timeValue = `${hours.toString().padStart(2, '0')}:${minutes}`;
                }
                $('input[name="time"]').val(timeValue);
            } else {
                $('input[name="time"]').val('');
            }

            $('input[name="venue"]').val(e.venue || '');
            $(`select[name="status"]`).val(e.status || '');
            $('input[name="total_registrations"]').val(e.total_registrations || 0);
            $('input[name="pending_registrations"]').val(e.pending_registrations || 0);
            $(`select[name="event_icon"]`).val(e.icon || '');

            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");

            $("#addTable3Form").slideDown();
            $("#addTable1Form, #addTable2Form").slideUp();
        }

        // Delete table 3
        function deleteTable3(id) {
            if (confirm("Are you sure you want to delete this event?")) {
                window.location.href = "?delete_c_dash3_id=" + id;
            }
        }

        // Table 3 form submission validation
        $("#table3Form").on("submit", function(e) {
            let isValid = true;
            let firstInvalidField = null;

            $(this).find("input, select").each(function() {
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

        // Table 3 search
        $("#searchTable3Input").on("keyup", function() {
            table3CurrentPage = 1;
            renderTable3();
        });

        // Initialize validation for all inputs
        $(document).ready(function() {
            $("input, textarea, select").on("input change", function() {
                validateInput(this);
            });

            // Initial render
            renderTable1();
            renderTable2();
            renderTable3();
        });
    </script>

</body>

</html>