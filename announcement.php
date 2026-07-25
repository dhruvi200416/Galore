<!DOCTYPE html>
<html lang="en">

<head>
    <title>Announcement Manager - Galore</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- AOS CSS for scroll animations -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- TinyMCE or Quill for rich text editor -->
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

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

        /* Create Announcement Card */
        .create-announcement-card {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 40px;
            border-left: 8px solid var(--galore-red);
        }

        .create-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }

        /* Form Styles */
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

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        /* Rich Text Editor */
        .editor-container {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            margin-bottom: 20px;
            overflow: hidden;
        }

        #announcementEditor {
            min-height: 200px;
            padding: 15px;
        }

        /* Priority Badges */
        .priority-badges {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .priority-badge {
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .priority-badge:hover {
            transform: translateY(-2px);
        }

        .priority-badge.active {
            border-color: currentColor;
        }

        .priority-high {
            background: rgba(220, 53, 69, 0.15);
            color: #dc3545;
        }

        .priority-medium {
            background: rgba(255, 193, 7, 0.15);
            color: #ffc107;
        }

        .priority-low {
            background: rgba(40, 167, 69, 0.15);
            color: #28a745;
        }

        /* Target Audience */
        .audience-selector {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }

        .audience-item {
            padding: 8px 20px;
            border-radius: 50px;
            background: #f8f9fa;
            color: var(--galore-dark);
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .audience-item:hover {
            background: #e9ecef;
        }

        .audience-item.active {
            background: var(--galore-red);
            color: white;
            border-color: var(--galore-red);
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn-action {
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

        .btn-publish {
            background: var(--galore-red);
            color: white;
        }

        .btn-publish:hover {
            background: var(--galore-red-dark);
            transform: translateY(-3px);
        }

        .btn-save {
            background: #f8f9fa;
            color: var(--galore-dark);
            border: 2px solid #dee2e6;
        }

        .btn-save:hover {
            background: #e9ecef;
            transform: translateY(-3px);
        }

        .btn-preview {
            background: #007bff;
            color: white;
        }

        .btn-preview:hover {
            background: #0056b3;
            transform: translateY(-3px);
        }

        /* Announcements Grid */
        .announcements-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .announcement-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
        }

        .announcement-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
        }

        .announcement-header {
            padding: 20px;
            position: relative;
        }

        .announcement-priority {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 6px 15px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .announcement-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--galore-dark);
            margin-bottom: 10px;
            line-height: 1.4;
        }

        .announcement-meta {
            display: flex;
            align-items: center;
            gap: 15px;
            color: var(--galore-gray);
            font-size: 0.9rem;
            margin-bottom: 15px;
        }

        .announcement-content {
            padding: 0 20px 20px;
        }

        .announcement-excerpt {
            color: #444;
            line-height: 1.6;
            margin-bottom: 20px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .announcement-footer {
            padding: 15px 20px;
            background: #f8f9fa;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .announcement-audience {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.85rem;
            color: var(--galore-gray);
        }

        .announcement-actions {
            display: flex;
            gap: 10px;
        }

        .btn-card-action {
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

        .btn-card-action:hover {
            background: var(--galore-red);
            color: white;
            transform: scale(1.1);
        }

        /* Schedule Announcement */
        .schedule-section {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 40px;
        }

        .schedule-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
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

        /* Announcement Table */
        .announcement-table-container {
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

        .status-published {
            background: rgba(40, 167, 69, 0.15);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .status-scheduled {
            background: rgba(0, 123, 255, 0.15);
            color: #007bff;
            border: 1px solid rgba(0, 123, 255, 0.3);
        }

        .status-draft {
            background: rgba(108, 117, 125, 0.15);
            color: #6c757d;
            border: 1px solid rgba(108, 117, 125, 0.3);
        }

        /* Preview Modal */
        .preview-modal-content {
            border-radius: 16px;
            overflow: hidden;
        }

        .preview-modal-header {
            background: linear-gradient(135deg, var(--galore-red) 0%, var(--galore-red-dark) 100%);
            color: white;
            padding: 25px;
        }

        .preview-modal-title {
            font-weight: 700;
            font-size: 1.5rem;
        }

        /* Quill Editor Customization */
        .ql-toolbar {
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            border-color: #e9ecef !important;
            background: #f8f9fa;
        }

        .ql-container {
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
            border-color: #e9ecef !important;
            font-family: "Segoe UI", Arial, sans-serif;
        }

        /* DataTables Custom Styling */
        .dataTables_wrapper {
            margin-top: 20px;
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .announcements-grid {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            }

            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .section-title {
                font-size: 1.6rem;
            }

            .announcements-grid {
                grid-template-columns: 1fr;
            }

            .bulk-action-buttons {
                flex-direction: column;
            }

            .btn-bulk {
                width: 100%;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-action {
                width: 100%;
                justify-content: center;
            }

            .announcement-meta {
                flex-direction: column;
                gap: 8px;
                align-items: flex-start;
            }
        }

        @media (max-width: 576px) {
            .stat-number {
                font-size: 1.8rem;
            }

            .priority-badges,
            .audience-selector,
            .filter-badges {
                justify-content: center;
            }

            .create-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .announcement-footer {
                flex-direction: column;
                gap: 15px;
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
                <h1 class="display-5 fw-bold mb-3" data-aos="fade-up">Announcement Manager</h1>
                <p class="lead mb-4" data-aos="fade-up" data-aos-delay="100">
                    Create, schedule, and manage announcements for Galore 2024
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
                    <i class="fas fa-bullhorn"></i>
                </div>
                <div class="stat-number">28</div>
                <div class="stat-label">Total Announcements</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="stat-number">22</div>
                <div class="stat-label">Published</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-number">4</div>
                <div class="stat-label">Scheduled</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <div class="stat-number">2</div>
                <div class="stat-label">Drafts</div>
            </div>
        </div>

        <!-- Create Announcement -->
        <div class="create-announcement-card" data-aos="fade-up">
            <div class="create-header">
                <div>
                    <h3 class="section-title">Create Announcement</h3>
                    <p class="section-subtitle">Share important updates with participants</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn-action btn-preview" id="previewBtn">
                        <i class="fas fa-eye"></i>
                        <span>Preview</span>
                    </button>
                </div>
            </div>

            <form id="announcementForm">
                <!-- Basic Information -->
                <div class="form-grid mb-4">
                    <div>
                        <label class="form-label">Announcement Title *</label>
                        <input type="text" class="form-control" placeholder="Enter announcement title" required>
                    </div>
                    <div>
                        <label class="form-label">Announcement Type</label>
                        <select class="form-select">
                            <option value="general">General Announcement</option>
                            <option value="event">Event Update</option>
                            <option value="schedule">Schedule Change</option>
                            <option value="emergency">Emergency Alert</option>
                            <option value="result">Results Announcement</option>
                            <option value="reminder">Reminder</option>
                        </select>
                    </div>
                </div>

                <!-- Priority Selection -->
                <div class="mb-4">
                    <label class="form-label">Priority Level</label>
                    <div class="priority-badges">
                        <div class="priority-badge priority-high active" data-priority="high">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>High Priority</span>
                        </div>
                        <div class="priority-badge priority-medium" data-priority="medium">
                            <i class="fas fa-info-circle"></i>
                            <span>Medium Priority</span>
                        </div>
                        <div class="priority-badge priority-low" data-priority="low">
                            <i class="fas fa-check-circle"></i>
                            <span>Low Priority</span>
                        </div>
                    </div>
                </div>

                <!-- Target Audience -->
                <div class="mb-4">
                    <label class="form-label">Target Audience</label>
                    <div class="audience-selector">
                        <div class="audience-item active" data-audience="all">All Participants</div>
                        <div class="audience-item" data-audience="engineering">School of Engineering</div>
                        <div class="audience-item" data-audience="commerce">School of Management</div>
                        <div class="audience-item" data-audience="science">School of Science</div>
                        <div class="audience-item" data-audience="sports">Sports Participants</div>
                        <div class="audience-item" data-audience="cultural">Cultural Participants</div>
                    </div>
                </div>

                <!-- Rich Text Editor -->
                <div class="mb-4">
                    <label class="form-label">Announcement Content *</label>
                    <div class="editor-container">
                        <div id="announcementEditor">
                            <p>Dear Participants,</p>
                            <p><br></p>
                            <p>This is your announcement content. You can format text, add links, insert images, and more using the toolbar above.</p>
                            <p><br></p>
                            <p>Best regards,</p>
                            <p>Galore Coordination Team</p>
                        </div>
                    </div>
                </div>

                <!-- Schedule Options -->
                <div class="schedule-section">
                    <div class="schedule-toggle">
                        <input type="checkbox" id="scheduleToggle" class="form-check-input">
                        <label class="form-check-label fw-bold" for="scheduleToggle">
                            Schedule for Later
                        </label>
                    </div>

                    <div class="form-grid" id="scheduleFields" style="display: none;">
                        <div>
                            <label class="form-label">Schedule Date</label>
                            <input type="date" class="form-control" min="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div>
                            <label class="form-label">Schedule Time</label>
                            <input type="time" class="form-control">
                        </div>
                        <div>
                            <label class="form-label">Expiry Date (Optional)</label>
                            <input type="date" class="form-control">
                        </div>
                    </div>
                </div>

                <!-- Additional Options -->
                <div class="form-grid mb-4">
                    <div>
                        <label class="form-label">Attachments (Optional)</label>
                        <input type="file" class="form-control" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        <small class="text-muted">Max file size: 10MB each</small>
                    </div>
                    <div>
                        <label class="form-label">Notification Method</label>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="notifyEmail" checked>
                            <label class="form-check-label" for="notifyEmail">
                                Send Email Notification
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="notifySMS">
                            <label class="form-check-label" for="notifySMS">
                                Send SMS Alert
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="pushNotification" checked>
                            <label class="form-check-label" for="pushNotification">
                                Push Notification
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <button type="button" class="btn-action btn-save" id="saveDraftBtn">
                        <i class="fas fa-save"></i>
                        <span>Save as Draft</span>
                    </button>
                    <button type="submit" class="btn-action btn-publish">
                        <i class="fas fa-paper-plane"></i>
                        <span>Publish Announcement</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Filter Section -->
        <div class="filter-section" data-aos="fade-up">
            <h5 class="fw-bold mb-3">Filter Announcements</h5>
            <div class="filter-badges">
                <span class="filter-badge active" data-filter="all">All (28)</span>
                <span class="filter-badge" data-filter="published">Published (22)</span>
                <span class="filter-badge" data-filter="scheduled">Scheduled (4)</span>
                <span class="filter-badge" data-filter="draft">Drafts (2)</span>
                <span class="filter-badge" data-filter="high">High Priority (8)</span>
                <span class="filter-badge" data-filter="engineering">Engineering (12)</span>
                <span class="filter-badge" data-filter="today">Today (3)</span>
            </div>
        </div>

        <!-- Bulk Actions -->
        <div class="bulk-actions" data-aos="fade-up">
            <h5 class="fw-bold mb-3">Bulk Actions</h5>
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="selectAllAnnouncements">
                <label class="form-check-label" for="selectAllAnnouncements">
                    Select all announcements
                </label>
            </div>
            <div class="bulk-action-buttons">
                <button class="btn-bulk btn-bulk-publish" id="bulkPublishBtn">
                    <i class="fas fa-paper-plane"></i>
                    <span>Publish Selected</span>
                </button>
                <button class="btn-bulk" style="background: #f8f9fa; color: var(--galore-dark); border: 2px solid #dee2e6;">
                    <i class="fas fa-trash"></i>
                    <span>Delete Selected</span>
                </button>
                <button class="btn-bulk" style="background: rgba(0, 123, 255, 0.15); color: #007bff; border: 2px solid rgba(0, 123, 255, 0.3);">
                    <i class="fas fa-download"></i>
                    <span>Export Selected</span>
                </button>
            </div>
        </div>

        <!-- Announcements Grid -->
        <div class="announcements-grid" data-aos="fade-up">
            <!-- Announcement 1 - High Priority -->
            <div class="announcement-card">
                <div class="announcement-header">
                    <div class="announcement-priority priority-high">
                        <i class="fas fa-exclamation-circle me-1"></i>High
                    </div>
                    <h4 class="announcement-title">Football Quarter-Finals Schedule Change</h4>
                    <div class="announcement-meta">
                        <span><i class="far fa-calendar me-1"></i>Mar 20, 2024</span>
                        <span><i class="far fa-clock me-1"></i>10:30 AM</span>
                        <span><i class="fas fa-user-tie me-1"></i>Rahul Sharma</span>
                    </div>
                </div>
                <div class="announcement-content">
                    <p class="announcement-excerpt">
                        Important update: The Football Quarter-Finals match between School of Engineering and School of Commerce has been rescheduled...
                    </p>
                </div>
                <div class="announcement-footer">
                    <div class="announcement-audience">
                        <i class="fas fa-users me-1"></i>
                        <span>All Participants</span>
                    </div>
                    <div class="announcement-actions">
                        <button class="btn-card-action" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-card-action" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                        <button class="btn-card-action" title="View">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Announcement 2 - Medium Priority -->
            <div class="announcement-card">
                <div class="announcement-header">
                    <div class="announcement-priority priority-medium">
                        <i class="fas fa-info-circle me-1"></i>Medium
                    </div>
                    <h4 class="announcement-title">Robotics Competition Results Published</h4>
                    <div class="announcement-meta">
                        <span><i class="far fa-calendar me-1"></i>Mar 18, 2024</span>
                        <span><i class="far fa-clock me-1"></i>3:15 PM</span>
                        <span><i class="fas fa-user-tie me-1"></i>Prof. Rajesh Kumar</span>
                    </div>
                </div>
                <div class="announcement-content">
                    <p class="announcement-excerpt">
                        The results for the Robotics Competition are now available. School of Engineering secured first place with their innovative autonomous delivery robot...
                    </p>
                </div>
                <div class="announcement-footer">
                    <div class="announcement-audience">
                        <i class="fas fa-users me-1"></i>
                        <span>Technical Participants</span>
                    </div>
                    <div class="announcement-actions">
                        <button class="btn-card-action" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-card-action" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                        <button class="btn-card-action" title="View">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Announcement 3 - Scheduled -->
            <div class="announcement-card">
                <div class="announcement-header">
                    <div class="announcement-priority priority-low">
                        <i class="fas fa-clock me-1"></i>Scheduled
                    </div>
                    <h4 class="announcement-title">Cultural Events Dress Rehearsal</h4>
                    <div class="announcement-meta">
                        <span><i class="far fa-calendar me-1"></i>Mar 22, 2024</span>
                        <span><i class="far fa-clock me-1"></i>Scheduled for 9:00 AM</span>
                        <span><i class="fas fa-user-tie me-1"></i>Priya Mehta</span>
                    </div>
                </div>
                <div class="announcement-content">
                    <p class="announcement-excerpt">
                        Reminder: All cultural event participants are required to attend the final dress rehearsal tomorrow at the Cultural Hall. Please arrive 30 minutes early...
                    </p>
                </div>
                <div class="announcement-footer">
                    <div class="announcement-audience">
                        <i class="fas fa-users me-1"></i>
                        <span>Cultural Participants</span>
                    </div>
                    <div class="announcement-actions">
                        <button class="btn-card-action" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-card-action" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                        <button class="btn-card-action" title="View">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Announcement Table -->
        <div class="announcement-table-container" data-aos="fade-up">
            <h3 class="section-title">All Announcements</h3>
            <p class="section-subtitle">Complete list of announcements with management options</p>

            <table id="announcementsTable" class="table table-hover w-100">
                <thead>
                    <tr>
                        <th width="50">
                            <input type="checkbox" id="selectAllTable">
                        </th>
                        <th>Title</th>
                        <th>Priority</th>
                        <th>Audience</th>
                        <th>Date & Time</th>
                        <th>Status</th>
                        <th>Author</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Row 1 -->
                    <tr>
                        <td>
                            <input type="checkbox" class="announcement-checkbox" data-id="1">
                        </td>
                        <td>
                            <strong>Football Quarter-Finals Schedule Change</strong>
                            <div class="small text-muted">Important update about match timing</div>
                        </td>
                        <td>
                            <span class="announcement-priority priority-high">High</span>
                        </td>
                        <td>All Participants</td>
                        <td>
                            <div>Mar 20, 2024</div>
                            <div class="small text-muted">10:30 AM</div>
                        </td>
                        <td>
                            <span class="status-badge status-published">Published</span>
                        </td>
                        <td>Rahul Sharma</td>
                        <td>
                            <div class="action-buttons-small">
                                <button class="btn-card-action" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-card-action" title="View">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-card-action" title="Statistics">
                                    <i class="fas fa-chart-bar"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 2 -->
                    <tr>
                        <td>
                            <input type="checkbox" class="announcement-checkbox" data-id="2">
                        </td>
                        <td>
                            <strong>Robotics Competition Results</strong>
                            <div class="small text-muted">Winners announced and prize distribution</div>
                        </td>
                        <td>
                            <span class="announcement-priority priority-medium">Medium</span>
                        </td>
                        <td>Technical Participants</td>
                        <td>
                            <div>Mar 18, 2024</div>
                            <div class="small text-muted">3:15 PM</div>
                        </td>
                        <td>
                            <span class="status-badge status-published">Published</span>
                        </td>
                        <td>Prof. Rajesh Kumar</td>
                        <td>
                            <div class="action-buttons-small">
                                <button class="btn-card-action" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-card-action" title="View">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-card-action" title="Statistics">
                                    <i class="fas fa-chart-bar"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 3 - Scheduled -->
                    <tr>
                        <td>
                            <input type="checkbox" class="announcement-checkbox" data-id="3">
                        </td>
                        <td>
                            <strong>Cultural Events Dress Rehearsal</strong>
                            <div class="small text-muted">Final rehearsal schedule and requirements</div>
                        </td>
                        <td>
                            <span class="announcement-priority priority-low">Low</span>
                        </td>
                        <td>Cultural Participants</td>
                        <td>
                            <div>Mar 22, 2024</div>
                            <div class="small text-muted">Scheduled: 9:00 AM</div>
                        </td>
                        <td>
                            <span class="status-badge status-scheduled">Scheduled</span>
                        </td>
                        <td>Priya Mehta</td>
                        <td>
                            <div class="action-buttons-small">
                                <button class="btn-card-action" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-card-action" title="View">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-card-action" title="Publish Now">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 4 - Draft -->
                    <tr>
                        <td>
                            <input type="checkbox" class="announcement-checkbox" data-id="4">
                        </td>
                        <td>
                            <strong>Singing Competition Guidelines</strong>
                            <div class="small text-muted">Rules and regulations for participants</div>
                        </td>
                        <td>
                            <span class="announcement-priority priority-medium">Medium</span>
                        </td>
                        <td>Cultural Participants</td>
                        <td>
                            <div>Draft</div>
                            <div class="small text-muted">Last edited: Today</div>
                        </td>
                        <td>
                            <span class="status-badge status-draft">Draft</span>
                        </td>
                        <td>Rahul Sharma</td>
                        <td>
                            <div class="action-buttons-small">
                                <button class="btn-card-action" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-card-action" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <button class="btn-card-action" title="Publish">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

    <!-- Preview Modal -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content preview-modal-content">
                <div class="preview-modal-header">
                    <h5 class="modal-title preview-modal-title" id="previewModalLabel">
                        <i class="fas fa-eye me-2"></i>Announcement Preview
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div id="previewContent">
                        <!-- Preview content will be loaded here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Edit Announcement
                    </button>
                    <button type="button" class="btn btn-success">
                        <i class="fas fa-paper-plane me-2"></i>Publish Now
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <!-- Quill Editor JS -->
    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>

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

        // Initialize Quill Editor
        const quill = new Quill('#announcementEditor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],
                    [{
                        'header': 1
                    }, {
                        'header': 2
                    }],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    [{
                        'script': 'sub'
                    }, {
                        'script': 'super'
                    }],
                    [{
                        'indent': '-1'
                    }, {
                        'indent': '+1'
                    }],
                    [{
                        'direction': 'rtl'
                    }],
                    [{
                        'size': ['small', false, 'large', 'huge']
                    }],
                    [{
                        'header': [1, 2, 3, 4, 5, 6, false]
                    }],
                    [{
                        'color': []
                    }, {
                        'background': []
                    }],
                    [{
                        'font': []
                    }],
                    [{
                        'align': []
                    }],
                    ['clean'],
                    ['link', 'image', 'video']
                ]
            }
        });

        // Initialize DataTable
        $(document).ready(function() {
            $('#announcementsTable').DataTable({
                pageLength: 10,
                responsive: true,
                language: {
                    search: "Search announcements:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ announcements"
                }
            });
        });

        // Priority Selection
        document.querySelectorAll('.priority-badge').forEach(badge => {
            badge.addEventListener('click', function() {
                // Remove active class from all badges
                document.querySelectorAll('.priority-badge').forEach(b => {
                    b.classList.remove('active');
                });

                // Add active class to clicked badge
                this.classList.add('active');

                const priority = this.getAttribute('data-priority');
                console.log(`Selected priority: ${priority}`);
            });
        });

        // Audience Selection
        document.querySelectorAll('.audience-item').forEach(item => {
            item.addEventListener('click', function() {
                // Toggle active class
                this.classList.toggle('active');

                const audience = this.getAttribute('data-audience');
                const isActive = this.classList.contains('active');
                console.log(`Audience ${audience}: ${isActive ? 'selected' : 'deselected'}`);
            });
        });

        // Filter Selection
        document.querySelectorAll('.filter-badge').forEach(badge => {
            badge.addEventListener('click', function() {
                // Remove active class from all badges
                document.querySelectorAll('.filter-badge').forEach(b => {
                    b.classList.remove('active');
                });

                // Add active class to clicked badge
                this.classList.add('active');

                const filter = this.getAttribute('data-filter');
                filterAnnouncements(filter);
            });
        });

        function filterAnnouncements(filter) {
            const cards = document.querySelectorAll('.announcement-card');
            const tableRows = document.querySelectorAll('#announcementsTable tbody tr');

            cards.forEach(card => {
                card.style.display = 'block';
            });

            tableRows.forEach(row => {
                row.style.display = '';
            });

            if (filter === 'all') {
                showNotification('Showing all announcements', 'info');
                return;
            }

            // Filter logic for cards
            cards.forEach(card => {
                const priority = card.querySelector('.announcement-priority').classList.contains(filter);
                const audience = card.querySelector('.announcement-audience span').textContent.toLowerCase().includes(filter);

                if (!priority && !audience) {
                    card.style.display = 'none';
                }
            });

            // Filter logic for table rows
            tableRows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                if (!rowText.includes(filter)) {
                    row.style.display = 'none';
                }
            });

            showNotification(`Filtered by: ${filter}`, 'info');
        }

        // Schedule Toggle
        const scheduleToggle = document.getElementById('scheduleToggle');
        const scheduleFields = document.getElementById('scheduleFields');

        scheduleToggle.addEventListener('change', function() {
            if (this.checked) {
                scheduleFields.style.display = 'grid';
                showNotification('Scheduling enabled', 'info');
            } else {
                scheduleFields.style.display = 'none';
            }
        });

        // Preview Functionality
        document.getElementById('previewBtn').addEventListener('click', function() {
            const title = document.querySelector('input[type="text"]').value || 'Announcement Preview';
            const content = quill.root.innerHTML;
            const priority = document.querySelector('.priority-badge.active').textContent.trim();

            const previewHTML = `
        <div class="preview-card">
          <div class="announcement-header">
            <div class="announcement-priority ${getPriorityClass(priority)}">
              <i class="fas ${getPriorityIcon(priority)} me-1"></i>${priority}
            </div>
            <h3 class="announcement-title">${title}</h3>
            <div class="announcement-meta">
              <span><i class="far fa-calendar me-1"></i>${new Date().toLocaleDateString()}</span>
              <span><i class="far fa-clock me-1"></i>${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</span>
              <span><i class="fas fa-user-tie me-1"></i>Rahul Sharma</span>
            </div>
          </div>
          <div class="announcement-content mt-3">
            <div class="announcement-excerpt" style="-webkit-line-clamp: none;">
              ${content}
            </div>
          </div>
        </div>
      `;

            document.getElementById('previewContent').innerHTML = previewHTML;

            const modal = new bootstrap.Modal(document.getElementById('previewModal'));
            modal.show();
        });

        function getPriorityClass(priority) {
            if (priority.includes('High')) return 'priority-high';
            if (priority.includes('Medium')) return 'priority-medium';
            return 'priority-low';
        }

        function getPriorityIcon(priority) {
            if (priority.includes('High')) return 'fa-exclamation-circle';
            if (priority.includes('Medium')) return 'fa-info-circle';
            return 'fa-check-circle';
        }

        // Save Draft
        document.getElementById('saveDraftBtn').addEventListener('click', function() {
            if (validateForm()) {
                showNotification('Announcement saved as draft', 'info');
                // In real application, save to server
            }
        });

        // Form Submission
        document.getElementById('announcementForm').addEventListener('submit', function(e) {
            e.preventDefault();

            if (!validateForm()) {
                return;
            }

            const isScheduled = scheduleToggle.checked;
            const action = isScheduled ? 'scheduled' : 'published';

            showNotification(`Announcement ${action} successfully!`, 'success');

            // Reset form
            this.reset();
            quill.setText('');
            scheduleFields.style.display = 'none';
            scheduleToggle.checked = false;

            // Reset priority and audience selections
            document.querySelectorAll('.priority-badge').forEach((b, i) => {
                b.classList.toggle('active', i === 0);
            });

            document.querySelectorAll('.audience-item').forEach((a, i) => {
                a.classList.toggle('active', i === 0);
            });
        });

        function validateForm() {
            const title = document.querySelector('input[type="text"]').value;
            const content = quill.getText().trim();

            if (!title) {
                showNotification('Please enter announcement title', 'danger');
                return false;
            }

            if (content.length < 10) {
                showNotification('Please enter announcement content', 'danger');
                return false;
            }

            return true;
        }

        // Bulk Actions
        document.getElementById('selectAllAnnouncements').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.announcement-checkbox');
            const tableCheckbox = document.getElementById('selectAllTable');

            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });

            tableCheckbox.checked = this.checked;
        });

        document.getElementById('selectAllTable').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.announcement-checkbox');
            const bulkCheckbox = document.getElementById('selectAllAnnouncements');

            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });

            bulkCheckbox.checked = this.checked;
        });

        // Individual checkboxes
        document.querySelectorAll('.announcement-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateBulkSelection);
        });

        function updateBulkSelection() {
            const checkboxes = document.querySelectorAll('.announcement-checkbox');
            const selectAll = document.getElementById('selectAllTable');
            const selectAllBulk = document.getElementById('selectAllAnnouncements');

            const checkedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
            const totalCount = checkboxes.length;

            selectAll.checked = checkedCount === totalCount;
            selectAllBulk.checked = checkedCount === totalCount;
        }

        document.getElementById('bulkPublishBtn').addEventListener('click', function() {
            const selectedIds = getSelectedAnnouncementIds();
            if (selectedIds.length === 0) {
                alert('Please select at least one announcement.');
                return;
            }

            if (confirm(`Publish ${selectedIds.length} selected announcement(s)?`)) {
                selectedIds.forEach(id => {
                    // Update status in UI
                    const row = document.querySelector(`.announcement-checkbox[data-id="${id}"]`).closest('tr');
                    const statusBadge = row.querySelector('.status-badge');
                    if (statusBadge) {
                        statusBadge.className = 'status-badge status-published';
                        statusBadge.textContent = 'Published';
                    }
                });

                showNotification(`${selectedIds.length} announcement(s) published`, 'success');
                clearSelections();
            }
        });

        function getSelectedAnnouncementIds() {
            const checkboxes = document.querySelectorAll('.announcement-checkbox:checked');
            return Array.from(checkboxes).map(cb => cb.getAttribute('data-id'));
        }

        function clearSelections() {
            document.querySelectorAll('.announcement-checkbox').forEach(cb => {
                cb.checked = false;
            });
            document.getElementById('selectAllTable').checked = false;
            document.getElementById('selectAllAnnouncements').checked = false;
        }

        // Card Actions
        document.querySelectorAll('.btn-card-action').forEach(btn => {
            btn.addEventListener('click', function() {
                const action = this.querySelector('i').className;
                const card = this.closest('.announcement-card');
                const title = card ? card.querySelector('.announcement-title').textContent : 'Announcement';

                if (action.includes('fa-edit')) {
                    showNotification(`Editing: ${title}`, 'info');
                    // In real application, load into editor
                } else if (action.includes('fa-trash')) {
                    if (confirm(`Delete "${title}"?`)) {
                        if (card) {
                            card.style.transform = 'scale(0.9)';
                            card.style.opacity = '0';
                            setTimeout(() => {
                                card.remove();
                                showNotification('Announcement deleted', 'warning');
                            }, 300);
                        }
                    }
                } else if (action.includes('fa-eye')) {
                    showNotification(`Viewing: ${title}`, 'info');
                    // In real application, open view modal
                } else if (action.includes('fa-chart-bar')) {
                    showNotification(`Viewing statistics for: ${title}`, 'info');
                } else if (action.includes('fa-paper-plane')) {
                    showNotification(`Publishing: ${title}`, 'success');
                }
            });
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
    </script>

</body>

</html>