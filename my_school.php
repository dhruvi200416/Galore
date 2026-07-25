<!DOCTYPE html>
<html lang="en">

<head>
    <title>School Dashboard - Galore</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- AOS CSS for scroll animations -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />

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

        .school-header-info {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 25px;
            margin-top: 30px;
        }

        .school-icon-large {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            border: 6px solid white;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .school-icon-large i {
            font-size: 3.5rem;
            color: var(--galore-red);
        }

        .school-name-header {
            font-size: 2.8rem;
            font-weight: 800;
            margin-bottom: 5px;
            text-align: center;
        }

        .school-dean-header {
            font-size: 1.3rem;
            font-weight: 500;
            margin-bottom: 20px;
            color: rgba(255, 255, 255, 0.9);
            text-align: center;
        }

        .school-stats-header {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 30px;
            margin-top: 25px;
        }

        .stat-header-box {
            text-align: center;
            min-width: 120px;
        }

        .stat-number-header {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-label-header {
            font-size: 0.95rem;
            opacity: 0.9;
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
            font-size: 1.8rem;
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

        /* Dashboard Sections */
        .dashboard-section {
            margin-bottom: 50px;
        }

        /* Quick Stats Cards */
        .quick-stats {
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
            display: flex;
            align-items: center;
            gap: 20px;
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
            flex-shrink: 0;
        }

        .stat-icon i {
            font-size: 1.8rem;
            color: var(--galore-red);
        }

        .stat-content {
            flex: 1;
        }

        .stat-card-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--galore-dark);
            line-height: 1;
            margin-bottom: 5px;
        }

        .stat-card-label {
            color: var(--galore-gray);
            font-size: 0.95rem;
        }

        /* School Info Card */
        .school-info-card {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 40px;
            height: 100%;
        }

        .coordinator-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .coordinator-list li {
            padding: 12px 0;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .coordinator-list li:last-child {
            border-bottom: none;
        }

        .coordinator-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .coordinator-avatar i {
            font-size: 1.5rem;
            color: var(--galore-red);
        }

        .coordinator-details {
            flex: 1;
        }

        .coordinator-name {
            font-weight: 600;
            color: var(--galore-dark);
            margin-bottom: 3px;
        }

        .coordinator-role {
            color: var(--galore-red);
            font-size: 0.9rem;
            margin-bottom: 3px;
        }

        .coordinator-contact {
            color: var(--galore-gray);
            font-size: 0.85rem;
        }

        /* Events Grid */
        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .event-card-compact {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            height: 100%;
        }

        .event-card-compact:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
        }

        .event-header-compact {
            background: linear-gradient(135deg, var(--galore-red) 0%, var(--galore-red-dark) 100%);
            color: white;
            padding: 20px;
            position: relative;
        }

        .event-category-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255, 255, 255, 0.2);
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .event-title-compact {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .event-date-compact {
            font-size: 0.9rem;
            opacity: 0.9;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .event-content-compact {
            padding: 20px;
        }

        .event-stats-compact {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .event-stat-compact {
            text-align: center;
            flex: 1;
        }

        .event-stat-number {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--galore-red);
            margin-bottom: 3px;
        }

        .event-stat-label {
            font-size: 0.8rem;
            color: var(--galore-gray);
        }

        .event-description-compact {
            color: #444;
            line-height: 1.6;
            font-size: 0.9rem;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .event-actions-compact {
            display: flex;
            gap: 10px;
        }

        .btn-event-action {
            flex: 1;
            padding: 8px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 0.9rem;
        }

        .btn-primary-action {
            background: var(--galore-red);
            color: white;
        }

        .btn-primary-action:hover {
            background: var(--galore-red-dark);
        }

        .btn-outline-action {
            background: transparent;
            color: var(--galore-red);
            border: 2px solid var(--galore-red);
        }

        .btn-outline-action:hover {
            background: var(--galore-red);
            color: white;
        }

        /* Calendar Section */
        .calendar-section {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 40px;
        }

        /* FullCalendar Custom Styling */
        .fc {
            font-family: "Segoe UI", Arial, sans-serif;
        }

        .fc .fc-toolbar-title {
            color: var(--galore-red);
            font-weight: 700;
            font-size: 1.5rem;
        }

        .fc .fc-button {
            background-color: white;
            border-color: #dee2e6;
            color: var(--galore-dark);
            font-weight: 600;
        }

        .fc .fc-button:hover {
            background-color: var(--galore-red);
            border-color: var(--galore-red);
            color: white;
        }

        .fc .fc-button-primary:not(:disabled).fc-button-active {
            background-color: var(--galore-red);
            border-color: var(--galore-red);
            color: white;
        }

        .fc .fc-day-today {
            background-color: #fff5f5 !important;
        }

        .fc .fc-event {
            border-radius: 8px;
            border: none;
            padding: 5px 10px;
            font-size: 0.85rem;
        }

        .fc .fc-event:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            transition: all 0.3s ease;
        }

        /* Event Categories Colors */
        .event-sports {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border-left: 4px solid #20c997;
        }

        .event-cultural {
            background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
            border-left: 4px solid #fd7e14;
        }

        .event-technical {
            background: linear-gradient(135deg, #007bff 0%, #17a2b8 100%);
            border-left: 4px solid #17a2b8;
        }

        .event-literary {
            background: linear-gradient(135deg, #6f42c1 0%, #e83e8c 100%);
            border-left: 4px solid #e83e8c;
        }

        /* Schedule Timeline */
        .timeline-section {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, var(--galore-red), var(--galore-red-dark));
        }

        .timeline-item {
            position: relative;
            margin-bottom: 25px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 12px;
            border-left: 4px solid var(--galore-red);
        }

        .timeline-item::before {
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

        .timeline-time {
            font-weight: 700;
            color: var(--galore-red);
            margin-bottom: 5px;
            font-size: 1.1rem;
        }

        .timeline-title {
            font-weight: 600;
            color: var(--galore-dark);
            margin-bottom: 5px;
            font-size: 1.1rem;
        }

        .timeline-desc {
            color: var(--galore-gray);
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .timeline-venue {
            color: var(--galore-red);
            font-weight: 600;
            font-size: 0.9rem;
        }

        /* Tabs Navigation */
        .dashboard-tabs {
            background: white;
            border-radius: 16px;
            padding: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
        }

        .dashboard-tab {
            padding: 12px 25px;
            border-radius: 50px;
            background: #f8f9fa;
            color: var(--galore-dark);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dashboard-tab:hover,
        .dashboard-tab.active {
            background: var(--galore-red);
            color: white;
            border-color: var(--galore-red);
        }

        /* Responsive adjustments */
        @media (max-width: 1200px) {
            .events-grid {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            }
        }

        @media (max-width: 992px) {
            .school-name-header {
                font-size: 2.2rem;
            }

            .quick-stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .events-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .school-stats-header {
                gap: 20px;
            }

            .stat-header-box {
                min-width: 100px;
            }

            .quick-stats {
                grid-template-columns: 1fr;
            }

            .fc .fc-toolbar {
                flex-direction: column;
                gap: 10px;
            }

            .dashboard-tabs {
                flex-direction: column;
            }

            .dashboard-tab {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .school-name-header {
                font-size: 1.8rem;
            }

            .section-title {
                font-size: 1.5rem;
            }

            .event-actions-compact {
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
                    <a href="coordinator-dashboard.php" class="back-button" data-aos="fade-right">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>

                <!-- School Header Info -->
                <div class="school-header-info" data-aos="fade-up">
                    <div class="text-center">
                        <div class="school-icon-large" data-aos="zoom-in">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <h1 class="school-name-header" data-aos="fade-up">School of Engineering</h1>
                        <div class="school-dean-header" data-aos="fade-up" data-aos-delay="100">
                            <i class="fas fa-user-tie me-2"></i>Dean: Dr. Sanjay Patel
                        </div>

                        <!-- School Stats -->
                        <div class="school-stats-header" data-aos="fade-up" data-aos-delay="200">
                            <div class="stat-header-box">
                                <div class="stat-number-header">285</div>
                                <div class="stat-label-header">Participants</div>
                            </div>
                            <div class="stat-header-box">
                                <div class="stat-number-header">24</div>
                                <div class="stat-label-header">Events</div>
                            </div>
                            <div class="stat-header-box">
                                <div class="stat-number-header">15</div>
                                <div class="stat-label-header">Medals Won</div>
                            </div>
                            <div class="stat-header-box">
                                <div class="stat-number-header">1st</div>
                                <div class="stat-label-header">Current Rank</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container">

        <!-- Dashboard Navigation Tabs -->
        <div class="dashboard-tabs" data-aos="fade-up">
            <a href="#school-info" class="dashboard-tab active">
                <i class="fas fa-school"></i>
                School Details
            </a>
            <a href="#events" class="dashboard-tab">
                <i class="fas fa-calendar-alt"></i>
                Events Management
            </a>
            <a href="#schedule" class="dashboard-tab">
                <i class="fas fa-clock"></i>
                Schedule
            </a>
            <a href="#performance" class="dashboard-tab">
                <i class="fas fa-chart-line"></i>
                Performance
            </a>
        </div>

        <!-- Quick Stats -->
        <div class="quick-stats" data-aos="fade-up">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-card-number">18</div>
                    <div class="stat-card-label">Active Events</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-card-number">285</div>
                    <div class="stat-card-label">Total Participants</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-trophy"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-card-number">15</div>
                    <div class="stat-card-label">Medals Won</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-card-number">380</div>
                    <div class="stat-card-label">Total Points</div>
                </div>
            </div>
        </div>

        <!-- School Details Section -->
        <div class="dashboard-section" id="school-info">
            <div class="row">
                <!-- School Information -->
                <div class="col-lg-8 mb-4" data-aos="fade-right">
                    <div class="school-info-card">
                        <h3 class="section-title">School Information</h3>
                        <div class="underline left mb-4"></div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5><i class="fas fa-info-circle text-primary me-2"></i>About School</h5>
                                <p class="text-muted">
                                    The School of Engineering at RK University excels in technical education and
                                    extracurricular activities. With a strong focus on holistic development,
                                    our students shine in both academic and Galore events.
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h5><i class="fas fa-medal text-warning me-2"></i>Achievements</h5>
                                <ul class="text-muted">
                                    <li>Winner of Robotics Competition 2024</li>
                                    <li>2nd Place in Code-a-thon</li>
                                    <li>Football Team in Semi-Finals</li>
                                    <li>Best Cultural Performance Award</li>
                                </ul>
                            </div>
                        </div>

                        <h5 class="mb-3"><i class="fas fa-list-check text-success me-2"></i>Event Categories</h5>
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            <span class="badge bg-success p-2">Sports (6 Events)</span>
                            <span class="badge bg-warning p-2">Cultural (8 Events)</span>
                            <span class="badge bg-primary p-2">Technical (7 Events)</span>
                            <span class="badge bg-info p-2">Literary (3 Events)</span>
                        </div>

                        <h5 class="mb-3"><i class="fas fa-bullseye text-danger me-2"></i>Goals for Galore 2024</h5>
                        <div class="progress mb-2" style="height: 20px;">
                            <div class="progress-bar bg-success" style="width: 85%">Participation: 85%</div>
                        </div>
                        <div class="progress mb-2" style="height: 20px;">
                            <div class="progress-bar bg-primary" style="width: 70%">Medal Target: 70%</div>
                        </div>
                        <div class="progress mb-4" style="height: 20px;">
                            <div class="progress-bar bg-warning" style="width: 95%">Overall Rank: 95%</div>
                        </div>
                    </div>
                </div>

                <!-- Coordinators -->
                <div class="col-lg-4 mb-4" data-aos="fade-left">
                    <div class="school-info-card">
                        <h3 class="section-title">Coordinators</h3>
                        <div class="underline left mb-4"></div>

                        <ul class="coordinator-list">
                            <li>
                                <div class="coordinator-avatar">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <div class="coordinator-details">
                                    <div class="coordinator-name">Prof. Rajesh Kumar</div>
                                    <div class="coordinator-role">Faculty Coordinator</div>
                                    <div class="coordinator-contact">
                                        <i class="fas fa-envelope me-1"></i>rajesh.kumar@rku.ac.in
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="coordinator-avatar">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <div class="coordinator-details">
                                    <div class="coordinator-name">Rahul Sharma</div>
                                    <div class="coordinator-role">Head Sports Coordinator</div>
                                    <div class="coordinator-contact">
                                        <i class="fas fa-phone me-1"></i>+91 98765 43210
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="coordinator-avatar">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <div class="coordinator-details">
                                    <div class="coordinator-name">Priya Mehta</div>
                                    <div class="coordinator-role">Cultural Coordinator</div>
                                    <div class="coordinator-contact">
                                        <i class="fas fa-envelope me-1"></i>priya.mehta@rku.ac.in
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="coordinator-avatar">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                                <div class="coordinator-details">
                                    <div class="coordinator-name">Vikram Singh</div>
                                    <div class="coordinator-role">Technical Coordinator</div>
                                    <div class="coordinator-contact">
                                        <i class="fas fa-phone me-1"></i>+91 98765 67890
                                    </div>
                                </div>
                            </li>
                        </ul>

                        <div class="text-center mt-4">
                            <button class="btn btn-outline-danger">
                                <i class="fas fa-plus me-2"></i>Add Coordinator
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Events Management Section -->
        <div class="dashboard-section" id="events" data-aos="fade-up">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="section-title">Events Management</h3>
                    <p class="section-subtitle">Manage all events for School of Engineering</p>
                </div>
                <button class="btn btn-danger">
                    <i class="fas fa-plus me-2"></i>Add New Event
                </button>
            </div>

            <!-- Filter Tabs -->
            <div class="dashboard-tabs mb-4">
                <a href="#" class="dashboard-tab active">All Events</a>
                <a href="#" class="dashboard-tab">Sports</a>
                <a href="#" class="dashboard-tab">Cultural</a>
                <a href="#" class="dashboard-tab">Technical</a>
                <a href="#" class="dashboard-tab">Upcoming</a>
                <a href="#" class="dashboard-tab">Completed</a>
            </div>

            <!-- Events Grid -->
            <div class="events-grid">
                <!-- Football Event -->
                <div class="event-card-compact" data-aos="fade-up">
                    <div class="event-header-compact">
                        <div class="event-category-badge">Sports</div>
                        <div class="event-title-compact">Football Tournament</div>
                        <div class="event-date-compact">
                            <i class="far fa-calendar"></i> Mar 15-20, 2024
                        </div>
                    </div>
                    <div class="event-content-compact">
                        <div class="event-stats-compact">
                            <div class="event-stat-compact">
                                <div class="event-stat-number">22</div>
                                <div class="event-stat-label">Participants</div>
                            </div>
                            <div class="event-stat-compact">
                                <div class="event-stat-number">2</div>
                                <div class="event-stat-label">Teams</div>
                            </div>
                            <div class="event-stat-compact">
                                <div class="event-stat-number">Semi</div>
                                <div class="event-stat-label">Stage</div>
                            </div>
                        </div>
                        <p class="event-description-compact">
                            Annual inter-department football championship with knockout format.
                            School has two teams competing for the Galore Cup.
                        </p>
                        <div class="event-actions-compact">
                            <button class="btn-event-action btn-primary-action">
                                <i class="fas fa-edit"></i> Manage
                            </button>
                            <button class="btn-event-action btn-outline-action">
                                <i class="fas fa-eye"></i> View
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Robotics Event -->
                <div class="event-card-compact" data-aos="fade-up" data-aos-delay="100">
                    <div class="event-header-compact">
                        <div class="event-category-badge">Technical</div>
                        <div class="event-title-compact">Robotics Competition</div>
                        <div class="event-date-compact">
                            <i class="far fa-calendar"></i> Mar 18, 2024
                        </div>
                    </div>
                    <div class="event-content-compact">
                        <div class="event-stats-compact">
                            <div class="event-stat-compact">
                                <div class="event-stat-number">15</div>
                                <div class="event-stat-label">Participants</div>
                            </div>
                            <div class="event-stat-compact">
                                <div class="event-stat-number">5</div>
                                <div class="event-stat-label">Projects</div>
                            </div>
                            <div class="event-stat-compact">
                                <div class="event-stat-number">1st</div>
                                <div class="event-stat-label">Place</div>
                            </div>
                        </div>
                        <p class="event-description-compact">
                            Robotics and automation competition with theme-based challenges.
                            School won 1st place with autonomous delivery robot project.
                        </p>
                        <div class="event-actions-compact">
                            <button class="btn-event-action btn-primary-action">
                                <i class="fas fa-award"></i> Results
                            </button>
                            <button class="btn-event-action btn-outline-action">
                                <i class="fas fa-images"></i> Gallery
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Dance Competition -->
                <div class="event-card-compact" data-aos="fade-up" data-aos-delay="200">
                    <div class="event-header-compact">
                        <div class="event-category-badge">Cultural</div>
                        <div class="event-title-compact">Dance Competition</div>
                        <div class="event-date-compact">
                            <i class="far fa-calendar"></i> Mar 22, 2024
                        </div>
                    </div>
                    <div class="event-content-compact">
                        <div class="event-stats-compact">
                            <div class="event-stat-compact">
                                <div class="event-stat-number">12</div>
                                <div class="event-stat-label">Participants</div>
                            </div>
                            <div class="event-stat-compact">
                                <div class="event-stat-number">1</div>
                                <div class="event-stat-label">Group</div>
                            </div>
                            <div class="event-stat-compact">
                                <div class="event-stat-number">Final</div>
                                <div class="event-stat-label">Stage</div>
                            </div>
                        </div>
                        <p class="event-description-compact">
                            Inter-school dance competition with contemporary and classical categories.
                            School team has reached the finals with contemporary performance.
                        </p>
                        <div class="event-actions-compact">
                            <button class="btn-event-action btn-primary-action">
                                <i class="fas fa-edit"></i> Manage
                            </button>
                            <button class="btn-event-action btn-outline-action">
                                <i class="fas fa-calendar-check"></i> Schedule
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Schedule Section -->
        <div class="dashboard-section" id="schedule" data-aos="fade-up">
            <div class="row">
                <!-- Calendar View -->
                <div class="col-lg-8 mb-4">
                    <div class="calendar-section">
                        <h3 class="section-title">Event Calendar</h3>
                        <p class="section-subtitle">March 2024 - All scheduled events</p>
                        <div id="calendar"></div>
                    </div>
                </div>

                <!-- Today's Schedule -->
                <div class="col-lg-4 mb-4">
                    <div class="timeline-section">
                        <h3 class="section-title">Today's Schedule</h3>
                        <p class="section-subtitle">March 21, 2024</p>

                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-time">9:00 AM - 11:00 AM</div>
                                <h5 class="timeline-title">Football Quarter-Finals</h5>
                                <p class="timeline-desc">School of Engineering vs Commerce</p>
                                <div class="timeline-venue">
                                    <i class="fas fa-map-marker-alt me-1"></i>Main Football Ground
                                </div>
                                <div class="mt-2">
                                    <span class="badge bg-danger">Live Now</span>
                                    <span class="badge bg-secondary">Coordinator: Rahul</span>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-time">11:30 AM - 1:30 PM</div>
                                <h5 class="timeline-title">Robotics Workshop</h5>
                                <p class="timeline-desc">Advanced Programming Techniques</p>
                                <div class="timeline-venue">
                                    <i class="fas fa-map-marker-alt me-1"></i>Engineering Block - Room 205
                                </div>
                                <div class="mt-2">
                                    <span class="badge bg-info">Starting Soon</span>
                                    <span class="badge bg-secondary">Coordinator: Prof. Kumar</span>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-time">2:00 PM - 4:00 PM</div>
                                <h5 class="timeline-title">Dance Rehearsal</h5>
                                <p class="timeline-desc">Final rehearsal for competition</p>
                                <div class="timeline-venue">
                                    <i class="fas fa-map-marker-alt me-1"></i>Cultural Hall
                                </div>
                                <div class="mt-2">
                                    <span class="badge bg-warning">Participants: 12</span>
                                    <span class="badge bg-secondary">Coordinator: Priya</span>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-time">4:30 PM - 5:30 PM</div>
                                <h5 class="timeline-title">Coordinator Meeting</h5>
                                <p class="timeline-desc">Daily schedule review and updates</p>
                                <div class="timeline-venue">
                                    <i class="fas fa-map-marker-alt me-1"></i>Conference Room
                                </div>
                                <div class="mt-2">
                                    <span class="badge bg-primary">Required: All</span>
                                    <span class="badge bg-secondary">Agenda: Review</span>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button class="btn btn-outline-danger">
                                <i class="fas fa-calendar-plus me-2"></i>Add Schedule Item
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Section -->
        <div class="dashboard-section" id="performance" data-aos="fade-up">
            <div class="calendar-section">
                <h3 class="section-title">Performance Analytics</h3>
                <p class="section-subtitle">School of Engineering performance metrics for Galore 2024</p>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="school-info-card">
                            <h5 class="fw-bold mb-3">Participation by Category</h5>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Sports</span>
                                    <span class="fw-bold">120 Participants</span>
                                </div>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar bg-success" style="width: 85%"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Cultural</span>
                                    <span class="fw-bold">65 Participants</span>
                                </div>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar bg-warning" style="width: 75%"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Technical</span>
                                    <span class="fw-bold">80 Participants</span>
                                </div>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar bg-primary" style="width: 95%"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Literary</span>
                                    <span class="fw-bold">20 Participants</span>
                                </div>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar bg-info" style="width: 70%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="school-info-card">
                            <h5 class="fw-bold mb-3">Medal Count</h5>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="text-center">
                                    <div class="display-6 text-warning">🥇</div>
                                    <div class="fw-bold">7 Gold</div>
                                </div>
                                <div class="text-center">
                                    <div class="display-6 text-secondary">🥈</div>
                                    <div class="fw-bold">5 Silver</div>
                                </div>
                                <div class="text-center">
                                    <div class="display-6 text-danger">🥉</div>
                                    <div class="fw-bold">3 Bronze</div>
                                </div>
                            </div>

                            <h5 class="fw-bold mb-3">Points Distribution</h5>
                            <div class="row text-center">
                                <div class="col-6 mb-3">
                                    <div class="display-6 text-success">180</div>
                                    <div class="text-muted">Sports Points</div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="display-6 text-warning">110</div>
                                    <div class="text-muted">Cultural Points</div>
                                </div>
                                <div class="col-6">
                                    <div class="display-6 text-primary">170</div>
                                    <div class="text-muted">Technical Points</div>
                                </div>
                                <div class="col-6">
                                    <div class="display-6 text-info">65</div>
                                    <div class="text-muted">Literary Points</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php include 'footer.php'; ?>

    <!-- FullCalendar JS -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <script>
        AOS.init({
            duration: 1200,
            once: true
        });

        // Initialize FullCalendar
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: [{
                        title: 'Football Quarter-Finals',
                        start: '2024-03-21T09:00:00',
                        end: '2024-03-21T11:00:00',
                        className: 'event-sports'
                    },
                    {
                        title: 'Robotics Workshop',
                        start: '2024-03-21T11:30:00',
                        end: '2024-03-21T13:30:00',
                        className: 'event-technical'
                    },
                    {
                        title: 'Dance Rehearsal',
                        start: '2024-03-21T14:00:00',
                        end: '2024-03-21T16:00:00',
                        className: 'event-cultural'
                    },
                    {
                        title: 'Coordinator Meeting',
                        start: '2024-03-21T16:30:00',
                        end: '2024-03-21T17:30:00'
                    },
                    {
                        title: 'Cricket Match',
                        start: '2024-03-22T09:00:00',
                        end: '2024-03-22T12:00:00',
                        className: 'event-sports'
                    },
                    {
                        title: 'Singing Competition',
                        start: '2024-03-23T14:00:00',
                        end: '2024-03-23T18:00:00',
                        className: 'event-cultural'
                    },
                    {
                        title: 'Code-a-thon Finals',
                        start: '2024-03-24T10:00:00',
                        end: '2024-03-24T16:00:00',
                        className: 'event-technical'
                    }
                ],
                eventClick: function(info) {
                    alert('Event: ' + info.event.title + '\nStart: ' + info.event.start.toLocaleString());
                }
            });
            calendar.render();
        });

        // Tab Navigation
        document.querySelectorAll('.dashboard-tab').forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();

                // Remove active class from all tabs
                document.querySelectorAll('.dashboard-tab').forEach(t => t.classList.remove('active'));

                // Add active class to clicked tab
                this.classList.add('active');

                // Get target section
                const targetId = this.getAttribute('href').substring(1);
                const targetSection = document.getElementById(targetId);

                // Scroll to section
                if (targetSection) {
                    window.scrollTo({
                        top: targetSection.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Event action buttons
        document.querySelectorAll('.btn-event-action').forEach(btn => {
            btn.addEventListener('click', function() {
                const action = this.querySelector('i').className;
                const eventCard = this.closest('.event-card-compact');
                const eventTitle = eventCard.querySelector('.event-title-compact').textContent;

                if (action.includes('fa-edit')) {
                    alert(`Manage event: ${eventTitle}`);
                } else if (action.includes('fa-eye')) {
                    alert(`View details for: ${eventTitle}`);
                } else if (action.includes('fa-award')) {
                    alert(`View results for: ${eventTitle}`);
                } else if (action.includes('fa-images')) {
                    alert(`View gallery for: ${eventTitle}`);
                } else if (action.includes('fa-calendar-check')) {
                    alert(`View schedule for: ${eventTitle}`);
                }
            });
        });

        // Add event button
        document.querySelector('button.btn-danger').addEventListener('click', function() {
            alert('Open event creation form');
        });

        // Add coordinator button
        document.querySelector('.btn-outline-danger').addEventListener('click', function() {
            alert('Open coordinator addition form');
        });
    </script>

</body>

</html>