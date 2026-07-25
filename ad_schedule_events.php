<?php
include 'ad_schedule_events_handler.php';
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

        .btn-add-event:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(220, 53, 69, 0.45);
        }

        /* STATUS BUTTON STYLES - Same as carousel */
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

        #eventForm {
            display: grid;
            grid-template-columns: 1fr;
            gap: 18px;
        }

        @media (min-width: 768px) {
            #eventForm {
                grid-template-columns: 1fr 1fr;
            }

            .form-buttons {
                grid-column: span 2;
            }
        }

        .full-width {
            grid-column: 1 / -1;
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

        /* DAY BADGE */
        .day-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: bold;
            text-transform: uppercase;
        }

        .day-1 {
            background: rgba(255, 193, 7, 0.2);
            color: #856404;
        }

        .day-2 {
            background: rgba(0, 123, 255, 0.2);
            color: #004085;
        }

        .day-3 {
            background: rgba(40, 167, 69, 0.2);
            color: #155724;
        }
    </style>
</head>

<body>

    <?php require 'admin_header.php'; ?>

    <main class="main-content">

        <div class="top-bar d-flex justify-content-between align-items-center flex-wrap gap-3" id="topBar">
            <h1 class="mb-0">Schedule Events Management</h1>
            <button class="btn-add-event" id="openFormBtn">
                <i class="bi bi-plus-circle"></i> Add Event
            </button>
        </div>

        <!-- FORM -->
        <div class="add-event-form-container" id="addEventForm" style="display:none;">
            <h3 class="form-title" id="formTitleText">Add Schedule Event</h3>

            <form id="eventForm" method="POST" action="">
                <input type="hidden" name="edit_id" id="edit_id" value="">

                <div class="galore-input-group full-width">
                    <label class="galore-label">Day Title (e.g., Day 1 - 10th Jan 2026) <span class="text-danger">*</span></label>
                    <input type="text" name="day_title" class="galore-input" data-validation="required min" data-min="3" data-max="100">
                    <span id="day_title_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Event Time (e.g., 09:00 AM) <span class="text-danger">*</span></label>
                    <input type="text" name="event_time" class="galore-input" data-validation="required min" data-min="3" data-max="100">
                    <span id="event_time_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Event Name <span class="text-danger">*</span></label>
                    <input type="text" name="event_name" class="galore-input" data-validation="required min" data-min="3" data-max="100">
                    <span id="event_name_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Event Location <span class="text-danger">*</span></label>
                    <input type="text" name="event_location" class="galore-input" data-validation="required min" data-min="3" data-max="100">
                    <span id="event_location_error" class="error-message"></span>
                </div>

                <div class="form-buttons full-width">
                    <button type="submit" name="submit" class="btn-save">Save Event</button>
                    <button type="button" class="btn-cancel" id="cancelForm">Cancel</button>
                </div>

            </form>
        </div>

        <!-- TABLE -->
        <div class="data-table-container">

            <div class="table-header" id="tableHeader">
                <h2 class="mb-0">Schedule Events Data</h2>

                <div class="search-box" id="searchBox">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchInput" placeholder="Search events...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Day</th>
                            <th>Time</th>
                            <th>Event Name</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th id="actionsHeader">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="eventsTableBody"></tbody>
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
                    <h5 class="modal-title fw-bold">Event Full Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <strong>ID:</strong> <span id="v_id"></span>
                        </div>
                        <div class="col-12 mb-3">
                            <strong>Day Title:</strong> <span id="v_day_title"></span>
                        </div>
                        <div class="col-12 mb-3">
                            <strong>Event Time:</strong> <span id="v_event_time"></span>
                        </div>
                        <div class="col-12 mb-3">
                            <strong>Event Name:</strong> <span id="v_event_name"></span>
                        </div>
                        <div class="col-12 mb-3">
                            <strong>Event Location:</strong> <span id="v_event_location"></span>
                        </div>
                        <div class="col-12 mb-3">
                            <strong>Status:</strong> <span id="v_status"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Use PHP to pass database events to JavaScript
        let eventsData = <?php echo json_encode($eventsData); ?>;

        // If no events in database, use empty array
        if (!eventsData || eventsData.length === 0) {
            eventsData = [];
        }

        const rowsPerPage = 5;
        let currentPage = 1;
        let editId = null; // Track editing row

        const addEventForm = $("#addEventForm");
        const formTitleText = $("#formTitleText");

        // Get day class based on day title
        function getDayClass(dayTitle) {
            if (dayTitle.includes("Day 1")) return "day-1";
            if (dayTitle.includes("Day 2")) return "day-2";
            if (dayTitle.includes("Day 3")) return "day-3";
            return "";
        }

        // Toggle status function - using button style like carousel
        function toggleStatus(id) {
                window.location.href = "?toggle_status=" + id;
            
        }

        // Open form button
        $("#openFormBtn").click(() => {
            formTitleText.text("Add Schedule Event");
            editId = null;
            $("#edit_id").val("");
            $("#eventForm")[0].reset();
            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            addEventForm.slideDown();
        });

        // Cancel form button
        $("#cancelForm").click(() => {
            addEventForm.slideUp();
            $("#eventForm")[0].reset();
            $("#edit_id").val("");
            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            editId = null;
        });

        // Render table with pagination
        function renderTable() {
            let tbody = $("#eventsTableBody");
            tbody.html("");

            const searchValue = $("#searchInput").val().toLowerCase();
            const filteredData = eventsData.filter(e =>
                e.day_title.toLowerCase().includes(searchValue) ||
                e.event_time.toLowerCase().includes(searchValue) ||
                e.event_name.toLowerCase().includes(searchValue) ||
                e.event_location.toLowerCase().includes(searchValue)
            );

            const start = (currentPage - 1) * rowsPerPage;
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
                    const dayClass = getDayClass(e.day_title);
                    const statusClass = e.status === 'Active' ? 'btn-status-active' : 'btn-status-inactive';
                    
                    tbody.append(`
                        <tr>
                            <td>${e.id}</td>
                            <td>
                                <span class="day-badge ${dayClass}">${e.day_title.split(' - ')[0]}</span><br>
                                <small>${e.day_title.split(' - ')[1] || ''}</small>
                            </td>
                            <td><strong>${e.event_time}</strong></td>
                            <td>${escapeHtml(e.event_name)}</td>
                            <td>${escapeHtml(e.event_location)}</td>
                            <td>
                                <button class="btn-status ${statusClass}" 
                                        onclick="toggleStatus(${e.id})">
                                    ${e.status}
                                </button>
                            </td>
                            <td>
                                <div class="d-flex flex-column flex-sm-row gap-2 gap-sm-2">
                                    <button class="action-btn btn-view" onclick="viewEvent(${e.id})">View</button>
                                    <button class="action-btn btn-edit" onclick="editEvent(${e.id})">Edit</button>
                                    <button class="action-btn btn-delete" onclick="deleteEvent(${e.id})">Delete</button>
                                </div>
                            </td>
                        </tr>
                    `);
                });
            }

            renderPagination(filteredData.length);
        }
        
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
            const filteredData = eventsData.filter(e =>
                e.day_title.toLowerCase().includes(searchValue) ||
                e.event_time.toLowerCase().includes(searchValue) ||
                e.event_name.toLowerCase().includes(searchValue) ||
                e.event_location.toLowerCase().includes(searchValue)
            );
            let totalPages = Math.ceil(filteredData.length / rowsPerPage);
            if (page < 1 || page > totalPages) return;
            currentPage = page;
            renderTable();
        }

        // View event details
        function viewEvent(id) {
            let e = eventsData.find(x => x.id == id);
            if (e) {
                $("#v_id").text(e.id);
                $("#v_day_title").text(e.day_title);
                $("#v_event_time").text(e.event_time);
                $("#v_event_name").text(e.event_name);
                $("#v_event_location").text(e.event_location);
                const statusClass = e.status === 'Active' ? 'status-active' : 'status-inactive';
                $("#v_status").html(`<span class="badge ${statusClass}">${e.status}</span>`);
                new bootstrap.Modal(document.getElementById("viewModal")).show();
            }
        }

        // Delete event
        function deleteEvent(id) {
            if (confirm("Are you sure you want to delete this event?")) {
                window.location.href = "?delete_id=" + id;
            }
        }

        // Edit event
        function editEvent(id) {
            editId = id;
            const e = eventsData.find(x => x.id == id);
            if (e) {
                formTitleText.text("Edit Event");
                $("#edit_id").val(id);
                
                $('input[name="day_title"]').val(e.day_title);
                $('input[name="event_time"]').val(e.event_time);
                $('input[name="event_name"]').val(e.event_name);
                $('input[name="event_location"]').val(e.event_location);
                
                // Clear validation classes and error messages
                $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
                $(".error-message").text("");
                
                addEventForm.slideDown();
            }
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
        renderTable();
    </script>

</body>

</html>