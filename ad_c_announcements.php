<?php
// At the very top of ad_c_announcements.php
require_once 'admin_auth_check.php';

// Now you can access admin session variables
$admin_name = $_SESSION['full_name'];
$admin_role = $_SESSION['role'];
$admin_email = $_SESSION['email'];

// Include the handler (this will also create the table and fetch announcements)
include 'ad_c_announcements_handler.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard |RKU Galore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
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

        /* ADD BUTTON */
        .btn-add-announcement {
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

        .btn-add-announcement:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(220, 53, 69, 0.45);
        }

        .btn-add-announcement i {
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

        /* Game Badge Styles */
        .game-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .game-cricket {
            background: rgba(220, 53, 69, 0.15);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }

        .game-football {
            background: rgba(40, 167, 69, 0.15);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .game-basketball {
            background: rgba(255, 193, 7, 0.15);
            color: #ffc107;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }

        .game-volleyball {
            background: rgba(23, 162, 184, 0.15);
            color: #17a2b8;
            border: 1px solid rgba(23, 162, 184, 0.3);
        }

        .game-athletics {
            background: rgba(108, 117, 125, 0.15);
            color: #6c757d;
            border: 1px solid rgba(108, 117, 125, 0.3);
        }

        .game-general {
            background: rgba(111, 66, 193, 0.15);
            color: #6f42c1;
            border: 1px solid rgba(111, 66, 193, 0.3);
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
            min-height: 150px;
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
            margin-left: 20%;

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

    <?php require 'ad_c_header.php'; ?>

    <main class="main-content">

        <!-- ==================== ANNOUNCEMENTS TABLE ==================== -->
        <div class="top-bar d-flex justify-content-between align-items-center flex-wrap gap-3">
            <h1 class="mb-0">Announcements Management</h1>
            <button class="btn-add-announcement" id="openAnnouncementFormBtn">
                <i class="bi bi-plus-circle"></i> Add Announcement
            </button>
        </div>

        <!-- ANNOUNCEMENT FORM -->
        <div class="add-form-container" id="addAnnouncementForm">
            <h3 class="form-title" id="announcementFormTitleText">Add New Announcement</h3>

            <form id="announcementForm" method="POST" action="">
                <input type="hidden" name="edit_id" id="announcement_edit_id" value="">

                <div class="form-grid">
                    <div class="galore-input-group full-width">
                        <label class="galore-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="galore-input" data-validation="required min" data-min="3" data-max="200">
                        <span id="title_error" class="error-message"></span>
                    </div>

                    <div class="galore-input-group">
                        <label class="galore-label">Game/Sport <span class="text-danger">*</span></label>
                        <select name="game" class="galore-select" data-validation="required select">
                            <option value="">Select Game</option>
                            <option value="Cricket">🏏 Cricket</option>
                            <option value="Football">⚽ Football</option>
                            <option value="Basketball">🏀 Basketball</option>
                            <option value="Volleyball">🏐 Volleyball</option>
                            <option value="Athletics">🏃 Athletics</option>
                            <option value="Badminton">🏸 Badminton</option>
                            <option value="Chess">♟️ Chess</option>
                            <option value="General">📢 General</option>
                        </select>
                        <span id="game_error" class="error-message"></span>
                    </div>

                    <div class="galore-input-group">
                        <label class="galore-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="galore-select" data-validation="required select">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                        <span id="status_error" class="error-message"></span>
                    </div>

                    <div class="galore-input-group full-width">
                        <label class="galore-label">Content <span class="text-danger">*</span></label>
                        <textarea name="content" class="galore-textarea" rows="8" data-validation="required min" data-min="10" data-max="5000"></textarea>
                        <span id="content_error" class="error-message"></span>
                    </div>
                </div>

                <div class="form-buttons">
                    <button type="submit" name="submit_announcement" class="btn-save">Save Announcement</button>
                    <button type="button" class="btn-cancel" id="cancelAnnouncementForm">Cancel</button>
                </div>
            </form>
        </div>

        <!-- ANNOUNCEMENTS DATA TABLE -->
        <div class="data-table-container">
            <div class="table-header">
                <h2>Announcements List</h2>
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchAnnouncementInput" placeholder="Search by title, game, or content...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Game</th>
                        <th>Status</th>
                        <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="announcementTableBody"></tbody>
                </table>
            </div>

            <div class="pagination-container">
                <ul class="pagination" id="announcementPagination"></ul>
            </div>
        </div>

    </main>

    <!-- VIEW MODAL FOR ANNOUNCEMENTS -->
    <div class="modal fade" id="viewAnnouncementModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Announcement Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-label">ID</div>
                            <div class="detail-value" id="view_id"></div>
                        </div>
                        <div class="detail-item full-width">
                            <div class="detail-label">Title</div>
                            <div class="detail-value" id="view_title"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Game/Sport</div>
                            <div class="detail-value" id="view_game"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Status</div>
                            <div class="detail-value" id="view_status"></div>
                        </div>
                        <div class="detail-item full-width">
                            <div class="detail-label">Content</div>
                            <div class="detail-value" id="view_content" style="white-space: pre-wrap;"></div>
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
        let announcementData = <?php echo json_encode($announcements); ?>;

        // If no data in database, use empty array
        if (!announcementData || announcementData.length === 0) {
            announcementData = [];
        }

        // Pagination settings
        const rowsPerPage = 5;
        let announcementCurrentPage = 1;
        let announcementEditId = null;

        // Game badge class mapping
        function getGameBadgeClass(game) {
            const gameLower = game ? game.toLowerCase() : '';
            if (gameLower.includes('cricket')) return 'game-cricket';
            if (gameLower.includes('football')) return 'game-football';
            if (gameLower.includes('basketball')) return 'game-basketball';
            if (gameLower.includes('volleyball')) return 'game-volleyball';
            if (gameLower.includes('athletics')) return 'game-athletics';
            return 'game-general';
        }

        function getGameIcon(game) {
            const gameLower = game ? game.toLowerCase() : '';
            if (gameLower.includes('cricket')) return '🏏';
            if (gameLower.includes('football')) return '⚽';
            if (gameLower.includes('basketball')) return '🏀';
            if (gameLower.includes('volleyball')) return '🏐';
            if (gameLower.includes('athletics')) return '🏃';
            if (gameLower.includes('badminton')) return '🏸';
            if (gameLower.includes('chess')) return '♟️';
            return '📢';
        }

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

        // ==================== ANNOUNCEMENT FUNCTIONS ====================

        // Open announcement form
        $("#openAnnouncementFormBtn").click(() => {
            $("#announcementFormTitleText").text("Add New Announcement");
            announcementEditId = null;
            $("#announcement_edit_id").val("");
            $("#announcementForm")[0].reset();
            $("#announcementForm select[name='status']").val('Active');
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            $("#addAnnouncementForm").slideDown();
        });

        // Cancel announcement form
        $("#cancelAnnouncementForm").click(() => {
            $("#addAnnouncementForm").slideUp();
            $("#announcementForm")[0].reset();
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            announcementEditId = null;
        });

        // Render announcement table
        function renderAnnouncementTable() {
            let tbody = $("#announcementTableBody");
            tbody.html("");

            const searchValue = $("#searchAnnouncementInput").val().toLowerCase();
            const filteredData = announcementData.filter(item =>
                (item.title && item.title.toLowerCase().includes(searchValue)) ||
                (item.game && item.game.toLowerCase().includes(searchValue)) ||
                (item.content && item.content.toLowerCase().includes(searchValue))
            );

            const start = (announcementCurrentPage - 1) * rowsPerPage;
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
                paginatedData.forEach(item => {
                    let statusClass = item.status === 'Active' ? 'btn-status-active' : 'btn-status-inactive';
                    let gameBadgeClass = getGameBadgeClass(item.game);
                    let gameIcon = getGameIcon(item.game);

                    tbody.append(`
                        <tr>
                            <td>${item.id}</td>
                            <td><strong>${item.title ? (item.title.substring(0, 50) + (item.title.length > 50 ? '...' : '')) : ''}</strong></td>
                            <td><span class="game-badge ${gameBadgeClass}">${gameIcon} ${item.game || 'General'}</span></td>
                            <td>
                                <button class="btn-status ${statusClass}" onclick="toggleAnnouncementStatus(${item.id})">
                                    ${item.status}
                                </button>
                            </td>
                            <td>
                                <button class="action-btn btn-view" onclick="viewAnnouncement(${item.id})">View</button>
                                <button class="action-btn btn-edit" onclick="editAnnouncement(${item.id})">Edit</button>
                                <button class="action-btn btn-delete" onclick="deleteAnnouncement(${item.id})">Delete</button>
                            </td>
                        </tr>
                    `);
                });
            }

            renderAnnouncementPagination(filteredData.length);
        }

        // Toggle announcement status
        function toggleAnnouncementStatus(id) {
            if (confirm("Are you sure you want to change the status of this announcement?")) {
                window.location.href = "?toggle_announcement_id=" + id;
            }
        }

        // Render announcement pagination
        function renderAnnouncementPagination(totalRows) {
            let totalPages = Math.ceil(totalRows / rowsPerPage);
            let pagination = $("#announcementPagination");
            pagination.html("");

            if (totalPages === 0 || totalPages === 1) {
                return;
            }

            pagination.append(`
                <li class="page-item ${announcementCurrentPage === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="changeAnnouncementPage(${announcementCurrentPage - 1})">Previous</a>
                </li>
            `);

            for (let i = 1; i <= totalPages; i++) {
                pagination.append(`
                    <li class="page-item ${i === announcementCurrentPage ? 'active' : ''}">
                        <a class="page-link" href="#" onclick="changeAnnouncementPage(${i})">${i}</a>
                    </li>
                `);
            }

            pagination.append(`
                <li class="page-item ${announcementCurrentPage === totalPages ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="changeAnnouncementPage(${announcementCurrentPage + 1})">Next</a>
                </li>
            `);
        }

        // Change announcement page
        function changeAnnouncementPage(page) {
            const filteredData = announcementData.filter(item =>
                (item.title && item.title.toLowerCase().includes($("#searchAnnouncementInput").val().toLowerCase())) ||
                (item.game && item.game.toLowerCase().includes($("#searchAnnouncementInput").val().toLowerCase())) ||
                (item.content && item.content.toLowerCase().includes($("#searchAnnouncementInput").val().toLowerCase()))
            );
            let totalPages = Math.ceil(filteredData.length / rowsPerPage);
            if (page < 1 || page > totalPages) return;
            announcementCurrentPage = page;
            renderAnnouncementTable();
        }

        // View announcement
        function viewAnnouncement(id) {
            let item = announcementData.find(x => x.id == id);
            $("#view_id").text(item.id);
            $("#view_title").text(item.title || '');

            let gameIcon = getGameIcon(item.game);
            let gameBadgeClass = getGameBadgeClass(item.game);
            $("#view_game").html(`<span class="game-badge ${gameBadgeClass}">${gameIcon} ${item.game || 'General'}</span>`);

            // Add status badge styling
            let statusHtml = `<span class="badge ${item.status === 'Active' ? 'bg-success' : 'bg-secondary'} px-3 py-2">${item.status || ''}</span>`;
            $("#view_status").html(statusHtml);

            $("#view_content").html(item.content ? item.content.replace(/\n/g, '<br>') : '');

            new bootstrap.Modal(document.getElementById("viewAnnouncementModal")).show();
        }

        // Edit announcement
        function editAnnouncement(id) {
            announcementEditId = id;
            const item = announcementData.find(x => x.id == id);
            $("#announcementFormTitleText").text("Edit Announcement");
            $("#announcement_edit_id").val(id);

            $('input[name="title"]').val(item.title || '');
            $('select[name="game"]').val(item.game || '');
            $('textarea[name="content"]').val(item.content || '');
            $('select[name="status"]').val(item.status || 'Active');

            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");

            $("#addAnnouncementForm").slideDown();
            $('html, body').animate({
                scrollTop: $("#addAnnouncementForm").offset().top - 100
            }, 500);
        }

        // Delete announcement
        function deleteAnnouncement(id) {
            if (confirm("Are you sure you want to delete this announcement? This action cannot be undone.")) {
                window.location.href = "?delete_announcement_id=" + id;
            }
        }

        // Announcement form submission validation
        $("#announcementForm").on("submit", function(e) {
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

        // Announcement search
        $("#searchAnnouncementInput").on("keyup", function() {
            announcementCurrentPage = 1;
            renderAnnouncementTable();
        });

        // Initialize validation for all inputs
        $(document).ready(function() {
            $("input, textarea, select").on("input change", function() {
                validateInput(this);
            });

            // Initial render
            renderAnnouncementTable();
        });
    </script>

</body>

</html>