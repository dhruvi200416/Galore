<?php
require_once 'ad_c_participations_handler.php';
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

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>

    <style>
        :root {
            --galore-red: #dc3545;
            --galore-red-dark: #b02a37;
            --galore-red-light: #f8d7da;
            --galore-white: #ffffff;
            --galore-gray: #6c757d;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Roboto, sans-serif;
            background-color: #f8f9fa;
            padding-bottom: 50px;
        }

        /* Main wrapper to account for fixed sidebar (270px width) */
        .main-wrapper {
            margin-left: 270px;
            padding: 30px 30px 0 30px;
            max-width: calc(100% - 270px);
        }

        @media (max-width: 991.98px) {
            .main-wrapper {
                margin-left: 0;
                max-width: 100%;
                padding: 20px;
            }
        }

        /* ===== HERO SECTION ===== */
        .hero {
            background: linear-gradient(135deg, #dc3545, #7a1c25);
            color: #fff;
            text-align: center;
            padding: 60px 20px 60px;
            position: relative;
            overflow: hidden;
            margin-bottom: 30px;
            border-radius: 20px;
        }

        .hero::after {
            content: "";
            position: absolute;
            bottom: -60px;
            left: 0;
            width: 100%;
            height: 120px;
            background: #f8f9fa;
            border-radius: 50% 50% 0 0;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 900;
            letter-spacing: 2px;
            margin-bottom: 12px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .hero p {
            font-size: 1.2rem;
            opacity: 0.95;
            max-width: 600px;
            margin: 0 auto;
        }

        .hero-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 25px;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            margin-top: 20px;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* ===== EVENT CARDS ===== */
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

        .event-card {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(220, 53, 69, 0.15);
            transition: transform 0.4s, box-shadow 0.4s;
            cursor: pointer;
            border-top: 5px solid var(--galore-red);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .event-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(220, 53, 69, 0.35);
        }

        .event-card-body {
            padding: 35px;
            text-align: center;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .event-card-body h4 {
            color: var(--galore-red);
            font-weight: 700;
            margin-bottom: 15px;
            font-size: 1.8rem;
        }

        .event-stats {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
            padding: 15px 0;
            border-top: 2px solid #f0f0f0;
            border-bottom: 2px solid #f0f0f0;
            background: #fafafa;
            border-radius: 8px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--galore-red);
            line-height: 1.2;
        }

        .stat-label {
            font-size: 0.75rem;
            color: var(--galore-gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .event-btn {
            display: inline-block;
            margin-top: auto;
            padding: 12px 24px;
            border-radius: 30px;
            background: linear-gradient(135deg, var(--galore-red-dark), var(--galore-red));
            color: #fff !important;
            font-weight: 600;
            text-decoration: none;
            border: none;
            width: 100%;
            transition: all 0.3s ease;
            cursor: pointer;
            font-size: 1rem;
        }

        .event-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.4);
        }

        .event-btn i {
            margin-right: 8px;
        }

        /* Button group for two buttons */
        .btn-group-vertical-custom {
            display: flex;
            gap: 10px;
            margin-top: auto;
        }

        .event-btn-half {
            flex: 1;
            padding: 12px 15px;
            border-radius: 30px;
            background: linear-gradient(135deg, var(--galore-red-dark), var(--galore-red));
            color: #fff !important;
            font-weight: 600;
            text-decoration: none;
            border: none;
            transition: all 0.3s ease;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .event-btn-half:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.4);
        }

        .event-btn-half i {
            margin-right: 6px;
        }

        /* ===== ADD BUTTON ===== */
        .btn-add-participant {
            background: linear-gradient(135deg, #ff4d5a, var(--galore-red));
            color: #fff;
            padding: 12px 25px;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .btn-add-participant:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(220, 53, 69, 0.45);
        }

        .btn-add-participant i {
            margin-right: 8px;
        }

        /* ===== FORM ===== */
        .add-participant-form-container {
            background: #ffffff;
            width: 100%;
            max-width: 800px;
            margin: 30px auto;
            padding: 40px;
            border-radius: 18px;
            border-top: 6px solid var(--galore-red);
            box-shadow: 0 20px 45px rgba(220, 53, 69, 0.18);
            display: none;
        }

        .form-title {
            text-align: center;
            color: var(--galore-red);
            font-size: 2rem;
            margin-bottom: 25px;
            font-weight: 800;
        }

        #participantForm {
            display: grid;
            grid-template-columns: 1fr;
            gap: 18px;
        }

        @media (min-width: 768px) {
            #participantForm {
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
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 10px;
            font-size: 0.95rem;
        }

        .galore-select {
            padding: 12px 15px;
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
            padding: 12px 25px;
            border-radius: 12px;
            font-weight: 600;
            border: none;
            transition: 0.3s ease;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.3);
        }

        .btn-cancel {
            background: #6c757d;
            color: white;
            padding: 12px 25px;
            border-radius: 12px;
            font-weight: 600;
            border: none;
            transition: 0.3s ease;
        }

        .btn-cancel:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(108, 117, 125, 0.3);
        }

        /* ===== RECORDS SECTION ===== */
        .records-section {
            display: none;
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            padding: 35px;
            margin: 50px 0;
            animation: slideIn 0.5s ease;
            border-top: 6px solid var(--galore-red);
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .table-title {
            color: var(--galore-red);
            font-weight: 700;
            font-size: 2rem;
            margin: 0;
            position: relative;
            padding-bottom: 10px;
        }

        .table-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 4px;
            background: var(--galore-red);
            border-radius: 2px;
        }

        .event-badge {
            background: var(--galore-red);
            color: white;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            box-shadow: 0 4px 10px rgba(220, 53, 69, 0.3);
        }

        .event-badge i {
            margin-right: 8px;
        }

        /* Table scroll container */
        .table-scroll-container {
            max-height: 500px;
            overflow-y: auto;
            border-radius: 12px;
            border: 1px solid #e9ecef;
        }

        /* Custom Scrollbar */
        .table-scroll-container::-webkit-scrollbar {
            width: 8px;
        }

        .table-scroll-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .table-scroll-container::-webkit-scrollbar-thumb {
            background: var(--galore-red);
            border-radius: 10px;
        }

        .table-scroll-container::-webkit-scrollbar-thumb:hover {
            background: var(--galore-red-dark);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th {
            position: sticky;
            top: 0;
            background: var(--galore-red);
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            z-index: 10;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #e9ecef;
            vertical-align: middle;
        }

        tbody tr:hover {
            background: var(--galore-red-light);
            transition: background 0.3s;
        }

        /* Table Badges */
        .school-badge,
        .event-badge-table {
            background: rgba(220, 53, 69, 0.1);
            color: var(--galore-red);
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
            border: 1px solid rgba(220, 53, 69, 0.2);
        }

        /* ACTION BUTTONS */
        .action-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: 0.2s;
            margin-right: 5px;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }

        .btn-view {
            background: rgba(23, 162, 184, 0.1);
            color: #17a2b8;
        }

        .btn-view:hover {
            background: #17a2b8;
            color: white;
        }

        .btn-edit {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }

        .btn-edit:hover {
            background: #ffc107;
            color: white;
        }

        .btn-delete {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .btn-delete:hover {
            background: #dc3545;
            color: white;
        }

        /* STATUS BUTTON STYLES */
        .btn-status {
            padding: 6px 12px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
            font-size: 0.75rem;
            min-width: 70px;
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

        /* Filter Section */
        .filter-section {
            background: white;
            border-radius: 16px;
            padding: 25px;
            margin: 30px 0;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: center;
        }

        .filter-input {
            flex: 1;
            min-width: 250px;
            padding: 12px 18px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .filter-input:focus {
            outline: none;
            border-color: var(--galore-red);
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.1);
        }

        .filter-btn {
            padding: 12px 30px;
            background: var(--galore-red);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.95rem;
        }

        .filter-btn:hover {
            background: var(--galore-red-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }

        .filter-btn i {
            margin-right: 8px;
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

        /* Info Text */
        .info-text {
            color: var(--galore-gray);
            font-size: 0.95rem;
        }

        .info-text i {
            color: var(--galore-red);
            margin-right: 5px;
        }

        /* Alert Styles */
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

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }
    </style>
</head>

<body>
    <?php require 'ad_c_header.php'; ?>

    <!-- Main Wrapper to account for fixed sidebar -->
    <div class="main-wrapper">

        <!-- Alert Messages -->
        <?php if ($msg == 'added'): ?>
            <div class="alert alert-success"><i class="bi bi-check-circle-fill me-2"></i> Participant added successfully!</div>
        <?php elseif ($msg == 'updated'): ?>
            <div class="alert alert-success"><i class="bi bi-check-circle-fill me-2"></i> Participant updated successfully!</div>
        <?php elseif ($msg == 'deleted'): ?>
            <div class="alert alert-success"><i class="bi bi-check-circle-fill me-2"></i> Participant deleted successfully!</div>
        <?php elseif ($msg == 'toggled'): ?>
            <div class="alert alert-success"><i class="bi bi-check-circle-fill me-2"></i> Status updated successfully!</div>
        <?php elseif ($msg == 'email_sent' && isset($email_results) && $email_results): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <strong>Email Campaign Completed!</strong><br>
                <strong>Total Participants:</strong> <?php echo $email_results['total']; ?><br>
                <strong>Successfully sent:</strong> <?php echo $email_results['success']; ?> emails<br>
                <strong>Failed:</strong> <?php echo $email_results['fail']; ?> emails
                <?php if (!empty($email_results['failed_emails'])): ?>
                    <br><small><strong>Failed emails:</strong> <?php echo implode(', ', $email_results['failed_emails']); ?></small>
                <?php endif; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php elseif ($msg == 'error'): ?>
            <div class="alert alert-danger"><i class="bi bi-exclamation-triangle-fill me-2"></i> <?php echo $error_msg; ?></div>
        <?php endif; ?>

        <!-- Event Cards Row -->
        <div class="stats-container">
            <!-- All Participants Card -->
            <div class="event-card">
                <div class="event-card-body">
                    <h4><i class="bi bi-people-fill me-2"></i> All Participants</h4>
                    <div class="event-stats">
                        <div class="stat-item">
                            <div class="stat-number"><?php echo $stats['all']['total']; ?></div>
                            <div class="stat-label">Total</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number"><?php echo $stats['all']['active']; ?></div>
                            <div class="stat-label">Active</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number"><?php echo $stats['all']['inactive']; ?></div>
                            <div class="stat-label">Inactive</div>
                        </div>
                    </div>
                    <button class="event-btn" onclick="viewRecords('all', 'All')">
                        <i class="bi bi-eye-fill me-2"></i> View All Participants
                    </button>
                </div>
            </div>

            <!-- School of Engineering Card -->
            <?php 
            $soeData = isset($schoolStats['School of Engineering']) ? $schoolStats['School of Engineering'] : (isset($schoolStats['SOE']) ? $schoolStats['SOE'] : ['total' => 0, 'active' => 0]);
            ?>
            <div class="event-card">
                <div class="event-card-body">
                    <h4><i class="bi bi-building me-2"></i> School of Engineering</h4>
                    <div class="event-stats">
                        <div class="stat-item">
                            <div class="stat-number"><?php echo $soeData['total']; ?></div>
                            <div class="stat-label">Students</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number"><?php echo $soeData['active']; ?></div>
                            <div class="stat-label">Active</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number"><?php echo $soeData['inactive'] ?? 0; ?></div>
                            <div class="stat-label">Inactive</div>
                        </div>
                    </div>
                    <button class="event-btn" onclick="viewRecords('school', 'School of Engineering')">
                        <i class="bi bi-eye-fill me-2"></i> View SOE Students
                    </button>
                </div>
            </div>

            <!-- School of Management Card -->
            <?php 
            $somData = isset($schoolStats['School Of Management']) ? $schoolStats['School Of Management'] : (isset($schoolStats['SOM']) ? $schoolStats['SOM'] : ['total' => 0, 'active' => 0]);
            ?>
            <div class="event-card">
                <div class="event-card-body">
                    <h4><i class="bi bi-building me-2"></i> School of Management</h4>
                    <div class="event-stats">
                        <div class="stat-item">
                            <div class="stat-number"><?php echo $somData['total']; ?></div>
                            <div class="stat-label">Students</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number"><?php echo $somData['active']; ?></div>
                            <div class="stat-label">Active</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number"><?php echo $somData['inactive'] ?? 0; ?></div>
                            <div class="stat-label">Inactive</div>
                        </div>
                    </div>
                    <button class="event-btn" onclick="viewRecords('school', 'School Of Management')">
                        <i class="bi bi-eye-fill me-2"></i> View SOM Students
                    </button>
                </div>
            </div>

            <!-- Cricket Event Card with SOE and SOM buttons -->
            <div class="event-card">
                <div class="event-card-body">
                    <h4><i class="bi bi-trophy me-2"></i> Cricket</h4>
                    <div class="event-stats">
                        <div class="stat-item">
                            <div class="stat-number"><?php echo isset($eventStats['Cricket']['total']) ? $eventStats['Cricket']['total'] : 0; ?></div>
                            <div class="stat-label">Players</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number"><?php echo isset($eventStats['Cricket']['active']) ? $eventStats['Cricket']['active'] : 0; ?></div>
                            <div class="stat-label">Active</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number"><?php echo isset($eventStats['Cricket']['inactive']) ? $eventStats['Cricket']['inactive'] : 0; ?></div>
                            <div class="stat-label">Inactive</div>
                        </div>
                    </div>
                    <div class="btn-group-vertical-custom">
                        <button class="event-btn-half" onclick="viewEventSchoolRecords('Cricket', 'School of Engineering')">
                            <i class="bi bi-building me-2"></i> SOE Cricket
                        </button>
                        <button class="event-btn-half" onclick="viewEventSchoolRecords('Cricket', 'School Of Management')">
                            <i class="bi bi-building me-2"></i> SOM Cricket
                        </button>
                    </div>
                </div>
            </div>

            <!-- Football Event Card with SOE and SOM buttons -->
            <div class="event-card">
                <div class="event-card-body">
                    <h4><i class="bi bi-trophy me-2"></i> Football</h4>
                    <div class="event-stats">
                        <div class="stat-item">
                            <div class="stat-number"><?php echo isset($eventStats['Football']['total']) ? $eventStats['Football']['total'] : 0; ?></div>
                            <div class="stat-label">Players</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number"><?php echo isset($eventStats['Football']['active']) ? $eventStats['Football']['active'] : 0; ?></div>
                            <div class="stat-label">Active</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number"><?php echo isset($eventStats['Football']['inactive']) ? $eventStats['Football']['inactive'] : 0; ?></div>
                            <div class="stat-label">Inactive</div>
                        </div>
                    </div>
                    <div class="btn-group-vertical-custom">
                        <button class="event-btn-half" onclick="viewEventSchoolRecords('Football', 'School of Engineering')">
                            <i class="bi bi-building me-2"></i> SOE Football
                        </button>
                        <button class="event-btn-half" onclick="viewEventSchoolRecords('Football', 'School Of Management')">
                            <i class="bi bi-building me-2"></i> SOM Football
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- PARTICIPANT FORM (Hidden by default) -->
        <div class="add-participant-form-container" id="addParticipantForm" style="display:none;">
            <h3 class="form-title" id="participantFormTitle">Add New Participant</h3>

            <form id="participantForm" method="POST">
                <input type="hidden" name="participant_id" id="participantId" value="">
                <input type="hidden" name="action" id="formAction" value="add">
                <input type="hidden" name="submit_participant" value="1">

                <div class="galore-input-group">
                    <label class="galore-label">Student Name <span class="text-danger">*</span></label>
                    <input type="text" name="student_name" id="student_name" class="galore-input" placeholder="Enter student name">
                    <span id="student_name_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Enrollment No. <span class="text-danger">*</span></label>
                    <input type="text" name="enrollment" id="enrollment" class="galore-input" placeholder="Enter enrollment number">
                    <span id="enrollment_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="email" class="galore-input" placeholder="Enter email address">
                    <span id="email_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Contact No. <span class="text-danger">*</span></label>
                    <input type="text" name="contact" id="contact" class="galore-input" placeholder="Enter contact number">
                    <span id="contact_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Branch <span class="text-danger">*</span></label>
                    <input type="text" name="branch" id="branch" class="galore-input" placeholder="Enter branch">
                    <span id="branch_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Semester <span class="text-danger">*</span></label>
                    <select name="semester" id="semester" class="galore-select">
                        <option value="">Select Semester</option>
                        <?php for($i = 1; $i <= 8; $i++): ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?>th Semester</option>
                        <?php endfor; ?>
                    </select>
                    <span id="semester_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">School <span class="text-danger">*</span></label>
                    <select name="school" id="school" class="galore-select">
                        <option value="">Select School</option>
                        <option value="School of Engineering">School of Engineering</option>
                        <option value="School Of Management">School Of Management</option>
                        <option value="School of Pharmacy">School of Pharmacy</option>
                        <option value="School of Commerce">School of Commerce</option>
                        <option value="School of Science">School of Science</option>
                    </select>
                    <span id="school_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Event <span class="text-danger">*</span></label>
                    <select name="event" id="event_name" class="galore-select">
                        <option value="">Select Event</option>
                        <option value="Cricket">Cricket</option>
                        <option value="Football">Football</option>
                        <option value="Chess">Chess</option>
                        <option value="Basketball">Basketball</option>
                        <option value="Volleyball">Volleyball</option>
                        <option value="Badminton">Badminton</option>
                        <option value="Carrom">Carrom</option>
                        <option value="Table Tennis">Table Tennis</option>
                        <option value="Singing">Singing</option>
                        <option value="Dancing">Dancing</option>
                        <option value="Rangoli">Rangoli</option>
                        <option value="Debate">Debate</option>
                    </select>
                    <span id="event_error" class="error-message"></span>
                </div>

                <div class="galore-input-group">
                    <label class="galore-label">Status <span class="text-danger">*</span></label>
                    <select name="status" id="status" class="galore-select">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    <span id="status_error" class="error-message"></span>
                </div>

                <div class="form-buttons">
                    <button type="submit" class="btn-save">Save Participant</button>
                    <button type="button" class="btn-cancel" id="cancelParticipantForm">Cancel</button>
                </div>
            </form>
        </div>

        <!-- Records Section -->
        <div id="recordsArea" class="records-section">
            <div class="table-header">
                <h2 id="tableEventTitle" class="table-title">
                    <i class="bi bi-people-fill me-2"></i>Participants
                </h2>
                <div class="d-flex gap-3">
                    <button class="btn-add-participant" id="openParticipantFormBtn">
                        <i class="bi bi-plus-circle"></i> Add Participant
                    </button>
                    <form method="POST" action="ad_c_participations_handler.php" style="display: inline;" onsubmit="return confirm('Are you sure you want to send confirmation emails to ALL active participants? This may take a few moments.');">
                        <button type="submit" name="send_email_to_all" class="btn-add-participant" style="background: linear-gradient(135deg, #198754, #157347);">
                            <i class="bi bi-envelope-paper-fill"></i> Send Mail to All
                        </button>
                    </form>
                    <span class="event-badge" id="eventBadge">
                        <i class="bi bi-person-check-fill me-2"></i><span id="participantCount">0</span> Participants
                    </span>
                </div>
            </div>

            <!-- Filter Section inside Records -->
            <div class="filter-section mb-4">
                <input type="text" class="filter-input" id="searchInput" placeholder="Search by name, enrollment, or branch...">
                <select class="filter-input" id="statusFilter">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                <button class="filter-btn" onclick="resetFilters()">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                </button>
            </div>

            <div class="table-scroll-container">
                <table class="table">
                    <thead id="tableHeader">
                        <!-- Headers will be dynamically generated -->
                    </thead>
                    <tbody id="recordRows">
                        <!-- Data will be populated by JavaScript -->
                    </tbody>
                </table>
            </div>

            <!-- Pagination Container -->
            <div class="pagination-container" id="paginationContainer"></div>
            <div class="pagination-info" id="paginationInfo"></div>
        </div>
    </div>

    <!-- VIEW MODAL -->
    <div class="modal fade" id="viewParticipantModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius:18px;border-top:6px solid var(--galore-red);">
                <div class="modal-header text-white" style="background:var(--galore-red);">
                    <h5 class="modal-title fw-bold">Participant Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="participantDetails">
                    <!-- Details will be populated by JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let allParticipants = <?php echo json_encode($allParticipants); ?>;
        let currentViewType = 'all';
        let currentFilterValue = 'All';
        let currentRecords = [];
        let filteredRecords = [];
        let editParticipantId = null;
        
        // Pagination variables
        let currentPage = 1;
        let rowsPerPage = 5;
        let totalPages = 1;

        const addParticipantForm = $("#addParticipantForm");
        const participantFormTitle = $("#participantFormTitle");

        // jQuery Validation for Form
        $(document).ready(function() {
            // Initialize jQuery Validation
            $("#participantForm").validate({
                rules: {
                    student_name: {
                        required: true,
                        minlength: 3,
                        maxlength: 100,
                        pattern: /^[a-zA-Z\s]+$/
                    },
                    enrollment: {
                        required: true,
                        minlength: 8,
                        maxlength: 20
                    },
                    email: {
                        required: true,
                        email: true,
                        maxlength: 100
                    },
                    contact: {
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
                        minlength: "Name must be at least 3 characters",
                        maxlength: "Name cannot exceed 100 characters",
                        pattern: "Only alphabetic characters and spaces allowed"
                    },
                    enrollment: {
                        required: "Please enter enrollment number",
                        minlength: "Enrollment number must be at least 8 characters",
                        maxlength: "Enrollment number cannot exceed 20 characters"
                    },
                    email: {
                        required: "Please enter email address",
                        email: "Please enter a valid email address",
                        maxlength: "Email cannot exceed 100 characters"
                    },
                    contact: {
                        required: "Please enter contact number",
                        digits: "Please enter only digits",
                        minlength: "Contact number must be exactly 10 digits",
                        maxlength: "Contact number must be exactly 10 digits"
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

            // Custom pattern validation
            $.validator.addMethod("pattern", function(value, element, regexp) {
                return this.optional(element) || regexp.test(value);
            }, "Invalid format");
        });

        // Open participant form
        $("#openParticipantFormBtn").click(() => {
            participantFormTitle.text("Add New Participant");
            editParticipantId = null;
            $("#formAction").val('add');
            $("#participantId").val('');
            $("#participantForm")[0].reset();
            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
            addParticipantForm.slideDown();
        });

        // Cancel participant form
        $("#cancelParticipantForm").click(() => {
            addParticipantForm.slideUp();
            $("#participantForm")[0].reset();
            $("#participantId").val('');
            editParticipantId = null;
            // Clear validation classes and error messages
            $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
            $(".error-message").text("");
        });

        // New function to view event records filtered by school
        function viewEventSchoolRecords(eventName, schoolName) {
            currentViewType = 'event_school';
            currentFilterValue = eventName + '_' + schoolName;
            
            // Filter participants by both event and school
            currentRecords = allParticipants.filter(p => 
                p.event_value === eventName && p.school === schoolName
            );
            
            filteredRecords = [...currentRecords];
            currentPage = 1;
            
            const tableSection = document.getElementById('recordsArea');
            const tableTitle = document.getElementById('tableEventTitle');
            const participantCount = document.getElementById('participantCount');
            const tableHeader = document.getElementById('tableHeader');

            // Set Title
            tableTitle.innerHTML = `<i class="bi bi-trophy me-2"></i>${eventName} - ${schoolName} Students`;
            participantCount.innerText = currentRecords.length;

            // Generate dynamic headers
            let headerHTML = `
                <th>ID</th>
                <th>Student Name</th>
                <th>Enrollment No.</th>
                <th>Branch</th>
                <th>Semester</th>
                <th>Event</th>
                <th>School</th>
                <th>Status</th>
                <th>Actions</th>
            `;
            tableHeader.innerHTML = headerHTML;

            // Show Section
            tableSection.style.display = 'block';

            // Render Table with Pagination
            renderEventSchoolTable();

            // Smooth Scroll
            tableSection.scrollIntoView({
                behavior: 'smooth'
            });
        }

        // Function to render table for event-school view with pagination
        function renderEventSchoolTable() {
            const tableBody = document.getElementById('recordRows');
            const totalRecords = filteredRecords.length;
            
            // Calculate pagination
            totalPages = Math.ceil(totalRecords / rowsPerPage);
            if (currentPage > totalPages) currentPage = totalPages;
            if (currentPage < 1) currentPage = 1;
            
            const startIndex = (currentPage - 1) * rowsPerPage;
            const endIndex = Math.min(startIndex + rowsPerPage, totalRecords);
            const paginatedData = filteredRecords.slice(startIndex, endIndex);
            
            document.getElementById('participantCount').innerHTML = totalRecords;
            
            // Clear and Populate Table
            tableBody.innerHTML = "";

            if (filteredRecords.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="9" class="text-center py-4">No records found</td></tr>`;
            } else {
                paginatedData.forEach(participant => {
                    const isActive = participant.status.toLowerCase() === 'active';
                    const statusClass = isActive ? 'btn-status-active' : 'btn-status-inactive';
                    const displayStatus = participant.status.charAt(0).toUpperCase() + participant.status.slice(1);
                    
                    let row = `
                        <tr>
                            <td><strong>${participant.id}</strong></td>
                            <td><strong>${escapeHtml(participant.full_name)}</strong></td>
                            <td>${escapeHtml(participant.enrollment_no)}</td>
                            <td><span class="school-badge">${escapeHtml(participant.branch)}</span></td>
                            <td>${participant.semester}th Sem</td>
                            <td><span class="event-badge-table">${escapeHtml(participant.event_value)}</span></td>
                            <td><span class="school-badge">${escapeHtml(participant.school)}</span></td>
                            <td>
                                <button class="btn-status ${statusClass}" onclick="toggleStatus(${participant.id})">
                                    ${displayStatus}
                                </button>
                            </td>
                            <td>
                                <button class="action-btn btn-view" onclick="viewParticipant(${participant.id})"><i class="bi bi-eye"></i></button>
                                <button class="action-btn btn-edit" onclick="editParticipant(${participant.id})"><i class="bi bi-pencil"></i></button>
                                <button class="action-btn btn-delete" onclick="deleteParticipant(${participant.id})"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                    `;
                    tableBody.innerHTML += row;
                });
            }
            
            renderPagination(totalRecords);
        }

        // Function to view records based on type
        function viewRecords(type, filterValue) {
            currentViewType = type;
            currentFilterValue = filterValue;
            currentPage = 1;

            if (type === 'all') {
                currentRecords = [...allParticipants];
            } else if (type === 'school') {
                currentRecords = allParticipants.filter(p => p.school === filterValue);
            } else if (type === 'event') {
                currentRecords = allParticipants.filter(p => p.event_value === filterValue);
            }

            filteredRecords = [...currentRecords];

            const tableSection = document.getElementById('recordsArea');
            const tableTitle = document.getElementById('tableEventTitle');
            const participantCount = document.getElementById('participantCount');
            const tableHeader = document.getElementById('tableHeader');

            // Set Title and Count
            if (type === 'all') {
                tableTitle.innerHTML = `<i class="bi bi-people-fill me-2"></i>All Participants`;
            } else if (type === 'school') {
                tableTitle.innerHTML = `<i class="bi bi-building me-2"></i>School: ${filterValue}`;
            } else if (type === 'event') {
                tableTitle.innerHTML = `<i class="bi bi-trophy me-2"></i>Event: ${filterValue}`;
            }

            participantCount.innerText = currentRecords.length;

            // Generate dynamic headers
            let headerHTML = `
                <th>ID</th>
                <th>Student Name</th>
                <th>Enrollment No.</th>
                <th>Branch</th>
                <th>Semester</th>
            `;

            if (type === 'all') {
                headerHTML += `<th>Event</th><th>School</th>`;
            } else if (type === 'school') {
                headerHTML += `<th>School</th>`;
            } else if (type === 'event') {
                headerHTML += `<th>Event</th>`;
            }

            headerHTML += `<th>Status</th><th>Actions</th>`;
            tableHeader.innerHTML = headerHTML;

            // Show Section
            tableSection.style.display = 'block';

            // Render Table with Pagination
            renderTable();

            // Smooth Scroll
            tableSection.scrollIntoView({
                behavior: 'smooth'
            });
        }

        // Render table with pagination
        function renderTable() {
            const tableBody = document.getElementById('recordRows');
            const totalRecords = filteredRecords.length;
            
            // Calculate pagination
            totalPages = Math.ceil(totalRecords / rowsPerPage);
            if (currentPage > totalPages) currentPage = totalPages;
            if (currentPage < 1) currentPage = 1;
            
            const startIndex = (currentPage - 1) * rowsPerPage;
            const endIndex = Math.min(startIndex + rowsPerPage, totalRecords);
            const paginatedData = filteredRecords.slice(startIndex, endIndex);
            
            document.getElementById('participantCount').innerHTML = totalRecords;

            // Clear and Populate Table
            tableBody.innerHTML = "";

            if (filteredRecords.length === 0) {
                tableBody.innerHTML = `<tr><td colspan="10" class="text-center py-4">No records found</td></tr>`;
            } else {
                paginatedData.forEach(participant => {
                    const isActive = participant.status.toLowerCase() === 'active';
                    const statusClass = isActive ? 'btn-status-active' : 'btn-status-inactive';
                    const displayStatus = participant.status.charAt(0).toUpperCase() + participant.status.slice(1);
                    
                    let row = `
                        <tr>
                            <td><strong>${participant.id}</strong></td>
                            <td><strong>${escapeHtml(participant.full_name)}</strong></td>
                            <td>${escapeHtml(participant.enrollment_no)}</td>
                            <td><span class="school-badge">${escapeHtml(participant.branch)}</span></td>
                            <td>${participant.semester}th Sem</td>
                    `;

                    if (currentViewType === 'all') {
                        row += `<td><span class="event-badge-table">${escapeHtml(participant.event_value)}</span></td>`;
                        row += `<td><span class="school-badge">${escapeHtml(participant.school)}</span></td>`;
                    } else if (currentViewType === 'school') {
                        row += `<td><span class="school-badge">${escapeHtml(participant.school)}</span></td>`;
                    } else if (currentViewType === 'event') {
                        row += `<td><span class="event-badge-table">${escapeHtml(participant.event_value)}</span></td>`;
                    }

                    row += `
                            <td>
                                <button class="btn-status ${statusClass}" onclick="toggleStatus(${participant.id})">
                                    ${displayStatus}
                                </button>
                            </td>
                            <td>
                                <button class="action-btn btn-view" onclick="viewParticipant(${participant.id})"><i class="bi bi-eye"></i></button>
                                <button class="action-btn btn-edit" onclick="editParticipant(${participant.id})"><i class="bi bi-pencil"></i></button>
                                <button class="action-btn btn-delete" onclick="deleteParticipant(${participant.id})"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                    `;
                    tableBody.innerHTML += row;
                });
            }
            
            renderPagination(totalRecords);
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
            
            if (currentViewType === 'event_school') {
                renderEventSchoolTable();
            } else {
                renderTable();
            }
        }

        function escapeHtml(text) {
            if (!text) return '';
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // Filter table function
        function filterTable() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value;

            filteredRecords = currentRecords.filter(participant => {
                const matchesSearch = participant.full_name.toLowerCase().includes(searchTerm) ||
                    participant.enrollment_no.toLowerCase().includes(searchTerm) ||
                    (participant.branch && participant.branch.toLowerCase().includes(searchTerm));
                const matchesStatus = statusFilter === '' || participant.status.toLowerCase() === statusFilter;
                return matchesSearch && matchesStatus;
            });
            
            currentPage = 1;

            // Check if we're in event_school view to use appropriate render function
            if (currentViewType === 'event_school') {
                renderEventSchoolTable();
            } else {
                renderTable();
            }
        }

        // Reset filters
        function resetFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('statusFilter').value = '';
            filteredRecords = [...currentRecords];
            currentPage = 1;
            
            if (currentViewType === 'event_school') {
                renderEventSchoolTable();
            } else {
                renderTable();
            }
        }

        // Toggle status
        function toggleStatus(id) {
            if (confirm('Are you sure you want to change the status of this participant?')) {
                window.location.href = '?toggle_id=' + id + '&view_type=' + currentViewType + '&filter_value=' + currentFilterValue;
            }
        }

        // View participant details
        function viewParticipant(id) {
            const participant = allParticipants.find(p => p.id == id);
            const modalBody = document.getElementById('participantDetails');
            const isActive = participant.status.toLowerCase() === 'active';
            const statusClass = isActive ? 'btn-status-active' : 'btn-status-inactive';
            const displayStatus = participant.status.charAt(0).toUpperCase() + participant.status.slice(1);

            modalBody.innerHTML = `
                <div class="text-center mb-4">
                    <div style="width: 80px; height: 80px; background: #f8d7da; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="bi bi-person-fill" style="font-size: 3rem; color: var(--galore-red);"></i>
                    </div>
                </div>
                <table class="table table-bordered">
                    <tr><th style="width: 40%">ID</th><td>${participant.id}</td></tr>
                    <tr><th>Full Name</th><td>${escapeHtml(participant.full_name)}</td></tr>
                    <tr><th>Enrollment No.</th><td>${escapeHtml(participant.enrollment_no)}</td></tr>
                    <tr><th>Email</th><td>${escapeHtml(participant.email)}</td></tr>
                    <tr><th>Contact No.</th><td>${escapeHtml(participant.phone)}</td></tr>
                    <tr><th>Branch</th><td>${escapeHtml(participant.branch)}</td></tr>
                    <tr><th>Semester</th><td>${participant.semester}th Semester</td></tr>
                    <tr><th>School</th><td>${escapeHtml(participant.school)}</td></tr>
                    <tr><th>Event</th><td>${escapeHtml(participant.event_value)}</td></tr>
                    <tr><th>Status</th><td><span class="btn-status ${statusClass}">${displayStatus}</span></td></tr>
                </table>
            `;

            new bootstrap.Modal(document.getElementById('viewParticipantModal')).show();
        }

        // Edit participant
        function editParticipant(id) {
            const participant = allParticipants.find(p => p.id == id);
            if (participant) {
                editParticipantId = id;
                participantFormTitle.text("Edit Participant");
                $("#formAction").val('edit');
                $("#participantId").val(participant.id);
                $("#student_name").val(participant.full_name);
                $("#enrollment").val(participant.enrollment_no);
                $("#email").val(participant.email);
                $("#contact").val(participant.phone);
                $("#branch").val(participant.branch);
                $("#semester").val(participant.semester);
                $("#school").val(participant.school);
                $("#event_name").val(participant.event_value);
                $("#status").val(participant.status.toLowerCase());

                // Clear validation classes and error messages
                $(".is-valid, .is-invalid").removeClass("is-valid is-invalid");
                $(".error-message").text("");

                addParticipantForm.slideDown();
            }
        }

        // Delete participant
        function deleteParticipant(id) {
            if (confirm('Are you sure you want to delete this participant? This action cannot be undone.')) {
                window.location.href = '?delete_id=' + id + '&view_type=' + currentViewType + '&filter_value=' + currentFilterValue;
            }
        }
        
        // Event listeners for filter
        document.getElementById('searchInput').addEventListener('keyup', filterTable);
        document.getElementById('statusFilter').addEventListener('change', filterTable);
    </script>
</body>

</html>