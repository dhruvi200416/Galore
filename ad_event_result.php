<?php
include 'ad_event_result_handler.php';
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

        #eventResultForm {
            display: grid;
            grid-template-columns: 1fr;
            gap: 18px;
        }

        @media (min-width: 768px) {
            #eventResultForm {
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

        .galore-select {
            padding: 13px 15px;
            border: 2px solid #ddd;
            border-radius: 10px;
            font-size: 0.95rem;
            background-color: white;
        }

        .galore-input:focus,
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

        /* RANK STYLES */
        .rank-gold {
            background: linear-gradient(135deg, #ffd966, #ffc107);
            color: #7a5c00;
            padding: 5px 12px;
            border-radius: 20px;
            display: inline-block;
            font-weight: bold;
            font-size: 0.85rem;
        }

        .rank-silver {
            background: linear-gradient(135deg, #e3e4e5, #c0c0c0);
            color: #4a4a4a;
            padding: 5px 12px;
            border-radius: 20px;
            display: inline-block;
            font-weight: bold;
            font-size: 0.85rem;
        }

        .rank-bronze {
            background: linear-gradient(135deg, #e3bc8e, #cd7f32);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            display: inline-block;
            font-weight: bold;
            font-size: 0.85rem;
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

        .school-badge {
            background: rgba(220, 53, 69, 0.1);
            color: var(--galore-red);
            padding: 4px 12px;
            border-radius: 20px;
            display: inline-block;
            font-size: 0.8rem;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <?php require 'admin_header.php'; ?>

    <main class="main-content">

        <div class="top-bar d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3" id="topBar">
            <h1 class="mb-0">Event Results Management</h1>
            <button class="btn-add-user" id="openFormBtn">
                <i class="bi bi-plus-circle"></i> Add Event Result
            </button>
        </div>

        <!-- FORM -->
        <div class="add-user-form-container" id="addEventResultForm" style="display:none;">
            <h3 class="form-title" id="formTitleText">Add Event Result</h3>

            <form id="eventResultForm" method="POST" action="">
                <input type="hidden" name="edit_id" id="edit_id" value="">

                <div class="galore-input-group">
                    <label class="galore-label">Event Name <span class="text-danger">*</span></label>
                    <input type="text" name="event_name" class="galore-input" placeholder="e.g., Football Championship, Dance Competition" data-validation="required min" data-min="2" data-max="100">
                    <span id="event_name_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Event Type <span class="text-danger">*</span></label>
                    <select name="event_type" class="galore-select" data-validation="required select">
                        <option value="">Select Event Type</option>
                        <option value="Cultural">Cultural</option>
                        <option value="Sports">Sports</option>
                        <option value="Technical">Technical</option>
                        <option value="Academic">Academic</option>
                    </select>
                    <span id="event_type_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Team Name <span class="text-danger">*</span></label>
                    <input type="text" name="team_name" class="galore-input" placeholder="e.g., RK Warriors, Creative Minds" data-validation="required min" data-min="2" data-max="100">
                    <span id="team_name_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">School/College <span class="text-danger">*</span></label>
                    <input type="text" name="school" class="galore-input" placeholder="e.g., RK University, School of Engineering" data-validation="required min" data-min="2" data-max="100">
                    <span id="school_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Rank/Position <span class="text-danger">*</span></label>
                    <select name="ranks" class="galore-select" data-validation="required select">
                        <option value="">Select Rank</option>
                        <option value="1st">🥇 1st Place</option>
                        <option value="2nd">🥈 2nd Place</option>
                        <option value="3rd">🥉 3rd Place</option>
                        <option value="Gold">🏆 Gold Medal</option>
                        <option value="Silver">🥈 Silver Medal</option>
                        <option value="Bronze">🥉 Bronze Medal</option>
                    </select>
                    <span id="ranks_error" class="error-message"></span>
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
                <h2 class="mb-0">Event Results Data</h2>

                <div class="search-box" id="searchBox">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchInput" placeholder="Search events, teams, schools...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Event Name</th>
                            <th>Event Type</th>
                            <th>Team Name</th>
                            <!-- <th>School</th> -->
                            <th>Rank</th>
                            <th>Status</th>
                            <th id="actionsHeader">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="eventResultTableBody"></tbody>
                </table>
            </div>

            <div class="pagination-container">
                <ul class="pagination" id="pagination"></ul>
            </div>
        </div>

    </main>

    <!-- VIEW MODAL -->
    <div class="modal fade" id="viewModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="border-radius:18px;border-top:6px solid var(--galore-red);">
                <div class="modal-header text-white" style="background:var(--galore-red);">
                    <h5 class="modal-title fw-bold">Event Result Full Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><b>ID:</b> <span id="v_id"></span></p>
                            <p><b>Event Name:</b> <span id="v_event_name"></span></p>
                            <p><b>Event Type:</b> <span id="v_event_type"></span></p>
                            <p><b>Team Name:</b> <span id="v_team_name"></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><b>School/College:</b> <span id="v_school"></span></p>
                            <p><b>Rank/Position:</b> <span id="v_ranks"></span></p>
                            <p><b>Status:</b> <span id="v_status"></span></p>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center mt-3">
                        <h5>Result Card Preview:</h5>
                        <div class="result-card-preview d-inline-block p-4 border rounded" id="cardPreview">
                            <!-- Preview will be inserted here by JavaScript -->
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
        // Use PHP to pass database event results to JavaScript
        let eventResultData = <?php echo json_encode($eventResultData); ?>;

        // If no event results in database, use empty array
        if (!eventResultData || eventResultData.length === 0) {
            eventResultData = [];
        }

        const rowsPerPage = 5;
        let currentPage = 1;
        let editId = null; // Track editing row

        const addEventResultForm = $("#addEventResultForm");
        const formTitleText = $("#formTitleText");

        // Toggle status function
        function toggleStatus(id) {
            window.location.href = "?toggle_status=" + id;
        }

        // Function to get rank HTML with styling
        function getRankHtml(rank) {
            if (rank === '1st' || rank === 'Gold') return '<span class="rank-gold">🥇 ' + rank + '</span>';
            if (rank === '2nd' || rank === 'Silver') return '<span class="rank-silver">🥈 ' + rank + '</span>';
            if (rank === '3rd' || rank === 'Bronze') return '<span class="rank-bronze">🥉 ' + rank + '</span>';
            return '<span>' + rank + '</span>';
        }

        // Function to get rank icon
        function getRankIcon(rank) {
            if (rank === '1st' || rank === 'Gold') return '🥇';
            if (rank === '2nd' || rank === 'Silver') return '🥈';
            if (rank === '3rd' || rank === 'Bronze') return '🥉';
            return '🏆';
        }

        // Open form button
        $("#openFormBtn").click(() => {
            formTitleText.text("Add Event Result");
            editId = null;
            $("#edit_id").val("");
            $("#eventResultForm")[0].reset();
            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            addEventResultForm.slideDown();
        });

        // Cancel form button
        $("#cancelForm").click(() => {
            addEventResultForm.slideUp();
            $("#eventResultForm")[0].reset();
            $("#edit_id").val("");
            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            editId = null;
        });

        // Function to create card preview HTML
        function createCardPreview(result) {
            const rankIcon = getRankIcon(result.ranks);
            return `
                <div class="result-card-preview" style="
                    background: white;
                    border-radius: 15px;
                    padding: 20px;
                    margin: 10px;
                    text-align: center;
                    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
                    min-width: 300px;
                ">
                    <div style="font-size: 3rem; margin-bottom: 15px;">
                        ${rankIcon}
                    </div>
                    <h5 style="color: #dc3545; margin-bottom: 15px; font-weight: bold;">${escapeHtml(result.event_name)}</h5>
                    <p style="margin: 8px 0; color: #555;"><b>Event Type:</b> ${escapeHtml(result.event_type)}</p>
                    <p style="margin: 8px 0; color: #555;"><b>Team:</b> ${escapeHtml(result.team_name)}</p>
                    <p style="margin: 8px 0; color: #555;"><b>School:</b> ${escapeHtml(result.school)}</p>
                    <p style="margin: 8px 0; color: #555;"><b>Rank:</b> ${escapeHtml(result.ranks)}</p>
                </div>
            `;
        }

        // Render table with pagination
        function renderTable() {
            let tbody = $("#eventResultTableBody");
            tbody.html("");

            const searchValue = $("#searchInput").val().toLowerCase();
            const filteredData = eventResultData.filter(r =>
                r.event_name.toLowerCase().includes(searchValue) ||
                r.event_type.toLowerCase().includes(searchValue) ||
                r.team_name.toLowerCase().includes(searchValue) ||
                r.school.toLowerCase().includes(searchValue) ||
                r.ranks.toLowerCase().includes(searchValue)
            );

            const start = (currentPage - 1) * rowsPerPage;
            const paginatedData = filteredData.slice(start, start + rowsPerPage);

            if (paginatedData.length === 0) {
                tbody.append(`
                     <tr>
                        <td colspan="8" class="text-center py-4">
                            <i class="bi bi-inbox fs-1 d-block mb-3" style="color: #ddd;"></i>
                            <h5 style="color: #999;">No data found</h5>
                          </td>
                      </tr>
                `);
            } else {
                paginatedData.forEach(r => {
                    const statusClass = r.status === 'Active' ? 'btn-status-active' : 'btn-status-inactive';
                    
                    tbody.append(`
                      <tr>
                        <td>${r.id}</td>
                        <td><strong>${escapeHtml(r.event_name)}</strong></td>
                        <td>${escapeHtml(r.event_type)}</td>
                        <td>${escapeHtml(r.team_name)}</td>
                       <!-- <td><span class="school-badge">${escapeHtml(r.school)}</span></td>-->
                        <td>${getRankHtml(r.ranks)}</td>
                        <td>
                            <button class="btn-status ${statusClass}" 
                                    onclick="toggleStatus(${r.id})">
                                ${r.status}
                            </button>
                        </td>
                        <td>
                            <button class="action-btn btn-view" onclick="viewEventResult(${r.id})">View</button>
                            <button class="action-btn btn-edit" onclick="editEventResult(${r.id})">Edit</button>
                            <button class="action-btn btn-delete" onclick="deleteEventResult(${r.id})">Delete</button>
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
            return String(text).replace(/[&<>]/g, function(m) {
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
            const filteredData = eventResultData.filter(r =>
                r.event_name.toLowerCase().includes(searchValue) ||
                r.event_type.toLowerCase().includes(searchValue) ||
                r.team_name.toLowerCase().includes(searchValue) ||
                r.school.toLowerCase().includes(searchValue) ||
                r.ranks.toLowerCase().includes(searchValue)
            );
            const totalPages = Math.ceil(filteredData.length / rowsPerPage);
            if (page < 1 || page > totalPages) return;
            currentPage = page;
            renderTable();
        }

        // View event result details with card preview
        function viewEventResult(id) {
            let r = eventResultData.find(x => x.id == id);

            // Set modal text content
            $("#v_id").text(r.id);
            $("#v_event_name").text(r.event_name);
            $("#v_event_type").text(r.event_type);
            $("#v_team_name").text(r.team_name);
            $("#v_school").text(r.school);
            $("#v_ranks").html(getRankHtml(r.ranks));
            const statusClass = r.status === 'Active' ? 'bg-success' : 'bg-secondary';
            $("#v_status").html(`<span class="badge ${statusClass} px-3 py-2 rounded-pill">${r.status}</span>`);

            // Create and insert card preview
            const previewHtml = createCardPreview(r);
            $("#cardPreview").html(previewHtml);

            // Show modal
            new bootstrap.Modal(document.getElementById("viewModal")).show();
        }

        // Delete event result
        function deleteEventResult(id) {
            if (confirm("Are you sure you want to delete this event result?")) {
                window.location.href = "?delete_id=" + id;
            }
        }

        // Edit event result
        function editEventResult(id) {
            editId = id;
            const r = eventResultData.find(x => x.id == id);
            formTitleText.text("Edit Event Result");
            $("#edit_id").val(id);

            // Populate form fields
            $('input[name="event_name"]').val(r.event_name);
            $('select[name="event_type"]').val(r.event_type);
            $('input[name="team_name"]').val(r.team_name);
            $('input[name="school"]').val(r.school);
            $('select[name="ranks"]').val(r.ranks);

            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");

            addEventResultForm.slideDown();
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

            $("input, select").on("input change", function() {
                validateInput(this);
            });

            // Event result form submission with validation
            $("#eventResultForm").on("submit", function(e) {
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