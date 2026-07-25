<?php
// At the very top of admin_dashboard.php
require_once 'admin_auth_check.php';

// Now you can access admin session variables
$admin_name = $_SESSION['full_name'];
$admin_role = $_SESSION['role'];
$admin_email = $_SESSION['email'];

include 'ad_c_dashboard_handler.php';
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

    <!-- AOS CSS for scroll animations -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Font Awesome for additional icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- FORM + TABLE CSS - Updated to match second code styling -->
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
        .btn-add-dashboard,
        .btn-add-statistics,
        .btn-add-event {
            background: linear-gradient(135deg, #ff4d5a, var(--galore-red));
            color: #fff;
            padding: 12px 22px;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .btn-add-dashboard:hover,
        .btn-add-statistics:hover,
        .btn-add-event:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(220, 53, 69, 0.45);
        }

        .btn-add-dashboard i,
        .btn-add-statistics i,
        .btn-add-event i {
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
        .add-dashboard-form-container,
        .add-statistics-form-container,
        .add-event-form-container {
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
        #dashboardForm,
        #statisticsForm,
        #eventForm {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }

        @media (max-width: 768px) {

            #dashboardForm,
            #statisticsForm,
            #eventForm {
                grid-template-columns: 1fr;
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

        /* BADGE STYLES */
        .badge-icon {
            background: rgba(220, 53, 69, 0.1);
            color: var(--galore-red);
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin: 2px;
        }

        .badge-icon i {
            font-size: 1rem;
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

        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
    </style>
</head>

<body>

    <?php require 'ad_c_header.php'; ?>

    <main class="main-content">

        <!-- Main Page Title Bar -->
        <div class="top-bar d-flex justify-content-between align-items-center flex-wrap gap-3">
            <h1 class="mb-0">Dashboard Management</h1>
            <!-- Main action buttons removed - now placed per table -->
        </div>

        <!-- ==================== TABLE 1: DASHBOARD ITEMS (co_dash1) ==================== -->
        <div class="top-bar d-flex justify-content-between align-items-center flex-wrap gap-3" style="margin-top: 20px;">
            <h2 class="mb-0" style="color: var(--galore-red); font-size: 1.5rem;">Dashboard Items</h2>
            <!-- <button class="btn-add-dashboard" id="openFormBtn">
                <i class="bi bi-plus-circle"></i> Add Dashboard Item
            </button> -->
        </div>

        <!-- DASHBOARD ITEMS FORM (co_dash1) -->
        <div class="add-dashboard-form-container" id="addDashboardForm">
            <h3 class="form-title" id="formTitleText">Add Dashboard Item</h3>

            <form id="dashboardForm" method="POST" action="">
                <input type="hidden" name="edit_id" id="itemId" value="">
                <input type="hidden" name="submit_c_dash1" value="1">

                <div class="galore-input-group">
                    <label class="galore-label">Icon Class <span class="text-muted">(Bootstrap/Font Awesome)</span> <span class="text-danger">*</span></label>
                    <input type="text" name="icon" id="icon" class="galore-input" placeholder="e.g., bi bi-person-badge or fa-solid fa-users" data-validation="required min" data-min="3" data-max="100">
                    <span id="icon_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Hero Title <span class="text-danger">*</span></label>
                    <input type="text" name="hero_title" id="hero_title" class="galore-input" placeholder="Enter hero title" data-validation="required min" data-min="5" data-max="100">
                    <span id="hero_title_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Hero Subtitle <span class="text-danger">*</span></label>
                    <input type="text" name="hero_subtitle" id="hero_subtitle" class="galore-input" placeholder="Enter hero subtitle" data-validation="required min" data-min="10" data-max="200">
                    <span id="hero_subtitle_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="title" class="galore-input" placeholder="Enter title" data-validation="required min" data-min="5" data-max="100">
                    <span id="title_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Icons <span class="text-muted">(comma separated)</span> <span class="text-danger">*</span></label>
                    <input type="text" name="icons" id="icons" class="galore-input" placeholder="bi bi-star, fa-solid fa-heart, bi bi-bell" data-validation="required min" data-min="3" data-max="200">
                    <span id="icons_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Subtitle/Description <span class="text-danger">*</span></label>
                    <textarea name="sub" id="sub" class="galore-textarea" placeholder="Enter subtitle or description" data-validation="required min" data-min="10" data-max="500"></textarea>
                    <span id="sub_error" class="error-message"></span>
                </div>

                <div class="form-buttons">
                    <button type="submit" class="btn-save">Save</button>
                    <button type="button" class="btn-cancel" id="cancelForm">Cancel</button>
                </div>

            </form>
        </div>

        <!-- DASHBOARD ITEMS TABLE (co_dash1) -->
        <div class="data-table-container">
            <div class="table-header">
                <h2 class="mb-0">Dashboard Items Records</h2>
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchInput" placeholder="Search...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Icon</th>
                            <th>Hero Title</th>
                            <th>Hero Subtitle</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="dashboardTableBody"></tbody>
                </table>
            </div>

            <div class="pagination-container">
                <ul class="pagination" id="pagination"></ul>
            </div>
        </div>

        <!-- ==================== TABLE 2: DASHBOARD STATISTICS (co_dash2) ==================== -->
        <div class="top-bar d-flex justify-content-between align-items-center flex-wrap gap-3" style="margin-top: 40px;">
            <h2 class="mb-0" style="color: var(--galore-red); font-size: 1.5rem;">Dashboard Statistics</h2>
            <button class="btn-add-statistics" id="openStatsFormBtn">
                <i class="bi bi-plus-circle"></i> Add Statistics
            </button>
        </div>

        <!-- STATISTICS FORM (co_dash2) -->
        <div class="add-statistics-form-container" id="addStatisticsForm">
            <h3 class="form-title" id="statsFormTitleText">Add Statistics</h3>

            <form id="statisticsForm" method="POST" action="">
                <input type="hidden" name="edit_id" id="statsItemId" value="">
                <input type="hidden" name="submit_c_dash2" value="1">

                <div class="galore-input-group">
                    <label class="galore-label">Icon Class <span class="text-muted">(Bootstrap/Font Awesome)</span> <span class="text-danger">*</span></label>
                    <input type="text" name="stats_icon" id="stats_icon" class="galore-input" placeholder="e.g., bi bi-calendar or fa-solid fa-users" data-validation="required min" data-min="3" data-max="100">
                    <span id="stats_icon_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Count <span class="text-danger">*</span></label>
                    <input type="text" name="stats_count" id="stats_count" class="galore-input" placeholder="Enter count (e.g., 1,245)" data-validation="required min number" data-min="1" data-max="10">
                    <span id="stats_count_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Title <span class="text-danger">*</span></label>
                    <input type="text" name="stats_title" id="stats_title" class="galore-input" placeholder="Enter statistics title" data-validation="required min" data-min="3" data-max="100">
                    <span id="stats_title_error" class="error-message"></span>
                </div>

                <div class="form-buttons">
                    <button type="submit" class="btn-save">Save</button>
                    <button type="button" class="btn-cancel" id="cancelStatsForm">Cancel</button>
                </div>

            </form>
        </div>

        <!-- DASHBOARD STATISTICS TABLE (co_dash2) -->
        <div class="data-table-container">
            <div class="table-header">
                <h2 class="mb-0">Statistics Records</h2>
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" id="statsSearchInput" placeholder="Search statistics...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Icon</th>
                            <th>Count</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="statisticsTableBody"></tbody>
                </table>
            </div>

            <div class="pagination-container">
                <ul class="pagination" id="statisticsPagination"></ul>
            </div>
        </div>

        <!-- ==================== TABLE 3: ASSIGNED EVENTS (co_dash3) ==================== -->
        <div class="top-bar d-flex justify-content-between align-items-center flex-wrap gap-3" style="margin-top: 40px;">
            <h2 class="mb-0" style="color: var(--galore-red); font-size: 1.5rem;"><i class="bi bi-calendar-event-fill me-2"></i> Assigned Events</h2>
            <button class="btn-add-event" id="openEventFormBtn">
                <i class="bi bi-plus-circle"></i> Add Event
            </button>
        </div>

        <!-- EVENT FORM (co_dash3) -->
        <div class="add-event-form-container" id="addEventForm">
            <h3 class="form-title" id="eventFormTitleText">Add New Event</h3>

            <form id="eventForm" method="POST" action="">
                <input type="hidden" name="edit_id" id="eventId" value="">
                <input type="hidden" name="submit_c_dash3" value="1">

                <div class="galore-input-group">
                    <label class="galore-label">Event Name <span class="text-danger">*</span></label>
                    <input type="text" name="event_name" id="event_name" class="galore-input" placeholder="Enter event name" data-validation="required min" data-min="3" data-max="100">
                    <span id="event_name_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Category <span class="text-danger">*</span></label>
                    <select name="category" id="category" class="galore-select" data-validation="required select">
                        <option value="">Select category</option>
                        <option value="Boys & Girls">Boys & Girls</option>
                        <option value="Boys">Boys Only</option>
                        <option value="Girls">Girls Only</option>
                        <option value="Open">Open</option>
                    </select>
                    <span id="category_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">School <span class="text-danger">*</span></label>
                    <select name="school" id="school" class="galore-select" data-validation="required select">
                        <option value="">Select school</option>
                        <option value="All Schools">All Schools</option>
                        <option value="Engineering">Engineering</option>
                        <option value="Science">Science</option>
                        <option value="Commerce">Commerce</option>
                        <option value="Management">Management</option>
                        <option value="Arts">Arts</option>
                    </select>
                    <span id="school_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Date Range <span class="text-danger">*</span></label>
                    <input type="text" name="date_range" id="date_range" class="galore-input" placeholder="e.g., 15-17 Feb 2026" data-validation="required min" data-min="5" data-max="50">
                    <span id="date_range_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Time <span class="text-danger">*</span></label>
                    <input type="time" name="time" id="time" class="galore-input" data-validation="required min" data-min="3">
                    <span id="time_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Venue <span class="text-danger">*</span></label>
                    <input type="text" name="venue" id="venue" class="galore-input" placeholder="Enter venue" data-validation="required min" data-min="3" data-max="100">
                    <span id="venue_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Status <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="galore-select" data-validation="required select">
                        <option value="">Select status</option>
                        <option value="Scheduled">Scheduled</option>
                        <option value="Pending">Pending</option>
                        <option value="Upcoming">Upcoming</option>
                        <option value="Completed">Completed</option>
                    </select>
                    <span id="status_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Total Registrations <span class="text-danger">*</span></label>
                    <input type="number" name="total_registrations" id="total_registrations" class="galore-input" placeholder="Enter total registrations" data-validation="required number min" data-min="0">
                    <span id="total_registrations_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Pending Registrations <span class="text-danger">*</span></label>
                    <input type="number" name="pending_registrations" id="pending_registrations" class="galore-input" placeholder="Enter pending registrations" data-validation="required number min" data-min="0">
                    <span id="pending_registrations_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Icon <span class="text-danger">*</span></label>
                    <input type="text" name="event_icon" id="event_icon" class="galore-input" placeholder="e.g., fa-futbol or fa-basketball-ball or bi bi-trophy" data-validation="required min" data-min="3" data-max="100">
                    <span id="event_icon_error" class="error-message"></span>
                </div>

                <div class="form-buttons">
                    <button type="submit" class="btn-save">Save</button>
                    <button type="button" class="btn-cancel" id="cancelEventForm">Cancel</button>
                </div>

            </form>
        </div>

        <!-- EVENTS TABLE (co_dash3) -->
        <div class="data-table-container">
            <div class="table-header">
                <h2 class="mb-0"><i class="bi bi-calendar-event-fill me-2"></i> Events Records</h2>
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" id="eventSearchInput" placeholder="Search events...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Event</th>
                            <th>Category</th>
                            <th>School</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="eventTableBody"></tbody>
                </table>
            </div>

            <div class="pagination-container">
                <ul class="pagination" id="eventPagination"></ul>
            </div>
        </div>

    </main>

    <!-- VIEW MODAL for Dashboard Items -->
    <div class="modal fade" id="viewModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Dashboard Item Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="detail-grid">
                        <div class="detail-item full-width text-center mb-3">
                            <div class="icon-preview mx-auto" style="width: 60px; height: 60px; font-size: 2rem;">
                                <i id="v_icon" class=""></i>
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">ID</div>
                            <div class="detail-value" id="v_id"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Hero Title</div>
                            <div class="detail-value" id="v_hero_title"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Hero Subtitle</div>
                            <div class="detail-value" id="v_hero_subtitle"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Title</div>
                            <div class="detail-value" id="v_title"></div>
                        </div>
                        <div class="detail-item full-width">
                            <div class="detail-label">Icons</div>
                            <div class="detail-value" id="v_icons"></div>
                        </div>
                        <div class="detail-item full-width">
                            <div class="detail-label">Subtitle/Description</div>
                            <div class="detail-value" id="v_sub"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Status</div>
                            <div class="detail-value" id="v_status"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- VIEW MODAL for Statistics -->
    <div class="modal fade" id="viewStatsModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Statistics Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="detail-grid">
                        <div class="detail-item full-width text-center mb-3">
                            <div class="icon-preview mx-auto" style="width: 60px; height: 60px; font-size: 2rem;">
                                <i id="vs_icon" class=""></i>
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">ID</div>
                            <div class="detail-value" id="vs_id"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Count</div>
                            <div class="detail-value" id="vs_count"></div>
                        </div>
                        <div class="detail-item full-width">
                            <div class="detail-label">Title</div>
                            <div class="detail-value" id="vs_title"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Status</div>
                            <div class="detail-value" id="vs_status"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- VIEW MODAL for Events -->
    <div class="modal fade" id="viewEventModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Event Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="detail-grid">
                        <div class="detail-item full-width text-center mb-3">
                            <div class="icon-preview mx-auto" style="width: 60px; height: 60px; font-size: 2rem;">
                                <i id="ve_icon" class=""></i>
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">ID</div>
                            <div class="detail-value" id="ve_id"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Event Name</div>
                            <div class="detail-value" id="ve_name"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Category</div>
                            <div class="detail-value" id="ve_category"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">School</div>
                            <div class="detail-value" id="ve_school"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Date Range</div>
                            <div class="detail-value" id="ve_date"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Time</div>
                            <div class="detail-value" id="ve_time"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Venue</div>
                            <div class="detail-value" id="ve_venue"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Status</div>
                            <div class="detail-value" id="ve_status"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Total Registrations</div>
                            <div class="detail-value" id="ve_total"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Pending Registrations</div>
                            <div class="detail-value" id="ve_pending"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 1200,
            once: true,
            offset: 50
        });

        // Pass PHP data to JavaScript
        let dashboardData = <?php echo json_encode($c_dash1Data); ?>;
        let statisticsData = <?php echo json_encode($c_dash2Data); ?>;
        let eventsData = <?php echo json_encode($c_dash3Data); ?>;

        // If no data in database, use empty array
        if (!dashboardData || dashboardData.length === 0) {
            dashboardData = [];
        }
        if (!statisticsData || statisticsData.length === 0) {
            statisticsData = [];
        }
        if (!eventsData || eventsData.length === 0) {
            eventsData = [];
        }

        // Function to format icon class for display
        function formatIconClass(iconClass) {
            if (!iconClass) return '';
            return iconClass;
        }

        // Function to split multiple icons
        function splitIcons(iconsString) {
            if (!iconsString) return [];
            return iconsString.split(',').map(icon => icon.trim()).filter(icon => icon);
        }

        // Pagination settings
        const rowsPerPage = 5;
        let currentPage = 1;
        let statsCurrentPage = 1;
        let eventCurrentPage = 1;

        // Edit IDs
        let editId = null;
        let statsEditId = null;
        let eventEditId = null;

        // Form references
        const addDashboardForm = $("#addDashboardForm");
        const addStatisticsForm = $("#addStatisticsForm");
        const addEventForm = $("#addEventForm");

        const formTitleText = $("#formTitleText");
        const statsFormTitleText = $("#statsFormTitleText");
        const eventFormTitleText = $("#eventFormTitleText");

        // ========== FORM OPEN/CLOSE HANDLERS ==========

        // Open dashboard form
        $("#openFormBtn").click(() => {
            formTitleText.text("Add Dashboard Item");
            editId = null;
            $("#itemId").val('');
            $("#dashboardForm")[0].reset();
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            addDashboardForm.slideDown();
            addStatisticsForm.slideUp();
            addEventForm.slideUp();
        });

        // Open statistics form
        $("#openStatsFormBtn").click(() => {
            statsFormTitleText.text("Add Statistics");
            statsEditId = null;
            $("#statsItemId").val('');
            $("#statisticsForm")[0].reset();
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            addStatisticsForm.slideDown();
            addDashboardForm.slideUp();
            addEventForm.slideUp();
        });

        // Open event form
        $("#openEventFormBtn").click(() => {
            eventFormTitleText.text("Add New Event");
            eventEditId = null;
            $("#eventId").val('');
            $("#eventForm")[0].reset();
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            addEventForm.slideDown();
            addDashboardForm.slideUp();
            addStatisticsForm.slideUp();
        });

        // Cancel dashboard form
        $("#cancelForm").click(() => {
            addDashboardForm.slideUp();
            $("#dashboardForm")[0].reset();
            $("#itemId").val('');
            editId = null;
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
        });

        // Cancel statistics form
        $("#cancelStatsForm").click(() => {
            addStatisticsForm.slideUp();
            $("#statisticsForm")[0].reset();
            $("#statsItemId").val('');
            statsEditId = null;
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
        });

        // Cancel event form
        $("#cancelEventForm").click(() => {
            addEventForm.slideUp();
            $("#eventForm")[0].reset();
            $("#eventId").val('');
            eventEditId = null;
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
        });

        // ========== HELPER FUNCTIONS ==========

        function escapeHtml(text) {
            if (!text) return '';
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function formatTimeForDisplay(timeStr) {
            if (!timeStr) return '10:00 AM';
            if (timeStr.includes('AM') || timeStr.includes('PM')) return timeStr;

            let [hours, minutes] = timeStr.split(':');
            hours = parseInt(hours);
            const ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12;
            return `${hours}:${minutes} ${ampm}`;
        }

        function getStatusClass(status) {
            switch (status) {
                case 'Scheduled':
                    return 'badge-scheduled';
                case 'Pending':
                    return 'badge-pending';
                case 'Upcoming':
                    return 'badge-upcoming';
                case 'Completed':
                    return 'badge-completed';
                default:
                    return 'badge-scheduled';
            }
        }

        function getItemStatusClass(status) {
            return status === 'Active' ? 'btn-status-active' : 'btn-status-inactive';
        }

        // ========== VALIDATION FUNCTION ==========

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

                    if (validationType.includes("number")) {
                        var number_regex = /^[0-9,]+$/;
                        if (!number_regex.test(value)) {
                            errorMessage = "Please enter a valid number (e.g., 100 or 1,000).";
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

        // ========== DASHBOARD ITEMS FUNCTIONS ==========

        function renderDashboardTable() {
            let tbody = $("#dashboardTableBody");
            tbody.html("");

            const searchValue = $("#searchInput").val().toLowerCase();
            const filteredData = dashboardData.filter(item =>
                (item.hero_title && item.hero_title.toLowerCase().includes(searchValue)) ||
                (item.hero_subtitle && item.hero_subtitle.toLowerCase().includes(searchValue)) ||
                (item.title && item.title.toLowerCase().includes(searchValue)) ||
                (item.sub && item.sub.toLowerCase().includes(searchValue))
            );

            const start = (currentPage - 1) * rowsPerPage;
            const paginatedData = filteredData.slice(start, start + rowsPerPage);

            if (paginatedData.length === 0) {
                tbody.append(`
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <i class="bi bi-inbox fs-1 d-block mb-3" style="color: #ddd;"></i>
                            <h5 style="color: #999;">No data found</h5>
                        <\/td>
                    <\/tr>
                `);
            } else {
                paginatedData.forEach(item => {
                    const statusClass = getItemStatusClass(item.status);
                    const iconClass = formatIconClass(item.icon);

                    tbody.append(`
                        <tr>
                            <td>${item.id}<\/td>
                            <td>
                                <div class="icon-preview">
                                    <i class="${iconClass}"><\/i>
                                </div>
                            <\/td>
                            <td>${escapeHtml(item.hero_title)}<\/td>
                            <td>${escapeHtml(item.hero_subtitle)}<\/td>
                            <td>
                                <button class="btn-status ${statusClass}" onclick="toggleDashboardStatus(${item.id})">
                                    ${item.status || 'Active'}
                                </button>
                            <\/td>
                            <td>
                                <button class="action-btn btn-view" onclick="viewDashboardItem(${item.id})">View</button>
                                <button class="action-btn btn-edit" onclick="editDashboardItem(${item.id})">Edit</button>
                                <button class="action-btn btn-delete" onclick="deleteDashboardItem(${item.id})">Delete</button>
                            <\/td>
                        <\/tr>
                    `);
                });
            }

            renderDashboardPagination(filteredData.length);
        }

        function toggleDashboardStatus(id) {
            window.location.href = "?toggle_c_dash1_id=" + id;
        }

        function renderDashboardPagination(totalRows) {
            let totalPages = Math.ceil(totalRows / rowsPerPage);
            let pagination = $("#pagination");
            pagination.html("");

            if (totalPages === 0 || totalPages === 1) {
                return;
            }

            pagination.append(`
                <li class="page-item ${currentPage === 1 ? "disabled" : ""}">
                    <a class="page-link" href="#" onclick="goDashboardPage(${currentPage - 1}); return false;">Previous</a>
                </li>
            `);

            for (let i = 1; i <= totalPages; i++) {
                pagination.append(`
                    <li class="page-item ${i === currentPage ? "active" : ""}">
                        <a class="page-link" href="#" onclick="goDashboardPage(${i}); return false;">${i}</a>
                    </li>
                `);
            }

            pagination.append(`
                <li class="page-item ${currentPage === totalPages ? "disabled" : ""}">
                    <a class="page-link" href="#" onclick="goDashboardPage(${currentPage + 1}); return false;">Next</a>
                </li>
            `);
        }

        function goDashboardPage(page) {
            const searchValue = $("#searchInput").val().toLowerCase();
            const filteredData = dashboardData.filter(item =>
                (item.hero_title && item.hero_title.toLowerCase().includes(searchValue)) ||
                (item.hero_subtitle && item.hero_subtitle.toLowerCase().includes(searchValue)) ||
                (item.title && item.title.toLowerCase().includes(searchValue)) ||
                (item.sub && item.sub.toLowerCase().includes(searchValue))
            );
            let totalPages = Math.ceil(filteredData.length / rowsPerPage);

            if (page < 1 || page > totalPages) return;
            currentPage = page;
            renderDashboardTable();
        }

        function viewDashboardItem(id) {
            let item = dashboardData.find(x => x.id == id);

            const iconsArray = splitIcons(item.icons);
            const iconsHtml = iconsArray.map(icon => `<span class="badge-icon"><i class="${formatIconClass(icon)}"><\/i><\/span>`).join(' ');

            $("#v_id").text(item.id);
            $("#v_icon").attr('class', formatIconClass(item.icon));
            $("#v_hero_title").text(item.hero_title || '');
            $("#v_hero_subtitle").text(item.hero_subtitle || '');
            $("#v_title").text(item.title || '');
            $("#v_icons").html(iconsHtml);
            $("#v_sub").text(item.sub || '');
            $("#v_status").text(item.status || 'Active');

            new bootstrap.Modal(document.getElementById("viewModal")).show();
        }

        function editDashboardItem(id) {
            editId = id;
            const item = dashboardData.find(x => x.id == id);

            formTitleText.text("Edit Dashboard Item");
            $("#itemId").val(item.id);
            $("#icon").val(item.icon);
            $("#hero_title").val(item.hero_title);
            $("#hero_subtitle").val(item.hero_subtitle);
            $("#title").val(item.title);
            $("#icons").val(item.icons);
            $("#sub").val(item.sub);

            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");

            addDashboardForm.slideDown();
            addStatisticsForm.slideUp();
            addEventForm.slideUp();
        }

        function deleteDashboardItem(id) {
            if (confirm("Are you sure you want to delete this dashboard item?")) {
                window.location.href = "?delete_c_dash1_id=" + id;
            }
        }

        // ========== STATISTICS FUNCTIONS ==========

        function renderStatisticsTable() {
            let tbody = $("#statisticsTableBody");
            tbody.html("");

            const searchValue = $("#statsSearchInput").val().toLowerCase();
            const filteredData = statisticsData.filter(item =>
                (item.title && item.title.toLowerCase().includes(searchValue)) ||
                (item.count_val && item.count_val.toString().toLowerCase().includes(searchValue))
            );

            const start = (statsCurrentPage - 1) * rowsPerPage;
            const paginatedData = filteredData.slice(start, start + rowsPerPage);

            if (paginatedData.length === 0) {
                tbody.append(`
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <i class="bi bi-inbox fs-1 d-block mb-3" style="color: #ddd;"></i>
                            <h5 style="color: #999;">No data found</h5>
                        <\/td>
                    <\/tr>
                `);
            } else {
                paginatedData.forEach(item => {
                    const statusClass = getItemStatusClass(item.status);
                    const iconClass = formatIconClass(item.icon);

                    tbody.append(`
                        <tr>
                            <td>${item.id}<\/td>
                            <td>
                                <div class="icon-preview">
                                    <i class="${iconClass}"><\/i>
                                </div>
                            <\/td>
                            <td>${escapeHtml(item.count_val)}<\/td>
                            <td>${escapeHtml(item.title)}<\/td>
                            <td>
                                <button class="btn-status ${statusClass}" onclick="toggleStatisticsStatus(${item.id})">
                                    ${item.status || 'Active'}
                                </button>
                            <\/td>
                            <td>
                                <button class="action-btn btn-view" onclick="viewStatistic(${item.id})">View</button>
                                <button class="action-btn btn-edit" onclick="editStatistic(${item.id})">Edit</button>
                                <button class="action-btn btn-delete" onclick="deleteStatistic(${item.id})">Delete</button>
                            <\/td>
                        <\/tr>
                    `);
                });
            }

            renderStatisticsPagination(filteredData.length);
        }

        function toggleStatisticsStatus(id) {
            window.location.href = "?toggle_c_dash2_id=" + id;
        }

        function renderStatisticsPagination(totalRows) {
            let totalPages = Math.ceil(totalRows / rowsPerPage);
            let pagination = $("#statisticsPagination");
            pagination.html("");

            if (totalPages === 0 || totalPages === 1) {
                return;
            }

            pagination.append(`
                <li class="page-item ${statsCurrentPage === 1 ? "disabled" : ""}">
                    <a class="page-link" href="#" onclick="goStatsPage(${statsCurrentPage - 1}); return false;">Previous</a>
                </li>
            `);

            for (let i = 1; i <= totalPages; i++) {
                pagination.append(`
                    <li class="page-item ${i === statsCurrentPage ? "active" : ""}">
                        <a class="page-link" href="#" onclick="goStatsPage(${i}); return false;">${i}</a>
                    </li>
                `);
            }

            pagination.append(`
                <li class="page-item ${statsCurrentPage === totalPages ? "disabled" : ""}">
                    <a class="page-link" href="#" onclick="goStatsPage(${statsCurrentPage + 1}); return false;">Next</a>
                </li>
            `);
        }

        function goStatsPage(page) {
            const searchValue = $("#statsSearchInput").val().toLowerCase();
            const filteredData = statisticsData.filter(item =>
                (item.title && item.title.toLowerCase().includes(searchValue)) ||
                (item.count_val && item.count_val.toString().toLowerCase().includes(searchValue))
            );
            let totalPages = Math.ceil(filteredData.length / rowsPerPage);

            if (page < 1 || page > totalPages) return;
            statsCurrentPage = page;
            renderStatisticsTable();
        }

        function viewStatistic(id) {
            let item = statisticsData.find(x => x.id == id);

            $("#vs_id").text(item.id);
            $("#vs_icon").attr('class', formatIconClass(item.icon));
            $("#vs_count").text(item.count_val || '0');
            $("#vs_title").text(item.title || '');
            $("#vs_status").text(item.status || 'Active');

            new bootstrap.Modal(document.getElementById("viewStatsModal")).show();
        }

        function editStatistic(id) {
            statsEditId = id;
            const item = statisticsData.find(x => x.id == id);

            statsFormTitleText.text("Edit Statistics");
            $("#statsItemId").val(item.id);
            $("#stats_icon").val(item.icon);
            $("#stats_count").val(item.count_val);
            $("#stats_title").val(item.title);

            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");

            addStatisticsForm.slideDown();
            addDashboardForm.slideUp();
            addEventForm.slideUp();
        }

        function deleteStatistic(id) {
            if (confirm("Are you sure you want to delete this statistic?")) {
                window.location.href = "?delete_c_dash2_id=" + id;
            }
        }

        // ========== EVENTS FUNCTIONS ==========

        function renderEventTable() {
            let tbody = $("#eventTableBody");
            tbody.html("");

            const searchValue = $("#eventSearchInput").val().toLowerCase();
            const filteredData = eventsData.filter(item =>
                (item.event_name && item.event_name.toLowerCase().includes(searchValue)) ||
                (item.category && item.category.toLowerCase().includes(searchValue)) ||
                (item.school && item.school.toLowerCase().includes(searchValue)) ||
                (item.venue && item.venue.toLowerCase().includes(searchValue)) ||
                (item.status && item.status.toLowerCase().includes(searchValue))
            );

            const start = (eventCurrentPage - 1) * rowsPerPage;
            const paginatedData = filteredData.slice(start, start + rowsPerPage);

            if (paginatedData.length === 0) {
                tbody.append(`
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <i class="bi bi-inbox fs-1 d-block mb-3" style="color: #ddd;"></i>
                            <h5 style="color: #999;">No data found</h5>
                        <\/td>
                    <\/tr>
                `);
            } else {
                paginatedData.forEach(item => {
                    const statusClass = getStatusClass(item.status);
                    const iconClass = formatIconClass(item.icon);

                    tbody.append(`
                        <tr>
                            <td>${item.id}<\/td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="icon-preview me-2" style="width: 30px; height: 30px; font-size: 1rem;">
                                        <i class="${iconClass}"><\/i>
                                    </div>
                                    <span>${escapeHtml(item.event_name)}</span>
                                </div>
                            <\/td>
                            <td>${escapeHtml(item.category)}<\/td>
                            <td>${escapeHtml(item.school)}<\/td>
                            <td>
                                <span class="${statusClass}">
                                    <i class="fas ${statusClass === 'badge-scheduled' ? 'fa-check-circle' : statusClass === 'badge-pending' ? 'fa-clock' : statusClass === 'badge-upcoming' ? 'fa-calendar-plus' : 'fa-check-circle'} me-1"></i>
                                    ${item.status}
                                </span>
                            <\/td>
                            <td>
                                <button class="action-btn btn-view" onclick="viewEvent(${item.id})">View</button>
                                <button class="action-btn btn-edit" onclick="editEvent(${item.id})">Edit</button>
                                <button class="action-btn btn-delete" onclick="deleteEvent(${item.id})">Delete</button>
                            <\/td>
                        <\/tr>
                    `);
                });
            }

            renderEventPagination(filteredData.length);
        }

        function renderEventPagination(totalRows) {
            let totalPages = Math.ceil(totalRows / rowsPerPage);
            let pagination = $("#eventPagination");
            pagination.html("");

            if (totalPages === 0 || totalPages === 1) {
                return;
            }

            pagination.append(`
                <li class="page-item ${eventCurrentPage === 1 ? "disabled" : ""}">
                    <a class="page-link" href="#" onclick="goEventPage(${eventCurrentPage - 1}); return false;">Previous</a>
                </li>
            `);

            for (let i = 1; i <= totalPages; i++) {
                pagination.append(`
                    <li class="page-item ${i === eventCurrentPage ? "active" : ""}">
                        <a class="page-link" href="#" onclick="goEventPage(${i}); return false;">${i}</a>
                    </li>
                `);
            }

            pagination.append(`
                <li class="page-item ${eventCurrentPage === totalPages ? "disabled" : ""}">
                    <a class="page-link" href="#" onclick="goEventPage(${eventCurrentPage + 1}); return false;">Next</a>
                </li>
            `);
        }

        function goEventPage(page) {
            const searchValue = $("#eventSearchInput").val().toLowerCase();
            const filteredData = eventsData.filter(item =>
                (item.event_name && item.event_name.toLowerCase().includes(searchValue)) ||
                (item.category && item.category.toLowerCase().includes(searchValue)) ||
                (item.school && item.school.toLowerCase().includes(searchValue)) ||
                (item.venue && item.venue.toLowerCase().includes(searchValue)) ||
                (item.status && item.status.toLowerCase().includes(searchValue))
            );
            let totalPages = Math.ceil(filteredData.length / rowsPerPage);

            if (page < 1 || page > totalPages) return;
            eventCurrentPage = page;
            renderEventTable();
        }

        function viewEvent(id) {
            let item = eventsData.find(x => x.id == id);
            const statusClass = getStatusClass(item.status);

            $("#ve_id").text(item.id);
            $("#ve_icon").attr('class', formatIconClass(item.icon));
            $("#ve_name").text(item.event_name || '');
            $("#ve_category").text(item.category || '');
            $("#ve_school").text(item.school || '');
            $("#ve_date").text(item.date_range || '');
            $("#ve_time").text(item.time || '');
            $("#ve_venue").text(item.venue || '');
            $("#ve_status").text(item.status || '').attr('class', `${statusClass} d-inline-block p-2`);
            $("#ve_total").text(item.total_registrations || 0);
            $("#ve_pending").text(item.pending_registrations || 0);

            new bootstrap.Modal(document.getElementById("viewEventModal")).show();
        }

        function editEvent(id) {
            eventEditId = id;
            const item = eventsData.find(x => x.id == id);

            eventFormTitleText.text("Edit Event");
            $("#eventId").val(item.id);
            $("#event_name").val(item.event_name);
            $("#category").val(item.category);
            $("#school").val(item.school);
            $("#date_range").val(item.date_range);

            // Convert time to 24-hour format for input
            let timeValue = "10:00";
            if (item.time) {
                let timeParts = item.time.split(' ');
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
                } else {
                    timeValue = item.time;
                }
            }
            $("#time").val(timeValue);

            $("#venue").val(item.venue);
            $("#status").val(item.status);
            $("#total_registrations").val(item.total_registrations);
            $("#pending_registrations").val(item.pending_registrations);
            $("#event_icon").val(item.icon);

            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");

            addEventForm.slideDown();
            addDashboardForm.slideUp();
            addStatisticsForm.slideUp();
        }

        function deleteEvent(id) {
            if (confirm("Are you sure you want to delete this event?")) {
                window.location.href = "?delete_c_dash3_id=" + id;
            }
        }

        // ========== SEARCH HANDLERS ==========

        $("#searchInput").on("keyup", function() {
            currentPage = 1;
            renderDashboardTable();
        });

        $("#statsSearchInput").on("keyup", function() {
            statsCurrentPage = 1;
            renderStatisticsTable();
        });

        $("#eventSearchInput").on("keyup", function() {
            eventCurrentPage = 1;
            renderEventTable();
        });

        // ========== FORM SUBMISSIONS WITH VALIDATION ==========

        $(document).ready(function() {
            $("input, textarea, select").on("input change", function() {
                validateInput(this);
            });

            // Dashboard Form validation (will submit normally to PHP)
            $("#dashboardForm").on("submit", function(e) {
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

            // Statistics Form validation
            $("#statisticsForm").on("submit", function(e) {
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

            // Event Form validation
            $("#eventForm").on("submit", function(e) {
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
        });

        // ========== INITIAL RENDERS ==========
        renderDashboardTable();
        renderStatisticsTable();
        renderEventTable();

        // ========== RIPPLE ANIMATION ==========
        document.querySelectorAll('.btn-add-dashboard, .btn-add-statistics, .btn-add-event, .btn-save, .btn-cancel').forEach(button => {
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                ripple.style.cssText = `
                    position: absolute;
                    border-radius: 50%;
                    background: rgba(255, 255, 255, 0.6);
                    transform: scale(0);
                    animation: ripple 0.6s linear;
                    width: ${size}px;
                    height: ${size}px;
                    left: ${x}px;
                    top: ${y}px;
                    pointer-events: none;
                `;

                this.style.position = 'relative';
                this.style.overflow = 'hidden';
                this.appendChild(ripple);

                setTimeout(() => ripple.remove(), 600);
            });
        });
    </script>

</body>

</html>