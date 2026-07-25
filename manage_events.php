<!DOCTYPE html>
<html lang="en">

<head>
    <title>Event Manager - Galore</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- AOS CSS for scroll animations -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Flatpickr for date/time picker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

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

        /* Event Header */
        .event-header-card {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 40px;
            position: relative;
            overflow: hidden;
            border-left: 8px solid var(--galore-red);
        }

        .event-header-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .status-active {
            background: rgba(40, 167, 69, 0.15);
            color: #28a745;
        }

        .status-upcoming {
            background: rgba(0, 123, 255, 0.15);
            color: #007bff;
        }

        .status-cancelled {
            background: rgba(220, 53, 69, 0.15);
            color: #dc3545;
        }

        .status-completed {
            background: rgba(108, 117, 125, 0.15);
            color: #6c757d;
        }

        .event-category-tag {
            display: inline-block;
            padding: 6px 15px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-right: 10px;
            margin-bottom: 10px;
        }

        .category-sports {
            background: #e7f5e9;
            color: #28a745;
        }

        .category-cultural {
            background: #fff3cd;
            color: #ffc107;
        }

        .category-technical {
            background: #e7f0ff;
            color: #007bff;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 30px;
        }

        .btn-action-main {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 25px;
            border-radius: 12px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 160px;
            justify-content: center;
        }

        .btn-edit {
            background: var(--galore-red);
            color: white;
        }

        .btn-edit:hover {
            background: var(--galore-red-dark);
            transform: translateY(-3px);
        }

        .btn-cancel {
            background: #f8f9fa;
            color: var(--galore-dark);
            border: 2px solid #dee2e6;
        }

        .btn-cancel:hover {
            background: #dc3545;
            color: white;
            border-color: #dc3545;
            transform: translateY(-3px);
        }

        .btn-update {
            background: #007bff;
            color: white;
        }

        .btn-update:hover {
            background: #0056b3;
            transform: translateY(-3px);
        }

        .btn-archive {
            background: #6c757d;
            color: white;
        }

        .btn-archive:hover {
            background: #545b62;
            transform: translateY(-3px);
        }

        /* Edit Form */
        .edit-form-container {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 40px;
            display: none;
        }

        .form-section {
            margin-bottom: 30px;
            padding-bottom: 30px;
            border-bottom: 2px solid #f0f0f0;
        }

        .form-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .form-section-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--galore-red);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-label {
            font-weight: 600;
            color: var(--galore-dark);
            margin-bottom: 8px;
            display: block;
        }

        .form-control,
        .form-select,
        .form-textarea {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 12px 15px;
            transition: all 0.3s ease;
            width: 100%;
        }

        .form-control:focus,
        .form-select:focus,
        .form-textarea:focus {
            border-color: var(--galore-red);
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
            outline: none;
        }

        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        /* Participants List */
        .participants-section {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 40px;
        }

        .participant-card {
            display: flex;
            align-items: center;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }

        .participant-card:hover {
            background: #e9ecef;
            transform: translateX(5px);
        }

        .participant-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--galore-red);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.2rem;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .participant-info {
            flex: 1;
        }

        .participant-name {
            font-weight: 600;
            color: var(--galore-dark);
            margin-bottom: 3px;
        }

        .participant-details {
            color: var(--galore-gray);
            font-size: 0.9rem;
        }

        .participant-actions {
            display: flex;
            gap: 10px;
        }

        .btn-participant-action {
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

        .btn-participant-action:hover {
            background: var(--galore-red);
            color: white;
            transform: scale(1.1);
        }

        /* Cancel Event Modal */
        .cancel-modal-content {
            border-radius: 16px;
            overflow: hidden;
        }

        .cancel-modal-header {
            background: linear-gradient(135deg, var(--galore-red) 0%, var(--galore-red-dark) 100%);
            color: white;
            padding: 25px;
        }

        .cancel-modal-title {
            font-weight: 700;
            font-size: 1.5rem;
        }

        .cancel-modal-body {
            padding: 30px;
        }

        .cancel-reason-item {
            margin-bottom: 15px;
        }

        .cancel-reason-label {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 10px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .cancel-reason-label:hover {
            background: #f8f9fa;
        }

        /* Event History */
        .history-section {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .history-timeline {
            position: relative;
            padding-left: 30px;
        }

        .history-timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, #e9ecef, #e9ecef);
        }

        .history-item {
            position: relative;
            margin-bottom: 25px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 12px;
            border-left: 4px solid var(--galore-red);
        }

        .history-item::before {
            content: '';
            position: absolute;
            left: -25px;
            top: 25px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--galore-red);
            border: 3px solid white;
            box-shadow: 0 0 0 2px var(--galore-red);
        }

        .history-time {
            font-weight: 600;
            color: var(--galore-red);
            margin-bottom: 5px;
            font-size: 0.9rem;
        }

        .history-action {
            font-weight: 700;
            color: var(--galore-dark);
            margin-bottom: 5px;
        }

        .history-details {
            color: var(--galore-gray);
            font-size: 0.9rem;
            margin-bottom: 0;
        }

        /* Confirmation Dialog */
        .confirmation-dialog {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1050;
            min-width: 400px;
            max-width: 500px;
        }

        .confirmation-header {
            color: var(--galore-red);
            font-weight: 700;
            font-size: 1.5rem;
            margin-bottom: 20px;
            text-align: center;
        }

        .confirmation-message {
            color: var(--galore-gray);
            margin-bottom: 25px;
            text-align: center;
            font-size: 1.1rem;
        }

        .confirmation-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .confirmation-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1040;
            display: none;
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                justify-content: center;
            }

            .btn-action-main {
                min-width: 140px;
            }
        }

        @media (max-width: 768px) {
            .section-title {
                font-size: 1.6rem;
            }

            .event-header-card {
                padding: 20px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-action-main {
                width: 100%;
            }

            .confirmation-dialog {
                min-width: 300px;
                max-width: 90%;
            }

            .participant-card {
                flex-direction: column;
                text-align: center;
            }

            .participant-avatar {
                margin-right: 0;
                margin-bottom: 10px;
            }
        }

        @media (max-width: 576px) {
            .form-section-title {
                font-size: 1.1rem;
            }

            .cancel-modal-body {
                padding: 20px;
            }

            .confirmation-buttons {
                flex-direction: column;
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
                    <a href="events.php" class="back-button" data-aos="fade-right">
                        <i class="fas fa-arrow-left"></i> Back to Events
                    </a>
                </div>

                <!-- Page Title -->
                <h1 class="display-5 fw-bold mb-3" data-aos="fade-up">Event Management</h1>
                <p class="lead mb-4" data-aos="fade-up" data-aos-delay="100">
                    Edit, update, and manage your Galore events
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

        <!-- Event Header -->
        <div class="event-header-card" data-aos="fade-up">
            <div class="event-header-badge status-active">
                <i class="fas fa-circle me-2"></i>Active
            </div>

            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="display-6 fw-bold mb-3">Football Tournament - Quarter Finals</h2>
                    <div class="mb-4">
                        <span class="event-category-tag category-sports">Sports</span>
                        <span class="event-category-tag category-sports">Team Event</span>
                        <span class="event-category-tag category-sports">Outdoor</span>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-circle p-3 me-3">
                                    <i class="fas fa-calendar-alt text-primary fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Date & Time</h5>
                                    <p class="mb-0">March 21, 2024 | 9:00 AM - 11:00 AM</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-circle p-3 me-3">
                                    <i class="fas fa-map-marker-alt text-primary fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Venue</h5>
                                    <p class="mb-0">Main Football Ground</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-circle p-3 me-3">
                                    <i class="fas fa-users text-primary fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Participants</h5>
                                    <p class="mb-0">22 Participants | 2 Teams</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-circle p-3 me-3">
                                    <i class="fas fa-user-tie text-primary fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="mb-1">Coordinator</h5>
                                    <p class="mb-0">Rahul Sharma (Primary)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 text-center">
                    <div class="bg-light rounded-circle p-5 d-inline-flex mb-3">
                        <i class="fas fa-futbol text-primary fa-5x"></i>
                    </div>
                    <h5 class="fw-bold">Event ID: GAL-FB-2024-015</h5>
                    <p class="text-muted">Created: March 10, 2024</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons" data-aos="fade-up">
            <button class="btn-action-main btn-edit" id="editEventBtn">
                <i class="fas fa-edit"></i>
                <span>Edit Event</span>
            </button>
            <button class="btn-action-main btn-update" id="saveChangesBtn" style="display: none;">
                <i class="fas fa-save"></i>
                <span>Save Changes</span>
            </button>
            <button class="btn-action-main btn-cancel" id="cancelEventBtn">
                <i class="fas fa-times-circle"></i>
                <span>Cancel Event</span>
            </button>
            <button class="btn-action-main btn-archive">
                <i class="fas fa-archive"></i>
                <span>Archive Event</span>
            </button>
        </div>

        <!-- Edit Form -->
        <div class="edit-form-container" id="editForm">
            <h3 class="section-title mb-4">Edit Event Details</h3>

            <form id="eventEditForm">
                <!-- Basic Information -->
                <div class="form-section">
                    <h4 class="form-section-title">
                        <i class="fas fa-info-circle"></i>
                        Basic Information
                    </h4>

                    <div class="form-grid">
                        <div>
                            <label class="form-label">Event Name *</label>
                            <input type="text" class="form-control" value="Football Tournament - Quarter Finals" required>
                        </div>
                        <div>
                            <label class="form-label">Event Category *</label>
                            <select class="form-select" required>
                                <option value="sports" selected>Sports</option>
                                <option value="cultural">Cultural</option>
                                <option value="technical">Technical</option>
                                <option value="literary">Literary</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Sub Category</label>
                            <input type="text" class="form-control" value="Football - Outdoor">
                        </div>
                        <div>
                            <label class="form-label">Event Type *</label>
                            <select class="form-select" required>
                                <option value="team" selected>Team Event</option>
                                <option value="individual">Individual</option>
                                <option value="group">Group</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Event Description *</label>
                        <textarea class="form-textarea">Annual inter-department football championship with knockout format. School of Engineering vs School of Commerce in quarter finals. Winner advances to semi-finals.</textarea>
                    </div>
                </div>

                <!-- Schedule & Venue -->
                <div class="form-section">
                    <h4 class="form-section-title">
                        <i class="fas fa-calendar-alt"></i>
                        Schedule & Venue
                    </h4>

                    <div class="form-grid">
                        <div>
                            <label class="form-label">Start Date & Time *</label>
                            <input type="text" class="form-control datetime-picker" value="2024-03-21 09:00" required>
                        </div>
                        <div>
                            <label class="form-label">End Date & Time *</label>
                            <input type="text" class="form-control datetime-picker" value="2024-03-21 11:00" required>
                        </div>
                        <div>
                            <label class="form-label">Registration Deadline</label>
                            <input type="text" class="form-control datetime-picker" value="2024-03-20 18:00">
                        </div>
                        <div>
                            <label class="form-label">Venue *</label>
                            <input type="text" class="form-control" value="Main Football Ground" required>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div>
                            <label class="form-label">Max Participants</label>
                            <input type="number" class="form-control" value="22" min="1">
                        </div>
                        <div>
                            <label class="form-label">Max Teams</label>
                            <input type="number" class="form-control" value="2" min="1">
                        </div>
                        <div>
                            <label class="form-label">Team Size</label>
                            <input type="number" class="form-control" value="11" min="1">
                        </div>
                    </div>
                </div>

                <!-- Coordinators & Judges -->
                <div class="form-section">
                    <h4 class="form-section-title">
                        <i class="fas fa-user-tie"></i>
                        Coordinators & Judges
                    </h4>

                    <div class="form-grid">
                        <div>
                            <label class="form-label">Primary Coordinator *</label>
                            <select class="form-select" required>
                                <option value="rahul" selected>Rahul Sharma</option>
                                <option value="priya">Priya Mehta</option>
                                <option value="vikram">Vikram Singh</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Secondary Coordinator</label>
                            <select class="form-select">
                                <option value="">Select coordinator</option>
                                <option value="priya">Priya Mehta</option>
                                <option value="vikram" selected>Vikram Singh</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Chief Referee</label>
                            <input type="text" class="form-control" value="Prof. Ajay Verma">
                        </div>
                    </div>
                </div>

                <!-- Rules & Requirements -->
                <div class="form-section">
                    <h4 class="form-section-title">
                        <i class="fas fa-clipboard-list"></i>
                        Rules & Requirements
                    </h4>

                    <div class="mb-4">
                        <label class="form-label">Event Rules</label>
                        <textarea class="form-textarea">1. Standard FIFA rules apply
2. Each team consists of 11 players
3. Substitutions allowed: Maximum 3
4. Yellow card: Warning, Red card: Ejection
5. Match duration: 90 minutes (45 min halves)
6. Tie: Extra time (15 min each) then penalty shootout</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Equipment Required</label>
                        <textarea class="form-textarea">- Football (provided by organizers)
- Team jerseys (distinct colors)
- Football boots (cleats)
- Shin guards (mandatory)
- Goalkeeper gloves</textarea>
                    </div>

                    <div class="form-grid">
                        <div>
                            <label class="form-label">Registration Fee</label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" class="form-control" value="500" min="0">
                                <span class="input-group-text">per team</span>
                            </div>
                        </div>
                        <div>
                            <label class="form-label">Prize Money</label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" class="form-control" value="10000" min="0">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Advanced Settings -->
                <div class="form-section">
                    <h4 class="form-section-title">
                        <i class="fas fa-cog"></i>
                        Advanced Settings
                    </h4>

                    <div class="form-grid">
                        <div>
                            <label class="form-label">Event Status</label>
                            <select class="form-select">
                                <option value="draft">Draft</option>
                                <option value="scheduled" selected>Scheduled</option>
                                <option value="active">Active</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Visibility</label>
                            <select class="form-select">
                                <option value="public" selected>Public (All can see)</option>
                                <option value="private">Private (Coordinators only)</option>
                                <option value="school">School Specific</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Registration Status</label>
                            <select class="form-select">
                                <option value="open" selected>Open</option>
                                <option value="closed">Closed</option>
                                <option value="waiting">Waiting List</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Participants Section -->
        <div class="participants-section" data-aos="fade-up">
            <h3 class="section-title mb-4">Participants Management</h3>
            <p class="section-subtitle">22 Participants | 2 Teams Registered</p>

            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Team A - School of Engineering</h5>
                    <span class="badge bg-success">11 Players</span>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="participant-card">
                            <div class="participant-avatar">RS</div>
                            <div class="participant-info">
                                <div class="participant-name">Rahul Sharma (Captain)</div>
                                <div class="participant-details">Roll No: ENG2024001 | Forward</div>
                            </div>
                            <div class="participant-actions">
                                <button class="btn-participant-action" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-participant-action" title="Remove">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="participant-card">
                            <div class="participant-avatar">VK</div>
                            <div class="participant-info">
                                <div class="participant-name">Vikram Kumar</div>
                                <div class="participant-details">Roll No: ENG2024002 | Midfielder</div>
                            </div>
                            <div class="participant-actions">
                                <button class="btn-participant-action" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-participant-action" title="Remove">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <button class="btn btn-outline-danger me-3">
                    <i class="fas fa-user-plus me-2"></i>Add Participant
                </button>
                <button class="btn btn-danger">
                    <i class="fas fa-file-export me-2"></i>Export List
                </button>
            </div>
        </div>

        <!-- Event History -->
        <div class="history-section" data-aos="fade-up">
            <h3 class="section-title mb-4">Event History & Changes</h3>

            <div class="history-timeline">
                <div class="history-item">
                    <div class="history-time">March 20, 2024 | 10:30 AM</div>
                    <div class="history-action">Registration Closed</div>
                    <p class="history-details">Registration deadline reached. 22 participants registered across 2 teams.</p>
                </div>

                <div class="history-item">
                    <div class="history-time">March 18, 2024 | 3:15 PM</div>
                    <div class="history-action">Venue Updated</div>
                    <p class="history-details">Changed venue from Ground B to Main Football Ground due to maintenance.</p>
                </div>

                <div class="history-item">
                    <div class="history-time">March 15, 2024 | 11:00 AM</div>
                    <div class="history-action">Time Updated</div>
                    <p class="history-details">Event time changed from 10:00 AM to 9:00 AM to avoid schedule conflict.</p>
                </div>

                <div class="history-item">
                    <div class="history-time">March 10, 2024 | 2:00 PM</div>
                    <div class="history-action">Event Created</div>
                    <p class="history-details">Event created by Rahul Sharma. Initial registration opened.</p>
                </div>
            </div>
        </div>

    </div>

    <!-- Cancel Event Modal -->
    <div class="modal fade" id="cancelEventModal" tabindex="-1" aria-labelledby="cancelEventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content cancel-modal-content">
                <div class="cancel-modal-header">
                    <h5 class="modal-title cancel-modal-title" id="cancelEventModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Cancel Event
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="cancel-modal-body">
                    <div class="alert alert-warning mb-4">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Warning:</strong> Cancelling this event will notify all participants and cannot be undone easily.
                    </div>

                    <h6 class="fw-bold mb-3">Select Cancellation Reason:</h6>
                    <div class="mb-4">
                        <div class="cancel-reason-item">
                            <label class="cancel-reason-label">
                                <input type="radio" name="cancelReason" value="weather" class="me-2">
                                <span>Bad Weather Conditions</span>
                            </label>
                        </div>

                        <div class="cancel-reason-item">
                            <label class="cancel-reason-label">
                                <input type="radio" name="cancelReason" value="venue" class="me-2">
                                <span>Venue Unavailable</span>
                            </label>
                        </div>

                        <div class="cancel-reason-item">
                            <label class="cancel-reason-label">
                                <input type="radio" name="cancelReason" value="participants" class="me-2">
                                <span>Insufficient Participants</span>
                            </label>
                        </div>

                        <div class="cancel-reason-item">
                            <label class="cancel-reason-label">
                                <input type="radio" name="cancelReason" value="schedule" class="me-2">
                                <span>Schedule Conflict</span>
                            </label>
                        </div>

                        <div class="cancel-reason-item">
                            <label class="cancel-reason-label">
                                <input type="radio" name="cancelReason" value="other" class="me-2">
                                <span>Other Reason</span>
                            </label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Additional Details (Optional):</label>
                        <textarea class="form-textarea" placeholder="Provide additional details about the cancellation..." rows="3"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Notification Method:</label>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="notifyEmail" checked>
                            <label class="form-check-label" for="notifyEmail">
                                Send email notification to all participants
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="notifySMS" checked>
                            <label class="form-check-label" for="notifySMS">
                                Send SMS notification to all participants
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="refundFees" checked>
                            <label class="form-check-label" for="refundFees">
                                Automatically process registration fee refunds
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Go Back</button>
                    <button type="button" class="btn btn-danger" id="confirmCancelBtn">
                        <i class="fas fa-ban me-2"></i>Confirm Cancellation
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Overlay -->
    <div class="confirmation-overlay" id="confirmationOverlay"></div>

    <!-- Confirmation Dialog -->
    <div class="confirmation-dialog" id="saveConfirmation">
        <div class="confirmation-header">
            <i class="fas fa-question-circle me-2"></i>Save Changes?
        </div>
        <p class="confirmation-message">
            Are you sure you want to save all changes made to this event?
        </p>
        <div class="confirmation-buttons">
            <button class="btn btn-secondary" id="cancelSaveBtn">Cancel</button>
            <button class="btn btn-primary" id="confirmSaveBtn">Save Changes</button>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        AOS.init({
            duration: 1200,
            once: true
        });

        // Initialize date/time pickers
        flatpickr('.datetime-picker', {
            enableTime: true,
            dateFormat: 'Y-m-d H:i',
            time_24hr: true
        });

        // Edit Event Button
        document.getElementById('editEventBtn').addEventListener('click', function() {
            const editForm = document.getElementById('editForm');
            const saveBtn = document.getElementById('saveChangesBtn');
            const editBtn = this;

            if (editForm.style.display === 'block') {
                editForm.style.display = 'none';
                saveBtn.style.display = 'none';
                editBtn.innerHTML = '<i class="fas fa-edit"></i><span>Edit Event</span>';
            } else {
                editForm.style.display = 'block';
                saveBtn.style.display = 'inline-flex';
                editBtn.innerHTML = '<i class="fas fa-times"></i><span>Cancel Edit</span>';

                // Scroll to form
                editForm.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });

        // Save Changes Button
        document.getElementById('saveChangesBtn').addEventListener('click', function() {
            document.getElementById('saveConfirmation').style.display = 'block';
            document.getElementById('confirmationOverlay').style.display = 'block';
        });

        // Cancel Save
        document.getElementById('cancelSaveBtn').addEventListener('click', function() {
            document.getElementById('saveConfirmation').style.display = 'none';
            document.getElementById('confirmationOverlay').style.display = 'none';
        });

        // Confirm Save
        document.getElementById('confirmSaveBtn').addEventListener('click', function() {
            // In a real application, this would submit the form via AJAX
            alert('Event details saved successfully!');

            // Hide confirmation dialog
            document.getElementById('saveConfirmation').style.display = 'none';
            document.getElementById('confirmationOverlay').style.display = 'none';

            // Hide edit form
            document.getElementById('editForm').style.display = 'none';
            document.getElementById('saveChangesBtn').style.display = 'none';
            document.getElementById('editEventBtn').innerHTML = '<i class="fas fa-edit"></i><span>Edit Event</span>';

            // Show success message
            showNotification('Event updated successfully!', 'success');
        });

        // Cancel Event Button
        document.getElementById('cancelEventBtn').addEventListener('click', function() {
            const modal = new bootstrap.Modal(document.getElementById('cancelEventModal'));
            modal.show();
        });

        // Confirm Cancellation
        document.getElementById('confirmCancelBtn').addEventListener('click', function() {
            const reason = document.querySelector('input[name="cancelReason"]:checked');

            if (!reason) {
                alert('Please select a cancellation reason.');
                return;
            }

            if (confirm('Are you sure you want to cancel this event? This action cannot be undone.')) {
                // In a real application, this would send cancellation request to server
                alert('Event cancelled successfully! Notifications sent to participants.');

                // Update event status in UI
                const statusBadge = document.querySelector('.event-header-badge');
                statusBadge.className = 'event-header-badge status-cancelled';
                statusBadge.innerHTML = '<i class="fas fa-ban me-2"></i>Cancelled';

                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('cancelEventModal'));
                modal.hide();

                // Show success message
                showNotification('Event has been cancelled.', 'danger');
            }
        });

        // Participant action buttons
        document.querySelectorAll('.btn-participant-action').forEach(btn => {
            btn.addEventListener('click', function() {
                const action = this.querySelector('i').className;
                const participantCard = this.closest('.participant-card');
                const participantName = participantCard.querySelector('.participant-name').textContent;

                if (action.includes('fa-edit')) {
                    alert(`Edit participant: ${participantName}`);
                } else if (action.includes('fa-trash')) {
                    if (confirm(`Remove ${participantName} from event?`)) {
                        participantCard.style.transform = 'translateX(100%)';
                        participantCard.style.opacity = '0';
                        setTimeout(() => {
                            participantCard.remove();
                            showNotification('Participant removed from event.', 'warning');
                        }, 300);
                    }
                }
            });
        });

        // Archive button
        document.querySelector('.btn-archive').addEventListener('click', function() {
            if (confirm('Archive this event? Archived events are hidden from public view but can be restored later.')) {
                alert('Event archived successfully!');
                showNotification('Event archived.', 'info');
            }
        });

        // Form validation
        document.getElementById('eventEditForm').addEventListener('submit', function(e) {
            e.preventDefault();

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

            // Form is valid, trigger save
            document.getElementById('confirmSaveBtn').click();
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

        // Overlay click to close confirmation
        document.getElementById('confirmationOverlay').addEventListener('click', function() {
            document.getElementById('saveConfirmation').style.display = 'none';
            this.style.display = 'none';
        });
    </script>

</body>

</html>