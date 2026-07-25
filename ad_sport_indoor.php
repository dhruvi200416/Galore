<?php
include 'ad_sport_indoor_handler.php';
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
        .btn-add-sport,
        .btn-add-event {
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

        .btn-add-sport:hover,
        .btn-add-event:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(220, 53, 69, 0.45);
        }

        /* STATUS BUTTON STYLES - Added from carousel code */
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

        /* FORM */
        .add-sport-form-container,
        .add-event-form-container {
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

        #sportForm,
        #eventForm {
            display: grid;
            grid-template-columns: 1fr;
            gap: 18px;
        }

        @media (min-width: 768px) {

            #sportForm,
            #eventForm {
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

        /* STATUS BADGES */
        .status-active {
            background-color: #d4edda;
            color: #155724;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-inactive {
            background-color: #f8d7da;
            color: #721c24;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        /* ICON PREVIEW */
        .icon-preview {
            font-size: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background: #f8f9fa;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }

        /* Emoji font size */
        .event-name-emoji {
            font-size: 1.2rem;
        }
    </style>
</head>

<body>

    <?php require 'admin_header.php'; ?>

    <main class="main-content">

        <div class="top-bar d-flex justify-content-between align-items-center flex-wrap gap-3" id="topBar">
            <h1 class="mb-0">Sport & Indoor Management</h1>
            <div class="d-flex gap-2">
                <button class="btn-add-event" id="openEventFormBtn">
                    <i class="bi bi-plus-circle"></i> Add Event
                </button>
                <!-- <button class="btn-add-sport" id="openFormBtn">
                    <i class="bi bi-plus-circle"></i> Add Sport & Indoor
                </button> -->
            </div>
        </div>

        <!-- SPORT & INDOOR FORM -->
        <div class="add-sport-form-container" id="addSportForm" style="display:none;">
            <h3 class="form-title" id="formTitleText">Add Sport & Indoor</h3>

            <form id="sportForm" method="POST" action="">
                <input type="hidden" name="edit_id" id="edit_id" value="">

                <div class="galore-input-group">
                    <label class="galore-label">Hero Title <span class="text-danger">*</span></label>
                    <input type="text" name="hero_title" class="galore-input" data-validation="required min" data-min="3" data-max="100">
                    <span id="hero_title_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Hero Subtitle <span class="text-danger">*</span></label>
                    <input type="text" name="hero_subtitle" class="galore-input" data-validation="required min" data-min="3" data-max="100">
                    <span id="hero_subtitle_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Section Title <span class="text-danger">*</span></label>
                    <input type="text" name="section_title" class="galore-input" data-validation="required min alphabetic" data-min="3" data-max="100">
                    <span id="section_title_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Section Subtitle <span class="text-danger">*</span></label>
                    <input type="text" name="section_subtitle" class="galore-input" data-validation="required min alphanumeric" data-min="3" data-max="100">
                    <span id="section_subtitle_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Note Text <span class="text-danger">*</span></label>
                    <textarea name="note_text" class="galore-textarea" data-validation="required min alphanumeric" data-min="3" data-max="500"></textarea>
                    <span id="note_text_error" class="error-message"></span>
                </div>

                <div class="form-buttons">
                    <button type="submit" name="submit_header" class="btn-save">Save</button>
                    <button type="button" class="btn-cancel" id="cancelForm">Cancel</button>
                </div>

            </form>
        </div>

        <!-- EVENT FORM - REMOVED STATUS FIELD -->
        <div class="add-event-form-container" id="addEventForm" style="display:none;">
            <h3 class="form-title" id="eventFormTitleText">Add Event</h3>

            <form id="eventForm" method="POST" action="">
                <input type="hidden" name="edit_id" id="event_edit_id" value="">

                <div class="galore-input-group">
                    <label class="galore-label">Event Name <span class="text-danger">*</span></label>
                    <input type="text" name="event_name" class="galore-input" data-validation="required min" data-min="5" data-max="100" placeholder="e.g., 🎯 Carrom">
                    <span id="event_name_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Description <span class="text-danger">*</span></label>
                    <textarea name="description" class="galore-textarea" data-validation="required min alphanumeric" data-min="10" data-max="500"></textarea>
                    <span id="description_error" class="error-message"></span>
                </div>

                <!-- <div class="galore-input-group">
                    <label class="galore-label">Icon <span class="text-danger">*</span></label>
                    <input type="text" name="icon" class="galore-input" data-validation="required" placeholder="e.g., bi-activity, bi-trophy">
                    <span id="icon_error" class="error-message"></span>
                </div> -->

                <div class="form-buttons">
                    <button type="submit" name="submit_event" class="btn-save">Save</button>
                    <button type="button" class="btn-cancel" id="cancelEventForm">Cancel</button>
                </div>

            </form>
        </div>

        <!-- FIRST TABLE: SPORT & INDOOR -->
        <div class="data-table-container">

            <div class="table-header" id="tableHeader1">
                <h2 class="mb-0">Sport & Indoor Data</h2>

                <div class="search-box" id="searchBox1">
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
                            <th>Hero Subtitle</th>
                            <th id="actionsHeader1">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="sportTableBody"></tbody>
                </table>
            </div>

            <div class="pagination-container">
                <ul class="pagination" id="pagination"></ul>
            </div>
        </div>

        <!-- SECOND TABLE: EVENTS - WITH STATUS BUTTON LIKE CAROUSEL -->
        <div class="data-table-container">

            <div class="table-header" id="tableHeader2">
                <h2 class="mb-0">Event Data</h2>

                <div class="search-box" id="searchBox2">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchEventInput" placeholder="Search events...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Event Name</th>
                            <th>Description</th>
                            <!-- <th>Icon</th> -->
                            <th>Status</th>
                            <th id="actionsHeader2">Actions</th>
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

    <!-- SPORT VIEW MODAL -->
    <div class="modal fade" id="viewModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius:18px;border-top:6px solid var(--galore-red);">
                <div class="modal-header text-white" style="background:var(--galore-red);">
                    <h5 class="modal-title fw-bold">Sport & Indoor Full Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <p><b>ID:</b> <span id="v_id"></span></p>
                    <p><b>Hero Title:</b> <span id="v_hero_title"></span></p>
                    <p><b>Hero Subtitle:</b> <span id="v_hero_subtitle"></span></p>
                    <p><b>Section Title:</b> <span id="v_section_title"></span></p>
                    <p><b>Section Subtitle:</b> <span id="v_section_subtitle"></span></p>
                    <p><b>Note Text:</b> <span id="v_note_text"></span></p>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div> -->
            </div>
        </div>
    </div>

    <!-- EVENT VIEW MODAL -->
    <div class="modal fade" id="viewEventModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius:18px;border-top:6px solid var(--galore-red);">
                <div class="modal-header text-white" style="background:var(--galore-red);">
                    <h5 class="modal-title fw-bold">Event Full Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <p><b>ID:</b> <span id="ev_id"></span></p>
                    <p><b>Event Name:</b> <span id="ev_event_name"></span></p>
                    <p><b>Description:</b> <span id="ev_description"></span></p>
                    <!-- <p><b>Icon:</b> <span id="ev_icon"></span></p> -->
                    <p><b>Status:</b> <span id="ev_status"></span></p>
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
        // Use PHP to pass database data to JavaScript
        let sportData = <?php echo json_encode($sportData); ?>;
        let eventData = <?php echo json_encode($eventData); ?>;

        // If no data in database, use empty array
        if (!sportData || sportData.length === 0) {
            sportData = [];
        }
        if (!eventData || eventData.length === 0) {
            eventData = [];
        }

        const rowsPerPage = 5;
        let currentPage = 1;
        let currentEventPage = 1;
        let editId = null; // Track editing row for sport
        let editEventId = null; // Track editing row for event

        const addSportForm = $("#addSportForm");
        const addEventForm = $("#addEventForm");
        const formTitleText = $("#formTitleText");
        const eventFormTitleText = $("#eventFormTitleText");

        // Open sport form button
        $("#openFormBtn").click(() => {
            formTitleText.text("Add Sport & Indoor");
            editId = null;
            $("#edit_id").val("");
            $("#sportForm")[0].reset();
            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            addSportForm.slideDown();
            addEventForm.slideUp();
        });

        // Open event form button
        $("#openEventFormBtn").click(() => {
            eventFormTitleText.text("Add Event");
            editEventId = null;
            $("#event_edit_id").val("");
            $("#eventForm")[0].reset();
            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            addEventForm.slideDown();
            addSportForm.slideUp();
        });

        // Cancel sport form button
        $("#cancelForm").click(() => {
            addSportForm.slideUp();
            $("#sportForm")[0].reset();
            $("#edit_id").val("");
            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            editId = null;
        });

        // Cancel event form button
        $("#cancelEventForm").click(() => {
            addEventForm.slideUp();
            $("#eventForm")[0].reset();
            $("#event_edit_id").val("");
            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            editEventId = null;
        });

        // Render sport table with pagination
        function renderSportTable() {
            let tbody = $("#sportTableBody");
            tbody.html("");

            const searchValue = $("#searchInput").val().toLowerCase();
            const filteredData = sportData.filter(s =>
                s.hero_title.toLowerCase().includes(searchValue) ||
                s.hero_subtitle.toLowerCase().includes(searchValue) ||
                s.section_title.toLowerCase().includes(searchValue) ||
                s.section_subtitle.toLowerCase().includes(searchValue)
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
                paginatedData.forEach(s => {
                    tbody.append(`
                    <tr>
                        <td>${s.id}</td>
                        <td>${s.hero_title}</td>
                        <td>${s.hero_subtitle}</td>
                        <td>
                            <button class="action-btn btn-view" onclick="viewSport(${s.id})">View</button>
                            <button class="action-btn btn-edit" onclick="editSport(${s.id})">Edit</button>
                            <button class="action-btn btn-delete" onclick="deleteSport(${s.id})">Delete</button>
                        </td>
                    </tr>`);
                });
            }

            renderPagination(filteredData.length, "pagination", currentPage, false);
        }

        // Render event table with pagination - USING STATUS BUTTON LIKE CAROUSEL
        function renderEventTable() {
            let tbody = $("#eventTableBody");
            tbody.html("");

            const searchValue = $("#searchEventInput").val().toLowerCase();
            const filteredData = eventData.filter(e =>
                e.event_name.toLowerCase().includes(searchValue) ||
                e.description.toLowerCase().includes(searchValue) ||
                e.status.toLowerCase().includes(searchValue)
            );

            const start = (currentEventPage - 1) * rowsPerPage;
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
                paginatedData.forEach(e => {
                    tbody.append(`
                    <tr>
                        <td>${e.id}</td>
                        <td class="event-name-emoji">${e.event_name}</td>
                        <td>${e.description.substring(0, 50)}${e.description.length > 50 ? '...' : ''}</td>
                        <!--<td>
                            <div class="icon-preview">
                                <i class="bi ${e.icon}"></i>
                            </div>
                        </td>-->
                        <td>
                            <button class="btn-status ${e.status === 'Active' ? 'btn-status-active' : 'btn-status-inactive'}" 
                                    onclick="toggleEventStatus(${e.id})">
                                ${e.status}
                            </button>
                        </td>
                        <td>
                            <button class="action-btn btn-view" onclick="viewEvent(${e.id})">View</button>
                            <button class="action-btn btn-edit" onclick="editEvent(${e.id})">Edit</button>
                            <button class="action-btn btn-delete" onclick="deleteEvent(${e.id})">Delete</button>
                        </td>
                    </tr>`);
                });
            }

            renderPagination(filteredData.length, "eventPagination", currentEventPage, true);
        }

        // Toggle event status function - LIKE CAROUSEL
        function toggleEventStatus(id) {
            window.location.href = "?toggle_event_id=" + id;
        }

        // Render pagination controls
        function renderPagination(totalRows, paginationId, currentPageNum, isEvent = false) {
            let totalPages = Math.ceil(totalRows / rowsPerPage);
            let pagination = $("#" + paginationId);
            pagination.html("");

            if (totalPages === 0) {
                pagination.html('<li class="page-item disabled"><a class="page-link">No data</a></li>');
                return;
            }

            // Previous Button
            pagination.append(`
                <li class="page-item ${currentPageNum === 1 ? "disabled" : ""}">
                    <a class="page-link" href="#" onclick="goPage(${currentPageNum - 1}, ${isEvent})">Previous</a>
                </li>
            `);

            // Page Numbers
            for (let i = 1; i <= totalPages; i++) {
                pagination.append(`
                    <li class="page-item ${i === currentPageNum ? "active" : ""}">
                        <a class="page-link" href="#" onclick="goPage(${i}, ${isEvent})">${i}</a>
                    </li>
                `);
            }

            // Next Button
            pagination.append(`
                <li class="page-item ${currentPageNum === totalPages ? "disabled" : ""}">
                    <a class="page-link" href="#" onclick="goPage(${currentPageNum + 1}, ${isEvent})">Next</a>
                </li>
            `);
        }

        // Navigate to page
        function goPage(page, isEvent = false) {
            if (isEvent) {
                const searchValue = $("#searchEventInput").val().toLowerCase();
                const filteredData = eventData.filter(e =>
                    e.event_name.toLowerCase().includes(searchValue) ||
                    e.description.toLowerCase().includes(searchValue) ||
                    e.status.toLowerCase().includes(searchValue)
                );
                let totalPages = Math.ceil(filteredData.length / rowsPerPage);
                if (page < 1 || page > totalPages) return;
                currentEventPage = page;
                renderEventTable();
            } else {
                const searchValue = $("#searchInput").val().toLowerCase();
                const filteredData = sportData.filter(s =>
                    s.hero_title.toLowerCase().includes(searchValue) ||
                    s.hero_subtitle.toLowerCase().includes(searchValue) ||
                    s.section_title.toLowerCase().includes(searchValue) ||
                    s.section_subtitle.toLowerCase().includes(searchValue)
                );
                let totalPages = Math.ceil(filteredData.length / rowsPerPage);
                if (page < 1 || page > totalPages) return;
                currentPage = page;
                renderSportTable();
            }
        }

        // View sport details
        function viewSport(id) {
            let s = sportData.find(x => x.id == id);
            $("#v_id").text(s.id);
            $("#v_hero_title").text(s.hero_title);
            $("#v_hero_subtitle").text(s.hero_subtitle);
            $("#v_section_title").text(s.section_title);
            $("#v_section_subtitle").text(s.section_subtitle);
            $("#v_note_text").text(s.note_text);
            new bootstrap.Modal(document.getElementById("viewModal")).show();
        }

        // View event details
        function viewEvent(id) {
            let e = eventData.find(x => x.id == id);
            $("#ev_id").text(e.id);
            $("#ev_event_name").text(e.event_name);
            $("#ev_description").text(e.description);
            // $("#ev_icon").text(e.icon);
            $("#ev_status").text(e.status);
            new bootstrap.Modal(document.getElementById("viewEventModal")).show();
        }

        // Delete sport
        function deleteSport(id) {
            if (confirm("Are you sure you want to delete this sport & indoor entry?")) {
                window.location.href = "?delete_header_id=" + id;
            }
        }

        // Delete event
        function deleteEvent(id) {
            if (confirm("Are you sure you want to delete this event?")) {
                window.location.href = "?delete_event_id=" + id;
            }
        }

        // Edit sport
        function editSport(id) {
            editId = id;
            const s = sportData.find(x => x.id == id);
            formTitleText.text("Edit Sport & Indoor");
            $("#edit_id").val(id);

            $('input[name="hero_title"]').val(s.hero_title);
            $('input[name="hero_subtitle"]').val(s.hero_subtitle);
            $('input[name="section_title"]').val(s.section_title);
            $('input[name="section_subtitle"]').val(s.section_subtitle);
            $('textarea[name="note_text"]').val(s.note_text);

            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");

            addSportForm.slideDown();
            addEventForm.slideUp();
        }

        // Edit event
        function editEvent(id) {
            editEventId = id;
            const e = eventData.find(x => x.id == id);
            eventFormTitleText.text("Edit Event");
            $("#event_edit_id").val(id);

            $('input[name="event_name"]').val(e.event_name);
            $('textarea[name="description"]').val(e.description);
            // $('input[name="icon"]').val(e.icon);

            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");

            addEventForm.slideDown();
            addSportForm.slideUp();
        }

        // Search functionality for sport
        $("#searchInput").on("keyup", function() {
            currentPage = 1;
            renderSportTable();
        });

        // Search functionality for events
        $("#searchEventInput").on("keyup", function() {
            currentEventPage = 1;
            renderEventTable();
        });

        // VALIDATION SCRIPT - MODIFIED TO ACCEPT EMOJIS
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

                        // Add alphabetic validation - MODIFIED TO ACCEPT EMOJIS AND SPECIAL CHARACTERS
                        if (validationType.includes("alphabetic")) {
                            // This regex allows letters, numbers, spaces, and common emoji/unicode characters
                            // Emojis are Unicode characters that fall outside the ASCII range
                            // We'll allow any character except control characters
                            var unicode_regex = /^[\p{L}\p{N}\p{P}\p{S}\s]+$/u;
                            // Simpler approach: allow any character except problematic ones
                            // This allows emojis, letters, numbers, and special characters
                            if (!/^.+$/.test(value)) {
                                errorMessage = "Please enter valid characters.";
                            }
                            // Remove the strict alphabetic check for event_name
                            if (field.attr("name") === "event_name") {
                                // Event name can contain emojis, so we don't validate strictly
                                // Just check if it's not empty (already checked)
                            } else if (!/^[a-zA-Z\s]+$/.test(value)) {
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

            // Sport form submission with validation
            $("#sportForm").on("submit", function(e) {
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

            // Event form submission with validation
            $("#eventForm").on("submit", function(e) {
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
        renderSportTable();
        renderEventTable();
    </script>

</body>

</html>