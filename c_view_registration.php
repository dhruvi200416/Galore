<!DOCTYPE html>
<html lang="en">

<head>
    <title>Registration Manager - Galore</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- AOS CSS for scroll animations -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

    <style>
        :root {
            --galore-red: #dc3545;
            --galore-red-dark: #b02a37;
            --galore-bg: #f8f9fa;
            --galore-dark: #212529;
            --galore-gray: #6c757d;
            --galore-white: #ffffff;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: "Segoe UI", Arial, sans-serif;
            background: linear-gradient(135deg, #ffffff 0%, #fff5f5 40%, #f8f9fa 100%);
            color: var(--galore-dark);
            min-height: 100vh;
        }

        .page-header {
            background: linear-gradient(135deg, var(--galore-red) 0%, var(--galore-red-dark) 100%);
            color: white;
            padding: 80px 0 40px;
            margin-bottom: 40px;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0,0 L100,0 L100,100 Z" fill="rgba(255,255,255,0.1)"/></svg>');
            background-size: cover;
        }

        .header-content {
            position: relative;
            z-index: 2;
        }

        .coordinator-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: white;
            color: var(--galore-red);
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 600;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .coordinator-badge i {
            font-size: 1.2rem;
        }

        .underline {
            width: 60px;
            height: 4px;
            background: linear-gradient(135deg, var(--galore-red), var(--galore-red-dark));
            margin: 12px auto;
            border-radius: 10px;
        }

        .underline.left {
            margin: 12px 0;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--galore-red);
            margin-bottom: 20px;
        }

        .section-subtitle {
            color: var(--galore-gray);
            font-weight: 500;
            margin-bottom: 30px;
        }

        /* Back Button */
        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--galore-red);
            color: white;
            padding: 12px 24px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-bottom: 30px;
        }

        .back-button:hover {
            background: var(--galore-red-dark);
            color: white;
            transform: translateX(-5px);
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border-top: 4px solid var(--galore-red);
            text-align: center;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #fff5f5 0%, #ffe6e6 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
        }

        .stat-icon i {
            font-size: 1.8rem;
            color: var(--galore-red);
        }

        .stat-number {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--galore-dark);
            margin-bottom: 5px;
        }

        .stat-label {
            color: var(--galore-gray);
            font-size: 0.95rem;
        }

        /* Event Selector */
        .event-selector {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 40px;
        }

        .event-select-card {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .event-select-card:hover {
            background: #e9ecef;
            transform: translateX(5px);
        }

        .event-select-card.active {
            background: #fff5f5;
            border-color: var(--galore-red);
        }

        .event-select-title {
            font-weight: 700;
            color: var(--galore-dark);
            margin-bottom: 5px;
        }

        .event-select-details {
            color: var(--galore-gray);
            font-size: 0.9rem;
        }

        /* Registration Table */
        .registration-table-container {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 40px;
            overflow: hidden;
        }

        /* Status Badges */
        .status-badge {
            display: inline-block;
            padding: 6px 15px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            text-align: center;
            min-width: 100px;
        }

        .status-pending {
            background: rgba(255, 193, 7, 0.15);
            color: #ffc107;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }

        .status-approved {
            background: rgba(40, 167, 69, 0.15);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .status-rejected {
            background: rgba(220, 53, 69, 0.15);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }

        .status-waiting {
            background: rgba(108, 117, 125, 0.15);
            color: #6c757d;
            border: 1px solid rgba(108, 117, 125, 0.3);
        }

        /* Action Buttons */
        .action-buttons-small {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn-action-sm {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .btn-approve {
            background: rgba(40, 167, 69, 0.15);
            color: #28a745;
        }

        .btn-approve:hover {
            background: #28a745;
            color: white;
            transform: scale(1.1);
        }

        .btn-reject {
            background: rgba(220, 53, 69, 0.15);
            color: #dc3545;
        }

        .btn-reject:hover {
            background: #dc3545;
            color: white;
            transform: scale(1.1);
        }

        .btn-view {
            background: rgba(0, 123, 255, 0.15);
            color: #007bff;
        }

        .btn-view:hover {
            background: #007bff;
            color: white;
            transform: scale(1.1);
        }

        /* Bulk Actions */
        .bulk-actions {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 40px;
        }

        .bulk-action-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 20px;
        }

        .btn-bulk {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 25px;
            border-radius: 12px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-bulk-approve {
            background: var(--galore-red);
            color: white;
        }

        .btn-bulk-approve:hover {
            background: var(--galore-red-dark);
            transform: translateY(-3px);
        }

        .btn-bulk-reject {
            background: #f8f9fa;
            color: var(--galore-dark);
            border: 2px solid #dee2e6;
        }

        .btn-bulk-reject:hover {
            background: #dc3545;
            color: white;
            border-color: #dc3545;
            transform: translateY(-3px);
        }

        /* Export Options */
        .export-options {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 40px;
        }

        .export-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 20px;
        }

        .btn-export {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 25px;
            border-radius: 12px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #f8f9fa;
            color: var(--galore-dark);
            border: 2px solid #dee2e6;
            min-width: 160px;
            justify-content: center;
        }

        .btn-export:hover {
            background: var(--galore-red);
            color: white;
            border-color: var(--galore-red);
            transform: translateY(-3px);
        }

        /* Filter Section */
        .filter-section {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 40px;
        }

        .filter-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 15px;
        }

        .filter-badge {
            padding: 8px 20px;
            border-radius: 50px;
            background: #f8f9fa;
            color: var(--galore-dark);
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .filter-badge:hover {
            background: #e9ecef;
        }

        .filter-badge.active {
            background: var(--galore-red);
            color: white;
            border-color: var(--galore-red);
        }

        /* Registration Details Modal */
        .registration-modal-content {
            border-radius: 16px;
            overflow: hidden;
        }

        .registration-modal-header {
            background: linear-gradient(135deg, var(--galore-red) 0%, var(--galore-red-dark) 100%);
            color: white;
            padding: 25px;
        }

        .registration-modal-title {
            font-weight: 700;
            font-size: 1.5rem;
        }

        .registration-details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .detail-item {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
        }

        .detail-label {
            font-weight: 600;
            color: var(--galore-gray);
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .detail-value {
            color: var(--galore-dark);
            font-weight: 500;
        }

        /* Notification Badge */
        .notification-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* DataTables Custom Styling */
        .dataTables_wrapper {
            margin-top: 20px;
        }

        .dataTables_length select {
            border-radius: 8px;
            padding: 6px 12px;
            border: 2px solid #e9ecef;
        }

        .dataTables_filter input {
            border-radius: 8px;
            padding: 6px 12px;
            border: 2px solid #e9ecef;
            margin-left: 10px;
        }

        .dt-buttons .btn {
            background: var(--galore-red);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            margin: 0 5px;
        }

        .dt-buttons .btn:hover {
            background: var(--galore-red-dark);
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .registration-details-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .section-title {
                font-size: 1.6rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .bulk-action-buttons,
            .export-buttons {
                flex-direction: column;
            }

            .btn-bulk,
            .btn-export {
                width: 100%;
            }

            .action-buttons-small {
                flex-direction: column;
            }

            .btn-action-sm {
                width: 100%;
                border-radius: 8px;
                margin-bottom: 5px;
            }
        }

        @media (max-width: 576px) {
            .stat-number {
                font-size: 1.8rem;
            }

            .event-select-card {
                padding: 15px;
            }

            .filter-badges {
                justify-content: center;
            }
        }
    </style>
</head>

<body>

    <?php include 'c_navbar.php'; ?>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="header-content">

                <!-- Back button -->
                <div class="text-start mb-4">
                    <a href="coordinator-dashboard.php" class="back-button" data-aos="fade-right">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>

                <!-- Page Title -->
                <h1 class="display-5 fw-bold mb-3" data-aos="fade-up">Registration Manager</h1>
                <p class="lead mb-4" data-aos="fade-up" data-aos-delay="100">
                    View, approve, reject, and manage all event registrations
                </p>

                <!-- Coordinator Badge -->
                <div class="coordinator-badge" data-aos="fade-up" data-aos-delay="200">
                    <i class="fas fa-user-tie"></i>
                    <span>Coordinator: Rahul Sharma | School of Engineering</span>
                </div>

            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container">

        <!-- Stats Overview -->
        <div class="stats-grid" data-aos="fade-up">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-number">142</div>
                <div class="stat-label">Total Registrations</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-number">68</div>
                <div class="stat-label">Pending Review</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-number">58</div>
                <div class="stat-label">Approved</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-number">16</div>
                <div class="stat-label">Rejected</div>
            </div>
        </div>

        <!-- Event Selection -->
        <div class="event-selector" data-aos="fade-up">
            <h3 class="section-title">Select Event</h3>
            <p class="section-subtitle">Choose an event to manage registrations</p>

            <div class="row">
                <!-- Football Event -->
                <div class="col-lg-6 mb-3">
                    <div class="event-select-card active" data-event="football">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="event-select-title">Football Tournament</h5>
                                <p class="event-select-details mb-2">Quarter Finals | Sports Category</p>
                                <p class="event-select-details mb-0">
                                    <i class="fas fa-calendar me-1"></i>March 21, 2024
                                    <i class="fas fa-users ms-3 me-1"></i>42 Registrations
                                </p>
                            </div>
                            <div class="position-relative">
                                <span class="notification-badge">12</span>
                                <span class="status-badge status-pending">Pending</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Robotics Event -->
                <div class="col-lg-6 mb-3">
                    <div class="event-select-card" data-event="robotics">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="event-select-title">Robotics Competition</h5>
                                <p class="event-select-details mb-2">Technical Category</p>
                                <p class="event-select-details mb-0">
                                    <i class="fas fa-calendar me-1"></i>March 18, 2024
                                    <i class="fas fa-users ms-3 me-1"></i>35 Registrations
                                </p>
                            </div>
                            <div>
                                <span class="status-badge status-approved">Approved</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dance Event -->
                <div class="col-lg-6 mb-3">
                    <div class="event-select-card" data-event="dance">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="event-select-title">Dance Competition</h5>
                                <p class="event-select-details mb-2">Cultural Category</p>
                                <p class="event-select-details mb-0">
                                    <i class="fas fa-calendar me-1"></i>March 22, 2024
                                    <i class="fas fa-users ms-3 me-1"></i>28 Registrations
                                </p>
                            </div>
                            <div>
                                <span class="status-badge status-pending">Pending</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Singing Event -->
                <div class="col-lg-6 mb-3">
                    <div class="event-select-card" data-event="singing">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="event-select-title">Singing Competition</h5>
                                <p class="event-select-details mb-2">Western Category</p>
                                <p class="event-select-details mb-0">
                                    <i class="fas fa-calendar me-1"></i>March 26, 2024
                                    <i class="fas fa-users ms-3 me-1"></i>37 Registrations
                                </p>
                            </div>
                            <div class="position-relative">
                                <span class="notification-badge">8</span>
                                <span class="status-badge status-pending">Pending</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section" data-aos="fade-up">
            <h5 class="fw-bold mb-3">Filter Registrations</h5>
            <div class="filter-badges">
                <span class="filter-badge active" data-filter="all">All (42)</span>
                <span class="filter-badge" data-filter="pending">Pending (12)</span>
                <span class="filter-badge" data-filter="approved">Approved (22)</span>
                <span class="filter-badge" data-filter="rejected">Rejected (8)</span>
                <span class="filter-badge" data-filter="individual">Individual (28)</span>
                <span class="filter-badge" data-filter="team">Team (14)</span>
                <span class="filter-badge" data-filter="engineering">Engineering (38)</span>
                <span class="filter-badge" data-filter="other-school">Other Schools (4)</span>
            </div>
        </div>

        <!-- Bulk Actions -->
        <div class="bulk-actions" data-aos="fade-up">
            <h5 class="fw-bold mb-3">Bulk Actions</h5>
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="selectAllRegistrations">
                <label class="form-check-label" for="selectAllRegistrations">
                    Select all 42 registrations
                </label>
            </div>
            <div class="bulk-action-buttons">
                <button class="btn-bulk btn-bulk-approve" id="bulkApproveBtn">
                    <i class="fas fa-check-circle"></i>
                    <span>Approve Selected</span>
                </button>
                <button class="btn-bulk btn-bulk-reject" id="bulkRejectBtn">
                    <i class="fas fa-times-circle"></i>
                    <span>Reject Selected</span>
                </button>
                <button class="btn-bulk" style="background: #f8f9fa; color: var(--galore-dark); border: 2px solid #dee2e6;">
                    <i class="fas fa-envelope"></i>
                    <span>Send Email</span>
                </button>
            </div>
        </div>

        <!-- Registration Table -->
        <div class="registration-table-container" data-aos="fade-up">
            <h3 class="section-title mb-4">Registrations - Football Tournament</h3>
            <p class="section-subtitle">42 total registrations | 12 pending review</p>

            <table id="registrationsTable" class="table table-hover w-100">
                <thead>
                    <tr>
                        <th width="30">
                            <input type="checkbox" id="selectAll">
                        </th>
                        <th>Registration ID</th>
                        <th>Participant Name</th>
                        <th>School</th>
                        <th>Team/Individual</th>
                        <th>Registration Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Registration 1 -->
                    <tr>
                        <td>
                            <input type="checkbox" class="registration-checkbox" data-id="1">
                        </td>
                        <td>
                            <strong>REG-FB-001</strong>
                        </td>
                        <td>
                            <div class="fw-bold">Rahul Sharma</div>
                            <small class="text-muted">ENG2024001</small>
                        </td>
                        <td>School of Engineering</td>
                        <td>
                            <span class="badge bg-info">Team A (Captain)</span>
                        </td>
                        <td>Mar 15, 2024</td>
                        <td>
                            <span class="status-badge status-approved">Approved</span>
                        </td>
                        <td>
                            <div class="action-buttons-small">
                                <button class="btn-action-sm btn-view" data-id="1">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action-sm btn-reject" data-id="1">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Registration 2 -->
                    <tr>
                        <td>
                            <input type="checkbox" class="registration-checkbox" data-id="2">
                        </td>
                        <td>
                            <strong>REG-FB-002</strong>
                        </td>
                        <td>
                            <div class="fw-bold">Vikram Kumar</div>
                            <small class="text-muted">ENG2024002</small>
                        </td>
                        <td>School of Engineering</td>
                        <td>
                            <span class="badge bg-info">Team A</span>
                        </td>
                        <td>Mar 15, 2024</td>
                        <td>
                            <span class="status-badge status-approved">Approved</span>
                        </td>
                        <td>
                            <div class="action-buttons-small">
                                <button class="btn-action-sm btn-view" data-id="2">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action-sm btn-reject" data-id="2">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Registration 3 -->
                    <tr>
                        <td>
                            <input type="checkbox" class="registration-checkbox" data-id="3">
                        </td>
                        <td>
                            <strong>REG-FB-003</strong>
                        </td>
                        <td>
                            <div class="fw-bold">Priya Patel</div>
                            <small class="text-muted">COM2024001</small>
                        </td>
                        <td>School of Commerce</td>
                        <td>
                            <span class="badge bg-warning">Team B</span>
                        </td>
                        <td>Mar 16, 2024</td>
                        <td>
                            <span class="status-badge status-pending">Pending</span>
                        </td>
                        <td>
                            <div class="action-buttons-small">
                                <button class="btn-action-sm btn-view" data-id="3">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action-sm btn-approve" data-id="3">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button class="btn-action-sm btn-reject" data-id="3">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Registration 4 -->
                    <tr>
                        <td>
                            <input type="checkbox" class="registration-checkbox" data-id="4">
                        </td>
                        <td>
                            <strong>REG-FB-004</strong>
                        </td>
                        <td>
                            <div class="fw-bold">Amit Verma</div>
                            <small class="text-muted">ENG2024003</small>
                        </td>
                        <td>School of Engineering</td>
                        <td>
                            <span class="badge bg-info">Team A</span>
                        </td>
                        <td>Mar 17, 2024</td>
                        <td>
                            <span class="status-badge status-approved">Approved</span>
                        </td>
                        <td>
                            <div class="action-buttons-small">
                                <button class="btn-action-sm btn-view" data-id="4">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action-sm btn-reject" data-id="4">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Registration 5 -->
                    <tr>
                        <td>
                            <input type="checkbox" class="registration-checkbox" data-id="5">
                        </td>
                        <td>
                            <strong>REG-FB-005</strong>
                        </td>
                        <td>
                            <div class="fw-bold">Neha Joshi</div>
                            <small class="text-muted">SCI2024001</small>
                        </td>
                        <td>School of Science</td>
                        <td>
                            <span class="badge bg-warning">Team B</span>
                        </td>
                        <td>Mar 18, 2024</td>
                        <td>
                            <span class="status-badge status-pending">Pending</span>
                        </td>
                        <td>
                            <div class="action-buttons-small">
                                <button class="btn-action-sm btn-view" data-id="5">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action-sm btn-approve" data-id="5">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button class="btn-action-sm btn-reject" data-id="5">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Registration 6 -->
                    <tr>
                        <td>
                            <input type="checkbox" class="registration-checkbox" data-id="6">
                        </td>
                        <td>
                            <strong>REG-FB-006</strong>
                        </td>
                        <td>
                            <div class="fw-bold">Rohit Mehta</div>
                            <small class="text-muted">COM2024002</small>
                        </td>
                        <td>School of Commerce</td>
                        <td>
                            <span class="badge bg-warning">Team B</span>
                        </td>
                        <td>Mar 18, 2024</td>
                        <td>
                            <span class="status-badge status-rejected">Rejected</span>
                        </td>
                        <td>
                            <div class="action-buttons-small">
                                <button class="btn-action-sm btn-view" data-id="6">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action-sm btn-approve" data-id="6">
                                    <i class="fas fa-check"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Registration 7 -->
                    <tr>
                        <td>
                            <input type="checkbox" class="registration-checkbox" data-id="7">
                        </td>
                        <td>
                            <strong>REG-FB-007</strong>
                        </td>
                        <td>
                            <div class="fw-bold">Sapna Patel</div>
                            <small class="text-muted">ENG2024004</small>
                        </td>
                        <td>School of Engineering</td>
                        <td>
                            <span class="badge bg-info">Team A</span>
                        </td>
                        <td>Mar 19, 2024</td>
                        <td>
                            <span class="status-badge status-approved">Approved</span>
                        </td>
                        <td>
                            <div class="action-buttons-small">
                                <button class="btn-action-sm btn-view" data-id="7">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action-sm btn-reject" data-id="7">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Registration 8 -->
                    <tr>
                        <td>
                            <input type="checkbox" class="registration-checkbox" data-id="8">
                        </td>
                        <td>
                            <strong>REG-FB-008</strong>
                        </td>
                        <td>
                            <div class="fw-bold">Megha Parmar</div>
                            <small class="text-muted">SCI2024002</small>
                        </td>
                        <td>School of Science</td>
                        <td>
                            <span class="badge bg-warning">Team B</span>
                        </td>
                        <td>Mar 20, 2024</td>
                        <td>
                            <span class="status-badge status-pending">Pending</span>
                        </td>
                        <td>
                            <div class="action-buttons-small">
                                <button class="btn-action-sm btn-view" data-id="8">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-action-sm btn-approve" data-id="8">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button class="btn-action-sm btn-reject" data-id="8">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Export Options -->
        <div class="export-options" data-aos="fade-up">
            <h5 class="fw-bold mb-3">Export Registration Data</h5>
            <div class="export-buttons">
                <button class="btn-export" id="exportExcelBtn">
                    <i class="fas fa-file-excel"></i>
                    <span>Export to Excel</span>
                </button>
                <button class="btn-export" id="exportPDFBtn">
                    <i class="fas fa-file-pdf"></i>
                    <span>Export to PDF</span>
                </button>
                <button class="btn-export" id="exportCSVBtn">
                    <i class="fas fa-file-csv"></i>
                    <span>Export to CSV</span>
                </button>
                <button class="btn-export" id="exportPrintBtn">
                    <i class="fas fa-print"></i>
                    <span>Print List</span>
                </button>
            </div>
        </div>

    </div>

    <!-- Registration Details Modal -->
    <div class="modal fade" id="registrationDetailsModal" tabindex="-1" aria-labelledby="registrationDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content registration-modal-content">
                <div class="registration-modal-header">
                    <h5 class="modal-title registration-modal-title" id="registrationDetailsModalLabel">
                        <i class="fas fa-id-card me-2"></i>Registration Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Details will be loaded here dynamically -->
                    <div id="registrationDetailsContent">
                        <!-- Content loaded via JavaScript -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="modalApproveBtn">
                        <i class="fas fa-check me-2"></i>Approve
                    </button>
                    <button type="button" class="btn btn-danger" id="modalRejectBtn">
                        <i class="fas fa-times me-2"></i>Reject
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>


    <!-- DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <script>
        AOS.init({
            duration: 1200,
            once: true
        });

        // Initialize DataTable
        $(document).ready(function() {
            $('#registrationsTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                pageLength: 10,
                responsive: true,
                language: {
                    search: "Search registrations:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ registrations"
                }
            });
        });

        // Event Selection
        document.querySelectorAll('.event-select-card').forEach(card => {
            card.addEventListener('click', function() {
                // Remove active class from all cards
                document.querySelectorAll('.event-select-card').forEach(c => {
                    c.classList.remove('active');
                });

                // Add active class to clicked card
                this.classList.add('active');

                const eventName = this.querySelector('.event-select-title').textContent;
                const eventId = this.getAttribute('data-event');

                // In real application, this would load event-specific registrations
                showNotification(`Loading registrations for: ${eventName}`, 'info');

                // Update table title
                document.querySelector('.section-title').textContent = `Registrations - ${eventName}`;

                // Simulate loading
                setTimeout(() => {
                    showNotification(`Loaded registrations for ${eventName}`, 'success');
                }, 1000);
            });
        });

        // Filter Badges
        document.querySelectorAll('.filter-badge').forEach(badge => {
            badge.addEventListener('click', function() {
                // Remove active class from all badges
                document.querySelectorAll('.filter-badge').forEach(b => {
                    b.classList.remove('active');
                });

                // Add active class to clicked badge
                this.classList.add('active');

                const filter = this.getAttribute('data-filter');
                const filterText = this.textContent;

                // In real application, this would filter the table
                showNotification(`Filtering by: ${filterText}`, 'info');
            });
        });

        // Checkbox Selection
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.registration-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });

            document.getElementById('selectAllRegistrations').checked = this.checked;
        });

        document.getElementById('selectAllRegistrations').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.registration-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });

            document.getElementById('selectAll').checked = this.checked;
        });

        // Individual checkboxes
        document.querySelectorAll('.registration-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateBulkSelection();
            });
        });

        function updateBulkSelection() {
            const checkboxes = document.querySelectorAll('.registration-checkbox');
            const selectAll = document.getElementById('selectAll');
            const selectAllRegistrations = document.getElementById('selectAllRegistrations');

            const checkedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
            const totalCount = checkboxes.length;

            selectAll.checked = checkedCount === totalCount;
            selectAllRegistrations.checked = checkedCount === totalCount;
        }

        // View Registration Details
        document.querySelectorAll('.btn-view').forEach(btn => {
            btn.addEventListener('click', function() {
                const regId = this.getAttribute('data-id');
                loadRegistrationDetails(regId);

                const modal = new bootstrap.Modal(document.getElementById('registrationDetailsModal'));
                modal.show();
            });
        });

        // Approve Registration
        document.querySelectorAll('.btn-approve').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const regId = this.getAttribute('data-id');
                approveRegistration(regId, this);
            });
        });

        // Reject Registration
        document.querySelectorAll('.btn-reject').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                const regId = this.getAttribute('data-id');
                rejectRegistration(regId, this);
            });
        });

        // Bulk Actions
        document.getElementById('bulkApproveBtn').addEventListener('click', function() {
            const selectedIds = getSelectedRegistrationIds();
            if (selectedIds.length === 0) {
                alert('Please select at least one registration.');
                return;
            }

            if (confirm(`Approve ${selectedIds.length} selected registration(s)?`)) {
                selectedIds.forEach(id => {
                    approveRegistration(id);
                });
                showNotification(`${selectedIds.length} registration(s) approved.`, 'success');
                clearSelections();
            }
        });

        document.getElementById('bulkRejectBtn').addEventListener('click', function() {
            const selectedIds = getSelectedRegistrationIds();
            if (selectedIds.length === 0) {
                alert('Please select at least one registration.');
                return;
            }

            if (confirm(`Reject ${selectedIds.length} selected registration(s)?`)) {
                selectedIds.forEach(id => {
                    rejectRegistration(id);
                });
                showNotification(`${selectedIds.length} registration(s) rejected.`, 'warning');
                clearSelections();
            }
        });

        // Export Functions
        document.getElementById('exportExcelBtn').addEventListener('click', function() {
            showNotification('Exporting to Excel... Download will start shortly.', 'info');
            // DataTables export functionality is already initialized
        });

        document.getElementById('exportPDFBtn').addEventListener('click', function() {
            showNotification('Exporting to PDF... Download will start shortly.', 'info');
            // DataTables export functionality is already initialized
        });

        document.getElementById('exportCSVBtn').addEventListener('click', function() {
            showNotification('Exporting to CSV... Download will start shortly.', 'info');
            // DataTables export functionality is already initialized
        });

        document.getElementById('exportPrintBtn').addEventListener('click', function() {
            window.print();
        });

        // Helper Functions
        function getSelectedRegistrationIds() {
            const checkboxes = document.querySelectorAll('.registration-checkbox:checked');
            return Array.from(checkboxes).map(cb => cb.getAttribute('data-id'));
        }

        function clearSelections() {
            document.querySelectorAll('.registration-checkbox').forEach(cb => {
                cb.checked = false;
            });
            document.getElementById('selectAll').checked = false;
            document.getElementById('selectAllRegistrations').checked = false;
        }

        function approveRegistration(id, button = null) {
            // Find the status badge for this registration
            const row = document.querySelector(`.registration-checkbox[data-id="${id}"]`).closest('tr');
            const statusBadge = row.querySelector('.status-badge');

            // Update UI
            statusBadge.className = 'status-badge status-approved';
            statusBadge.textContent = 'Approved';

            // Update action buttons
            if (button) {
                const actionContainer = button.closest('.action-buttons-small');
                actionContainer.innerHTML = `
          <button class="btn-action-sm btn-view" data-id="${id}">
            <i class="fas fa-eye"></i>
          </button>
          <button class="btn-action-sm btn-reject" data-id="${id}">
            <i class="fas fa-times"></i>
          </button>
        `;

                // Reattach event listeners
                attachActionListeners(actionContainer, id);
            }

            // In real application, this would send approval to server
            console.log(`Approved registration ${id}`);
        }

        function rejectRegistration(id, button = null) {
            // Find the status badge for this registration
            const row = document.querySelector(`.registration-checkbox[data-id="${id}"]`).closest('tr');
            const statusBadge = row.querySelector('.status-badge');

            // Update UI
            statusBadge.className = 'status-badge status-rejected';
            statusBadge.textContent = 'Rejected';

            // Update action buttons
            if (button) {
                const actionContainer = button.closest('.action-buttons-small');
                actionContainer.innerHTML = `
          <button class="btn-action-sm btn-view" data-id="${id}">
            <i class="fas fa-eye"></i>
          </button>
          <button class="btn-action-sm btn-approve" data-id="${id}">
            <i class="fas fa-check"></i>
          </button>
        `;

                // Reattach event listeners
                attachActionListeners(actionContainer, id);
            }

            // In real application, this would send rejection to server
            console.log(`Rejected registration ${id}`);
        }

        function attachActionListeners(container, id) {
            const viewBtn = container.querySelector('.btn-view');
            const approveBtn = container.querySelector('.btn-approve');
            const rejectBtn = container.querySelector('.btn-reject');

            if (viewBtn) {
                viewBtn.addEventListener('click', function() {
                    loadRegistrationDetails(id);
                    const modal = new bootstrap.Modal(document.getElementById('registrationDetailsModal'));
                    modal.show();
                });
            }

            if (approveBtn) {
                approveBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    approveRegistration(id, this);
                });
            }

            if (rejectBtn) {
                rejectBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    rejectRegistration(id, this);
                });
            }
        }

        function loadRegistrationDetails(id) {
            // Sample registration data
            const registrationData = {
                '1': {
                    id: 'REG-FB-001',
                    name: 'Rahul Sharma',
                    rollNo: 'ENG2024001',
                    email: 'rahul.sharma@rku.ac.in',
                    phone: '+91 98765 43210',
                    school: 'School of Engineering',
                    department: 'Computer Engineering',
                    year: '3rd Year',
                    team: 'Team A (Captain)',
                    position: 'Forward',
                    registrationDate: 'March 15, 2024',
                    status: 'Approved',
                    feePaid: 'Yes (₹500)',
                    paymentId: 'PAY-001234',
                    emergencyContact: '+91 98765 43211',
                    medicalInfo: 'No known allergies',
                    previousExperience: 'College team captain for 2 years',
                    notes: 'Primary coordinator for team'
                },
                '2': {
                    id: 'REG-FB-002',
                    name: 'Vikram Kumar',
                    rollNo: 'ENG2024002',
                    email: 'vikram.kumar@rku.ac.in',
                    phone: '+91 98765 43212',
                    school: 'School of Engineering',
                    department: 'Mechanical Engineering',
                    year: '2nd Year',
                    team: 'Team A',
                    position: 'Midfielder',
                    registrationDate: 'March 15, 2024',
                    status: 'Approved',
                    feePaid: 'Yes (₹500)',
                    paymentId: 'PAY-001235',
                    emergencyContact: '+91 98765 43213',
                    medicalInfo: 'Asthma (mild)',
                    previousExperience: 'School team player',
                    notes: 'Requires regular breaks'
                },
                '3': {
                    id: 'REG-FB-003',
                    name: 'Priya Patel',
                    rollNo: 'COM2024001',
                    email: 'priya.patel@rku.ac.in',
                    phone: '+91 98765 43214',
                    school: 'School of Commerce',
                    department: 'B.Com',
                    year: '2nd Year',
                    team: 'Team B',
                    position: 'Goalkeeper',
                    registrationDate: 'March 16, 2024',
                    status: 'Pending',
                    feePaid: 'Pending',
                    paymentId: 'N/A',
                    emergencyContact: '+91 98765 43215',
                    medicalInfo: 'None',
                    previousExperience: 'New player',
                    notes: 'First time participating'
                }
            };

            const data = registrationData[id] || registrationData['1'];

            // Build HTML for modal
            const html = `
        <div class="registration-details-grid">
          <div class="detail-item">
            <div class="detail-label">Registration ID</div>
            <div class="detail-value">${data.id}</div>
          </div>
          <div class="detail-item">
            <div class="detail-label">Full Name</div>
            <div class="detail-value">${data.name}</div>
          </div>
          <div class="detail-item">
            <div class="detail-label">Roll Number</div>
            <div class="detail-value">${data.rollNo}</div>
          </div>
          <div class="detail-item">
            <div class="detail-label">Email</div>
            <div class="detail-value">${data.email}</div>
          </div>
          <div class="detail-item">
            <div class="detail-label">Phone</div>
            <div class="detail-value">${data.phone}</div>
          </div>
          <div class="detail-item">
            <div class="detail-label">School</div>
            <div class="detail-value">${data.school}</div>
          </div>
          <div class="detail-item">
            <div class="detail-label">Department</div>
            <div class="detail-value">${data.department}</div>
          </div>
          <div class="detail-item">
            <div class="detail-label">Year</div>
            <div class="detail-value">${data.year}</div>
          </div>
          <div class="detail-item">
            <div class="detail-label">Team</div>
            <div class="detail-value">${data.team}</div>
          </div>
          <div class="detail-item">
            <div class="detail-label">Position</div>
            <div class="detail-value">${data.position}</div>
          </div>
          <div class="detail-item">
            <div class="detail-label">Registration Date</div>
            <div class="detail-value">${data.registrationDate}</div>
          </div>
          <div class="detail-item">
            <div class="detail-label">Status</div>
            <div class="detail-value"><span class="status-badge status-${data.status.toLowerCase()}">${data.status}</span></div>
          </div>
          <div class="detail-item">
            <div class="detail-label">Fee Paid</div>
            <div class="detail-value">${data.feePaid}</div>
          </div>
          <div class="detail-item">
            <div class="detail-label">Payment ID</div>
            <div class="detail-value">${data.paymentId}</div>
          </div>
          <div class="detail-item">
            <div class="detail-label">Emergency Contact</div>
            <div class="detail-value">${data.emergencyContact}</div>
          </div>
          <div class="detail-item">
            <div class="detail-label">Medical Information</div>
            <div class="detail-value">${data.medicalInfo}</div>
          </div>
          <div class="detail-item">
            <div class="detail-label">Previous Experience</div>
            <div class="detail-value">${data.previousExperience}</div>
          </div>
        </div>
        
        <div class="detail-item mt-3">
          <div class="detail-label">Additional Notes</div>
          <div class="detail-value">${data.notes}</div>
        </div>
      `;

            document.getElementById('registrationDetailsContent').innerHTML = html;

            // Set modal button actions
            document.getElementById('modalApproveBtn').onclick = function() {
                approveRegistration(id);
                const modal = bootstrap.Modal.getInstance(document.getElementById('registrationDetailsModal'));
                modal.hide();
                showNotification('Registration approved successfully!', 'success');
            };

            document.getElementById('modalRejectBtn').onclick = function() {
                rejectRegistration(id);
                const modal = bootstrap.Modal.getInstance(document.getElementById('registrationDetailsModal'));
                modal.hide();
                showNotification('Registration rejected.', 'warning');
            };
        }

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
            notification.style.cssText = `
        top: 20px;
        right: 20px;
        z-index: 1060;
        min-width: 300px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
      `;
            notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      `;

            document.body.appendChild(notification);

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 5000);
        }
    </script>

</body>

</html>