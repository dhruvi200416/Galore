<!DOCTYPE html>
<html lang="en">

<head>
    <title>Results Manager - Galore</title>
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

        .event-card-results {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .event-card-results:hover {
            background: #e9ecef;
            transform: translateX(5px);
        }

        .event-card-results.active {
            background: #fff5f5;
            border-color: var(--galore-red);
        }

        .event-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .event-card-title {
            font-weight: 700;
            color: var(--galore-dark);
            margin-bottom: 5px;
        }

        .event-card-details {
            color: var(--galore-gray);
            font-size: 0.9rem;
        }

        .results-status {
            padding: 6px 15px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-pending {
            background: rgba(255, 193, 7, 0.15);
            color: #ffc107;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }

        .status-published {
            background: rgba(40, 167, 69, 0.15);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .status-draft {
            background: rgba(108, 117, 125, 0.15);
            color: #6c757d;
            border: 1px solid rgba(108, 117, 125, 0.3);
        }

        /* Upload Section */
        .upload-section {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 40px;
        }

        .upload-area {
            border: 3px dashed #dee2e6;
            border-radius: 12px;
            padding: 60px 30px;
            text-align: center;
            background: #f8f9fa;
            transition: all 0.3s ease;
            cursor: pointer;
            margin-bottom: 20px;
        }

        .upload-area:hover {
            border-color: var(--galore-red);
            background: #fff5f5;
        }

        .upload-area.dragover {
            border-color: var(--galore-red);
            background: #ffe6e6;
        }

        .upload-icon {
            font-size: 3rem;
            color: var(--galore-red);
            margin-bottom: 20px;
        }

        .upload-text {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--galore-dark);
            margin-bottom: 10px;
        }

        .upload-subtext {
            color: var(--galore-gray);
            margin-bottom: 20px;
        }

        .upload-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: var(--galore-red);
            color: white;
            padding: 12px 25px;
            border-radius: 12px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .upload-btn:hover {
            background: var(--galore-red-dark);
            transform: translateY(-3px);
        }

        .file-list {
            margin-top: 20px;
        }

        .file-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .file-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .file-icon {
            font-size: 1.5rem;
            color: var(--galore-red);
        }

        .file-name {
            font-weight: 600;
            color: var(--galore-dark);
        }

        .file-size {
            color: var(--galore-gray);
            font-size: 0.9rem;
        }

        .file-actions {
            display: flex;
            gap: 10px;
        }

        .btn-file-action {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: none;
            background: white;
            color: var(--galore-gray);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-file-action:hover {
            background: var(--galore-red);
            color: white;
            transform: scale(1.1);
        }

        /* Manual Entry Form */
        .manual-entry-form {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 40px;
            display: none;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 600;
            color: var(--galore-dark);
            margin-bottom: 8px;
            display: block;
        }

        .form-control,
        .form-select {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 10px 15px;
            transition: all 0.3s ease;
            width: 100%;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--galore-red);
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
            outline: none;
        }

        .result-row {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
            border-left: 4px solid var(--galore-red);
        }

        .result-row-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .result-position {
            font-weight: 700;
            color: var(--galore-dark);
            font-size: 1.1rem;
        }

        .btn-add-result {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #28a745;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-add-result:hover {
            background: #218838;
            transform: translateY(-2px);
        }

        /* Results Table */
        .results-table-container {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 40px;
            overflow: hidden;
        }

        /* Medal Badges */
        .medal-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            font-weight: 700;
            color: white;
            font-size: 0.9rem;
        }

        .medal-gold {
            background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
            box-shadow: 0 3px 10px rgba(255, 215, 0, 0.3);
        }

        .medal-silver {
            background: linear-gradient(135deg, #C0C0C0 0%, #A9A9A9 100%);
            box-shadow: 0 3px 10px rgba(192, 192, 192, 0.3);
        }

        .medal-bronze {
            background: linear-gradient(135deg, #CD7F32 0%, #8B4513 100%);
            box-shadow: 0 3px 10px rgba(205, 127, 50, 0.3);
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn-action {
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

        .btn-edit {
            background: rgba(0, 123, 255, 0.15);
            color: #007bff;
        }

        .btn-edit:hover {
            background: #007bff;
            color: white;
            transform: scale(1.1);
        }

        .btn-delete {
            background: rgba(220, 53, 69, 0.15);
            color: #dc3545;
        }

        .btn-delete:hover {
            background: #dc3545;
            color: white;
            transform: scale(1.1);
        }

        .btn-publish {
            background: rgba(40, 167, 69, 0.15);
            color: #28a745;
        }

        .btn-publish:hover {
            background: #28a745;
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

        .btn-bulk-publish {
            background: var(--galore-red);
            color: white;
        }

        .btn-bulk-publish:hover {
            background: var(--galore-red-dark);
            transform: translateY(-3px);
        }

        /* Preview Section */
        .preview-section {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 40px;
        }

        .preview-card {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            border: 2px dashed #dee2e6;
        }

        .preview-title {
            font-weight: 700;
            color: var(--galore-red);
            margin-bottom: 20px;
            font-size: 1.3rem;
        }

        .preview-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .preview-table th {
            background: var(--galore-red);
            color: white;
            padding: 12px;
            font-weight: 600;
            text-align: left;
        }

        .preview-table td {
            padding: 12px;
            border-bottom: 1px solid #dee2e6;
        }

        .preview-table tr:nth-child(even) {
            background: #f8f9fa;
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

        /* DataTables Custom Styling */
        .dataTables_wrapper {
            margin-top: 20px;
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .form-grid {
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

            .action-buttons {
                flex-direction: column;
            }

            .btn-action {
                width: 100%;
                border-radius: 8px;
                margin-bottom: 5px;
            }
        }

        @media (max-width: 576px) {
            .stat-number {
                font-size: 1.8rem;
            }

            .upload-area {
                padding: 40px 20px;
            }

            .file-item {
                flex-direction: column;
                gap: 10px;
                text-align: center;
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
                <h1 class="display-5 fw-bold mb-3" data-aos="fade-up">Results Manager</h1>
                <p class="lead mb-4" data-aos="fade-up" data-aos-delay="100">
                    Upload, edit, and manage event results for Galore 2024
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
                    <i class="fas fa-trophy"></i>
                </div>
                <div class="stat-number">8</div>
                <div class="stat-label">Events Completed</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-number">6</div>
                <div class="stat-label">Results Published</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-number">2</div>
                <div class="stat-label">Pending Results</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-medal"></i>
                </div>
                <div class="stat-number">42</div>
                <div class="stat-label">Medals Awarded</div>
            </div>
        </div>

        <!-- Event Selection -->
        <div class="event-selector" data-aos="fade-up">
            <h3 class="section-title">Select Event</h3>
            <p class="section-subtitle">Choose an event to upload or edit results</p>

            <div class="row">
                <!-- Football Event -->
                <div class="col-lg-6 mb-3">
                    <div class="event-card-results active" data-event="football">
                        <div class="event-card-header">
                            <div>
                                <h5 class="event-card-title">Football Tournament</h5>
                                <p class="event-card-details mb-2">Quarter Finals | Sports Category</p>
                                <p class="event-card-details mb-0">
                                    <i class="fas fa-calendar me-1"></i>March 21, 2024
                                    <i class="fas fa-users ms-3 me-1"></i>42 Participants
                                </p>
                            </div>
                            <div>
                                <span class="results-status status-published">Published</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Robotics Event -->
                <div class="col-lg-6 mb-3">
                    <div class="event-card-results" data-event="robotics">
                        <div class="event-card-header">
                            <div>
                                <h5 class="event-card-title">Robotics Competition</h5>
                                <p class="event-card-details mb-2">Technical Category</p>
                                <p class="event-card-details mb-0">
                                    <i class="fas fa-calendar me-1"></i>March 18, 2024
                                    <i class="fas fa-users ms-3 me-1"></i>35 Participants
                                </p>
                            </div>
                            <div>
                                <span class="results-status status-published">Published</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dance Event -->
                <div class="col-lg-6 mb-3">
                    <div class="event-card-results" data-event="dance">
                        <div class="event-card-header">
                            <div>
                                <h5 class="event-card-title">Dance Competition</h5>
                                <div class="event-card-details mb-2">Cultural Category - Finals</div>
                                <p class="event-card-details mb-0">
                                    <i class="fas fa-calendar me-1"></i>March 22, 2024
                                    <i class="fas fa-users ms-3 me-1"></i>28 Participants
                                </p>
                            </div>
                            <div>
                                <span class="results-status status-pending">Pending</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Singing Event -->
                <div class="col-lg-6 mb-3">
                    <div class="event-card-results" data-event="singing">
                        <div class="event-card-header">
                            <div>
                                <h5 class="event-card-title">Singing Competition</h5>
                                <p class="event-card-details mb-2">Western Category - Semi Finals</p>
                                <p class="event-card-details mb-0">
                                    <i class="fas fa-calendar me-1"></i>March 26, 2024
                                    <i class="fas fa-users ms-3 me-1"></i>37 Participants
                                </p>
                            </div>
                            <div>
                                <span class="results-status status-draft">Draft</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upload Section -->
        <div class="upload-section" data-aos="fade-up">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="section-title">Upload Results</h3>
                    <p class="section-subtitle">Upload results file or enter manually</p>
                </div>
                <div>
                    <button class="upload-btn me-2" id="uploadBtn">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span>Upload File</span>
                    </button>
                    <button class="upload-btn" id="manualEntryBtn">
                        <i class="fas fa-keyboard"></i>
                        <span>Manual Entry</span>
                    </button>
                </div>
            </div>

            <!-- File Upload Area -->
            <div class="upload-area" id="uploadArea">
                <div class="upload-icon">
                    <i class="fas fa-file-excel"></i>
                </div>
                <div class="upload-text">Drop your results file here</div>
                <div class="upload-subtext">Supports: Excel (.xlsx, .xls), CSV, PDF, or Image files</div>
                <input type="file" id="fileInput" accept=".xlsx,.xls,.csv,.pdf,.jpg,.jpeg,.png" style="display: none;">
                <label for="fileInput" class="upload-btn">
                    <i class="fas fa-folder-open"></i>
                    <span>Browse Files</span>
                </label>
            </div>

            <!-- File List -->
            <div class="file-list" id="fileList">
                <!-- Files will be added here dynamically -->
            </div>

            <!-- Template Download -->
            <div class="alert alert-info mt-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-download me-3 fa-2x"></i>
                    <div>
                        <h6 class="alert-heading mb-1">Need a template?</h6>
                        <p class="mb-0">
                            Download our results template to ensure proper formatting:
                            <a href="#" class="alert-link">Download Excel Template</a> |
                            <a href="#" class="alert-link">Download CSV Template</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Manual Entry Form -->
        <div class="manual-entry-form" id="manualEntryForm">
            <h3 class="section-title">Manual Results Entry</h3>
            <p class="section-subtitle">Enter results for Football Tournament - Quarter Finals</p>

            <form id="manualResultsForm">
                <!-- Event Information -->
                <div class="form-grid mb-4">
                    <div>
                        <label class="form-label">Event Name</label>
                        <input type="text" class="form-control" value="Football Tournament - Quarter Finals" readonly>
                    </div>
                    <div>
                        <label class="form-label">Event Date</label>
                        <input type="text" class="form-control" value="March 21, 2024" readonly>
                    </div>
                    <div>
                        <label class="form-label">Venue</label>
                        <input type="text" class="form-control" value="Main Football Ground" readonly>
                    </div>
                </div>

                <!-- Winner Information -->
                <h5 class="fw-bold mb-3">Winner Information</h5>
                <div class="result-row">
                    <div class="result-row-header">
                        <div class="result-position">
                            <span class="medal-badge medal-gold me-2">🥇</span>
                            First Place
                        </div>
                    </div>
                    <div class="form-grid">
                        <div>
                            <label class="form-label">Team/School</label>
                            <input type="text" class="form-control" value="School of Engineering - Team A" required>
                        </div>
                        <div>
                            <label class="form-label">Score/Points</label>
                            <input type="text" class="form-control" value="3-1" required>
                        </div>
                        <div>
                            <label class="form-label">Captain Name</label>
                            <input type="text" class="form-control" value="Rahul Sharma" required>
                        </div>
                        <div>
                            <label class="form-label">Prize Money (₹)</label>
                            <input type="number" class="form-control" value="10000">
                        </div>
                    </div>
                </div>

                <!-- Second Place -->
                <div class="result-row">
                    <div class="result-row-header">
                        <div class="result-position">
                            <span class="medal-badge medal-silver me-2">🥈</span>
                            Second Place
                        </div>
                    </div>
                    <div class="form-grid">
                        <div>
                            <label class="form-label">Team/School</label>
                            <input type="text" class="form-control" value="School of Commerce - Team B" required>
                        </div>
                        <div>
                            <label class="form-label">Score/Points</label>
                            <input type="text" class="form-control" value="1-3" required>
                        </div>
                        <div>
                            <label class="form-label">Captain Name</label>
                            <input type="text" class="form-control" value="Priya Patel" required>
                        </div>
                        <div>
                            <label class="form-label">Prize Money (₹)</label>
                            <input type="number" class="form-control" value="5000">
                        </div>
                    </div>
                </div>

                <!-- Third Place -->
                <div class="result-row">
                    <div class="result-row-header">
                        <div class="result-position">
                            <span class="medal-badge medal-bronze me-2">🥉</span>
                            Third Place
                        </div>
                    </div>
                    <div class="form-grid">
                        <div>
                            <label class="form-label">Team/School</label>
                            <select class="form-select" required>
                                <option value="">Select team</option>
                                <option value="science">School of Science - Team C</option>
                                <option value="arts">School of Arts - Team D</option>
                                <option value="law">School of Law - Team E</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Score/Points</label>
                            <input type="text" class="form-control" placeholder="Enter score" required>
                        </div>
                        <div>
                            <label class="form-label">Captain Name</label>
                            <input type="text" class="form-control" placeholder="Enter captain name" required>
                        </div>
                        <div>
                            <label class="form-label">Prize Money (₹)</label>
                            <input type="number" class="form-control" value="2500">
                        </div>
                    </div>
                </div>

                <!-- Add More Positions -->
                <div class="text-center mt-4">
                    <button type="button" class="btn-add-result" id="addMorePositionsBtn">
                        <i class="fas fa-plus"></i>
                        Add More Positions
                    </button>
                </div>

                <!-- Additional Information -->
                <div class="mt-4">
                    <h5 class="fw-bold mb-3">Additional Information</h5>
                    <div class="form-grid">
                        <div>
                            <label class="form-label">Chief Referee</label>
                            <input type="text" class="form-control" value="Prof. Ajay Verma">
                        </div>
                        <div>
                            <label class="form-label">Match Duration</label>
                            <input type="text" class="form-control" value="90 minutes">
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="form-label">Match Summary</label>
                        <textarea class="form-control" rows="3" placeholder="Enter match summary...">School of Engineering defeated School of Commerce 3-1 in an exciting quarter-final match. Rahul Sharma scored 2 goals for the winning team.</textarea>
                    </div>

                    <div class="mt-3">
                        <label class="form-label">Special Awards (if any)</label>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="manOfMatch">
                            <label class="form-check-label" for="manOfMatch">
                                Man of the Match: Rahul Sharma (School of Engineering)
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="bestGoalkeeper">
                            <label class="form-check-label" for="bestGoalkeeper">
                                Best Goalkeeper: Priya Patel (School of Commerce)
                            </label>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="form-label">Result Status</label>
                        <select class="form-select">
                            <option value="draft">Draft</option>
                            <option value="pending">Pending Review</option>
                            <option value="published" selected>Publish Results</option>
                        </select>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-secondary" id="cancelManualEntryBtn">
                        Cancel
                    </button>
                    <div>
                        <button type="button" class="btn btn-success me-2" id="saveDraftBtn">
                            <i class="fas fa-save"></i> Save as Draft
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Publish Results
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Results Table -->
        <div class="results-table-container" data-aos="fade-up">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="section-title">Current Results</h3>
                    <p class="section-subtitle">Football Tournament - Quarter Finals (Published)</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn-action btn-edit" id="editResultsBtn" title="Edit Results">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn-action btn-publish" title="Republish Results">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>

            <table id="resultsTable" class="table table-hover w-100">
                <thead>
                    <tr>
                        <th width="50">Position</th>
                        <th>Team/School</th>
                        <th>Captain</th>
                        <th>Score</th>
                        <th>Points</th>
                        <th>Prize Money</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Result 1 -->
                    <tr>
                        <td>
                            <div class="medal-badge medal-gold">🥇</div>
                        </td>
                        <td>
                            <strong>School of Engineering - Team A</strong>
                            <div class="small text-muted">Team ID: TEA-ENG-001</div>
                        </td>
                        <td>Rahul Sharma</td>
                        <td>
                            <span class="badge bg-success">3-1</span>
                        </td>
                        <td>
                            <strong>25</strong>
                        </td>
                        <td>
                            <span class="badge bg-warning">₹10,000</span>
                        </td>
                        <td>
                            <span class="results-status status-published">Published</span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-action btn-edit" data-id="1">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-action btn-delete" data-id="1">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Result 2 -->
                    <tr>
                        <td>
                            <div class="medal-badge medal-silver">🥈</div>
                        </td>
                        <td>
                            <strong>School of Commerce - Team B</strong>
                            <div class="small text-muted">Team ID: TEA-COM-001</div>
                        </td>
                        <td>Priya Patel</td>
                        <td>
                            <span class="badge bg-danger">1-3</span>
                        </td>
                        <td>
                            <strong>15</strong>
                        </td>
                        <td>
                            <span class="badge bg-warning">₹5,000</span>
                        </td>
                        <td>
                            <span class="results-status status-published">Published</span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-action btn-edit" data-id="2">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-action btn-delete" data-id="2">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Result 3 -->
                    <tr>
                        <td>
                            <div class="medal-badge medal-bronze">🥉</div>
                        </td>
                        <td>
                            <strong>School of Science - Team C</strong>
                            <div class="small text-muted">Team ID: TEA-SCI-001</div>
                        </td>
                        <td>Neha Joshi</td>
                        <td>
                            <span class="badge bg-info">2-1</span>
                        </td>
                        <td>
                            <strong>10</strong>
                        </td>
                        <td>
                            <span class="badge bg-warning">₹2,500</span>
                        </td>
                        <td>
                            <span class="results-status status-published">Published</span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-action btn-edit" data-id="3">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-action btn-delete" data-id="3">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Result 4 -->
                    <tr>
                        <td>
                            <div class="fw-bold">4th</div>
                        </td>
                        <td>
                            <strong>School of Arts - Team D</strong>
                            <div class="small text-muted">Team ID: TEA-ART-001</div>
                        </td>
                        <td>Rohit Mehta</td>
                        <td>
                            <span class="badge bg-secondary">0-2</span>
                        </td>
                        <td>
                            <strong>5</strong>
                        </td>
                        <td>
                            <span class="badge bg-secondary">-</span>
                        </td>
                        <td>
                            <span class="results-status status-published">Published</span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-action btn-edit" data-id="4">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-action btn-delete" data-id="4">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Bulk Actions -->
        <div class="bulk-actions" data-aos="fade-up">
            <h5 class="fw-bold mb-3">Bulk Actions</h5>
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="selectAllResults">
                <label class="form-check-label" for="selectAllResults">
                    Select all results
                </label>
            </div>
            <div class="bulk-action-buttons">
                <button class="btn-bulk btn-bulk-publish" id="bulkPublishBtn">
                    <i class="fas fa-paper-plane"></i>
                    <span>Publish Selected</span>
                </button>
                <button class="btn-bulk" style="background: #f8f9fa; color: var(--galore-dark); border: 2px solid #dee2e6;">
                    <i class="fas fa-file-export"></i>
                    <span>Export Selected</span>
                </button>
                <button class="btn-bulk" style="background: rgba(220, 53, 69, 0.15); color: #dc3545; border: 2px solid rgba(220, 53, 69, 0.3);">
                    <i class="fas fa-trash"></i>
                    <span>Delete Selected</span>
                </button>
            </div>
        </div>

        <!-- Export Options -->
        <div class="export-options" data-aos="fade-up">
            <h5 class="fw-bold mb-3">Export Results</h5>
            <div class="export-buttons">
                <button class="btn-export" id="exportResultsExcelBtn">
                    <i class="fas fa-file-excel"></i>
                    <span>Export to Excel</span>
                </button>
                <button class="btn-export" id="exportResultsPDFBtn">
                    <i class="fas fa-file-pdf"></i>
                    <span>Export to PDF</span>
                </button>
                <button class="btn-export" id="exportResultsCSVBtn">
                    <i class="fas fa-file-csv"></i>
                    <span>Export to CSV</span>
                </button>
                <button class="btn-export" id="printResultsBtn">
                    <i class="fas fa-print"></i>
                    <span>Print Results</span>
                </button>
            </div>
        </div>

        <!-- Preview Section -->
        <div class="preview-section" data-aos="fade-up">
            <h5 class="fw-bold mb-4">Results Preview</h5>
            <div class="preview-card">
                <div class="preview-title">Football Tournament - Quarter Finals Results</div>
                <table class="preview-table">
                    <thead>
                        <tr>
                            <th>Position</th>
                            <th>Team</th>
                            <th>School</th>
                            <th>Score</th>
                            <th>Points</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>🥇 1st</td>
                            <td>Team A</td>
                            <td>School of Engineering</td>
                            <td>3-1</td>
                            <td>25</td>
                        </tr>
                        <tr>
                            <td>🥈 2nd</td>
                            <td>Team B</td>
                            <td>School of Commerce</td>
                            <td>1-3</td>
                            <td>15</td>
                        </tr>
                        <tr>
                            <td>🥉 3rd</td>
                            <td>Team C</td>
                            <td>School of Science</td>
                            <td>2-1</td>
                            <td>10</td>
                        </tr>
                        <tr>
                            <td>4th</td>
                            <td>Team D</td>
                            <td>School of Arts</td>
                            <td>0-2</td>
                            <td>5</td>
                        </tr>
                    </tbody>
                </table>
                <div class="mt-3 text-muted small">
                    Last updated: March 21, 2024 | Published by: Rahul Sharma
                </div>
            </div>
        </div>

    </div>

    <!-- Edit Result Modal -->
    <div class="modal fade" id="editResultModal" tabindex="-1" aria-labelledby="editResultModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, var(--galore-red) 0%, var(--galore-red-dark) 100%); color: white;">
                    <h5 class="modal-title" id="editResultModalLabel">
                        <i class="fas fa-edit me-2"></i>Edit Result
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="editResultForm">
                        <div class="form-grid mb-3">
                            <div>
                                <label class="form-label">Position</label>
                                <select class="form-select">
                                    <option value="1">🥇 1st Place</option>
                                    <option value="2">🥈 2nd Place</option>
                                    <option value="3">🥉 3rd Place</option>
                                    <option value="4">4th Place</option>
                                    <option value="5">5th Place</option>
                                </select>
                            </div>
                            <div>
                                <label class="form-label">Team/School</label>
                                <input type="text" class="form-control" value="School of Engineering - Team A" required>
                            </div>
                            <div>
                                <label class="form-label">Captain Name</label>
                                <input type="text" class="form-control" value="Rahul Sharma" required>
                            </div>
                            <div>
                                <label class="form-label">Score</label>
                                <input type="text" class="form-control" value="3-1" required>
                            </div>
                        </div>

                        <div class="form-grid mb-3">
                            <div>
                                <label class="form-label">Points Awarded</label>
                                <input type="number" class="form-control" value="25" required>
                            </div>
                            <div>
                                <label class="form-label">Prize Money (₹)</label>
                                <input type="number" class="form-control" value="10000">
                            </div>
                            <div>
                                <label class="form-label">Result Status</label>
                                <select class="form-select">
                                    <option value="draft">Draft</option>
                                    <option value="published" selected>Published</option>
                                    <option value="pending">Pending Review</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Additional Notes</label>
                            <textarea class="form-control" rows="2">Man of the Match award winner</textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Delete
                    </button>
                    <button type="button" class="btn btn-primary" id="saveResultBtn">
                        <i class="fas fa-save me-2"></i>Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

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
            $('#resultsTable').DataTable({
                pageLength: 10,
                responsive: true,
                language: {
                    search: "Search results:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ results"
                }
            });
        });

        // Event Selection
        document.querySelectorAll('.event-card-results').forEach(card => {
            card.addEventListener('click', function() {
                // Remove active class from all cards
                document.querySelectorAll('.event-card-results').forEach(c => {
                    c.classList.remove('active');
                });

                // Add active class to clicked card
                this.classList.add('active');

                const eventName = this.querySelector('.event-card-title').textContent;
                const eventStatus = this.querySelector('.results-status').textContent;

                // Update UI based on selected event
                updateEventDetails(eventName, eventStatus);
            });
        });

        function updateEventDetails(eventName, status) {
            // Update title and subtitle
            document.querySelector('.section-title').textContent = `Current Results`;
            document.querySelector('.section-subtitle').textContent = `${eventName} (${status})`;

            // Update manual entry form title
            const manualFormTitle = document.querySelector('#manualEntryForm .section-title');
            const manualFormSubtitle = document.querySelector('#manualEntryForm .section-subtitle');
            if (manualFormTitle) {
                manualFormTitle.textContent = 'Manual Results Entry';
                manualFormSubtitle.textContent = `Enter results for ${eventName}`;
            }

            // Update preview title
            const previewTitle = document.querySelector('.preview-title');
            if (previewTitle) {
                previewTitle.textContent = `${eventName} Results`;
            }

            showNotification(`Switched to: ${eventName}`, 'info');
        }

        // File Upload Functionality
        const uploadArea = document.getElementById('uploadArea');
        const fileInput = document.getElementById('fileInput');
        const fileList = document.getElementById('fileList');
        let uploadedFiles = [];

        // Click to upload
        uploadArea.addEventListener('click', () => fileInput.click());

        // Drag and drop
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('dragover');
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            const files = e.dataTransfer.files;
            handleFiles(files);
        });

        // File input change
        fileInput.addEventListener('change', (e) => {
            handleFiles(e.target.files);
        });

        function handleFiles(files) {
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                uploadedFiles.push(file);
                addFileToList(file);
            }

            if (files.length > 0) {
                showNotification(`${files.length} file(s) uploaded successfully`, 'success');
            }
        }

        function addFileToList(file) {
            const fileItem = document.createElement('div');
            fileItem.className = 'file-item';

            const fileSize = formatFileSize(file.size);
            const fileIcon = getFileIcon(file.name);

            fileItem.innerHTML = `
        <div class="file-info">
          <div class="file-icon">
            <i class="${fileIcon}"></i>
          </div>
          <div>
            <div class="file-name">${file.name}</div>
            <div class="file-size">${fileSize}</div>
          </div>
        </div>
        <div class="file-actions">
          <button class="btn-file-action btn-preview" title="Preview">
            <i class="fas fa-eye"></i>
          </button>
          <button class="btn-file-action btn-remove" title="Remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      `;

            fileList.appendChild(fileItem);

            // Add event listeners
            const removeBtn = fileItem.querySelector('.btn-remove');
            const previewBtn = fileItem.querySelector('.btn-preview');

            removeBtn.addEventListener('click', () => {
                fileItem.remove();
                uploadedFiles = uploadedFiles.filter(f => f.name !== file.name);
                showNotification('File removed', 'warning');
            });

            previewBtn.addEventListener('click', () => {
                showNotification(`Previewing: ${file.name}`, 'info');
                // In real application, this would open file preview
            });
        }

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        function getFileIcon(filename) {
            const extension = filename.split('.').pop().toLowerCase();
            switch (extension) {
                case 'xlsx':
                case 'xls':
                    return 'fas fa-file-excel text-success';
                case 'csv':
                    return 'fas fa-file-csv text-success';
                case 'pdf':
                    return 'fas fa-file-pdf text-danger';
                case 'jpg':
                case 'jpeg':
                case 'png':
                    return 'fas fa-file-image text-warning';
                default:
                    return 'fas fa-file text-secondary';
            }
        }

        // Manual Entry Toggle
        document.getElementById('manualEntryBtn').addEventListener('click', function() {
            const manualForm = document.getElementById('manualEntryForm');
            const uploadSection = document.querySelector('.upload-section');

            if (manualForm.style.display === 'block') {
                manualForm.style.display = 'none';
                uploadSection.style.display = 'block';
                this.innerHTML = '<i class="fas fa-keyboard"></i><span>Manual Entry</span>';
            } else {
                manualForm.style.display = 'block';
                uploadSection.style.display = 'none';
                this.innerHTML = '<i class="fas fa-upload"></i><span>File Upload</span>';
            }
        });

        document.getElementById('cancelManualEntryBtn').addEventListener('click', function() {
            document.getElementById('manualEntryForm').style.display = 'none';
            document.querySelector('.upload-section').style.display = 'block';
            document.getElementById('manualEntryBtn').innerHTML = '<i class="fas fa-keyboard"></i><span>Manual Entry</span>';
        });

        // Add More Positions
        document.getElementById('addMorePositionsBtn').addEventListener('click', function() {
            const positionsContainer = document.getElementById('manualResultsForm');
            const positionNumber = document.querySelectorAll('.result-row').length + 1;

            const newPosition = document.createElement('div');
            newPosition.className = 'result-row';
            newPosition.innerHTML = `
        <div class="result-row-header">
          <div class="result-position">
            <span class="badge bg-secondary me-2">${positionNumber}</span>
            ${positionNumber}${getOrdinalSuffix(positionNumber)} Place
          </div>
          <button type="button" class="btn btn-sm btn-danger remove-position-btn">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div class="form-grid">
          <div>
            <label class="form-label">Team/School</label>
            <input type="text" class="form-control" placeholder="Enter team/school" required>
          </div>
          <div>
            <label class="form-label">Score/Points</label>
            <input type="text" class="form-control" placeholder="Enter score/points" required>
          </div>
          <div>
            <label class="form-label">Captain Name</label>
            <input type="text" class="form-control" placeholder="Enter captain name" required>
          </div>
          <div>
            <label class="form-label">Points Awarded</label>
            <input type="number" class="form-control" placeholder="Points" min="0">
          </div>
        </div>
      `;

            positionsContainer.insertBefore(newPosition, this.parentElement.parentElement);

            // Add remove button functionality
            newPosition.querySelector('.remove-position-btn').addEventListener('click', function() {
                newPosition.remove();
                updatePositionNumbers();
            });

            showNotification(`Added ${positionNumber}${getOrdinalSuffix(positionNumber)} position`, 'info');
        });

        function getOrdinalSuffix(n) {
            const s = ["th", "st", "nd", "rd"];
            const v = n % 100;
            return s[(v - 20) % 10] || s[v] || s[0];
        }

        function updatePositionNumbers() {
            const positions = document.querySelectorAll('.result-row');
            positions.forEach((row, index) => {
                const positionNumber = index + 1;
                const positionBadge = row.querySelector('.badge');
                const positionText = row.querySelector('.result-position');

                if (positionBadge) {
                    positionBadge.textContent = positionNumber;
                }

                if (positionText) {
                    const prefix = positionText.textContent.split(' ')[0];
                    positionText.innerHTML = `<span class="badge bg-secondary me-2">${positionNumber}</span>${positionNumber}${getOrdinalSuffix(positionNumber)} Place`;
                }
            });
        }

        // Edit Results Actions
        document.querySelectorAll('.btn-edit[data-id]').forEach(btn => {
            btn.addEventListener('click', function() {
                const resultId = this.getAttribute('data-id');
                openEditResultModal(resultId);
            });
        });

        document.getElementById('editResultsBtn').addEventListener('click', function() {
            showNotification('Entering edit mode for all results', 'info');
            // In real application, this would enable inline editing
            document.querySelectorAll('.btn-action').forEach(btn => {
                btn.style.display = 'inline-flex';
            });
        });

        function openEditResultModal(resultId) {
            // In real application, this would load result data based on ID
            const modal = new bootstrap.Modal(document.getElementById('editResultModal'));
            modal.show();

            // Set form values based on resultId
            console.log(`Editing result ID: ${resultId}`);
        }

        // Bulk Actions
        document.getElementById('bulkPublishBtn').addEventListener('click', function() {
            const selectedCount = document.querySelectorAll('.form-check-input:checked').length;
            if (selectedCount === 0) {
                alert('Please select at least one result.');
                return;
            }

            if (confirm(`Publish ${selectedCount} selected result(s)?`)) {
                showNotification(`${selectedCount} result(s) published successfully`, 'success');
            }
        });

        // Export Functions
        document.getElementById('exportResultsExcelBtn').addEventListener('click', function() {
            showNotification('Exporting results to Excel...', 'info');
            // In real application, this would trigger export
        });

        document.getElementById('exportResultsPDFBtn').addEventListener('click', function() {
            showNotification('Exporting results to PDF...', 'info');
            // In real application, this would trigger export
        });

        document.getElementById('exportResultsCSVBtn').addEventListener('click', function() {
            showNotification('Exporting results to CSV...', 'info');
            // In real application, this would trigger export
        });

        document.getElementById('printResultsBtn').addEventListener('click', function() {
            window.print();
        });

        // Form Submission
        document.getElementById('manualResultsForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Validate form
            const requiredFields = this.querySelectorAll('[required]');
            let valid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    valid = false;
                    field.style.borderColor = '#dc3545';
                } else {
                    field.style.borderColor = '#e9ecef';
                }
            });

            if (!valid) {
                alert('Please fill all required fields.');
                return;
            }

            // In real application, this would submit data to server
            showNotification('Results saved and published successfully!', 'success');

            // Reset form
            this.reset();
            document.getElementById('manualEntryForm').style.display = 'none';
            document.querySelector('.upload-section').style.display = 'block';
        });

        // Save Draft
        document.getElementById('saveDraftBtn').addEventListener('click', function() {
            showNotification('Results saved as draft', 'info');
            // In real application, this would save draft to server
        });

        // Upload Button
        document.getElementById('uploadBtn').addEventListener('click', function() {
            fileInput.click();
        });

        // Show notification function
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

        // Initial setup
        updateEventDetails('Football Tournament', 'Published');
    </script>

</body>

</html>