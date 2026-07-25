<?php
require_once 'admin_auth_check.php';
require_once 'ad_c_results_handler.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | RKU Galore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- jQuery & Validation -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
        :root {
            --galore-red: #dc3545;
            --galore-red-dark: #b02a37;
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
        
        /* Top Bar Styles */
        .top-bar {
            background: white;
            border-radius: 18px;
            border-top: 6px solid var(--galore-red);
            padding: 20px 30px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
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
        
        /* Event Cards - Enhanced Centered Layout */
        .events-grid {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 30px;
            padding: 20px 0;
        }
        .event-card {
            background: white;
            border-radius: 24px;
            border-top: 5px solid var(--galore-red);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            cursor: pointer;
            width: 320px;
            max-width: 100%;
            position: relative;
            overflow: hidden;
        }
        .event-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 40px rgba(220, 53, 69, 0.2);
        }
        .event-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--galore-red), #ff8a5c);
            border-radius: 4px;
        }
        .event-card-body {
            padding: 28px 24px;
            text-align: center;
        }
        .event-icon {
            font-size: 3rem;
            margin-bottom: 15px;
            display: inline-block;
            background: rgba(220, 53, 69, 0.1);
            width: 70px;
            height: 70px;
            line-height: 70px;
            border-radius: 50%;
            color: var(--galore-red);
        }
        .event-card h4 {
            color: var(--galore-red);
            font-weight: 800;
            margin-bottom: 20px;
            font-size: 1.6rem;
            letter-spacing: -0.3px;
            word-break: break-word;
        }
        .event-stats {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
            padding: 15px 0;
            border-top: 1px solid #f0f0f0;
            border-bottom: 1px solid #f0f0f0;
            background: #fef9f9;
            border-radius: 40px;
        }
        .stat-item {
            text-align: center;
            flex: 1;
        }
        .stat-number {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--galore-red);
            line-height: 1.2;
        }
        .stat-label {
            font-size: 0.9rem;
            color: #6c757d;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .medal-count {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: bold;
        }
        .gold-count { 
            color: #b57c1c; 
            background: #fff8e7; 
            padding: 3px 10px; 
            border-radius: 30px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 1.3rem;
        }
        .silver-count { 
            color: #5a5a5a; 
            background: #f5f5f5; 
            padding: 3px 10px; 
            border-radius: 30px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 1.3rem;
        }
        .bronze-count { 
            color: #a5672e; 
            background: #fff1e6; 
            padding: 3px 10px; 
            border-radius: 30px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 1.3rem;
        }
        .event-btn {
            background: linear-gradient(135deg, #ff4d5a, var(--galore-red));
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 40px;
            width: 100%;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
            font-size: 0.85rem;
        }
        .event-btn:hover {
            transform: scale(0.98);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
        }
        
        /* Records Section */
        .records-section {
            background: white;
            border-radius: 24px;
            border-top: 6px solid var(--galore-red);
            padding: 30px;
            margin-top: 40px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
            display: none;
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
            font-weight: 800;
            font-size: 1.8rem;
            margin: 0;
        }
        .event-badge {
            background: rgba(220, 53, 69, 0.1);
            padding: 8px 18px;
            border-radius: 40px;
            color: var(--galore-red);
            font-weight: 600;
        }
        .filter-section {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }
        .filter-input {
            flex: 1;
            padding: 12px 18px;
            border: 2px solid #e9ecef;
            border-radius: 50px;
            min-width: 220px;
            font-size: 0.9rem;
            transition: all 0.3s;
        }
        .filter-input:focus {
            border-color: var(--galore-red);
            outline: none;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
        }
        .filter-btn {
            background: var(--galore-red);
            color: white;
            padding: 12px 28px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }
        .filter-btn:hover {
            background: var(--galore-red-dark);
            transform: translateY(-1px);
        }
        .table-responsive {
            overflow-x: auto;
            border-radius: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background: var(--galore-red);
            color: white;
            padding: 14px 12px;
            text-align: left;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 0.85rem;
            vertical-align: middle;
        }
        tr:hover {
            background: #fff9f9;
        }
        
        /* Enhanced Rank Styles with Icons */
        .rank-gold { 
            background: linear-gradient(135deg, #ffd966, #ffc107); 
            color: #7a5c00; 
            padding: 5px 14px; 
            border-radius: 30px; 
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-weight: bold; 
            font-size: 0.75rem; 
        }
        .rank-silver { 
            background: linear-gradient(135deg, #e3e4e5, #c0c0c0); 
            color: #4a4a4a; 
            padding: 5px 14px; 
            border-radius: 30px; 
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-weight: bold; 
            font-size: 0.75rem; 
        }
        .rank-bronze { 
            background: linear-gradient(135deg, #e3bc8e, #cd7f32); 
            color: white; 
            padding: 5px 14px; 
            border-radius: 30px; 
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-weight: bold; 
            font-size: 0.75rem; 
        }
        
        .action-btn { 
            padding: 6px 12px; 
            border: none; 
            border-radius: 30px; 
            cursor: pointer; 
            margin: 0 3px; 
            font-size: 0.75rem; 
            transition: 0.2s; 
        }
        .btn-view { background: #17a2b8; color: white; }
        .btn-edit { background: #ffc107; color: #212529; }
        .btn-delete { background: #dc3545; color: white; }
        .action-btn:hover { transform: translateY(-2px); opacity: 0.9; }
        .alert { padding: 14px 22px; border-radius: 60px; margin-bottom: 25px; font-weight: 500; border: none; }
        .alert-success { background: #d4edda; color: #155724; border-left: 5px solid #28a745; }
        .alert-danger { background: #f8d7da; color: #721c24; border-left: 5px solid #dc3545; }
        .alert-info { background: #d1ecf1; color: #0c5460; border-left: 5px solid #17a2b8; }
        .school-badge { background: rgba(220,53,69,0.1); color: var(--galore-red); padding: 4px 12px; border-radius: 40px; display: inline-block; font-size: 0.7rem; font-weight: 600; }
        
        /* Team Name with Icon */
        .team-name-cell {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .team-icon {
            font-size: 1.2rem;
        }
        
        /* Modal Styles */
        .modal-content {
            border-radius: 28px;
            border-top: 6px solid var(--galore-red);
            overflow: hidden;
        }
        .modal-header {
            background: var(--galore-red);
            color: white;
            border-bottom: none;
            padding: 18px 28px;
        }
        .modal-header .btn-close {
            filter: brightness(0) invert(1);
            opacity: 0.8;
        }
        .modal-body {
            padding: 32px;
        }
        .form-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 22px;
            margin-bottom: 22px;
        }
        .form-group {
            margin-bottom: 0;
        }
        .form-group label {
            font-weight: 700;
            margin-bottom: 8px;
            display: block;
            font-size: 0.8rem;
            color: #2c3e50;
            letter-spacing: 0.3px;
        }
        .form-control, .form-select {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e9ecef;
            border-radius: 16px;
            font-size: 0.9rem;
            transition: all 0.3s;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--galore-red);
            outline: none;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.15);
        }
        .full-width {
            grid-column: span 2;
        }
        .modal-footer {
            padding: 20px 32px;
            border-top: 1px solid #edf2f7;
            display: flex;
            justify-content: center;
            gap: 18px;
        }
        .error-message {
            font-size: 0.7rem;
            margin-top: 6px;
            display: block;
            color: #dc3545 !important;
            font-weight: 500;
        }
        .is-valid {
            border-color: #198754 !important;
        }
        .is-invalid {
            border-color: #dc3545 !important;
        }
        
        /* Empty state centering */
        .empty-events {
            text-align: center;
            padding: 60px 30px;
            background: white;
            border-radius: 32px;
            margin: 40px auto;
            max-width: 500px;
        }
        
        /* View Modal Specific Styles */
        .view-detail-card {
            background: #f8f9fa;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .detail-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 700;
            color: #6c757d;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }
        .detail-value {
            font-size: 1rem;
            font-weight: 600;
            color: #2c3e50;
            word-break: break-word;
        }
        .rank-badge-large {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 20px;
            border-radius: 40px;
            font-weight: bold;
            font-size: 1rem;
        }
        .status-badge-large {
            display: inline-block;
            padding: 6px 18px;
            border-radius: 40px;
            font-weight: 600;
            font-size: 0.85rem;
        }
        
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
                gap: 18px;
            }
            .full-width {
                grid-column: span 1;
            }
            .event-card {
                width: 100%;
                max-width: 360px;
            }
            .events-grid {
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <?php require 'ad_c_header.php'; ?>

    <div class="main-wrapper">
        <!-- Top Bar with Add Button -->
        <div class="top-bar">
            <h1><i class="bi bi-trophy-fill me-2"></i>Event Results Management</h1>
            <button class="btn-add" onclick="openAddModal()">
                <i class="bi bi-plus-circle me-2"></i>Add New Result
            </button>
        </div>

        <?php if ($msg == 'added'): ?>
            <div class="alert alert-success"><i class="bi bi-check-circle-fill me-2"></i> ✨ Result added successfully!</div>
        <?php elseif ($msg == 'updated'): ?>
            <div class="alert alert-success"><i class="bi bi-check-circle-fill me-2"></i> ✨ Result updated successfully!</div>
        <?php elseif ($msg == 'deleted'): ?>
            <div class="alert alert-success"><i class="bi bi-check-circle-fill me-2"></i> 🗑️ Result deleted successfully!</div>
        <?php endif; ?>

        <!-- Event Cards - Centered Layout with enhanced styling showing place counts -->
        <div class="events-grid">
            <?php if (empty($eventStats)): ?>
                <div class="empty-events">
                    <i class="bi bi-emoji-frown" style="font-size: 3rem; color: #dc3545;"></i>
                    <h4 class="mt-3" style="color:#dc3545;">No Results Found</h4>
                    <p class="text-muted">No results added yet. Click the button to add your first result.</p>
                    <button class="btn-add mt-2" onclick="openAddModal()"><i class="bi bi-plus-circle"></i> Add Your First Result</button>
                </div>
            <?php else: ?>
                <?php foreach ($eventStats as $eventName => $stats): ?>
                    <div class="event-card" onclick="viewResults('<?php echo addslashes($eventName); ?>')">
                        <div class="event-card-body">
                            <div class="event-icon">
                                <i class="bi bi-trophy-fill"></i>
                            </div>
                            <h4><?php echo htmlspecialchars($eventName); ?></h4>
                            <div class="event-stats">
                                <div class="stat-item">
                                    <div class="stat-number"><?php echo $stats['total']; ?></div>
                                    <div class="stat-label">Total</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number">
                                        <span class="gold-count">
                                            🥇 <?php echo $stats['first_place']; ?>
                                        </span>
                                    </div>
                                    <div class="stat-label">1st</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number">
                                        <span class="silver-count">
                                            🥈 <?php echo $stats['second_place']; ?>
                                        </span>
                                    </div>
                                    <div class="stat-label">2nd</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number">
                                        <span class="bronze-count">
                                            🥉 <?php echo $stats['third_place']; ?>
                                        </span>
                                    </div>
                                    <div class="stat-label">3rd</div>
                                </div>
                            </div>
                            <button class="event-btn">
                                <i class="bi bi-eye-fill me-2"></i>
                                View Results (<?php echo $stats['total']; ?>)
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Records Section - Shows all results for selected event -->
        <div id="recordsSection" class="records-section">
            <div class="table-header">
                <h2 id="tableTitle" class="table-title"><i class="bi bi-trophy-fill me-2"></i>Results</h2>
                <span class="event-badge" id="resultCount"></span>
            </div>
            <div class="filter-section">
                <input type="text" id="searchInput" class="filter-input" placeholder="🔍 Search by team name or school...">
                <button class="filter-btn" onclick="resetFilters()"><i class="bi bi-arrow-counterclockwise me-2"></i>Reset</button>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Event Name</th>
                            <th>Event Type</th>
                            <th>Team Name</th>
                            <th>School</th>
                            <th>Rank</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="resultsTableBody"></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal fade" id="resultModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add New Result</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="resultForm" method="POST">
                        <input type="hidden" name="result_id" id="resultId">
                        <input type="hidden" name="action" id="formAction" value="add">
                        <input type="hidden" name="submit_result" value="1">
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label>Event Name <span class="text-danger">*</span></label>
                                <input type="text" name="event_name" id="event_name" class="form-control" placeholder="Enter event name">
                                <span id="event_name_error" class="error-message"></span>
                            </div>
                            
                            <div class="form-group">
                                <label>Event Type <span class="text-danger">*</span></label>
                                <select name="event_type" id="event_type" class="form-select">
                                    <option value="">Select Event Type</option>
                                    <option value="Cultural">🎭 Cultural</option>
                                    <option value="Sports">⚽ Sports</option>
                                    <option value="Technical">💻 Technical</option>
                                    <option value="Academic">📚 Academic</option>
                                </select>
                                <span id="event_type_error" class="error-message"></span>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label>Team Name <span class="text-danger">*</span></label>
                                <input type="text" name="team_name" id="team_name" class="form-control" placeholder="Enter team name">
                                <span id="team_name_error" class="error-message"></span>
                            </div>
                            
                            <div class="form-group">
                                <label>School/College <span class="text-danger">*</span></label>
                                <input type="text" name="school" id="school" class="form-control" placeholder="Enter school name">
                                <span id="school_error" class="error-message"></span>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label>Rank/Position <span class="text-danger">*</span></label>
                                <select name="ranks" id="ranks" class="form-select">
                                    <option value="">Select Rank</option>
                                    <option value="Winner">🥇 Winner (1st Place)</option>
                                    <option value="Runner-up">🥈 Runner-up (2nd Place)</option>
                                    <option value="2nd Runner-up">🥉 2nd Runner-up (3rd Place)</option>
                                    <option value="1st">🥇 1st Place</option>
                                    <option value="2nd">🥈 2nd Place</option>
                                    <option value="3rd">🥉 3rd Place</option>
                                    <option value="Gold">🏆 Gold Medal</option>
                                    <option value="Silver">🥈 Silver Medal</option>
                                    <option value="Bronze">🥉 Bronze Medal</option>
                                </select>
                                <span id="ranks_error" class="error-message"></span>
                            </div>
                            
                            <div class="form-group">
                                <label>Status <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-select">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                                <span id="status_error" class="error-message"></span>
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="submit" class="btn-add">Save Result</button>
                            <button type="button" class="btn-add" style="background:#6c757d;" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- View Result Modal -->
    <div class="modal fade" id="viewResultModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-trophy-fill me-2"></i>Result Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="view-detail-card">
                        <div class="text-center mb-4">
                            <div id="viewRankIcon" style="font-size: 3rem;"></div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <div class="detail-label">Event Name</div>
                                <div class="detail-value" id="viewEventName">-</div>
                            </div>
                            <div class="form-group">
                                <div class="detail-label">Event Type</div>
                                <div class="detail-value" id="viewEventType">-</div>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <div class="detail-label">Team Name</div>
                                <div class="detail-value" id="viewTeamName">-</div>
                            </div>
                            <div class="form-group">
                                <div class="detail-label">School/College</div>
                                <div class="detail-value" id="viewSchool">-</div>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <div class="detail-label">Rank/Position</div>
                                <div class="detail-value" id="viewRank">-</div>
                            </div>
                            <div class="form-group">
                                <div class="detail-label">Status</div>
                                <div class="detail-value" id="viewStatus">-</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-add" style="background:#6c757d;" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let resultsData = <?php echo json_encode($results); ?>;
        let currentEvent = '<?php echo $current_event; ?>';
        let currentFilteredData = [];

        // Function to get event type icon
        function getEventTypeIcon(eventType) {
            const icons = {
                'Sports': '⚽',
                'Cultural': '🎭',
                'Technical': '💻',
                'Academic': '📚'
            };
            return icons[eventType] || '🏆';
        }

        function openAddModal() {
            document.getElementById('modalTitle').innerText = 'Add New Result';
            document.getElementById('resultForm').reset();
            document.getElementById('resultId').value = '';
            document.getElementById('formAction').value = 'add';
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            new bootstrap.Modal(document.getElementById('resultModal')).show();
        }

        function viewResults(eventName) {
            window.location.href = '?event=' + encodeURIComponent(eventName);
        }

        function getRankHtml(rank) {
            const rankLower = rank.toLowerCase();
            if (rankLower === 'winner' || rankLower === '1st' || rankLower === 'gold') 
                return '<span class="rank-gold">🥇 Winner</span>';
            if (rankLower === 'runner-up' || rankLower === 'runner up' || rankLower === '2nd' || rankLower === 'silver') 
                return '<span class="rank-silver">🥈 Runner-up</span>';
            if (rankLower === '2nd runner-up' || rankLower === 'second runner up' || rankLower === '3rd' || rankLower === 'bronze') 
                return '<span class="rank-bronze">🥉 2nd Runner-up</span>';
            return rank;
        }

        function getRankIcon(rank) {
            const rankLower = rank.toLowerCase();
            if (rankLower === 'winner' || rankLower === '1st' || rankLower === 'gold') return '🥇';
            if (rankLower === 'runner-up' || rankLower === 'runner up' || rankLower === '2nd' || rankLower === 'silver') return '🥈';
            if (rankLower === '2nd runner-up' || rankLower === 'second runner up' || rankLower === '3rd' || rankLower === 'bronze') return '🥉';
            return '🏆';
        }

        function getRankBadgeClass(rank) {
            const rankLower = rank.toLowerCase();
            if (rankLower === 'winner' || rankLower === '1st' || rankLower === 'gold') return 'rank-gold';
            if (rankLower === 'runner-up' || rankLower === 'runner up' || rankLower === '2nd' || rankLower === 'silver') return 'rank-silver';
            if (rankLower === '2nd runner-up' || rankLower === 'second runner up' || rankLower === '3rd' || rankLower === 'bronze') return 'rank-bronze';
            return '';
        }

        function getRankDisplayText(rank) {
            const rankLower = rank.toLowerCase();
            if (rankLower === 'winner' || rankLower === '1st' || rankLower === 'gold') return '🥇 Winner (1st Place)';
            if (rankLower === 'runner-up' || rankLower === 'runner up' || rankLower === '2nd' || rankLower === 'silver') return '🥈 Runner-up (2nd Place)';
            if (rankLower === '2nd runner-up' || rankLower === 'second runner up' || rankLower === '3rd' || rankLower === 'bronze') return '🥉 2nd Runner-up (3rd Place)';
            return rank;
        }

        function viewResult(id) {
            const r = resultsData.find(x => x.id == id);
            if(r) {
                // Set values in view modal
                const eventTypeIcon = getEventTypeIcon(r.event_type);
                document.getElementById('viewEventName').innerHTML = '<strong>' + escapeHtml(r.event_name) + '</strong>';
                document.getElementById('viewEventType').innerHTML = '<strong>' + eventTypeIcon + ' ' + escapeHtml(r.event_type) + '</strong>';
                document.getElementById('viewTeamName').innerHTML = '<strong>🏆 ' + escapeHtml(r.team_name) + '</strong>';
                document.getElementById('viewSchool').innerHTML = '<span class="school-badge">🏫 ' + escapeHtml(r.school) + '</span>';
                
                // Rank display with full text
                const rank = r.ranks;
                const rankIcon = getRankIcon(rank);
                const rankBadgeClass = getRankBadgeClass(rank);
                const rankDisplayText = getRankDisplayText(rank);
                document.getElementById('viewRankIcon').innerHTML = rankIcon;
                document.getElementById('viewRank').innerHTML = '<span class="' + rankBadgeClass + ' rank-badge-large">' + rankIcon + ' ' + rankDisplayText + '</span>';
                
                // Status display
                const statusClass = r.status === 'Active' ? 'bg-success' : 'bg-secondary';
                document.getElementById('viewStatus').innerHTML = '<span class="status-badge-large ' + statusClass + ' text-white px-3 py-2 rounded-pill">' + r.status + '</span>';
                
                // Show modal
                new bootstrap.Modal(document.getElementById('viewResultModal')).show();
            }
        }

        function renderTable() {
            const tbody = document.getElementById('resultsTableBody');
            const dataToShow = currentFilteredData.length > 0 ? currentFilteredData : resultsData;
            document.getElementById('resultCount').innerHTML = '<i class="bi bi-trophy-fill me-1"></i> ' + dataToShow.length + ' Results';
            
            if (dataToShow.length === 0) {
                tbody.innerHTML = '<tr><td colspan="8" class="text-center py-5"><i class="bi bi-inbox" style="font-size: 2rem;"></i><br>No results found for this event</td></tr>';
                return;
            }
            
            tbody.innerHTML = '';
            dataToShow.forEach(r => {
                const eventTypeIcon = getEventTypeIcon(r.event_type);
                tbody.innerHTML += `
                    <tr>
                        <td>${escapeHtml(r.id)}</td>
                        <td><strong>🏆 ${escapeHtml(r.event_name)}</strong></td>
                        <td>${eventTypeIcon} ${escapeHtml(r.event_type)}</td>
                        <td><div class="team-name-cell"><span class="team-icon">🏅</span> ${escapeHtml(r.team_name)}</div></td>
                        <td><span class="school-badge">🏫 ${escapeHtml(r.school)}</span></td>
                        <td>${getRankHtml(r.ranks)}</span></span></td>
                        <td><span class="badge ${r.status === 'Active' ? 'bg-success' : 'bg-secondary'} px-3 py-2 rounded-pill">${r.status}</span></td>
                        <td>
                            <button class="action-btn btn-view" onclick="viewResult(${r.id})"><i class="bi bi-eye"></i></button>
                            <button class="action-btn btn-edit" onclick="editResult(${r.id})"><i class="bi bi-pencil"></i></button>
                            <button class="action-btn btn-delete" onclick="deleteResult(${r.id})"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                `;
            });
        }

        function editResult(id) {
            const r = resultsData.find(x => x.id == id);
            if(r) {
                document.getElementById('modalTitle').innerText = 'Edit Result';
                document.getElementById('resultId').value = r.id;
                document.getElementById('formAction').value = 'edit';
                document.getElementById('event_name').value = r.event_name;
                document.getElementById('event_type').value = r.event_type;
                document.getElementById('team_name').value = r.team_name;
                document.getElementById('school').value = r.school;
                document.getElementById('ranks').value = r.ranks;
                document.getElementById('status').value = r.status;
                $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
                $(".error-message").text("");
                new bootstrap.Modal(document.getElementById('resultModal')).show();
            }
        }

        function deleteResult(id) {
            if (confirm('⚠️ Delete this result permanently? This action cannot be undone.')) {
                window.location.href = '?delete_id=' + id + '&event_name=' + encodeURIComponent(currentEvent);
            }
        }

        function filterTable() {
            const search = document.getElementById('searchInput').value.toLowerCase();
            if (!search) {
                currentFilteredData = [];
                renderTable();
                return;
            }
            currentFilteredData = resultsData.filter(r => 
                (r.team_name && r.team_name.toLowerCase().includes(search)) || 
                (r.school && r.school.toLowerCase().includes(search)) ||
                (r.event_type && r.event_type.toLowerCase().includes(search)) ||
                (r.event_name && r.event_name.toLowerCase().includes(search))
            );
            renderTable();
        }

        function resetFilters() {
            document.getElementById('searchInput').value = '';
            currentFilteredData = [];
            renderTable();
        }

        function escapeHtml(str) {
            if (!str) return '';
            return String(str).replace(/[&<>]/g, function(m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }

        document.getElementById('searchInput').addEventListener('keyup', filterTable);
        
        if (currentEvent) {
            document.getElementById('recordsSection').style.display = 'block';
            document.getElementById('tableTitle').innerHTML = '<i class="bi bi-trophy-fill me-2"></i>' + currentEvent + ' - Results List';
            renderTable();
        }

        // jQuery Validation with modern style
        $(document).ready(function() {
            $("#resultForm").validate({
                rules: {
                    event_name: { required: true, minlength: 2, maxlength: 100 },
                    event_type: { required: true },
                    team_name: { required: true, minlength: 2, maxlength: 100 },
                    school: { required: true, minlength: 2, maxlength: 100 },
                    ranks: { required: true },
                    status: { required: true }
                },
                messages: {
                    event_name: { required: "Please enter event name", minlength: "At least 2 characters" },
                    event_type: { required: "Please select event type" },
                    team_name: { required: "Please enter team name", minlength: "At least 2 characters" },
                    school: { required: "Please enter school name", minlength: "At least 2 characters" },
                    ranks: { required: "Please select rank" },
                    status: { required: "Select status" }
                },
                errorElement: "span",
                errorClass: "error-message",
                errorPlacement: function(error, element) { error.insertAfter(element); },
                highlight: function(element) { $(element).addClass("is-invalid").removeClass("is-valid"); },
                unhighlight: function(element) { $(element).removeClass("is-invalid").addClass("is-valid"); },
                submitHandler: function(form) { form.submit(); }
            });
        });
    </script>
</body>
</html>