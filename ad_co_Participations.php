<?php
require_once 'admin_auth_check.php';
require_once 'ad_co_participations_handler.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Co-coordinator | Event Participants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- jQuery & Validation -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        :root {
            --galore-red: #dc3545;
            --galore-red-dark: #b02a37;
            --galore-red-light: #f8d7da;
            --galore-gray: #6c757d;
        }

        body {
            background: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
        }

        .main-wrapper {
            margin-left: 270px;
            padding: 30px;
        }

        @media (max-width: 991.98px) {
            .main-wrapper {
                margin-left: 0;
                padding: 20px;
            }
        }

        /* Top Bar */
        .top-bar {
            background: white;
            border-radius: 18px;
            border-top: 6px solid var(--galore-red);
            padding: 20px 30px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .top-bar h1 {
            color: var(--galore-red);
            font-weight: 800;
            font-size: 1.8rem;
            margin: 0;
        }

        .btn-add {
            background: linear-gradient(135deg, #ff4d5a, var(--galore-red));
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.3);
        }

        /* Stats Cards */
.stats-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 30px;
}

@media (max-width: 1024px) {
    .stats-container {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .stats-container {
        grid-template-columns: 1fr;
    }
}

.stat-card {
    background: white;
    border-radius: 16px;
    padding: 20px;
    text-align: center;
    border-top: 4px solid var(--galore-red);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    transition: transform 0.3s;
    cursor: pointer;
}

.stat-card:hover {
    transform: translateY(-3px);
}

.stat-card h4 {
    color: var(--galore-red);
    margin-bottom: 15px;
    font-size: 1.2rem;
}

.stat-numbers {
    display: flex;
    justify-content: space-around;
    margin-bottom: 20px;
}

.stat-number {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--galore-red);
}

.stat-label {
    font-size: 0.7rem;
    color: var(--galore-gray);
}
        /* Modal Form */
        .modal-content {
            border-radius: 18px;
            border-top: 6px solid var(--galore-red);
            margin-left: 20%;
        }

        .modal-header {
            background: var(--galore-red);
            color: white;
            border-radius: 18px 18px 0 0;
        }

        .modal-header .btn-close {
            filter: brightness(0) invert(1);
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 0;
        }

        .form-group label {
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
            font-size: 0.85rem;
            color: #333;
        }

        .form-control,
        .form-select {
            width: 100%;
            padding: 10px 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--galore-red);
            outline: none;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
        }

        .full-width {
            grid-column: span 2;
        }

        .modal-footer {
            padding: 20px 30px;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        /* Validation Styles */
        .error-message {
            font-size: 0.75rem;
            margin-top: 0.25rem;
            display: block;
            color: #dc3545 !important;
            min-height: 18px;
        }

        .is-valid {
            border-color: #198754 !important;
        }

        .is-invalid {
            border-color: #dc3545 !important;
        }

        /* Table Section */
        .records-section {
            background: white;
            border-radius: 18px;
            border-top: 6px solid var(--galore-red);
            padding: 30px;
            margin-top: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .table-title {
            color: var(--galore-red);
            font-weight: 700;
            font-size: 1.5rem;
            margin: 0;
        }

        .filter-section {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .filter-input {
            flex: 1;
            padding: 10px 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            min-width: 200px;
        }

        .filter-btn {
            background: var(--galore-red);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: var(--galore-red);
            color: white;
            padding: 12px;
            text-align: left;
            font-size: 13px;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            font-size: 13px;
        }

        tr:hover {
            background: var(--galore-red-light);
        }

        .school-badge,
        .event-badge-table,
        .coordinator-badge {
            background: rgba(220, 53, 69, 0.1);
            color: var(--galore-red);
            padding: 4px 10px;
            border-radius: 15px;
            display: inline-block;
            font-size: 11px;
            font-weight: 600;
        }

        .btn-status {
            padding: 5px 10px;
            border: none;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.75rem;
            cursor: pointer;
        }

        .btn-status-active {
            background: #28a745;
            color: white;
        }

        .btn-status-inactive {
            background: #6c757d;
            color: white;
        }

        .action-btn {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 0 3px;
        }

        .btn-view {
            background: #17a2b8;
            color: white;
        }

        .btn-edit {
            background: #ffc107;
            color: white;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .alert {
            padding: 12px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .coordinator-matched {
            background: #d4edda;
            color: #155724;
        }

        /* Pagination Styles */
        .pagination-container {
            margin-top: 25px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .pagination-btn {
            padding: 8px 15px;
            border: 1px solid #ddd;
            background: white;
            color: var(--galore-red);
            cursor: pointer;
            border-radius: 5px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .pagination-btn:hover:not(:disabled) {
            background: var(--galore-red);
            color: white;
            border-color: var(--galore-red);
        }

        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .pagination-btn.active {
            background: var(--galore-red);
            color: white;
            border-color: var(--galore-red);
        }

        .page-numbers {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }

        .page-number {
            padding: 8px 12px;
            border: 1px solid #ddd;
            background: white;
            color: var(--galore-red);
            cursor: pointer;
            border-radius: 5px;
            transition: all 0.3s ease;
            min-width: 40px;
            text-align: center;
        }

        .page-number:hover {
            background: var(--galore-red);
            color: white;
            border-color: var(--galore-red);
        }

        .page-number.active {
            background: var(--galore-red);
            color: white;
            border-color: var(--galore-red);
        }

        .pagination-info {
            margin-top: 15px;
            text-align: center;
            font-size: 0.85rem;
            color: var(--galore-gray);
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .full-width {
                grid-column: span 1;
            }
            
            .page-numbers {
                order: 2;
                width: 100%;
                justify-content: center;
            }
            
            .pagination-container {
                flex-direction: column;
            }
        }
    </style>
    <style>
        /* Status Button Styles - Test with highest specificity */
        button.btn-status.btn-status-active {
            background-color: #28a745 !important;
            color: #ffffff !important;
        }

        button.btn-status.btn-status-inactive {
            background-color: #6c757d !important;
            color: #ffffff !important;
        }

        .btn-status-active {
            background-color: #28a745 !important;
            color: #ffffff !important;
        }

        .btn-status-inactive {
            background-color: #6c757d !important;
            color: #ffffff !important;
        }

        /* Override any Bootstrap button styles */
        .btn-status.btn-status-active,
        .btn-status.btn-status-inactive {
            background-image: none !important;
            border: none !important;
            box-shadow: none !important;
        }
    </style>
</head>

<body>
    <?php require 'ad_co_header.php'; ?>

    <div class="main-wrapper">
        <!-- Top Bar -->
        <div class="top-bar">
            <h1><i class="bi bi-people-fill me-2"></i>Event Participants Management</h1>
            <button class="btn-add" data-bs-toggle="modal" data-bs-target="#participantModal" onclick="openAddModal()">
                <i class="bi bi-plus-circle me-2"></i>Add Participant
            </button>
        </div>

        <!-- Alert Messages -->
        <?php if ($msg == 'added'): ?>
            <div class="alert alert-success"><i class="bi bi-check-circle-fill me-2"></i> Participant added successfully!</div>
        <?php elseif ($msg == 'updated'): ?>
            <div class="alert alert-success"><i class="bi bi-check-circle-fill me-2"></i> Participant updated successfully!</div>
        <?php elseif ($msg == 'deleted'): ?>
            <div class="alert alert-success"><i class="bi bi-check-circle-fill me-2"></i> Participant deleted successfully!</div>
        <?php elseif ($msg == 'toggled'): ?>
            <div class="alert alert-success"><i class="bi bi-check-circle-fill me-2"></i> Status updated successfully!</div>
        <?php elseif ($msg == 'error'): ?>
            <div class="alert alert-danger"><i class="bi bi-exclamation-triangle-fill me-2"></i> <?php echo $error_msg; ?></div>
        <?php endif; ?>

        <!-- Stats Cards - Dynamically generated from actual school data -->
        <div class="stats-container">
            <div class="stat-card" onclick="filterByView('all')">
                <h4><i class="bi bi-people-fill me-2"></i>All Participants</h4>
                <div class="stat-numbers">
                    <div>
                        <div class="stat-number"><?php echo $stats['total']; ?></div>
                        <div class="stat-label">Total</div>
                    </div>
                    <div>
                        <div class="stat-number"><?php echo $stats['active']; ?></div>
                        <div class="stat-label">Active</div>
                    </div>
                    <div>
                        <div class="stat-number"><?php echo $stats['inactive']; ?></div>
                        <div class="stat-label">Inactive</div>
                    </div>
                </div>
            </div>

            <?php
            // Display stats for each school that has participants
            foreach ($schoolStats as $schoolName => $schoolData):
                // Skip if no participants
                if ($schoolData['total'] == 0) continue;

                // Create a short display name for the card title
                $displayTitle = $schoolName;
                // You can customize titles here if needed
                if ($schoolName == 'School of Engineering') {
                    $displayTitle = 'School of Engineering';
                } elseif ($schoolName == 'School Of Management' || $schoolName == 'School of Management') {
                    $displayTitle = 'School of Management';
                }
            ?>
                <div class="stat-card" onclick="filterBySchool('<?php echo addslashes($schoolName); ?>')">
                    <h4><i class="bi bi-building me-2"></i><?php echo $displayTitle; ?></h4>
                    <div class="stat-numbers">
                        <div>
                            <div class="stat-number"><?php echo $schoolData['total']; ?></div>
                            <div class="stat-label">Students</div>
                        </div>
                        <div>
                            <div class="stat-number"><?php echo $schoolData['active']; ?></div>
                            <div class="stat-label">Active</div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Records Section -->
        <div class="records-section">
            <div class="table-header">
                <h2 id="tableTitle" class="table-title"><i class="bi bi-table me-2"></i>Participants List</h2>
                <span class="event-badge" id="participantCount"><?php echo count($allParticipants); ?> Participants</span>
            </div>

            <div class="filter-section">
                <input type="text" id="searchInput" class="filter-input" placeholder="Search by name, enrollment, branch...">
                <select id="statusFilter" class="filter-input">
                    <option value="">All Status</option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
                <button class="filter-btn" onclick="resetFilters()"><i class="bi bi-arrow-counterclockwise me-2"></i>Reset</button>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Student Name</th>
                            <th>Enrollment No</th>
                            <th>Branch</th>
                            <th>Semester</th>
                            <th>School</th>
                            <th>Event</th>
                            <th>Coordinator</th>
                            <th>Status</th>
                            <th>Actions</th>
                    </thead>
                    <tbody id="participantRows"></tbody>
                 </table>
            </div>
            
            <!-- Pagination Container -->
            <div class="pagination-container" id="paginationContainer"></div>
            <div class="pagination-info" id="paginationInfo"></div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal fade" id="participantModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add New Participant</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="participantForm" method="POST">
                        <input type="hidden" name="participant_id" id="participantId">
                        <input type="hidden" name="action" id="formAction" value="add">
                        <input type="hidden" name="submit_participant" value="1">

                        <div class="form-row">
                            <div class="form-group">
                                <label>Student Name <span class="text-danger">*</span></label>
                                <input type="text" name="student_name" id="student_name" class="form-control" placeholder="Enter full name">
                                <span id="student_name_error" class="error-message"></span>
                            </div>
                            <div class="form-group">
                                <label>Enrollment No <span class="text-danger">*</span></label>
                                <input type="text" name="enrollment" id="enrollment" class="form-control" placeholder="Enter enrollment number">
                                <span id="enrollment_error" class="error-message"></span>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter email address">
                                <span id="email_error" class="error-message"></span>
                            </div>
                            <div class="form-group">
                                <label>Phone <span class="text-danger">*</span></label>
                                <input type="text" name="contact" id="contact" class="form-control" placeholder="Enter contact number">
                                <span id="contact_error" class="error-message"></span>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Branch <span class="text-danger">*</span></label>
                                <input type="text" name="branch" id="branch" class="form-control" placeholder="Enter branch">
                                <span id="branch_error" class="error-message"></span>
                            </div>
                            <div class="form-group">
                                <label>Semester <span class="text-danger">*</span></label>
                                <select name="semester" id="semester" class="form-select">
                                    <option value="">Select Semester</option>
                                    <?php for ($i = 1; $i <= 8; $i++): ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?>th Semester</option>
                                    <?php endfor; ?>
                                </select>
                                <span id="semester_error" class="error-message"></span>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>School <span class="text-danger">*</span></label>
                                <select name="school" id="school" class="form-select">
                                    <option value="">Select School</option>
                                    <option value="SOE">School of Engineering</option>
                                    <option value="SOM">School of Management</option>
                                    <option value="SOP">School of Pharmacy</option>
                                    <option value="SOC">School of Commerce</option>
                                    <option value="SOS">School of Science</option>
                                </select>
                                <span id="school_error" class="error-message"></span>
                            </div>
                            <div class="form-group">
                                <label>Event <span class="text-danger">*</span></label>
                                <select name="event" id="event_name" class="form-select">
                                    <option value="">Select Event</option>
                                    <option value="Cricket">🏏 Cricket</option>
                                    <option value="Football">⚽ Football</option>
                                    <option value="Volleyball">🏐 Volleyball</option>
                                    <option value="Basketball">🏀 Basketball</option>
                                    <option value="Chess">♟️ Chess</option>
                                    <option value="Carrom">🎯 Carrom</option>
                                    <option value="Table Tennis">🏓 Table Tennis</option>
                                    <option value="Badminton">🏸 Badminton</option>
                                    <option value="Singing">🎤 Singing</option>
                                    <option value="Dancing">💃 Dancing</option>
                                    <option value="Rangoli">🎨 Rangoli</option>
                                    <option value="Debate">🗣️ Debate</option>
                                </select>
                                <span id="event_error" class="error-message"></span>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group full-width">
                                <label>Status <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-select">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                                <span id="status_error" class="error-message"></span>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn-add">Save Participant</button>
                            <button type="button" class="btn-add" style="background:#6c757d;" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- View Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Participant Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="viewDetails"></div>
            </div>
        </div>
    </div>

    <script>
        let allParticipants = <?php echo json_encode($allParticipants); ?>;
        let currentFiltered = [...allParticipants];
        let currentFilterType = 'all';
        let currentFilterValue = '';
        
        // Pagination variables
        let currentPage = 1;
        let rowsPerPage = 10;
        let totalPages = 1;

        function openAddModal() {
            document.getElementById('modalTitle').innerText = 'Add New Participant';
            document.getElementById('participantForm').reset();
            document.getElementById('participantId').value = '';
            document.getElementById('formAction').value = 'add';
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
        }

        function filterByView(type) {
            currentFilterType = type;
            if (type === 'all') {
                currentFiltered = [...allParticipants];
            }
            currentPage = 1;
            renderTable();
        }

        function filterBySchool(school) {
            currentFilterType = 'school';
            currentFilterValue = school;
            currentFiltered = allParticipants.filter(p => p.school === school);
            currentPage = 1;
            renderTable();
        }

        function renderTable() {
            const tbody = document.getElementById('participantRows');
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value;

            let data = currentFiltered.filter(p => {
                const matchSearch = p.full_name.toLowerCase().includes(searchTerm) ||
                    p.enrollment_no.toLowerCase().includes(searchTerm) ||
                    (p.branch && p.branch.toLowerCase().includes(searchTerm));
                const matchStatus = statusFilter === '' || p.status.toLowerCase() === statusFilter.toLowerCase();
                return matchSearch && matchStatus;
            });

            document.getElementById('participantCount').innerHTML = data.length + ' Participants';
            
            // Calculate pagination
            totalPages = Math.ceil(data.length / rowsPerPage);
            if (currentPage > totalPages) currentPage = totalPages;
            if (currentPage < 1) currentPage = 1;
            
            const startIndex = (currentPage - 1) * rowsPerPage;
            const endIndex = Math.min(startIndex + rowsPerPage, data.length);
            const paginatedData = data.slice(startIndex, endIndex);

            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="10" class="text-center py-4">No participants found</td></tr>';
                document.getElementById('paginationContainer').innerHTML = '';
                document.getElementById('paginationInfo').innerHTML = '';
                return;
            }

            tbody.innerHTML = '';
            paginatedData.forEach(p => {
                const isActive = p.status.toLowerCase() === 'active';
                const statusClass = isActive ? 'btn-status-active' : 'btn-status-inactive';

                const coordinatorHtml = p.coordinator_name ?
                    `<span class="coordinator-badge" style="background:#d4edda;color:#155724;">✓ ${p.coordinator_name}</span>` :
                    `<span class="coordinator-badge" style="background:#f8d7da;color:#721c24;">❌ No coordinator assigned</span>`;

                const displayStatus = p.status.charAt(0).toUpperCase() + p.status.slice(1);

                tbody.innerHTML += `
                    <tr>
                        <td>${p.id}</td>
                        <td><strong>${escapeHtml(p.full_name)}</strong></td>
                        <td>${escapeHtml(p.enrollment_no)}</td>
                        <td><span class="school-badge">${escapeHtml(p.branch) || '—'}</span></td>
                        <td>${p.semester}th Sem</td>
                        <td><span class="school-badge">${escapeHtml(p.school)}</span></td>
                        <td><span class="event-badge-table">${escapeHtml(p.event_value)}</span></td>
                        <td>${coordinatorHtml}</td>
                        <td><button class="btn-status ${statusClass}" onclick="toggleStatus(${p.id})">${displayStatus}</button></td>
                        <td>
                            <button class="action-btn btn-view" onclick="viewParticipant(${p.id})"><i class="bi bi-eye"></i></button>
                            <button class="action-btn btn-edit" onclick="editParticipant(${p.id})"><i class="bi bi-pencil"></i></button>
                            <button class="action-btn btn-delete" onclick="deleteParticipant(${p.id})"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                `;
            });
            
            // Render pagination
            renderPagination(data.length);
        }
        
        function renderPagination(totalRecords) {
            const paginationContainer = document.getElementById('paginationContainer');
            const paginationInfo = document.getElementById('paginationInfo');
            
            if (totalPages <= 1) {
                paginationContainer.innerHTML = '';
                paginationInfo.innerHTML = '';
                return;
            }
            
            // Show pagination info
            const startRecord = (currentPage - 1) * rowsPerPage + 1;
            const endRecord = Math.min(currentPage * rowsPerPage, totalRecords);
            paginationInfo.innerHTML = `Showing ${startRecord} to ${endRecord} of ${totalRecords} entries`;
            
            let paginationHTML = `
                <button class="pagination-btn" onclick="changePage('first')" ${currentPage === 1 ? 'disabled' : ''}>
                    <i class="bi bi-chevron-double-left"></i> First
                </button>
                <button class="pagination-btn" onclick="changePage('prev')" ${currentPage === 1 ? 'disabled' : ''}>
                    <i class="bi bi-chevron-left"></i> Previous
                </button>
                <div class="page-numbers">
            `;
            
            // Calculate page numbers to show (show 5 pages at a time)
            let startPage = Math.max(1, currentPage - 2);
            let endPage = Math.min(totalPages, startPage + 4);
            
            // Adjust if we're near the end
            if (endPage - startPage < 4 && startPage > 1) {
                startPage = Math.max(1, endPage - 4);
            }
            
            for (let i = startPage; i <= endPage; i++) {
                paginationHTML += `
                    <button class="page-number ${currentPage === i ? 'active' : ''}" onclick="changePage(${i})">
                        ${i}
                    </button>
                `;
            }
            
            paginationHTML += `
                </div>
                <button class="pagination-btn" onclick="changePage('next')" ${currentPage === totalPages ? 'disabled' : ''}>
                    Next <i class="bi bi-chevron-right"></i>
                </button>
                <button class="pagination-btn" onclick="changePage('last')" ${currentPage === totalPages ? 'disabled' : ''}>
                    Last <i class="bi bi-chevron-double-right"></i>
                </button>
            `;
            
            paginationContainer.innerHTML = paginationHTML;
        }
        
        function changePage(page) {
            if (page === 'first') {
                currentPage = 1;
            } else if (page === 'prev') {
                if (currentPage > 1) currentPage--;
            } else if (page === 'next') {
                if (currentPage < totalPages) currentPage++;
            } else if (page === 'last') {
                currentPage = totalPages;
            } else if (typeof page === 'number') {
                currentPage = page;
            }
            renderTable();
        }

        function viewParticipant(id) {
            const p = allParticipants.find(x => x.id == id);
            const modalBody = document.getElementById('viewDetails');
            modalBody.innerHTML = `
                <table class="table table-bordered">
                    <tr><th>ID</th><td>${p.id}</td></tr>
                    <tr><th>Full Name</th><td>${escapeHtml(p.full_name)}</td></tr>
                    <tr><th>Enrollment No</th><td>${escapeHtml(p.enrollment_no)}</td></tr>
                    <tr><th>Email</th><td>${escapeHtml(p.email)}</td></tr>
                    <tr><th>Phone</th><td>${escapeHtml(p.phone)}</td></tr>
                    <tr><th>Branch</th><td>${escapeHtml(p.branch)}</td></tr>
                    <tr><th>Semester</th><td>${p.semester}th Semester</td></tr>
                    <tr><th>School</th><td>${escapeHtml(p.school)}</td></tr>
                    <tr><th>Event</th><td>${escapeHtml(p.event_value)}</td></tr>
                    <tr><th>Status</th><td>${p.status}</td></tr>
                    <tr><th>Assigned Coordinator</th><td>${p.coordinator_name || 'Not Assigned'}</td></tr>
                </table>
            `;
            new bootstrap.Modal(document.getElementById('viewModal')).show();
        }

        function editParticipant(id) {
            const p = allParticipants.find(x => x.id == id);
            document.getElementById('modalTitle').innerText = 'Edit Participant';
            document.getElementById('participantId').value = p.id;
            document.getElementById('formAction').value = 'edit';
            document.getElementById('student_name').value = p.full_name;
            document.getElementById('enrollment').value = p.enrollment_no;
            document.getElementById('email').value = p.email;
            document.getElementById('contact').value = p.phone;
            document.getElementById('branch').value = p.branch;
            document.getElementById('semester').value = p.semester;
            document.getElementById('school').value = p.school;
            document.getElementById('event_name').value = p.event_value;
            const statusValue = p.status.charAt(0).toUpperCase() + p.status.slice(1);
            document.getElementById('status').value = statusValue;
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            new bootstrap.Modal(document.getElementById('participantModal')).show();
        }

        function deleteParticipant(id) {
            if (confirm('Delete this participant permanently?')) {
                window.location.href = '?delete_id=' + id;
            }
        }

        function toggleStatus(id) {
            if (confirm('Change status of this participant?')) {
                window.location.href = '?toggle_id=' + id;
            }
        }

        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('statusFilter').value = '';
            currentFiltered = [...allParticipants];
            currentPage = 1;
            renderTable();
        }

        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/[&<>]/g, function(m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }

        document.getElementById('searchInput').addEventListener('keyup', function() {
            currentPage = 1;
            renderTable();
        });
        document.getElementById('statusFilter').addEventListener('change', function() {
            currentPage = 1;
            renderTable();
        });

        // jQuery Validation
        $(document).ready(function() {
            $("#participantForm").validate({
                rules: {
                    student_name: {
                        required: true,
                        minlength: 3,
                        maxlength: 100
                    },
                    enrollment: {
                        required: true,
                        minlength: 8,
                        maxlength: 20
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    contact: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    branch: {
                        required: true,
                        minlength: 2
                    },
                    semester: {
                        required: true
                    },
                    school: {
                        required: true
                    },
                    event: {
                        required: true
                    },
                    status: {
                        required: true
                    }
                },
                messages: {
                    student_name: {
                        required: "Please enter student name",
                        minlength: "Name must be at least 3 characters"
                    },
                    enrollment: {
                        required: "Please enter enrollment number",
                        minlength: "Enrollment must be at least 8 characters"
                    },
                    email: {
                        required: "Please enter email",
                        email: "Enter valid email"
                    },
                    contact: {
                        required: "Please enter contact number",
                        digits: "Only numbers allowed",
                        minlength: "Must be 10 digits",
                        maxlength: "Must be 10 digits"
                    },
                    branch: {
                        required: "Please enter branch",
                        minlength: "Branch must be at least 2 characters"
                    },
                    semester: {
                        required: "Please select semester"
                    },
                    school: {
                        required: "Please select school"
                    },
                    event: {
                        required: "Please select event"
                    },
                    status: {
                        required: "Please select status"
                    }
                },
                errorElement: "span",
                errorClass: "error-message",
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                highlight: function(element) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function(element) {
                    $(element).removeClass("is-invalid").addClass("is-valid");
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });

        renderTable();
    </script>
</body>

</html>