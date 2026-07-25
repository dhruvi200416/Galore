<?php
require_once 'admin_auth_check.php';
require_once 'ad_c_school_handler.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | RKU Galore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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

        /* ADD BUTTON */
        .btn-add-event {
            background: linear-gradient(135deg, #ff4d5a, var(--galore-red));
            color: #fff;
            padding: 12px 24px;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-add-event:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(220, 53, 69, 0.45);
            color: white;
        }

        /* STATUS BUTTON STYLES */
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

        /* FORM CONTAINERS */
        .add-form-container {
            background: #ffffff;
            width: 100%;
            max-width: 1000px;
            margin: 30px auto;
            padding: 35px;
            border-radius: 18px;
            border-top: 6px solid var(--galore-red);
            box-shadow: 0 20px 45px rgba(220, 53, 69, 0.18);
            display: none;
        }

        .form-title {
            text-align: center;
            color: var(--galore-red);
            font-size: 1.8rem;
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

        .galore-input,
        .galore-select,
        .galore-textarea {
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 10px;
            font-size: 0.95rem;
        }

        .galore-textarea {
            min-height: 80px;
            resize: vertical;
        }

        .galore-input:focus,
        .galore-select:focus,
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
            min-height: 20px;
        }

        .is-valid {
            border-color: #198754 !important;
        }

        .is-invalid {
            border-color: #dc3545 !important;
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
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.4);
        }

        .btn-cancel {
            background: #6c757d;
            color: white;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }

        .btn-cancel:hover {
            background: #5a6268;
        }

        /* TABLE CONTAINER */
        .data-table-container {
            background: #ffffff;
            padding: 25px;
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
            font-size: 1.5rem;
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
            padding: 10px 15px 10px 40px;
            border: 2px solid #ddd;
            border-radius: 10px;
            font-size: 0.9rem;
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
            padding: 12px;
            text-align: left;
            font-weight: 700;
            color: var(--galore-red);
            border-bottom: 2px solid var(--galore-red);
            white-space: nowrap;
        }

        .data-table td {
            padding: 12px;
            border-bottom: 1px solid #dee2e6;
            vertical-align: middle;
        }

        .data-table tbody tr:hover {
            background: rgba(220, 53, 69, 0.1);
        }

        /* ACTION BUTTONS */
        .action-btn {
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.75rem;
            text-decoration: none;
            display: inline-block;
            margin: 0 2px;
            transition: 0.2s;
            border: none;
            cursor: pointer;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }

        .btn-view {
            background: #17a2b8;
            color: white;
        }

        .btn-edit {
            background: #ffc107;
            color: #212529;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        /* PAGINATION */
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

        /* TOP BAR */
        .top-bar {
            background: #ffffff;
            padding: 20px 25px;
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
            font-size: 1.5rem;
            font-weight: 800;
            margin: 0;
        }

        /* Alert */
        .alert {
            padding: 12px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border-left: 4px solid #17a2b8;
        }

        /* Event Stats Cards */
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
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(220, 53, 69, 0.15);
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

        .stat-item {
            text-align: center;
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

        .card-btn {
            background: linear-gradient(135deg, #ff4d5a, var(--galore-red));
            color: white;
            padding: 10px 20px;
            border-radius: 40px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            width: 100%;
            margin-top: 10px;
        }

        .card-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
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

        /* Badge styles */
        .badge {
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .badge.bg-danger {
            background-color: #dc3545 !important;
        }

        .badge.bg-warning {
            background-color: #ffc107 !important;
            color: #000;
        }

        .badge.bg-info {
            background-color: #17a2b8 !important;
        }
    </style>
</head>

<body>
    <?php require 'ad_c_header.php'; ?>

    <div class="main-wrapper">
        <?php if ($msg == 'added'): ?>
            <div class="alert alert-success"><i class="bi bi-check-circle-fill me-2"></i> Student registered successfully!</div>
        <?php elseif ($msg == 'updated'): ?>
            <div class="alert alert-success"><i class="bi bi-check-circle-fill me-2"></i> Student updated successfully!</div>
        <?php elseif ($msg == 'deleted'): ?>
            <div class="alert alert-success"><i class="bi bi-check-circle-fill me-2"></i> Student deleted successfully!</div>
        <?php elseif ($msg == 'toggled'): ?>
            <div class="alert alert-success"><i class="bi bi-check-circle-fill me-2"></i> Status updated successfully!</div>
        <?php elseif ($msg == 'auto_categorized'): ?>
            <div class="alert alert-info">
                <i class="bi bi-info-circle-fill me-2"></i> 
                The event was automatically categorized and added to the appropriate category!
            </div>
        <?php endif; ?>

        <!-- Event Stats Cards with View Register Buttons -->
        <div class="stats-container">
            <div class="stat-card">
                <h4><i class="bi bi-suit-club-fill me-2"></i> Sports Outdoor</h4>
                <div class="stat-numbers">
                    <div class="stat-item">
                        <div class="stat-number"><?php echo $eventStats['Sports_Outdoor']['total']; ?></div>
                        <div class="stat-label">Total</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?php echo $eventStats['Sports_Outdoor']['active']; ?></div>
                        <div class="stat-label">Active</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?php echo $eventStats['Sports_Outdoor']['inactive']; ?></div>
                        <div class="stat-label">Inactive</div>
                    </div>
                </div>
                <button class="card-btn" onclick="window.location.href='?event=Sports_Outdoor'">
                    <i class="bi bi-eye-fill me-2"></i> View Register
                </button>
            </div>
            <div class="stat-card">
                <h4><i class="bi bi-dice-5-fill me-2"></i> Sports Indoor</h4>
                <div class="stat-numbers">
                    <div class="stat-item">
                        <div class="stat-number"><?php echo $eventStats['Sports_Indoor']['total']; ?></div>
                        <div class="stat-label">Total</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?php echo $eventStats['Sports_Indoor']['active']; ?></div>
                        <div class="stat-label">Active</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?php echo $eventStats['Sports_Indoor']['inactive']; ?></div>
                        <div class="stat-label">Inactive</div>
                    </div>
                </div>
                <button class="card-btn" onclick="window.location.href='?event=Sports_Indoor'">
                    <i class="bi bi-eye-fill me-2"></i> View Register
                </button>
            </div>
            <div class="stat-card">
                <h4><i class="bi bi-music-note-beamed me-2"></i> Cultural</h4>
                <div class="stat-numbers">
                    <div class="stat-item">
                        <div class="stat-number"><?php echo $eventStats['Cultur']['total']; ?></div>
                        <div class="stat-label">Total</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?php echo $eventStats['Cultur']['active']; ?></div>
                        <div class="stat-label">Active</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?php echo $eventStats['Cultur']['inactive']; ?></div>
                        <div class="stat-label">Inactive</div>
                    </div>
                </div>
                <button class="card-btn" onclick="window.location.href='?event=Cultur'">
                    <i class="bi bi-eye-fill me-2"></i> View Register
                </button>
            </div>
        </div>

        <!-- Add/Edit Form -->
        <?php if ($current_event): ?>
            <div class="add-form-container" id="addEventForm">
                <h3 class="form-title" id="formTitle"><i class="bi bi-person-plus-fill me-2"></i> <?php echo $edit_data ? 'Edit' : 'Add New'; ?> Registration - <?php echo str_replace('_', ' ', $current_event); ?></h3>
                <form method="POST" id="eventForm">
                    <input type="hidden" name="submit_event_registration" value="1">
                    <input type="hidden" name="action" value="<?php echo $edit_data ? 'edit' : 'add'; ?>">
                    <input type="hidden" name="event_type" value="<?php echo $current_event; ?>">
                    <input type="hidden" name="id" id="editId" value="<?php echo $edit_data ? $edit_data['id'] : ''; ?>">

                    <div class="form-grid">
                        <div class="galore-input-group">
                            <label class="galore-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="full_name" id="full_name" class="galore-input" value="<?php echo $edit_data ? htmlspecialchars($edit_data['full_name']) : ''; ?>" required>
                            <span id="full_name_error" class="error-message"></span>
                        </div>
                        <div class="galore-input-group">
                            <label class="galore-label">Enrollment No. <span class="text-danger">*</span></label>
                            <input type="text" name="enrollment_no" id="enrollment_no" class="galore-input" value="<?php echo $edit_data ? htmlspecialchars($edit_data['enrollment_no']) : ''; ?>" required>
                            <span id="enrollment_no_error" class="error-message"></span>
                        </div>
                        <div class="galore-input-group">
                            <label class="galore-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" class="galore-input" value="<?php echo $edit_data ? htmlspecialchars($edit_data['email']) : ''; ?>" required>
                            <span id="email_error" class="error-message"></span>
                        </div>
                        <div class="galore-input-group">
                            <label class="galore-label">Phone <span class="text-danger">*</span></label>
                            <input type="text" name="phone" id="phone" class="galore-input" value="<?php echo $edit_data ? htmlspecialchars($edit_data['phone']) : ''; ?>" required>
                            <span id="phone_error" class="error-message"></span>
                        </div>
                        <div class="galore-input-group">
                            <label class="galore-label">Branch <span class="text-danger">*</span></label>
                            <input type="text" name="branch" id="branch" class="galore-input" value="<?php echo $edit_data ? htmlspecialchars($edit_data['branch']) : ''; ?>" required>
                            <span id="branch_error" class="error-message"></span>
                        </div>
                        <div class="galore-input-group">
                            <label class="galore-label">Semester <span class="text-danger">*</span></label>
                            <select name="semester" id="semester" class="galore-select" required>
                                <option value="">Select Semester</option>
                                <?php for ($i = 1; $i <= 8; $i++): ?>
                                    <option value="<?php echo $i; ?>" <?php echo ($edit_data && $edit_data['semester'] == $i) ? 'selected' : ''; ?>><?php echo $i; ?>th Semester</option>
                                <?php endfor; ?>
                            </select>
                            <span id="semester_error" class="error-message"></span>
                        </div>
                        <div class="galore-input-group">
                            <label class="galore-label">School <span class="text-danger">*</span></label>
                            <select name="school" id="school" class="galore-select" required>
                                <option value="">Select School</option>
                                <option value="School of Engineering" <?php echo ($edit_data && $edit_data['school'] == 'School of Engineering') ? 'selected' : ''; ?>>School of Engineering</option>
                                <option value="School of Management" <?php echo ($edit_data && $edit_data['school'] == 'School of Management') ? 'selected' : ''; ?>>School of Management</option>
                                <option value="School of Computer Science" <?php echo ($edit_data && $edit_data['school'] == 'School of Computer Science') ? 'selected' : ''; ?>>School of Computer Science</option>
                                <option value="School of Design" <?php echo ($edit_data && $edit_data['school'] == 'School of Design') ? 'selected' : ''; ?>>School of Design</option>
                                <option value="School of Pharmacy" <?php echo ($edit_data && $edit_data['school'] == 'School of Pharmacy') ? 'selected' : ''; ?>>School of Pharmacy</option>
                            </select>
                            <span id="school_error" class="error-message"></span>
                        </div>
                        <div class="galore-input-group full-width">
                            <label class="galore-label">Event Name <span class="text-danger">*</span></label>
                            <textarea name="event_value" id="event_value" class="galore-textarea" rows="2" placeholder="Enter event name (e.g., Cricket, Football, Singing, Rangoli)" required><?php echo $edit_data ? htmlspecialchars($edit_data['event_value']) : ''; ?></textarea>
                            <small class="text-muted">
                                <i class="bi bi-info-circle-fill"></i> 
                                Events will be automatically categorized: 
                                <span class="badge bg-danger">Outdoor Sports</span> 
                                <span class="badge bg-warning">Indoor Sports</span> 
                                <span class="badge bg-info">Cultural</span>
                                <br>For multiple events, separate with commas (e.g., Cricket, Basketball)
                            </small>
                            <span id="event_value_error" class="error-message"></span>
                        </div>
                        <div class="galore-input-group">
                            <label class="galore-label">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="galore-select" required>
                                <option value="active" <?php echo ($edit_data && strtolower($edit_data['status']) == 'active') ? 'selected' : ''; ?>>Active</option>
                                <option value="inactive" <?php echo ($edit_data && strtolower($edit_data['status']) == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                            </select>
                            <span id="status_error" class="error-message"></span>
                        </div>
                    </div>
                    <div class="form-buttons">
                        <button type="submit" class="btn-save"><i class="bi bi-save-fill me-2"></i> Save Registration</button>
                        <button type="button" class="btn-cancel" id="cancelFormBtn"><i class="bi bi-x-circle-fill me-2"></i> Cancel</button>
                    </div>
                </form>
            </div>
        <?php endif; ?>

        <!-- Records Table -->
        <?php if ($current_event): ?>
            <div class="data-table-container">
                <div class="table-header">
                    <h2><i class="bi bi-table me-2"></i> <?php echo str_replace('_', ' ', $current_event); ?> - Registered Students</h2>
                    <div style="display: flex; gap: 10px;">
                        <div class="search-box">
                            <i class="bi bi-search"></i>
                            <input type="text" id="searchInput" placeholder="Search by name, enrollment...">
                        </div>
                        <select id="statusFilter" class="galore-select" style="width: auto; min-width: 120px;">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <button class="btn-add-event" id="openAddFormBtn"><i class="bi bi-plus-circle-fill me-1"></i> Add New</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Student Name</th>
                                <th>Enrollment No</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Actions</th>
                        </thead>
                        <tbody id="recordsTable">
                            <?php if (empty($registrations)): ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        No students registered yet. Click "Add New" to add.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($registrations as $reg): ?>
                                    <tr data-id="<?php echo $reg['id']; ?>"
                                        data-name="<?php echo strtolower($reg['full_name']); ?>"
                                        data-enroll="<?php echo strtolower($reg['enrollment_no']); ?>"
                                        data-email="<?php echo htmlspecialchars($reg['email']); ?>"
                                        data-phone="<?php echo htmlspecialchars($reg['phone']); ?>"
                                        data-branch="<?php echo htmlspecialchars($reg['branch']); ?>"
                                        data-semester="<?php echo $reg['semester']; ?>"
                                        data-school="<?php echo htmlspecialchars($reg['school']); ?>"
                                        data-event="<?php echo htmlspecialchars($reg['event_value']); ?>"
                                        data-status="<?php echo strtolower($reg['status']); ?>">
                                        <td><?php echo $reg['id']; ?></td>
                                        <td><strong><?php echo htmlspecialchars($reg['full_name']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($reg['enrollment_no']); ?></td>
                                        <td><?php echo htmlspecialchars($reg['email']); ?></td>
                                        <td><?php echo htmlspecialchars($reg['phone']); ?></td>
                                        <td>
                                            <button class="btn-status <?php echo strtolower($reg['status']) == 'active' ? 'btn-status-active' : 'btn-status-inactive'; ?>"
                                                onclick="toggleStatus(<?php echo $reg['id']; ?>, '<?php echo $current_event; ?>')">
                                                <?php echo ucfirst($reg['status']); ?>
                                            </button>
                                        </td>
                                        <td>
                                            <button class="action-btn btn-view" onclick="viewRecord(<?php echo $reg['id']; ?>)">View</button>
                                            <button class="action-btn btn-edit" onclick="editRecord(<?php echo $reg['id']; ?>)">Edit</button>
                                            <button class="action-btn btn-delete" onclick="deleteRecord(<?php echo $reg['id']; ?>, '<?php echo $current_event; ?>')">Delete</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Container -->
                <div class="pagination-container" id="paginationContainer"></div>
                <div class="pagination-info" id="paginationInfo"></div>
            </div>
        <?php endif; ?>
    </div>

    <!-- VIEW MODAL -->
    <div class="modal fade" id="viewModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Student Full Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <div class="detail-label">ID</div>
                            <div class="detail-value" id="view_id"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Full Name</div>
                            <div class="detail-value" id="view_name"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Enrollment No.</div>
                            <div class="detail-value" id="view_enroll"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Email</div>
                            <div class="detail-value" id="view_email"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Phone</div>
                            <div class="detail-value" id="view_phone"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Branch</div>
                            <div class="detail-value" id="view_branch"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Semester</div>
                            <div class="detail-value" id="view_semester"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">School</div>
                            <div class="detail-value" id="view_school"></div>
                        </div>
                        <div class="detail-item full-width">
                            <div class="detail-label">Event Name</div>
                            <div class="detail-value" id="view_event"></div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Status</div>
                            <div class="detail-value" id="view_status"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
    <script>
        let allRows = [];
        let currentPage = 1;
        let rowsPerPage = 5;
        let currentEvent = '<?php echo $current_event; ?>';

        // jQuery Validation for Form
        $(document).ready(function() {
            // Initialize jQuery Validation
            $("#eventForm").validate({
                rules: {
                    full_name: {
                        required: true,
                        minlength: 3,
                        maxlength: 100,
                        pattern: /^[a-zA-Z\s]+$/
                    },
                    enrollment_no: {
                        required: true,
                        minlength: 8,
                        maxlength: 20
                    },
                    email: {
                        required: true,
                        email: true,
                        maxlength: 100
                    },
                    phone: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    branch: {
                        required: true,
                        minlength: 2,
                        maxlength: 100
                    },
                    semester: {
                        required: true
                    },
                    school: {
                        required: true
                    },
                    event_value: {
                        required: true,
                        minlength: 2,
                        maxlength: 500
                    },
                    status: {
                        required: true
                    }
                },
                messages: {
                    full_name: {
                        required: "Please enter full name",
                        minlength: "Name must be at least 3 characters",
                        maxlength: "Name cannot exceed 100 characters",
                        pattern: "Only alphabetic characters and spaces allowed"
                    },
                    enrollment_no: {
                        required: "Please enter enrollment number",
                        minlength: "Enrollment number must be at least 8 characters",
                        maxlength: "Enrollment number cannot exceed 20 characters"
                    },
                    email: {
                        required: "Please enter email address",
                        email: "Please enter a valid email address",
                        maxlength: "Email cannot exceed 100 characters"
                    },
                    phone: {
                        required: "Please enter phone number",
                        digits: "Please enter only digits",
                        minlength: "Phone number must be exactly 10 digits",
                        maxlength: "Phone number must be exactly 10 digits"
                    },
                    branch: {
                        required: "Please enter branch",
                        minlength: "Branch must be at least 2 characters",
                        maxlength: "Branch cannot exceed 100 characters"
                    },
                    semester: {
                        required: "Please select semester"
                    },
                    school: {
                        required: "Please select school"
                    },
                    event_value: {
                        required: "Please enter event name",
                        minlength: "Event name must be at least 2 characters",
                        maxlength: "Event name cannot exceed 500 characters"
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

            // Custom pattern validation for full name (only letters and spaces)
            $.validator.addMethod("pattern", function(value, element, regexp) {
                return this.optional(element) || regexp.test(value);
            }, "Invalid format");
        });

        // Toggle status function
        function toggleStatus(id, eventType) {
            if (confirm('Are you sure you want to change the status of this student?')) {
                window.location.href = '?event=' + eventType + '&toggle_event_id=' + id;
            }
        }

        // Delete record function
        function deleteRecord(id, eventType) {
            if (confirm('Are you sure you want to delete this record? This action cannot be undone.')) {
                window.location.href = '?event=' + eventType + '&delete_id=' + id;
            }
        }

        // Render pagination
        function renderPagination(totalRecords, totalPages, currentPage) {
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

        // Update display with pagination and filters
        function updateDisplay() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value;

            let filtered = allRows.filter(row => {
                const name = row.getAttribute('data-name') || '';
                const enroll = row.getAttribute('data-enroll') || '';
                const status = row.getAttribute('data-status') || '';
                const matchesSearch = name.includes(searchTerm) || enroll.includes(searchTerm);
                const matchesStatus = statusFilter === '' || status === statusFilter;
                return matchesSearch && matchesStatus;
            });

            const totalRecords = filtered.length;
            const totalPages = Math.ceil(totalRecords / rowsPerPage);
            
            if (currentPage > totalPages) currentPage = totalPages;
            if (currentPage < 1) currentPage = 1;
            
            const start = (currentPage - 1) * rowsPerPage;
            const end = Math.min(start + rowsPerPage, totalRecords);

            // Hide all rows first
            allRows.forEach(row => row.style.display = 'none');
            
            // Show only rows for current page
            for (let i = start; i < end; i++) {
                if (filtered[i]) filtered[i].style.display = '';
            }

            renderPagination(totalRecords, totalPages, currentPage);
        }

        function changePage(page) {
            if (page === 'first') {
                currentPage = 1;
            } else if (page === 'prev') {
                if (currentPage > 1) currentPage--;
            } else if (page === 'next') {
                const totalPages = Math.ceil(allRows.filter(row => {
                    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
                    const statusFilter = document.getElementById('statusFilter').value;
                    const name = row.getAttribute('data-name') || '';
                    const enroll = row.getAttribute('data-enroll') || '';
                    const status = row.getAttribute('data-status') || '';
                    const matchesSearch = name.includes(searchTerm) || enroll.includes(searchTerm);
                    const matchesStatus = statusFilter === '' || status === statusFilter;
                    return matchesSearch && matchesStatus;
                }).length / rowsPerPage);
                if (currentPage < totalPages) currentPage++;
            } else if (page === 'last') {
                const totalPages = Math.ceil(allRows.filter(row => {
                    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
                    const statusFilter = document.getElementById('statusFilter').value;
                    const name = row.getAttribute('data-name') || '';
                    const enroll = row.getAttribute('data-enroll') || '';
                    const status = row.getAttribute('data-status') || '';
                    const matchesSearch = name.includes(searchTerm) || enroll.includes(searchTerm);
                    const matchesStatus = statusFilter === '' || status === statusFilter;
                    return matchesSearch && matchesStatus;
                }).length / rowsPerPage);
                currentPage = totalPages;
            } else if (typeof page === 'number') {
                currentPage = page;
            }
            updateDisplay();
        }

        // View record details
        function viewRecord(id) {
            const row = Array.from(allRows).find(r => r.getAttribute('data-id') == id);
            if (row) {
                document.getElementById('view_id').innerText = id;
                document.getElementById('view_name').innerText = row.getAttribute('data-name') || '';
                document.getElementById('view_enroll').innerText = row.getAttribute('data-enroll') || '';
                document.getElementById('view_email').innerText = row.getAttribute('data-email') || '';
                document.getElementById('view_phone').innerText = row.getAttribute('data-phone') || '';
                document.getElementById('view_branch').innerText = row.getAttribute('data-branch') || '';
                document.getElementById('view_semester').innerText = row.getAttribute('data-semester') || '';
                document.getElementById('view_school').innerText = row.getAttribute('data-school') || '';
                document.getElementById('view_event').innerText = row.getAttribute('data-event') || '';
                const status = row.getAttribute('data-status') || '';
                const statusClass = status === 'active' ? 'btn-status-active' : 'btn-status-inactive';
                document.getElementById('view_status').innerHTML = `<span class="btn-status ${statusClass}" style="display: inline-block;">${status.charAt(0).toUpperCase() + status.slice(1)}</span>`;
                new bootstrap.Modal(document.getElementById('viewModal')).show();
            }
        }

        // Edit record
        function editRecord(id) {
            const row = Array.from(allRows).find(r => r.getAttribute('data-id') == id);
            if (row) {
                document.getElementById('editId').value = id;
                document.getElementById('full_name').value = row.getAttribute('data-name') || '';
                document.getElementById('enrollment_no').value = row.getAttribute('data-enroll') || '';
                document.getElementById('email').value = row.getAttribute('data-email') || '';
                document.getElementById('phone').value = row.getAttribute('data-phone') || '';
                document.getElementById('branch').value = row.getAttribute('data-branch') || '';
                document.getElementById('semester').value = row.getAttribute('data-semester') || '';
                document.getElementById('school').value = row.getAttribute('data-school') || '';
                document.getElementById('event_value').value = row.getAttribute('data-event') || '';
                const status = row.getAttribute('data-status') || '';
                document.getElementById('status').value = status;

                document.getElementById('formTitle').innerHTML = '<i class="bi bi-pencil-fill me-2"></i> Edit Registration - <?php echo str_replace('_', ' ', $current_event); ?>';
                document.querySelector('input[name="action"]').value = 'edit';
                document.getElementById('addEventForm').style.display = 'block';
                document.getElementById('addEventForm').scrollIntoView({
                    behavior: 'smooth'
                });

                // Reset validation styles
                $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
                $(".error-message").text("");
            }
        }

        // Open add form
        document.getElementById('openAddFormBtn').addEventListener('click', function() {
            document.getElementById('eventForm').reset();
            document.getElementById('editId').value = '';
            document.querySelector('input[name="action"]').value = 'add';
            document.getElementById('formTitle').innerHTML = '<i class="bi bi-person-plus-fill me-2"></i> Add New Registration - <?php echo str_replace('_', ' ', $current_event); ?>';
            document.getElementById('addEventForm').style.display = 'block';
            document.getElementById('addEventForm').scrollIntoView({
                behavior: 'smooth'
            });

            // Reset validation
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
        });

        // Cancel form
        document.getElementById('cancelFormBtn').addEventListener('click', function() {
            document.getElementById('addEventForm').style.display = 'none';
            document.getElementById('eventForm').reset();
            // Reset validation
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            allRows = Array.from(document.querySelectorAll('#recordsTable tr')).filter(row => row.cells.length > 1);
            updateDisplay();
            document.getElementById('searchInput').addEventListener('keyup', () => {
                currentPage = 1;
                updateDisplay();
            });
            document.getElementById('statusFilter').addEventListener('change', () => {
                currentPage = 1;
                updateDisplay();
            });
        });
    </script>
</body>

</html>