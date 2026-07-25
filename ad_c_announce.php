<?php
include 'ad_c_announce_handler.php';
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- FORM + TABLE CSS -->
    <style>
        :root {
            --galore-red: #dc3545;
            --galore-gray: #6c757d;
            --galore-dark: #333;
            --glass: rgba(255, 255, 255, 0.05);
        }

        /* ADD BUTTON */
        .btn-add-gallery {
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

        .btn-add-gallery:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(220, 53, 69, 0.45);
        }

        .btn-add-stats {
            background: linear-gradient(135deg, #ff4d5a, var(--galore-red));
            color: #fff;
            padding: 15px 22px;
            border: none;
            border-radius: 12px;
            font-size: 1.05rem;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s ease;
            margin-left: 10px;
        }

        .btn-add-stats:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(220, 53, 69, 0.45);
        }

        /* FORM */
        .add-gallery-form-container,
        .add-stats-form-container {
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

        #galleryForm,
        #statsForm {
            display: grid;
            grid-template-columns: 1fr;
            gap: 18px;
        }

        @media (min-width: 768px) {

            #galleryForm,
            #statsForm {
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

        /* ICON STYLES */
        .icon-preview {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(220, 53, 69, 0.1);
            border-radius: 10px;
            color: var(--galore-red);
            font-size: 1.5rem;
        }

        .icon-preview i {
            font-size: 1.5rem;
        }

        /* COUNT BADGE */
        .count-badge {
            background: var(--galore-red);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-block;
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

        .button-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
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

            .top-bar {
                flex-direction: column;
                align-items: flex-start;
            }

            .button-group {
                width: 100%;
            }

            .btn-add-gallery,
            .btn-add-stats {
                width: 100%;
                margin-left: 0 !important;
            }
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

        /* Badge for ID */
        .badge.bg-secondary {
            background-color: var(--galore-gray) !important;
            padding: 5px 10px;
            font-size: 0.85rem;
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
    </style>
</head>

<body>

    <?php require 'ad_c_header.php'; ?>

    <main class="main-content">

        <div class="top-bar d-flex justify-content-between align-items-center mb-3">
            <h1><i class="fas fa-bullhorn me-2"></i>Announcement Page Management</h1>
            <div class="button-group">
                <!-- <button class="btn-add-gallery" id="openGalleryFormBtn">
                    <i class="bi bi-plus-circle"></i> Add Announcement
                </button> -->
                <button class="btn-add-stats" id="openStatsFormBtn">
                    <i class="bi bi-plus-circle"></i> Add Statistics
                </button>
            </div>
        </div>

        <!-- ANNOUNCEMENT FORM (co_announce1) -->
        <div class="add-gallery-form-container" id="addGalleryForm" style="display:none;">
            <h3 class="form-title" id="galleryFormTitleText">Add Announcement Page</h3>

            <form id="galleryForm" method="POST" action="">
                <input type="hidden" name="edit_id_announce" id="edit_id_announce" value="">

                <div class="galore-input-group">
                    <label class="galore-label">Hero Title <span class="text-danger">*</span></label>
                    <input type="text" name="gallery_hero_title" id="gallery_hero_title" class="galore-input" placeholder="Enter hero title" data-validation="required min" data-min="5" data-max="100">
                    <span id="gallery_hero_title_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Hero Subtitle <span class="text-danger">*</span></label>
                    <input type="text" name="gallery_hero_subtitle" id="gallery_hero_subtitle" class="galore-input" placeholder="Enter hero subtitle" data-validation="required min" data-min="10" data-max="200">
                    <span id="gallery_hero_subtitle_error" class="error-message"></span>
                </div>

                <!-- Status field removed from form - now only in table -->

                <div class="form-buttons">
                    <button type="submit" name="submit_announce" class="btn-save"><i class="fas fa-save me-2"></i>Save</button>
                    <button type="button" class="btn-cancel" id="cancelGalleryForm"><i class="fas fa-times me-2"></i>Cancel</button>
                </div>

                <div class="text-center mt-3">
                    <small class="text-muted"><i class="fas fa-info-circle me-1 text-danger"></i> Fields marked with <span class="text-danger">*</span> are required</small>
                </div>
            </form>
        </div>

        <!-- STATISTICS FORM (co_announce2) -->
        <div class="add-stats-form-container" id="addStatsForm" style="display:none;">
            <h3 class="form-title" id="statsFormTitleText">Add Statistics Item</h3>

            <form id="statsForm" method="POST" action="">
                <input type="hidden" name="edit_id_stats" id="edit_id_stats" value="">
                <div class="galore-input-group">
                    <label class="galore-label">Icon <span class="text-muted">(Font Awesome class)</span> <span class="text-danger">*</span></label>
                    <input type="text" name="stats_icon" id="stats_icon" class="galore-input" placeholder="e.g., fas fa-bullhorn" data-validation="required">
                    <span id="stats_icon_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Count <span class="text-danger">*</span></label>
                    <input type="number" name="stats_count" id="stats_count" class="galore-input" placeholder="Enter count (e.g., 150)" data-validation="required min number" data-min="1" data-max="999999">
                    <span id="stats_count_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Heading <span class="text-danger">*</span></label>
                    <input type="text" name="stats_heading" id="stats_heading" class="galore-input" placeholder="Enter heading" data-validation="required min" data-min="3" data-max="100">
                    <span id="stats_heading_error" class="error-message"></span>
                </div>

                <!-- Status field removed from form - now only in table -->

                <div class="form-buttons">
                    <button type="submit" name="submit_stats" class="btn-save"><i class="fas fa-save me-2"></i>Save</button>
                    <button type="button" class="btn-cancel" id="cancelStatsForm"><i class="fas fa-times me-2"></i>Cancel</button>
                </div>

                <div class="text-center mt-3">
                    <small class="text-muted"><i class="fas fa-info-circle me-1 text-danger"></i> Fields marked with <span class="text-danger">*</span> are required</small>
                </div>
            </form>
        </div>

        <!-- ANNOUNCEMENT TABLE (co_announce1) -->
        <div class="data-table-container">
            <div class="table-header">
                <h2>Announcement Page Data</h2>
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" id="gallerySearchInput" placeholder="Search announcements...">
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
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="galleryTableBody"></tbody>
                </table>
            </div>

            <div class="pagination-container">
                <ul class="pagination" id="galleryPagination"></ul>
            </div>
        </div>

        <!-- STATISTICS TABLE (co_announce2) -->
        <div class="data-table-container">
            <div class="table-header">
                <h2>Statistics Data</h2>
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
                            <th>Heading</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="statsTableBody"></tbody>
                </table>
            </div>

            <div class="pagination-container">
                <ul class="pagination" id="statsPagination"></ul>
            </div>
        </div>

    </main>

    <!-- ANNOUNCEMENT VIEW MODAL -->
    <div class="modal fade" id="viewGalleryModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius:18px;border-top:6px solid var(--galore-red);">
                <div class="modal-header text-white" style="background:var(--galore-red);">
                    <h5 class="modal-title fw-bold"><i class="fas fa-info-circle me-2"></i>Announcement Page Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-bullhorn" style="font-size: 4rem; color: var(--galore-red); opacity: 0.5;"></i>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="detail-item">
                                <span class="detail-label">ID:</span>
                                <span id="v_gallery_id"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="detail-item">
                                <span class="detail-label">Hero Title:</span>
                                <span id="v_gallery_hero_title"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="detail-item">
                                <span class="detail-label">Hero Subtitle:</span>
                                <span id="v_gallery_hero_subtitle"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="detail-item">
                                <span class="detail-label">Status:</span>
                                <span id="v_gallery_status"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- STATISTICS VIEW MODAL -->
    <div class="modal fade" id="viewStatsModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius:18px;border-top:6px solid var(--galore-red);">
                <div class="modal-header text-white" style="background:var(--galore-red);">
                    <h5 class="modal-title fw-bold"><i class="fas fa-info-circle me-2"></i>Statistics Item Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <div class="icon-preview mx-auto" style="width: 60px; height: 60px; font-size: 2rem;">
                            <i id="v_stats_icon" class=""></i>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="detail-item">
                                <span class="detail-label">ID:</span>
                                <span id="v_stats_id"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="detail-item">
                                <span class="detail-label">Icon:</span>
                                <span id="v_stats_icon_text"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="detail-item">
                                <span class="detail-label">Count:</span>
                                <span id="v_stats_count" class="count-badge"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="detail-item">
                                <span class="detail-label">Heading:</span>
                                <span id="v_stats_heading"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="detail-item">
                                <span class="detail-label">Status:</span>
                                <span id="v_stats_status"></span>
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
        // Use PHP to pass database data to JavaScript
        let galleryData = <?php echo json_encode($announceData); ?>;
        let statsData = <?php echo json_encode($statsData); ?>;

        // If no data in database, use empty array
        if (!galleryData || galleryData.length === 0) {
            galleryData = [];
        }
        if (!statsData || statsData.length === 0) {
            statsData = [];
        }

        // ========== PAGINATION SETTINGS ==========
        const rowsPerPage = 5;

        // Gallery pagination
        let galleryCurrentPage = 1;
        let galleryEditId = null;

        // Stats pagination
        let statsCurrentPage = 1;
        let statsEditId = null;

        // ========== DOM ELEMENTS ==========
        const addGalleryForm = $("#addGalleryForm");
        const addStatsForm = $("#addStatsForm");
        const galleryFormTitleText = $("#galleryFormTitleText");
        const statsFormTitleText = $("#statsFormTitleText");

        // ========== GALLERY FORM HANDLING ==========
        $("#openGalleryFormBtn").click(() => {
            galleryFormTitleText.text("Add Announcement Page");
            galleryEditId = null;
            $("#edit_id_announce").val("");
            $("#galleryForm")[0].reset();
            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            addGalleryForm.slideDown(300);
            addStatsForm.slideUp(300);
        });

        $("#cancelGalleryForm").click(() => {
            addGalleryForm.slideUp(300);
            $("#galleryForm")[0].reset();
            $("#edit_id_announce").val("");
            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            galleryEditId = null;
        });

        // ========== STATISTICS FORM HANDLING ==========
        $("#openStatsFormBtn").click(() => {
            statsFormTitleText.text("Add Statistics Item");
            statsEditId = null;
            $("#edit_id_stats").val("");
            $("#statsForm")[0].reset();
            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            addStatsForm.slideDown(300);
            addGalleryForm.slideUp(300);
        });

        $("#cancelStatsForm").click(() => {
            addStatsForm.slideUp(300);
            $("#statsForm")[0].reset();
            $("#edit_id_stats").val("");
            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            statsEditId = null;
        });

        // ========== GALLERY TABLE FUNCTIONS ==========
        function renderGalleryTable() {
            let tbody = $("#galleryTableBody");
            tbody.html("");

            const searchValue = $("#gallerySearchInput").val().toLowerCase();
            const filteredData = galleryData.filter(g =>
                g.hero_title.toLowerCase().includes(searchValue) ||
                g.hero_subtitle.toLowerCase().includes(searchValue)
            );

            const start = (galleryCurrentPage - 1) * rowsPerPage;
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
                paginatedData.forEach(g => {
                    const statusClass = g.status === 'Active' ? 'btn-status-active' : 'btn-status-inactive';

                    tbody.append(`
                    <tr>
                        <td><span">${g.id}</span></td>
                        <td>${escapeHtml(g.hero_title)}</td>
                        <td>${escapeHtml(g.hero_subtitle)}</td>
                        <td>
                            <button class="btn-status ${statusClass}" onclick="toggleGalleryStatus(${g.id})">
                                ${g.status}
                            </button>
                        </td>
                        <td>
                            <button class="action-btn btn-view" onclick="viewGallery(${g.id})"> View</button>
                            <button class="action-btn btn-edit" onclick="editGallery(${g.id})"> Edit</button>
                            <button class="action-btn btn-delete" onclick="deleteGallery(${g.id})"> Delete</button>
                        </td>
                    </tr>`);
                });
            }

            renderGalleryPagination(filteredData.length);
        }

        function renderGalleryPagination(totalRows) {
            let totalPages = Math.ceil(totalRows / rowsPerPage);
            let pagination = $("#galleryPagination");
            pagination.html("");

            if (totalPages === 0) {
                pagination.html('<li class="page-item disabled"><span class="page-link">No data</span></li>');
                return;
            }

            pagination.append(`
                <li class="page-item ${galleryCurrentPage === 1 ? "disabled" : ""}">
                    <a class="page-link" href="#" onclick="goGalleryPage(${galleryCurrentPage - 1}); return false;">Previous</a>
                </li>
            `);

            for (let i = 1; i <= totalPages; i++) {
                pagination.append(`
                    <li class="page-item ${i === galleryCurrentPage ? "active" : ""}">
                        <a class="page-link" href="#" onclick="goGalleryPage(${i}); return false;">${i}</a>
                    </li>
                `);
            }

            pagination.append(`
                <li class="page-item ${galleryCurrentPage === totalPages ? "disabled" : ""}">
                    <a class="page-link" href="#" onclick="goGalleryPage(${galleryCurrentPage + 1}); return false;">Next</a>
                </li>
            `);
        }

        function goGalleryPage(page) {
            const searchValue = $("#gallerySearchInput").val().toLowerCase();
            const filteredData = galleryData.filter(g =>
                g.hero_title.toLowerCase().includes(searchValue) ||
                g.hero_subtitle.toLowerCase().includes(searchValue)
            );
            let totalPages = Math.ceil(filteredData.length / rowsPerPage);

            if (page < 1 || page > totalPages) return;
            galleryCurrentPage = page;
            renderGalleryTable();
        }

        // ========== STATISTICS TABLE FUNCTIONS ==========
        function renderStatsTable() {
            let tbody = $("#statsTableBody");
            tbody.html("");

            const searchValue = $("#statsSearchInput").val().toLowerCase();
            const filteredData = statsData.filter(s =>
                s.heading.toLowerCase().includes(searchValue) ||
                s.count.toString().includes(searchValue)
            );

            const start = (statsCurrentPage - 1) * rowsPerPage;
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
                paginatedData.forEach(s => {
                    const statusClass = s.status === 'Active' ? 'btn-status-active' : 'btn-status-inactive';

                    tbody.append(`
                    <tr>
                        <td><span ">${s.id}</span></td>
                        <td>
                            <div class="icon-preview">
                                <i class="${s.icon}"></i>
                            </div>
                        </td>
                        <td><span class="count-badge">${s.count}</span></td>
                        <td>${escapeHtml(s.heading)}</td>
                        <td>
                            <button class="btn-status ${statusClass}" onclick="toggleStatsStatus(${s.id})">
                                ${s.status}
                            </button>
                        </td>
                        <td>
                            <button class="action-btn btn-view" onclick="viewStats(${s.id})"> View</button>
                            <button class="action-btn btn-edit" onclick="editStats(${s.id})"> Edit</button>
                            <button class="action-btn btn-delete" onclick="deleteStats(${s.id})"> Delete</button>
                        </td>
                    </tr>`);
                });
            }

            renderStatsPagination(filteredData.length);
        }

        function renderStatsPagination(totalRows) {
            let totalPages = Math.ceil(totalRows / rowsPerPage);
            let pagination = $("#statsPagination");
            pagination.html("");

            if (totalPages === 0) {
                pagination.html('<li class="page-item disabled"><span class="page-link">No data</span></li>');
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
            const filteredData = statsData.filter(s =>
                s.heading.toLowerCase().includes(searchValue) ||
                s.count.toString().includes(searchValue)
            );
            let totalPages = Math.ceil(filteredData.length / rowsPerPage);

            if (page < 1 || page > totalPages) return;
            statsCurrentPage = page;
            renderStatsTable();
        }

        // ========== HELPER FUNCTION ==========
        function escapeHtml(text) {
            if (!text) return '';
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // ========== STATUS TOGGLE FUNCTIONS ==========
        // For Announcements (co_announce1)
        function toggleGalleryStatus(id) {
            window.location.href = "?toggle_id_announce=" + id;
        }

        // For Statistics (co_announce2)
        function toggleStatsStatus(id) {
            window.location.href = "?toggle_id_stats=" + id;
        }

        // ========== GALLERY CRUD OPERATIONS ==========
        window.viewGallery = function(id) {
            let g = galleryData.find(x => x.id == id);
            $("#v_gallery_id").text(g.id);
            $("#v_gallery_hero_title").text(g.hero_title);
            $("#v_gallery_hero_subtitle").text(g.hero_subtitle);
            $("#v_gallery_status").text(g.status);
            new bootstrap.Modal(document.getElementById("viewGalleryModal")).show();
        };

        window.deleteGallery = function(id) {
            if (confirm("Are you sure you want to delete this announcement page?")) {
                window.location.href = "?delete_id_announce=" + id;
            }
        };

        window.editGallery = function(id) {
            galleryEditId = id;
            const g = galleryData.find(x => x.id == id);
            galleryFormTitleText.text("Edit Announcement Page");
            $("#edit_id_announce").val(id);
            $("#gallery_hero_title").val(g.hero_title);
            $("#gallery_hero_subtitle").val(g.hero_subtitle);

            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");

            addGalleryForm.slideDown(300);
            addStatsForm.slideUp(300);
        };

        // ========== STATISTICS CRUD OPERATIONS ==========
        window.viewStats = function(id) {
            let s = statsData.find(x => x.id == id);
            $("#v_stats_id").text(s.id);
            $("#v_stats_icon").attr('class', s.icon);
            $("#v_stats_icon_text").text(s.icon);
            $("#v_stats_count").text(s.count);
            $("#v_stats_heading").text(s.heading);
            $("#v_stats_status").text(s.status);
            new bootstrap.Modal(document.getElementById("viewStatsModal")).show();
        };

        window.deleteStats = function(id) {
            if (confirm("Are you sure you want to delete this statistics item?")) {
                window.location.href = "?delete_id_stats=" + id;
            }
        };

        window.editStats = function(id) {
            statsEditId = id;
            const s = statsData.find(x => x.id == id);
            statsFormTitleText.text("Edit Statistics Item");
            $("#edit_id_stats").val(id);
            $("#stats_icon").val(s.icon);
            $("#stats_count").val(s.count);
            $("#stats_heading").val(s.heading);

            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");

            addStatsForm.slideDown(300);
            addGalleryForm.slideUp(300);
        };

        // ========== SEARCH FUNCTIONALITY ==========
        $("#gallerySearchInput").on("keyup", function() {
            galleryCurrentPage = 1;
            renderGalleryTable();
        });

        $("#statsSearchInput").on("keyup", function() {
            statsCurrentPage = 1;
            renderStatsTable();
        });

        // ========== VALIDATION SCRIPT ==========
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

                        // Numeric value validation
                        if (validationType.includes("number")) {
                            var number_regex = /^[0-9]+$/;
                            if (!number_regex.test(value)) {
                                errorMessage = "Please enter a valid number.";
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

            // Gallery Form submission with validation
            $("#galleryForm").on("submit", function(e) {
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

            // Statistics Form submission with validation
            $("#statsForm").on("submit", function(e) {
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

        // Handle escape key to close forms
        $(document).keydown(function(e) {
            if (e.key === "Escape") {
                if (addGalleryForm.is(":visible")) {
                    addGalleryForm.slideUp(300);
                    $("#galleryForm")[0].reset();
                    $("#edit_id_announce").val("");
                    $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
                    $(".error-message").text("");
                    galleryEditId = null;
                }
                if (addStatsForm.is(":visible")) {
                    addStatsForm.slideUp(300);
                    $("#statsForm")[0].reset();
                    $("#edit_id_stats").val("");
                    $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
                    $(".error-message").text("");
                    statsEditId = null;
                }
            }
        });

        // ========== INITIAL RENDER ==========
        renderGalleryTable();
        renderStatsTable();
    </script>

</body>

</html>