<?php
include 'ad_co_team_handler.php';
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
        .btn-add-team {
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

        .btn-add-team:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(220, 53, 69, 0.45);
        }

        /* FORM */
        .add-team-form-container {
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

        #teamForm {
            display: grid;
            grid-template-columns: 1fr;
            gap: 18px;
        }

        @media (min-width: 768px) {
            #teamForm {
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

        /* Status Badge */
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
        }

        .status-active {
            background: #d4edda;
            color: #155724;
        }

        .status-inactive {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</head>

<body>

    <?php require 'ad_co_header.php'; ?>

    <main class="main-content">

        <div class="top-bar d-flex justify-content-between align-items-center flex-wrap gap-3" id="topBar">
            <h1 id="pageTitle" class="mb-0">Teams Management</h1>
            <button class="btn-add-team" id="openFormBtn">
                <i class="bi bi-plus-circle"></i> Add Team
            </button>
        </div>

        <!-- FORM -->
        <div class="add-team-form-container" id="addTeamForm" style="display:none;">
            <h3 class="form-title" id="formTitleText">Add Team</h3>

            <form id="teamForm" method="POST" action="">
                <input type="hidden" name="edit_id" id="edit_id" value="">

                <div class="galore-input-group">
                    <label class="galore-label">Team Name <span class="text-danger">*</span></label>
                    <input type="text" name="team_name" class="galore-input" data-validation="required min" data-min="3" data-max="255">
                    <span id="team_name_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Event Name <span class="text-danger">*</span></label>
                    <input type="text" name="event_name" class="galore-input" data-validation="required min" data-min="3" data-max="255">
                    <span id="event_name_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Event Type <span class="text-danger">*</span></label>
                    <select name="event_type" class="galore-select" data-validation="required">
                        <option value="">Select Event Type</option>
                        <option value="Cultural">Cultural</option>
                        <option value="Sports">Sports</option>
                        <option value="Technical">Technical</option>
                        <option value="Academic">Academic</option>
                    </select>
                    <span id="event_type_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Game Name <span class="text-danger">*</span></label>
                    <input type="text" name="game_name" class="galore-input" data-validation="required min" data-min="3" data-max="255">
                    <span id="game_name_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">School/College <span class="text-danger">*</span></label>
                    <input type="text" name="school" class="galore-input" data-validation="required min" data-min="3" data-max="255">
                    <span id="school_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Coordinator Email <span class="text-danger">*</span></label>
                    <input type="email" name="coordinator_email" class="galore-input" data-validation="required email">
                    <span id="coordinator_email_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Coordinator Role <span class="text-danger">*</span></label>
                    <input type="text" name="coordinator_role" class="galore-input" data-validation="required min" data-min="2" data-max="100">
                    <span id="coordinator_role_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Player IDs (Comma separated)</label>
                    <textarea name="player_ids" class="galore-textarea" data-validation="max" data-max="1000" placeholder="Enter player IDs separated by commas"></textarea>
                    <span id="player_ids_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Player Count <span class="text-danger">*</span></label>
                    <input type="number" name="player_count" class="galore-input" data-validation="required number" data-min="1" data-max="50">
                    <span id="player_count_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Status</label>
                    <select name="status" class="galore-select">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                    <span id="status_error" class="error-message"></span>
                </div>

                <div class="form-buttons">
                    <button type="submit" name="submit" class="btn-save">Save Team</button>
                    <button type="button" class="btn-cancel" id="cancelForm">Cancel</button>
                </div>

            </form>
        </div>

        <!-- TABLE -->
        <div class="data-table-container">

            <div class="table-header" id="tableHeader">
                <h2 class="mb-0">Teams Data</h2>

                <div class="search-box" id="searchBox">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchInput" placeholder="Search by team name, event, school...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Team Name</th>
                            <th>Event Name</th>
                            <th>Event Type</th>
                            <th>Game Name</th>
                            <!-- <th>School</th>
                            <th>Coordinator Email</th>
                            <th>Coordinator Role</th>
                            <th>Player IDs</th>
                            <th>Player Count</th> -->
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="teamTableBody"></tbody>
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
                    <h5 class="modal-title fw-bold">Team Full Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3"><b>ID:</b> <span id="v_id"></span></div>
                        <div class="col-md-6 mb-3"><b>Team Name:</b> <span id="v_team_name"></span></div>
                        <div class="col-md-6 mb-3"><b>Event Name:</b> <span id="v_event_name"></span></div>
                        <div class="col-md-6 mb-3"><b>Event Type:</b> <span id="v_event_type"></span></div>
                        <div class="col-md-6 mb-3"><b>Game Name:</b> <span id="v_game_name"></span></div>
                        <div class="col-md-6 mb-3"><b>School:</b> <span id="v_school"></span></div>
                        <div class="col-md-6 mb-3"><b>Coordinator Email:</b> <span id="v_coordinator_email"></span></div>
                        <div class="col-md-6 mb-3"><b>Coordinator Role:</b> <span id="v_coordinator_role"></span></div>
                        <div class="col-12 mb-3"><b>Player IDs:</b> <span id="v_player_ids"></span></div>
                        <div class="col-md-6 mb-3"><b>Player Count:</b> <span id="v_player_count"></span></div>
                        <div class="col-md-6 mb-3"><b>Status:</b> <span id="v_status"></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Use PHP to pass database teams to JavaScript
        let teamsData = <?php echo json_encode($teamsData); ?>;

        // If no teams in database, use empty array
        if (!teamsData || teamsData.length === 0) {
            teamsData = [];
        }

        const rowsPerPage = 5;
        let currentPage = 1;
        let editId = null;

        const addTeamForm = $("#addTeamForm");
        const formTitleText = $("#formTitleText");

        // Open form button
        $("#openFormBtn").click(() => {
            formTitleText.text("Add Team");
            editId = null;
            $("#edit_id").val("");
            $("#teamForm")[0].reset();
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            addTeamForm.slideDown();
        });

        // Cancel form button
        $("#cancelForm").click(() => {
            addTeamForm.slideUp();
            $("#teamForm")[0].reset();
            $("#edit_id").val("");
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            editId = null;
        });

        // Render table with pagination
        function renderTable() {
            let tbody = $("#teamTableBody");
            tbody.html("");

            const searchValue = $("#searchInput").val().toLowerCase();
            const filteredData = teamsData.filter(t =>
                t.team_name.toLowerCase().includes(searchValue) ||
                t.event_name.toLowerCase().includes(searchValue) ||
                t.game_name.toLowerCase().includes(searchValue) ||
                t.school.toLowerCase().includes(searchValue) ||
                t.coordinator_email.toLowerCase().includes(searchValue)
            );

            const start = (currentPage - 1) * rowsPerPage;
            const paginatedData = filteredData.slice(start, start + rowsPerPage);

            if (paginatedData.length === 0) {
                tbody.append(`
            <tr>
                <td colspan="12" class="text-center py-4">
                    <i class="bi bi-inbox fs-1 d-block mb-3" style="color: #ddd;"></i>
                    <h5 style="color: #999;">No data found</h5>
                </td>
            </tr>
        `);
            } else {
                paginatedData.forEach(t => {
                    let statusClass = t.status === 'Active' ? 'btn-status-active' : 'btn-status-inactive';
                    let playerIdsDisplay = t.player_ids ? (t.player_ids.length > 30 ? t.player_ids.substring(0, 30) + '...' : t.player_ids) : '-';

                    tbody.append(`
                <tr>
                    <td>${t.id}</td>
                    <td>${t.team_name}</td>
                    <td>${t.event_name}</td>
                    <td>${t.event_type}</td>
                    <td>${t.game_name}</td>
                    <!--<td>${t.school}</td>
                    <td>${t.coordinator_email}</td>
                    <td>${t.coordinator_role}</td>
                    <td title="${t.player_ids || ''}">${playerIdsDisplay}</td>
                    <td>${t.player_count}</td>-->
                    <td>
                        <button class="btn-status ${statusClass}" onclick="toggleTeamStatus(${t.id})">
                            ${t.status}
                        </button>
                    </td>
                    <td>
                        <div class="d-flex flex-column flex-sm-row gap-2 gap-sm-2">
                            <button class="action-btn btn-view" onclick="viewTeam(${t.id})">View</button>
                            <button class="action-btn btn-edit" onclick="editTeam(${t.id})">Edit</button>
                            <button class="action-btn btn-delete" onclick="deleteTeam(${t.id})">Delete</button>
                        </div>
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

            pagination.append(`
                <li class="page-item ${currentPage === 1 ? "disabled" : ""}">
                    <a class="page-link" href="#" onclick="goPage(${currentPage - 1})">Previous</a>
                </li>
            `);

            for (let i = 1; i <= totalPages; i++) {
                pagination.append(`
                    <li class="page-item ${i === currentPage ? "active" : ""}">
                        <a class="page-link" href="#" onclick="goPage(${i})">${i}</a>
                    </li>
                `);
            }

            pagination.append(`
                <li class="page-item ${currentPage === totalPages || totalPages === 0 ? "disabled" : ""}">
                    <a class="page-link" href="#" onclick="goPage(${currentPage + 1})">Next</a>
                </li>
            `);
        }

        // Navigate to page
        function goPage(page) {
            const searchValue = $("#searchInput").val().toLowerCase();
            const filteredData = teamsData.filter(t =>
                t.team_name.toLowerCase().includes(searchValue) ||
                t.event_name.toLowerCase().includes(searchValue) ||
                t.game_name.toLowerCase().includes(searchValue) ||
                t.school.toLowerCase().includes(searchValue) ||
                t.coordinator_email.toLowerCase().includes(searchValue)
            );
            const totalPages = Math.ceil(filteredData.length / rowsPerPage);
            if (page < 1 || page > totalPages) return;
            currentPage = page;
            renderTable();
        }

        // View team details
        function viewTeam(id) {
            let t = teamsData.find(x => x.id == id);
            $("#v_id").text(t.id);
            $("#v_team_name").text(t.team_name);
            $("#v_event_name").text(t.event_name);
            $("#v_event_type").text(t.event_type);
            $("#v_game_name").text(t.game_name);
            $("#v_school").text(t.school);
            $("#v_coordinator_email").text(t.coordinator_email);
            $("#v_coordinator_role").text(t.coordinator_role);
            $("#v_player_ids").text(t.player_ids || '-');
            $("#v_player_count").text(t.player_count);
            $("#v_status").html(`<span class="badge ${t.status === 'Active' ? 'bg-success' : 'bg-secondary'} px-3 py-2">${t.status}</span>`);
            new bootstrap.Modal(document.getElementById("viewModal")).show();
        }

        // Delete team
        function deleteTeam(id) {
                window.location.href = "?delete_id=" + id;
        }

        // Toggle team status
        function toggleTeamStatus(id) {
                window.location.href = "?toggle_team_id=" + id;
        }

        // Edit team
        function editTeam(id) {
            editId = id;
            const t = teamsData.find(x => x.id == id);
            formTitleText.text("Edit Team");
            $("#edit_id").val(id);

            $('input[name="team_name"]').val(t.team_name);
            $('input[name="event_name"]').val(t.event_name);
            $('select[name="event_type"]').val(t.event_type);
            $('input[name="game_name"]').val(t.game_name);
            $('input[name="school"]').val(t.school);
            $('input[name="coordinator_email"]').val(t.coordinator_email);
            $('input[name="coordinator_role"]').val(t.coordinator_role);
            $('textarea[name="player_ids"]').val(t.player_ids);
            $('input[name="player_count"]').val(t.player_count);
            $('select[name="status"]').val(t.status);

            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");

            addTeamForm.slideDown();
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

                        if (validationType.includes("email")) {
                            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                            if (!emailRegex.test(value)) {
                                errorMessage = "Please enter a valid email address.";
                            }
                        }

                        if (validationType.includes("number")) {
                            if (isNaN(value) || value === "") {
                                errorMessage = "Please enter a valid number.";
                            } else {
                                let numValue = parseInt(value);
                                if (numValue < minLength) {
                                    errorMessage = `Value must be at least ${minLength}.`;
                                }
                                if (numValue > maxLength) {
                                    errorMessage = `Value must be at most ${maxLength}.`;
                                }
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

            $("#teamForm").on("submit", function(e) {
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
        });

        // Initial render
        renderTable();
    </script>

</body>

</html>